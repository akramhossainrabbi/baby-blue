<?php

namespace App\Http\Controllers;

use App\Slider;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SlidersController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Slider::latest();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    if (isset($data)){
                        $msg = "return confirm('Are you sure to Delete?')";
                        return '<a href="'.url('edit/'.$data->id).
                            '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> &nbsp;&nbsp;&nbsp;<a href="'.url('delete/'.$data->id).
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
        return view('slider.list');
    }

    public function create(){
        return view('slider.create');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'style' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:2048',
            'status' => 'required'
        ]);

        try {
            $image = $request->file('image');
            $slug = str_slug($request->title);
            if(isset($image)){
                $currentDate = Carbon::now()->toDateString();
                $imagename = 'slidersImage'.'/'.$slug.'-'.$currentDate.'-'.uniqid().'.'.
                    $image->getClientOriginalExtension();
                if(!file_exists('slidersImage')){
                    mkdir('slidersImage',0777,true);
                }
                $image->move('slidersImage',$imagename);
            }else{
                $imagename = "default.png";
            }

            $data = new Slider();
            $data->title = $request->title;
            $data->style = $request->style;
            $data->description = $request->description;
            $data->image = $imagename;
            $data->status = $request->status;
            $data->save();
            Toastr::success('Slider inserted!', 'Title', ["positionClass" => "toast-top-right"]);
            return redirect()->route('sliderslist');
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
        }
    }

    public function edit(Request $request, $id){
        $data = Slider::find($id);
        return view('slider.edit', compact('data'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'style' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        $data = Slider::find($id);
        $image = $request->file('image');
        $slug = str_slug($request->title);
        if($request->hasFile('image')){
            $currentDate = Carbon::now()->toDateString();
            $imagename = 'slidersImage'.'/'.$slug.'-'.$currentDate.'-'.uniqid().'.'.
                $image->getClientOriginalExtension();
            if(!file_exists('slidersImage')){
                mkdir('slidersImage',0777,true);
            }
            $image->move('slidersImage',$imagename);
            $data->image = $imagename;
        }

        $data->title = $request->title;
        $data->style = $request->style;
        $data->description = $request->description;
        $data->status = $request->status;
        $data->save();
        Toastr::success('Slider Updated!', 'Title', ["positionClass" => "toast-top-right"]);
        return redirect()->route('sliderslist');
    }

    public function delete(Request $request, $id){
        $data = Slider::find($id);
        if (!empty($data->image)){
            unlink($data->image);
        }
        $data->delete();
        Toastr::error('Slider Deleted!', 'title', ["positionClass" => "toast-top-right"]);
        return redirect()->route('sliderslist');
    }
}
