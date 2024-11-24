<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function home()
    {
        $blogs=Blog::paginate(4);
        return view('themes.home', compact('blogs'));
    }

    public function category($id)
    {
        $categoryname=Category::find($id)->name;
        $blogs=Blog::where('category_id' , $id)->paginate(8);
        return view('themes.category' ,compact('blogs' , 'categoryname'));
    }

    public function contact()
    {
        return view('themes.contact');
    }

    
    public function register()
    {
        return view('themes.register');
    }

    
    public function login()
    {
        return view('themes.login');
    }

}
