<?php

namespace App\Http\Controllers\Admin\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Wholesale;
use App\SM\SM;
use Maatwebsite\Excel\Facades\Excel;

class Wholesales extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//		$data['rightButton']['iconClass'] = 'fa fa-plus';
//		$data['rightButton']['text']      = 'Add Wholesale';
//		$data['rightButton']['link']      = 'wholesales/create';
        $data['name'] = $request->input('name', '');
        $data['email'] = $request->input('email', '');
        $data['contact'] = $request->input('contact', '');
        $data['status'] = $request->input('status', '');
        $query = Wholesale::orderBy("id", "desc");

        if ($data['name'] != '') {
            $query->where('name', '=', $data['name']);
        }
        if ($data['email'] != '') {
            $query->where('email', '=', $data['email']);
        }
        if ($data['status'] != '') {
            $query->where('status', '=', $data['status']);
        }
        if ($data['contact'] != '') {
            $query->where('contact', '=', $data['contact']);
        }
        $data['all_wholesale'] = $query->paginate(config("constant.smPagination"));
        if (\request()->ajax()) {
            $json['data'] = view('nptl-admin/common/wholesale/wholesales', $data)->render();
            $json['smPagination'] = view('nptl-admin/common/common/pagination_links', [
                'smPagination' => $data['all_wholesale']
            ])->render();

            return response()->json($json);
        }
        if ($request->has('excel') && $request->excel == 'excel') {
            $all_wholesale = $data['all_wholesale'];
            if (count($all_wholesale) > 0) {
                Excel::create('wholesales_' . date('YmdHis'), function ($excel) use ($all_wholesale) {
                    $excel->sheet('Wholesales ' . date('Y-m-d'), function ($sheet) use ($all_wholesale) {
                        $loop = 1;
                        $sheet->mergeCells("A$loop:G$loop");
                        $sheet->cells("A$loop:G$loop", function ($cells) {
                            $cells->setBackground('#1d2d5d');
                            $cells->setFontColor('#ffffff');
                            $cells->setFontSize(18);
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                            // Set all borders (top, right, bottom, left)
                            $cells->setBorder('none', 'none', 'solid', 'none');

// Set borders with array
                            $cells->setBorder(array(
                                'bottom' => array(
                                    'style' => 'solid'
                                ),
                            ));
                        });
                        $single = [];
                        $single[] = 'Wholesales';
                        $sheet->row($loop, $single);
                        $sheet->getRowDimension($loop)->setRowHeight(40);
                        $loop++;

                        $single = [];
                        $single[] = 'Name';
                        $single[] = 'Email';
                        $single[] = 'Contact';
                        $single[] = 'Location';
                        $single[] = 'Business';
                        $single[] = 'Business Type';
                        $single[] = 'Category';
                        $sheet->row($loop, $single);
                        $sheet->cells("A$loop:G$loop", function ($cells) {
                            $cells->setBackground('#1d2d5d');
                            $cells->setFontColor('#ffffff');
                            $cells->setFontSize(12);
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                        });
                        $sheet->getRowDimension($loop)->setRowHeight(20);
                        $loop++;
                        $loop++;
                        foreach ($all_wholesale as $wholesale) {
                            $single = [];
                            $single[] = $wholesale->name;
                            $single[] = $wholesale->email;
                            $single[] = $wholesale->contact;
                            $single[] = $wholesale->location;
                            $single[] = $wholesale->business;
                            $single[] = $wholesale->business_type;
                            $single[] = $wholesale->category_id;

                            $sheet->row($loop, $single);
                            $loop++;
                        }
                        $loop++;


                        $single = [];
                        $sheet->mergeCells("A$loop:G$loop");
                        $sheet->cells("A$loop:G$loop", function ($cells) {
                            $cells->setBackground('#1d2d5d');
                            $cells->setFontColor('#ffffff');
                            $cells->setFontSize(12);
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                        });
                        $single[0] = 'Developed by Next Page Technology Ltd.';
                        $sheet->row($loop, $single);


                    });

                })->download('xlsx');
            } else {
                return view("nptl-admin/common/wholesale/manage_wholesale", $data);
            }
        } else {
            return view("nptl-admin/common/wholesale/manage_wholesale", $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['rightButton']['iconClass'] = 'fa fa-wholesales';
        $data['rightButton']['text'] = 'Wholesale List';
        $data['rightButton']['link'] = 'wholesales';

        return view("nptl-admin/common/wholesale/add_wholesale", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            "meta_key" => "max:160",
            "meta_description" => "max:160"
        ]);
        $wholesale = new Wholesale();
        $wholesale->title = $request->title;
        $wholesale->description = $request->description;
        $wholesale->meta_key = $request->meta_key;
        $wholesale->meta_description = $request->meta_description;

        if (SM::is_admin() || isset($permission) &&
            isset($permission['wholesales']['wholesale_status_update'])
            && $permission['wholesales']['wholesale_status_update'] == 1) {
            $wholesale->status = $request->status;
        }
        if (isset($request->image) && $request->image != '') {
            $wholesale->image = $request->image;
        }

        $slug = (trim($request->slug) != '') ? $request->slug : $request->title;
        $wholesale->slug = SM::create_uri('wholesales', $slug);
        $wholesale->created_by = SM::current_user_id();
        $wholesale->save();

        return redirect(SM::smAdminSlug('wholesales'))
            ->with('s_message', 'Wholesale created successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
//	public function show( $id ) {
//		//
//	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['wholesale_info'] = Wholesale::find($id);
        if (count($data['wholesale_info']) > 0) {
            $data['rightButton']['iconClass'] = 'fa fa-wholesales';
            $data['rightButton']['text'] = 'Wholesale List';
            $data['rightButton']['link'] = 'wholesales';

            return view('nptl-admin/common/wholesale/edit_wholesale', $data);
        } else {
            return redirect(SM::smAdminSlug("wholesales"))
                ->with("w_message", "No wholesale Found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255|unique:wholesales,email,' . $id
        ]);
        $wholesale = Wholesale::find($id);
        if (count($wholesale) > 0) {
            $wholesale->email = $request->email;
            $wholesale->firstname = $request->firstname;
            $wholesale->lastname = $request->lastname;
            $wholesale->state = $request->state;
            $wholesale->country = $request->country;
            $wholesale->city = $request->city;
            $wholesale->extra = $request->extra;

            if (SM::is_admin() || isset($permission) &&
                isset($permission['wholesales']['wholesale_status_update'])
                && $permission['wholesales']['wholesale_status_update'] == 1) {
                $wholesale->status = $request->status;
            }
            $wholesale->update();

            return redirect(SM::smAdminSlug('wholesales'))
                ->with('s_message', 'Wholesale updated successfully!');
        } else {
            return redirect(SM::smAdminSlug("wholesales"))
                ->with("w_message", "No wholesale Found!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wholesale = Wholesale::find($id);
        if (count($wholesale) > 0) {
            $wholesale->delete();

            echo 1;
            exit;
        } else {
            echo 0;
            exit;
        }
    }

    /**
     * status change the specified resource from storage.
     *
     * @param  Request $request
     *
     * @return null
     */
    public function wholesale_status_update(Request $request)
    {
        $this->validate($request, [
            "post_id" => "required",
            "status" => "required",
        ]);

        $wholesale = Wholesale::find($request->post_id);
        if (count($wholesale) > 0) {
            $wholesale->status = $request->status;
            $wholesale->update();
            echo 1;
        }
        exit;
    }
}
