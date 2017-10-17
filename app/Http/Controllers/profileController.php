<?php

namespace App\Http\Controllers;
use App\Profile;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use App\Http\Requests;
use Validator;
use Redirect;
use Illuminate\Support\Facades\Input;

class profileController extends Controller
{
    //
     public function profile(){
    	return view('profile.profile');
          }

         public function addProfile(Request $request){
    	   $this->validate($request, [
             'name' => 'required',
              'designation' => 'required',
              'profile_pic' => 'required',
                     ]);
    	    $profiles = new Profile;
    	    $profiles ->name = $request->input('name');
    	    $profiles ->user_id = Auth::user()->id;
    	    $profiles ->designation = $request->input('designation');
    	    if(Input::hasFile('profile_pic')){
    	    	$file = Input::file('profile_pic');
$file->move(public_path().'/uploadz/', $file->getClientOriginalName());
$url=URL::to("/").'/uploadz/'. $file->getClientOriginalName();
               
    	    } 
    	    $profiles ->profile_pic = $url;
    	    $profiles ->save();
    	    return redirect('/home')->with('response', 'profile added successfully');
    	   

    	  
    	}    
      
  } 

      /* 
      protected function addProfile(Request $request) {
	   $rules = array(
             'name' => 'required|max:5',
              'designation' => 'required',
	       );
	       $validator = Validator::make(Input::all(), $rules);
	  // check if the validator failed -----------------------
	  if ($validator->fails()) {
	     // get the error messages from the validator
	     $messages = $validator->messages();
	     // redirect our user back to the form with the errors from the validator
	     return Redirect::to('/profile')
	         ->withErrors($validator);
	  } else {
	     // validation successful ---------------------------
	     // report has passed all tests!
	     // let him enter the database
	     // create the data for report
    	    $profiles = new Profile;
    	    $profiles -> name = $request->input('name');
    	    $profiles -> user_id = Auth::user()->id;
    	    $profiles -> designation = $request->input('designation');
	        $profiles->profile_pic     = $request->file;
	      $profiles->save();
	        $fileName = $profiles->id . '.' .
	        $request->file('file')->getClientOriginalExtension();
	        $request->file('file')->move(
	            base_path() . '/public/uploads', $fileName
	        );
	     $pat = '/public/uploads/'.$fileName;
	        $tend_obj = new Profile();
	        $tend_obj->id = $profiles->id;
	        $tend = Profile::find($tend_obj->id); // Eloquent Model
	        $tend->update(['profile_pic' => $pat]);
	     // save report
	     // redirect ----------------------------------------
	     // redirect our user back to the form so they can do it all over again
	     return Redirect::to('/profile');
	      }
	  }/*

