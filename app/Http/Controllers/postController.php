<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\Post;
use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Validator;
use Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Like;
use App\Dislike;
use App\Comment;
use App\Profile;

class postController extends Controller
{
    //
    public function post(){
    	$categories = category::all();

    	return view('post.post',['categories' => $categories]);
    }

   public function addPost(Request $request){
   	 $this->validate($request, [
             'post_title' => 'required',
              'post_body' => 'required',
              'category_id' => 'required',
              'image' => 'required',
              ]);
            $posts = new Post;
    	    $posts ->post_title = $request->input('post_title');
    	    $posts  ->user_id = Auth::user()->id;
    	    $posts  ->post_body = $request->input('post_body');
    	    $posts  ->category_id = $request->input('category_id');
    	    if(Input::hasFile('image')){
    	    	$file = Input::file('image');
$file->move(public_path().'/posts/', $file->getClientOriginalName());
$url=URL::to("/").'/posts/'. $file->getClientOriginalName();
               
    	    } 
    	    $posts ->image = $url;
    	    $posts ->save();
    	    return redirect('/home')->with('response', 'post added successfully');
    }

    public function view($post_id){
        $posts=Post::where('id', '=', $post_id)->get();
        $likePost=Post::find($post_id);
        $likeCtr=Like::where(['post_id'=> $likePost->id])->count();
        $dislikeCtr=Dislike::where(['post_id'=> $likePost->id])->count();
        $categories = Category::all();
         $comments = DB::table('users')
            ->join('comments', 'users.id', '=', 'comments.user_id')
            ->join('posts', 'comments.post_id', '=', 'posts.id')
            ->select('users.name', 'comments.*')
            ->where(['posts.id'=>$post_id])
            ->get(); 
        return view('post.view', ['posts' => $posts, 'categories' => $categories, 'likeCtr' => $likeCtr, 'dislikeCtr' => $dislikeCtr, 'comments' => $comments]);
        
     }

    public function edit($post_id){
       $categories = Category::all();
       $posts = Post::find($post_id);
       $categories = Category::find($posts->category_id);
       return view('post.edit', ['categories' => $categories, 'posts' => $posts, 'category' => $categories] );
    }

    public function editPost(Request $request, $post_id){
       $this->validate($request, [
             'post_title' => 'required',
              'post_body' => 'required',
              'category_id' => 'required',
              'image' => 'required',
              ]);
            $posts = new Post;
          $posts ->post_title = $request->input('post_title');
          $posts  ->user_id = Auth::user()->id;
          $posts  ->post_body = $request->input('post_body');
          $posts  ->category_id = $request->input('category_id');
          if(Input::hasFile('image')){
            $file = Input::file('image');
$file->move(public_path().'/posts/', $file->getClientOriginalName());
$url=URL::to("/").'/posts/'. $file->getClientOriginalName();
               
          } 
          $posts ->image = $url;
          $data =array(
              'post_title'=>  $posts ->post_title,
              'user_id'=>  $posts ->user_id,
              'post_body'=> $posts  ->post_body,
              'category_id'=> $posts  ->category_id,
              'image'=> $posts  ->image
            );
          Post::where('id', $post_id)
          ->update($data);
          $posts ->update();
          return redirect('/home')->with('response', 'post updated successfully');   
     }

      public function deletePost($post_id){
          Post::where('id', $post_id)
          ->delete();
          return redirect('/home')->with('response', 'post deleted successfully');

      }

       public function category($cat_id){
        $categories = Category::all();
         $posts = DB::table('posts')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->select('posts.*', 'categories.*')
            ->where(['categories.id'=>$cat_id])
            ->get();
            

         return view('category.categoriespost', ['categories' =>$categories, 'posts' =>$posts]);
      } 

       public function Like($id){
        $loggedin_user =Auth::user()->id;
        $like_user =Like::where(['user_id' => $loggedin_user, 'post_id' => $id])-> first();
        if(empty($like_user->user_id)){
           $like_user=Auth::user()->id;
           $email=Auth::user()->email;
           $post_id=$id;
           $like=new Like;
           $like->user_id=$user_id=Auth::user()->id;
           $like->email=$email;
           $like->post_id=$post_id;
           $like->save();

           Dislike::where(['user_id' => $loggedin_user, 'post_id' => $id])
          ->delete();

          return redirect("/view/{$id}" );
        }
        else{
          return redirect("/view/{$id}" );
        }

   } 
    public function Dislike($id){
        $loggedin_user =Auth::user()->id;
        $like_user =Dislike::where(['user_id' => $loggedin_user, 'post_id' => $id])-> first();
        if(empty($like_user->user_id)){
           $like_user=Auth::user()->id;
           $email=Auth::user()->email;
           $post_id=$id;
           $like=new Dislike;
           $like->user_id=$user_id=Auth::user()->id;
           $like->email=$email;
           $like->post_id=$post_id;
           $like->save();

           Like::where(['user_id' => $loggedin_user, 'post_id' => $id])
          ->delete();



          return redirect("/view/{$id}" );
        }
        else{
          return redirect("/view/{$id}" );
        }
   }
    public function Comment(Request $request, $post_id){
       $this->validate($request, [
             'comment' => 'required',
              ]);
         $comment = new Comment;
         $comment ->user_id=Auth::user()->id;
         $comment ->post_id=$post_id;
         $comment ->comment =$request->input('comment');
         $comment ->save();
          return redirect("/view/{$post_id}" )->with('response', 'Comment added successfully');
    } 

    public function Search(Request $request){
      $user_id =Auth::user()->id;
      $profile =Profile::find($user_id);
      $keyword =$request->input('search');
      $posts = Post::where('post_title', 'LIKE', '%'.$keyword.'%')->get();
      return view('post.searchposts', ['profile'=>$profile, 'posts'=>$posts, ]);
      

  }
}

