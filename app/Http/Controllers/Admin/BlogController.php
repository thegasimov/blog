<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Blog_Langs;
use App\Repositories\Admin\BlogCategoryRepository;
use App\Repositories\Admin\BlogRepository;
use App\Repositories\Admin\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class BlogController extends Controller
{
    protected $blogs;
    protected $blogCategory;
    protected $user;

    public function __construct(BlogRepository $blogs,
                                BlogCategoryRepository $blogCategory,
                                UserRepository $user
    )
    {
        $this->blogs = $blogs;
        $this->blogCategory = $blogCategory;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = $this->blogs->all();
        return view('dashboard.blogs.all',compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blogCategories = $this->blogCategory->all();
        $authors = $this->user->all();
        return view('dashboard.blogs.create',compact('blogCategories','authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       $store = $this->blogs->store($request);
        if($store){
            Alert::success('Uğurlu əməliyyat');
        }else{
            Alert::error('Xəta');
        }
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $blog = $this->blogs->find($id);
        $blogCategories = $this->blogCategory->all();
        $authors = $this->user->all();
        return view('dashboard.blogs.edit',compact('blog','authors','blogCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $update = $this->blogs->update($request,$id);
        if($update){
            Alert::success('Uğurlu əməliyyat');
        }else{
            Alert::error('Xəta');
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $update = $this->blogs->delete($id);
        if($update){
            Alert::success('Uğurlu əməliyyat');
        }else{
            Alert::error('Xəta');
        }
        return redirect()->route('blogs.index');
    }
}
