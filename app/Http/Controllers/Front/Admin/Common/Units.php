<?php

namespace App\Http\Controllers\Admin\Common;

use App\Model\Common\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Unit as Unit_Model;
use App\SM\SM;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Units extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['rightButton']['iconClass'] = 'fa fa-plus';
        $data['rightButton']['text'] = 'Add Unit';
        $data['rightButton']['link'] = 'units/create';
        return view("nptl-admin.common.unit.index", $data);
    }

    public function dataProcessing(Request $request)
    {
        $edit_unit = SM::check_this_method_access('units', 'edit') ? 1 : 0;
        $unit_status_update = SM::check_this_method_access('units', 'unit_status_update') ? 1 : 0;
        $delete_unit = SM::check_this_method_access('units', 'destroy') ? 1 : 0;
        $per = $edit_unit + $delete_unit;

        $columns = array(
            0 => 'id',
            1 => 'title',
        );

        $totalData = Unit::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $products = Unit::offset($start)
                ->limit($limit)
                //->orderBy($order, $dir)
                ->orderBy('id', 'desc')
                ->get();
            $totalFiltered = Unit::count();
        } else {
            $search = $request->input('search.value');

            $products = Unit::where('title', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                //->orderBy($order, $dir)
                ->orderBy('id', 'desc')
                ->get();
            $totalFiltered = Unit::where('title', 'like', "%{$search}%")->count();
        }
        $data = array();

        if ($products) {
            foreach ($products as $v_data) {
                $nestedData['id'] = $v_data->id;
                $nestedData['title'] = '<strong>' . $v_data->title . '</strong>';
                $nestedData['actual_name'] = $v_data->actual_name;
                if ($v_data->status == 1) {
                    $selected1 = "Selected";
                } else {
                    $selected1 = '';
                }
                if ($v_data->status == 2) {
                    $selected2 = "Selected";
                } else {
                    $selected2 = "";
                }
                if ($v_data->status == 3) {
                    $selected3 = "Selected";
                } else {
                    $selected3 = "";
                }
                if ($unit_status_update != 0) {
                    $nestedData['status'] = '<select class="form-control change_status"
                                            route="' . config('constant.smAdminSlug') . '/unit_status_update' . '"
                                            post_id="' . $v_data->id . '">
                                        <option value="1" ' . $selected1 . '>Published </option>
                                        <option value="2" ' . $selected2 . '>Pending </option>
                                        <option value="3" ' . $selected3 . '>Canceled </option>
                                        </select>';
                }
                if ($per != 0) {
                    if ($edit_unit != 0) {
                        $edit_data = '<a href="' . url(config('constant.smAdminSlug') . '/units') . '/' . $v_data->id . '/edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
                    } else {
                        $edit_data = '';
                    }
                    if ($delete_unit != 0) {
                        $delete_data = '<a href="' . url(config('constant.smAdminSlug') . '/units/destroy') . '/' . $v_data->id . '" 
                  title="Delete" class="btn btn-xs btn-default delete_data_row" delete_message="Are you sure to delete this data?" delete_row="tr_' . $v_data->id . '">
                     <i class="fa fa-times"></i>
                    </a> ';
                    } else {
                        $delete_data = '';
                    }
                    $nestedData['action'] = $edit_data . ' ' . $delete_data;
                } else {
                    $nestedData['action'] = '';
                }
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['rightButton']['iconClass'] = 'fa fa-list-alt';
        $data['rightButton']['text'] = 'Unit List';
        $data['rightButton']['link'] = 'units';
        $data['quick_add'] = false;
        if (!empty(request()->input('quick_add'))) {
            $data['quick_add'] = true;
        }

        return view("nptl-admin.common.unit.add_unit", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    // hospital_store
    public function unit_store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
        ]);
        $title = $request->input('title');
        $data['created_by'] = SM::current_user_id();
        $data['title'] = $title;
        $data['slug'] = str_slug($title, '-');
        $data['actual_name'] = $request->input('actual_name');
        $data['status'] = 2;
        $c_category = DB::table('units')->where('title', $data['title'])->get();
        $count = count($c_category);
        if ($count < 1) {
            if (DB::table('units')->insert($data)) {
                $hos_data = DB::table('units')->get();
                foreach ($hos_data as $v_data) {
                    echo "<option value=\"$v_data->id\">$v_data->title</option>";
                }
            } else {
                $hos_data = DB::table('units')->get();
                foreach ($hos_data as $v_data) {
                    echo "<option value=\"$v_data->id\">$v_data->title</option>";
                }
            }
        } else {
            $hos_data = DB::table('units')->get();
            foreach ($hos_data as $v_data) {
                echo "<option value=\"$v_data->id\">$v_data->title</option>";
            }
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:150',
        ]);
        $unit = $request->all();
        $permission = SM::current_user_permission_array();
        if (SM::is_admin() || isset($permission) &&
            isset($permission['units']['unit_status_update'])
            && $permission['units']['unit_status_update'] == 1) {
            $unit['status'] = $request->status;
        }

        $slug = (trim($request->slug) != '') ? $request->slug : $request->title;
        $unit['slug'] = SM::create_uri('units', $slug);
        $unit['actual_name'] = $request->input("actual_name", "");
        $unit['created_by'] = SM::current_user_id();
        $cat = Unit_Model::create($unit);
        if ($cat) {
            $this->removeThisCache();

            return redirect(SM::smAdminSlug("units"))
                ->with('s_message', 'Unit Saved Successfully!');
        } else {
            return redirect(SM::smAdminSlug("units"))
                ->with('s_message', 'Unit Save Failed!');
        }

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
        $data["unit_info"] = Unit_Model::find($id);
        if (count($data["unit_info"]) > 0) {
            $data['rightButton']['iconClass'] = 'fa fa-list-alt';
            $data['rightButton']['text'] = 'Unit List';
            $data['rightButton']['link'] = 'units';
            $data['rightButton2']['iconClass'] = 'fa fa-eye';
            $data['rightButton2']['text'] = 'View';
            $data['rightButton2']['link'] = "unit/unit/" . $data['unit_info']->slug;
            return view("nptl-admin/common/unit/edit_unit", $data);
        } else {
            return redirect(SM::smAdminSlug('units'))
                ->with('s_message', 'Unit not found!');
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
            'title' => 'required|max:150',
        ]);
        $unit = Unit_Model::find($id);
        if (count($unit) > 0) {
            $this->removeThisCache($unit->slug);
            $unit->title = $request->title;
            $unit->actual_name = $request->actual_name;
            $permission = SM::current_user_permission_array();
            if (SM::is_admin() || isset($permission) &&
                isset($permission['units']['unit_status_update'])
                && $permission['units']['unit_status_update'] == 1) {
                $unit->status = $request->status;
            }
            if (isset($request->image) && $request->image != '') {
                $unit->image = $request->image;
            }

            $slug = (trim($request->slug) != '') ? $request->slug : $request->title;
            $unit->slug = SM::create_uri('units', $slug, $id);
            $unit->modified_by = SM::current_user_id();

            if ($unit->update() > 0) {
                $this->removeThisCache();

                return redirect(SM::smAdminSlug("units/$unit->id/edit"))
                    ->with('s_message', 'Unit Update Successfully!');
            } else {
                return redirect(SM::smAdminSlug("units/$unit->id/edit"))
                    ->with('s_message', 'Unit Update Failed!');
            }
        } else {
            return redirect(SM::smAdminSlug('units'))
                ->with('w_message', 'Unit not found!');
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
        $cat = Unit_Model::find($id);
        if (count($cat) > 0) {
            if ($cat->delete() > 0) {
                $this->removeThisCache($cat->slug);
                return response(1);
            }
        }

        return response(0);
    }

    /**
     * status change the specified resource from storage.
     *
     * @param  Request $request
     *
     * @return null
     */
    public function unit_status_update(Request $request)
    {
        $this->validate($request, [
            "post_id" => "required",
            "status" => "required",
        ]);

        $cat = Unit_Model::find($request->post_id);
        if (count($cat) > 0) {
            $cat->status = $request->status;
            $cat->update();
            $this->removeThisCache($cat->slug);
        }
        exit;
    }

    private function removeThisCache($slug = null)
    {
        if ($slug != null) {
            SM::removeCache('unit_' . $slug);
        }
        SM::removeCache('units_have_posts');
        SM::removeCache('units_have_not_post');
        SM::removeCache(['unit'], 1);
        SM::removeCache(['unitBlogs'], 1);
    }
}
