<?php

namespace App\Http\Controllers;

use App\Page;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PagesController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Page::latest();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    if (isset($data)){
                        $msg = "return confirm('Are you sure to Delete?')";
                        return '<a href="'.url('pagesedit/'.$data->id).
                            '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> &nbsp;&nbsp;&nbsp;<a href="'.url('pagesdelete/'.$data->id).
                            '" class="btn btn-xs btn-danger" onclick="'.$msg.'"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
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
        return view('page.list');
    }

    public function create(){
        return view('page.create');
    }

    public function slugGenerate(Request $request)
    {
        $slug = Str::slug($request->menu_title);
        return response()->json(['slug' => $slug]);
    }

    public function store(Request $request){
        $request->validate([
            'menu_title' => 'required',
            'page_title' => 'required',
            'page_subtitle' => 'required',
            'banner_title' => 'required',
            'banner_subtitle' => 'required',
            'page_content' => 'required',
            'banner_image' => 'required|mimes:jpg,png,jpeg|max:2048',
            'status' => 'required',
            'seo_title' => 'required',
            'meta_key' => 'required',
            'meta_description' => 'required'
        ]);

        $data = new Page();
        $image = $request->file('banner_image');
        $slug = str_slug($request->menu_title);
        if($request->hasFile('banner_image')){
            $currentDate = Carbon::now()->toDateString();
            $imagename = 'pageBannerImage'.'/'.$slug.'-'.$currentDate.'-'.uniqid().'.'.
                $image->getClientOriginalExtension();
            if(!file_exists('pageBannerImage')){
                mkdir('pageBannerImage',0777,true);
            }
            $image->move('pageBannerImage',$imagename);
            $data->banner_image = $imagename;
        }
        $data->menu_title = $request->menu_title;
        $data->page_title = $request->page_title;
        $data->slug = $request->slug;
        $data->page_subtitle = $request->page_subtitle;
        $data->banner_title = $request->banner_title;
        $data->banner_subtitle = $request->banner_subtitle;
        $data->page_content = $request->page_content;
        $data->status = $request->status;
        $data->seo_title = $request->seo_title;
        $data->meta_key = $request->meta_key;
        $data->meta_description = $request->meta_description;
        $data->save();
        Toastr::success('Page inserted!', 'Title', ["positionClass" => "toast-top-right"]);
        return redirect()->route('pageslist');
    }

    public function edit(Request $request, $id){
        $data = Page::find($id);
        return view('page.edit', compact('data'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'menu_title' => 'required',
            'page_title' => 'required',
            'page_subtitle' => 'required',
            'banner_title' => 'required',
            'banner_subtitle' => 'required',
            'page_content' => 'required',
            'status' => 'required',
            'seo_title' => 'required',
            'meta_key' => 'required',
            'meta_description' => 'required'
        ]);

        $data = Page::find($id);
        $image = $request->file('banner_image');
        $slug = str_slug($request->menu_title);
        if($request->hasFile('banner_image')){
            $currentDate = Carbon::now()->toDateString();
            $imagename = 'pageBannerImage'.'/'.$slug.'-'.$currentDate.'-'.uniqid().'.'.
                $image->getClientOriginalExtension();
            if(!file_exists('pageBannerImage')){
                mkdir('pageBannerImage',0777,true);
            }
            $image->move('pageBannerImage',$imagename);
            $data->banner_image = $imagename;
        }
        $data->menu_title = $request->menu_title;
        $data->page_title = $request->page_title;
        $data->slug = $request->slug;
        $data->page_subtitle = $request->page_subtitle;
        $data->banner_title = $request->banner_title;
        $data->banner_subtitle = $request->banner_subtitle;
        $data->page_content = $request->page_content;
        $data->status = $request->status;
        $data->seo_title = $request->seo_title;
        $data->meta_key = $request->meta_key;
        $data->meta_description = $request->meta_description;
        $data->save();
        Toastr::success('Page Updated!', 'Title', ["positionClass" => "toast-top-right"]);
        return redirect()->route('pageslist');
    }

    public function delete(Request $request, $id){
        $data = Page::find($id);
        if (!empty($data->banner_image)){
            unlink($data->banner_image);
        }
        $data->delete();
        Toastr::error('Page Deleted!', 'title', ["positionClass" => "toast-top-right"]);
        return redirect()->route('pageslist');
    }
}
