<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewBlogRequest;
use App\Http\Requests\UPdateBlogRequest;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\error;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'myblogs']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('themes.blogs.create', compact('categories'));

        // if (Auth::check()) {
        //     $categories = Category::get();
        //     return view('themes.blogs.create', compact('categories'));
        // }
        // error(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewBlogRequest $request)
    {
        $data = $request->validated();
        // image uploading
        // 1- get image
        $image = $request->image;
        // 2- change it's current name
        $newimagename = time() . '-' . $image->getClientOriginalName();
        // 3- move image to my project
        $image->storeAs('blogs', $newimagename, 'public');
        // 4- save new name to database record
        $data['image'] = $newimagename;

        $data['user_id'] = Auth::user()->id;

        Blog::create($data);

        return back()->with('blog-status', 'Your blog is created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('themes.blogs.singleblog', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        if ($blog->user_id == Auth::user()->id) {
            $categories = Category::get();
            return view('themes.blogs.edite', compact('categories', 'blog'));
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UPdateBlogRequest $request, Blog $blog)
    {
        //php artisan storage
        if ($blog->user_id == Auth::user()->id) {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                // image uploading
                // 0- delete old image
                Storage::delete("storage/blogs/$blog->image");
                // 1- get image
                $image = $request->image;
                // 2- change it's current name
                $newimagename = time() . '-' . $image->getClientOriginalName();
                // 3- move image to my project
                $image->storeAs('blogs', $newimagename, 'public');
                // 4- save new name to database record
                $data['image'] = $newimagename;
            }

            $blog->update($data);

            return back()->with('blog-edite-status', 'Your blog is edited successfully');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if($blog->user_id == Auth::user()->id)
        {
            storage::delete("public/blogs/$blog->image");
            $blog->delete();
            return back()->with('blog-delete-status', 'Your blog is deleted successfully');

        }
    }

    /**
     * show my blogs.
     */
    public function myblogs()
    {
        $blogs = Blog::where('user_id', Auth::user()->id)->get();
        return view('themes.blogs.my-blogs', compact('blogs'));
    }
}
