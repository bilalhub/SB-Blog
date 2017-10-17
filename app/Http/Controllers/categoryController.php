<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;

class categoryController extends Controller
{
      public function category(){
    	return view('category.category');
     }

      public function addCategory(Request $request){
    	$this->validate($request, [
             'category' => 'required'	
                     ]);
    	    $category = new Category;
    	    $category -> category = $request->input('category');
    	    $category ->save();
    	    return redirect('/category')->with('response','category added successfully	');
      }
}