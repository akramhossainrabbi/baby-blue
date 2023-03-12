<?php

namespace App\Http\Controllers;

use App\Tag;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Tag::latest();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    if (isset($data)){
                        return '<a href="'.url('tags/edit/'.$data->id).
                            '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> &nbsp;&nbsp;&nbsp;<a href="'.url('tags/delete/'.$data->id).
                            '" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                    }else{
                        return '';
                    }
                })
                ->editColumn('total_products', function ($data) {
                    if ($data->status == 1) {
                        return "Publish";
                    }elseif ($data->status == 2){
                        return "Pending / Draft";
                    } else {
                        return "Cancel";
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
        return view('tag.list');
    }

    public function create(){
        return view('tag.create');
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
            'description' => 'required',
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
                $imagename = 'tagImage'.'/'.$slug.'-'.$currentDate.'-'.uniqid().'.'.
                    $image->getClientOriginalExtension();
                if(!file_exists('tagImage')){
                    mkdir('tagImage',0777,true);
                }
                $image->move('tagImage',$imagename);
            }else{
                $imagename = "default.png";
            }

            $data = new Tag();
            $data->title = $request->title;
            $data->slug = $request->slug;
            $data->description = $request->description;
            $data->image = $imagename;
            $data->seo_title = $request->seo_title;
            $data->meta_key = $request->meta_key;
            $data->meta_description = $request->meta_description;
            $data->status = $request->status;
            $data->save();
            Toastr::success('Tag inserted!', 'Title', ["positionClass" => "toast-top-right"]);
            return redirect()->route('list');
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
        }
    }

    public function edit(Request $request, $id){
        $data = Tag::find($id);
        return view('tag.edit', compact('data'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'seo_title' => 'required',
            'meta_key' => 'required',
            'meta_description' => 'required',
        ]);

        $data = Tag::find($id);
        $image = $request->file('image');
        $slug = str_slug($request->title);
        if($request->hasFile('image')){
            $currentDate = Carbon::now()->toDateString();
            $imagename = 'tagImage'.'/'.$slug.'-'.$currentDate.'-'.uniqid().'.'.
                $image->getClientOriginalExtension();
            if(!file_exists('tagImage')){
                mkdir('tagImage',0777,true);
            }
            $image->move('tagImage',$imagename);
            $data->image = $imagename;
        }

        $data->title = $request->title;
        $data->slug = $request->slug;
        $data->description = $request->description;
        $data->seo_title = $request->seo_title;
        $data->meta_key = $request->meta_key;
        $data->meta_description = $request->meta_description;
        $data->status = $request->status;
        $data->save();
        Toastr::success('Tag Updated!', 'Title', ["positionClass" => "toast-top-right"]);
        return redirect()->route('list');
    }

    public function delete(Request $request, $id){
        $data = Tag::find($id);
        if (!empty($data->image)){
            unlink($data->image);
        }
        $data->delete();
        Toastr::error('Tag Deleted!', 'title', ["positionClass" => "toast-top-right"]);
        return redirect()->route('list');
    }
}
