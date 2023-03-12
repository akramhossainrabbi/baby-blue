<?php

namespace App\Http\Controllers;


use App\Blog;
use App\Category;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Blog::latest();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    if (isset($data)){
                        return '<a href="'.url('blogedit/'.$data->id).
                            '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> &nbsp;&nbsp;&nbsp;<a href="'.url('blogdelete/'.$data->id).
                            '" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                    }else{
                        return '';
                    }
                })
                ->editColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return "Publish";
                    }elseif ($data->status == 2){
                        return "Pending / Draft";
                    } else {
                        return "Cancel";
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('blog.list');
    }

    public function create(){
        return view('blog.create');
    }

    public function slugGenerate(Request $request)
    {
        $slug = str_slug($request->title);
        return response()->json(['slug' => $slug]);
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:2048',
            'seo_title' => 'required',
            'meta_key' => 'required',
            'meta_description' => 'required',
        ]);

        try {
            $image = $request->file('image');
            $slug = str_slug($request->title);
            if(isset($image)){
                $currentDate = Carbon::now()->toDateString();
                $imagename = 'blogImage'.'/'.$slug.'-'.$currentDate.'-'.uniqid().'.'.
                    $image->getClientOriginalExtension();
                if(!file_exists('blogImage')){
                    mkdir('blogImage',0777,true);
                }
                $image->move('blogImage',$imagename);
            }else{
                $imagename = "default.png";
            }

            $data = new Blog();
            $data->title = $request->title;
            $data->slug = $request->slug;
            $data->short_description = $request->short_description;
            $data->long_description = $request->long_description;
            $data->image = $imagename;
            $data->is_sticky = $request->is_sticky;
            $data->comment_enable = $request->comment_enable;
            $data->seo_title = $request->seo_title;
            $data->meta_key = $request->meta_key;
            $data->meta_description = $request->meta_description;
            $data->status = $request->status;
            $data->save();
            Toastr::success('Blog inserted!', 'Title', ["positionClass" => "toast-top-right"]);
            return redirect()->route('bloglist');
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
        }
    }

    public function edit(Request $request, $id){
        $data = Blog::find($id);
        return view('blog.edit', compact('data'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'seo_title' => 'required',
            'meta_key' => 'required',
            'meta_description' => 'required',
        ]);

        $data = Blog::find($id);
        $image = $request->file('image');
        $slug = str_slug($request->title);
        if($request->hasFile('image')){
            $currentDate = Carbon::now()->toDateString();
            $imagename = 'blogImage'.'/'.$slug.'-'.$currentDate.'-'.uniqid().'.'.
                $image->getClientOriginalExtension();
            if(!file_exists('blogImage')){
                mkdir('blogImage',0777,true);
            }
            $image->move('blogImage',$imagename);
            $data->image = $imagename;
        }

        $data->title = $request->title;
        $data->slug = $request->slug;
        $data->short_description = $request->short_description;
        $data->long_description = $request->long_description;
        $data->is_sticky = $request->is_sticky;
        $data->comment_enable = $request->comment_enable;
        $data->seo_title = $request->seo_title;
        $data->meta_key = $request->meta_key;
        $data->meta_description = $request->meta_description;
        $data->status = $request->status;
        $data->save();
        Toastr::success('Blog Updated!', 'Title', ["positionClass" => "toast-top-right"]);
        return redirect()->route('bloglist');
    }

    public function delete(Request $request, $id){
        $data = Blog::find($id);
        if (!empty($data->image)){
            unlink($data->image);
        }
        $data->delete();
        Toastr::error('Blog Deleted!', 'title', ["positionClass" => "toast-top-right"]);
        return redirect()->route('bloglist');
    }
}
