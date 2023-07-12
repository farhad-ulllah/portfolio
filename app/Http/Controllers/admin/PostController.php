<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\file;
use Yajra\DataTables\DataTables;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::select('name as title','id as key')->get();
        $posts=Post::paginate(3);
        return Response::view('admin.posts.index',compact('categories','posts'));
    }
    public function dataTable()
    {
    $data = Post::get(); // Replace with your own model
        return DataTables::of($data)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::select('name as title','id as key')->get();
        return Response::view('admin.posts.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $content = $request->description;
         if($request->hasFile('photo')){
            $imageName = time().'.'.$request->photo->extension();
            $request->photo->storeAs('public/posts', $imageName);
            $blog_image = $imageName;
            }else{
                $blog_image = '';
            }
        $posts = new Post;
        $posts->title = $request->title;
        $posts->image =  $blog_image;
        $posts->slug = Str::slug($request->title);
        $posts->category_id = $request->category_id;
        $posts->title = $request->title;
        $posts->description = $content;
        $posts->save();
        return response()->json(['message' => 'Post Created successful'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posts=Post::find($id);
        return response()->json(['status' => 'success', 'posts' => $posts]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $posts=Post::find($request->post_id);
        if($request->hasFile('photo')) {
            $file_name = time().'.'.$request->photo->extension();
            $path = $request->file('photo')->storeAs('public/posts',$file_name);
            $posts->image=$file_name;
            $Image = str_replace('/storage', '', $request->old_image);
            #Using storage
            if(Storage::exists('public/posts/' . $Image)){
            $delete= Storage::delete('/public/posts/' . $Image);
            }
        }
        $posts->title=$request->title;
        $posts->description=$request->description;
        $posts->category_id=$request->category_id;
        $posts->update();
        return response()->json(['status' => 'success', 'message' => 'Post Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts=Post::find($id);
        if($posts->image)
        {
            if(Storage::exists('public/posts/' . $posts->image)){
            $delete= Storage::delete('/public/posts/' . $posts->image);
            }
        }
        $posts->delete();
        return redirect()->back()->with('success','Post deleted Successfully');
    }
       //Ck Editor Images Upload
       public function storeImage(Request $request)
       {
           $file=$request->upload;
           $filename=$file->getClientOriginalName();
           $new_name=time().$filename;
           $dir="ckeditor/images/";
          $file->move($dir,$new_name);
          $url=asset('ckeditor/images/'.$new_name);
         $CkeditorFuncNum=$request->input('CKEditorFuncNum');
   
            $status="<script>window.parent.CKEDITOR.tools.callFunction('$CkeditorFuncNum','$url','File Uploaded Succesfully')</script>";
          echo $status;
          return response()->$status;
   
       }
}