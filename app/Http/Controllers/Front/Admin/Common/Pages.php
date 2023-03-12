<?php

namespace App\Http\Controllers\Admin\Common;

use foo\bar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Page as Page_model;
use App\Model\Common\Role;
use App\SM\SM;
use Illuminate\Support\Facades\Auth;

class Pages extends Controller
{
    function index()
    {
        $data['rightButton']['iconClass'] = 'fa fa-plus';
        $data['rightButton']['text'] = 'Add Page';
        $data['rightButton']['link'] = 'pages/create';
        return view('nptl-admin/common/page/index', $data);
    }

    public function dataProcessing(Request $request)
    {
        $edit_page = SM::check_this_method_access('page', 'edit_page') ? 1 : 0;
        $page_status_update = SM::check_this_method_access('page', 'page_status_update') ? 1 : 0;
        $delete_page = SM::check_this_method_access('page', 'delete_page') ? 1 : 0;
        $per = $edit_page + $delete_page;

        $columns = array(
            0 => 'id',
            1 => 'title',
        );

        $totalData = Page_model::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $products = Page_model::offset($start)
                ->limit($limit)
                //->orderBy($order, $dir)
                ->orderBy('id', 'desc')
                ->get();
            $totalFiltered = Page_model::count();
        } else {
            $search = $request->input('search.value');

            $products = Page_model::where('title', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                //->orderBy($order, $dir)
                ->orderBy('id', 'desc')
                ->get();
            $totalFiltered = Page_model::where('title', 'like', "%{$search}%")->count();
        }
        $data = array();

        if ($products) {
            foreach ($products as $v_data) {
                $nestedData['id'] = $v_data->id;
                $nestedData['menu_title'] = '<strong>' . $v_data->menu_title . '</strong>';
                $nestedData['page_title'] = $v_data->page_title;

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
                if ($page_status_update != 0) {
                    $nestedData['status'] = '<select class="form-control change_status"
                                            route="' . config('constant.smAdminSlug') . '/page_status_update' . '"
                                            post_id="' . $v_data->id . '">
                                        <option value="1" ' . $selected1 . '>Published </option>
                                        <option value="2" ' . $selected2 . '>Pending </option>
                                        <option value="3" ' . $selected3 . '>Canceled </option>
                                        </select>';
                }
                if ($per != 0) {
                    if ($edit_page != 0) {
                        $edit_data = '<a href="' . url(config('constant.smAdminSlug') . '/pages') . '/' . $v_data->id . '/edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
                    } else {
                        $edit_data = '';
                    }
                    if ($delete_page != 0) {
                        $delete_data = '<a href="' . url(config('constant.smAdminSlug') . '/pages/destroy') . '/' . $v_data->id . '" 
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

    function create()
    {
        $data['rightButton']['iconClass'] = 'fa fa-pagelines';
        $data['rightButton']['text'] = 'Page List';
        $data['rightButton']['link'] = 'pages';

        return view('nptl-admin/common/page/add_page', $data);
    }

    function store(Request $data)
    {
        $this->validate($data, [
            'menu_title' => 'required|min:2|max:20',
            'page_title' => 'required|min:2|max:100',
            'content' => 'required',
            'seo_title' => 'max:70',
            'meta_description' => 'max:215'
        ]);
        $page = new Page_model();
        $page->menu_title = $data['menu_title'];
        $page->page_title = $data['page_title'];
        $page->page_subtitle = $data['page_subtitle'];
        if (isset($data->image) && $data->image != '') {
            $page->banner_image = $data->image;
        }
        $page->content = $data['content'];
        if (SM::is_admin() || isset($permission) &&
            isset($permission['page']['page_status_update'])
            && $permission['page']['page_status_update'] == 1) {
            $page->status = $data->status;
        }

        $page->banner_title = $data->input("banner_title", "");
        $page->banner_subtitle = $data->input("banner_subtitle", "");
        $page->seo_title = $data->input("seo_title", "");
        $page->meta_key = $data['meta_key'];
        $page->meta_description = $data['meta_description'];
        $page->created_by = SM::current_user_id();
        $slug = (trim($data->slug) != '') ? $data->slug : $data->title;
        $page->slug = SM::create_uri('pages', $slug);

        if ($page->save()) {
            $this->removeThisCache();

            return redirect(config('constant.smAdminSlug') . '/pages')->with('s_message', 'Page successfully created!');
        } else {
            return redirect(config('constant.smAdminSlug') . '/pages')->with('w_message', 'Page Save Failed!');
        }


    }

    public function show($id)
    {
        //
    }

    function edit($id)
    {
        $data['page_info'] = Page_model::find($id);
        if ($data['page_info']) {
            $data['rightButton']['iconClass'] = 'fa fa-pagelines';
            $data['rightButton']['text'] = 'Page List';
            $data['rightButton']['link'] = 'pages';
            $data['rightButton2']['iconClass'] = 'fa fa-eye';
            $data['rightButton2']['text'] = 'View';
            $data['rightButton2']['link'] = $data['page_info']->slug;

            return view('nptl-admin/common/page/edit_page', $data);
        } else {
            return back()->with("w_message", "No Page Found!");
        }
    }

    function update(Request $data, $id)
    {
        $this->validate($data, [
            'menu_title' => 'required|min:2|max:20',
            'page_title' => 'required|min:2|max:100',
            'content' => 'required',
            'seo_title' => 'max:70',
            'meta_description' => 'max:215'
        ]);
        $page = Page_model::find($id);
        if (count($page) > 0) {
            $this->removeThisCache($page->slug);
            $page->menu_title = $data['menu_title'];
            $page->page_title = $data['page_title'];
            $page->page_subtitle = $data['page_subtitle'];
            $page->banner_title = $data->input("banner_title", "");
            $page->banner_subtitle = $data->input("banner_subtitle", "");
            if (isset($data->image) && $data->image != '') {
                $page->banner_image = $data->image;
            }
            $page->content = $data['content'];
            if (SM::is_admin() || isset($permission) &&
                isset($permission['page']['page_status_update'])
                && $permission['page']['page_status_update'] == 1) {
                $page->status = $data->status;
            }
            $page->seo_title = $data->input("seo_title", "");
            $page->meta_key = $data['meta_key'];
            $page->meta_description = $data['meta_description'];
            $page->modified_by = SM::current_user_id();
            $slug = (trim($data->slug) != '') ? $data->slug : $data->title;
            $page->slug = SM::create_uri('pages', $slug, $id);
            $updateCount = $page->update();
            if ($updateCount > 0) {
                return redirect(config('constant.smAdminSlug') . '/pages')->with('s_message', 'Page updated successfully!');
            } else {
                return redirect(config('constant.smAdminSlug') . '/pages')->with('w_message', 'Page update error occurs!');
            }
        } else {
            return redirect(config('constant.smAdminSlug') . '/pages')->with('w_message', 'Page update error occurs!');
        }
    }

    public function destroy($id)
    {

        $cat = Page_model::find($id);
        if (count($cat) > 0) {
            if ($cat->delete() > 0) {
                $this->removeThisCache($cat->slug);
                return response(1);
            }
        }

        return response(0);
    }


    public function page_status_update(Request $data)
    {
        $page = Page_model::find($data['post_id']);
        if ($page) {
            $page->status = $data['status'];
            $page->save();
            $this->removeThisCache($page->slug);
        }
        echo 1;
    }

    private function removeThisCache($slug = null)
    {
        if ($slug != null) {
            SM::removeCache('page_' . $slug);
        }
        SM::removeCache(['page'], 1);
    }
}
