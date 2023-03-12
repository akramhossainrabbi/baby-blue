<?php

namespace App\Http\Controllers\Admin\Common;

use App\Model\Common\Category;
use App\Model\Common\Categoryable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Category as Category_model;
use App\SM\SM;
use Illuminate\Support\Facades\Cache;

class Categories extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['rightButton']['iconClass'] = 'fa fa-plus';
        $data['rightButton']['text'] = 'Add Category';
        $data['rightButton']['link'] = 'categories/create';

        return view("nptl-admin/common/category/index", $data);
    }

    public function dataProcessing(Request $request)
    {
        $edit_category = SM::check_this_method_access('categories', 'edit') ? 1 : 0;
        $status_update = SM::check_this_method_access('categories', 'category_status_update') ? 1 : 0;
        $delete_category = SM::check_this_method_access('categories', 'destroy') ? 1 : 0;
        $per = $edit_category + $delete_category;

        $columns = array(
            0 => 'id',
            1 => 'title',
        );

        $totalData = Category::where('parent_id', 0)->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $categories = Category::where('parent_id', 0)
                ->offset($start)
                ->limit($limit)
                //->orderBy($order, $dir)
//                ->orderBy('id', 'desc')
                ->get();
            $totalFiltered = Category::where('parent_id', 0)->count();
        } else {
            $search = $request->input('search.value');

            $categories = Category::where('title', 'like', "%{$search}%")
//                ->orWhere('branch', 'like', "%{$search}%")
//                ->orWhere('account_no', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                //->orderBy($order, $dir)
//                ->orderBy('id', 'desc')
                ->get();
            $totalFiltered = Category::where('title', 'like', "%{$search}%")->count();
        }
        $data = array();

        if ($categories) {
            foreach ($categories as $v_data) {
                $nestedData['title'] = '<strong>' . $v_data->title . '</strong>';
                $nestedData['color_code'] = '<div style="background-color: ' . $v_data->color_code . ' ; width: 25px; height: 25px;"></div>';
                $nestedData['priority'] = $v_data->priority;
                $nestedData['image'] = '<img class="img-product" src="' . SM::sm_get_the_src($v_data->image, 80, 80) . '">';
                $nestedData['fav_icon'] = '<img class="img-product" src="' . SM::sm_get_the_src($v_data->fav_icon, 30, 30) . '">';
                $nestedData['total_products'] = $v_data->total_products;

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
                if ($status_update != 0) {
                    $nestedData['status'] = '<select class="form-control change_status"
                                            route="' . config('constant.smAdminSlug') . '/category_status_update' . '"
                                            post_id="' . $v_data->id . '">
                                        <option value="1" ' . $selected1 . '>Published </option>
                                        <option value="2" ' . $selected2 . '>Pending </option>
                                        <option value="3" ' . $selected3 . '>Canceled </option>
                                        </select>';
                }
                if ($per != 0) {
                    if ($edit_category != 0) {
                        $edit_data = '<a href="' . url(config('constant.smAdminSlug') . '/categories') . '/' . $v_data->id . '/edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
                    } else {
                        $edit_data = '';
                    }
                    if ($delete_category != 0) {
                        $delete_data = '<a href="' . url(config('constant.smAdminSlug') . '/categories/destroy') . '/' . $v_data->id . '" 
                  title="Delete" class="btn btn-xs btn-default delete_data_row" delete_message="Are you sure to delete this data?" delete_row="tr_' . $v_data->id . '">
                     <i class="fa fa-times"></i>
                    </a> ';
                    } else {
                        $delete_category = '';
                    }
                    $nestedData['action'] = $edit_data . ' ' . $delete_data;
                } else {
                    $nestedData['action'] = '';
                }
                $data[] = $nestedData;

                $tcategories_data = Category::where('parent_id', $v_data->id)->get();

                if ($tcategories_data) {
                    foreach ($tcategories_data as $category_data) {
                        $nestedData['title'] = '__<strong>' . $category_data->title . '</strong>';
                        $nestedData['color_code'] = '<div style="background-color: ' . $category_data->color_code . ' ; width: 25px; height: 25px;"></div>';
                        $nestedData['priority'] = $category_data->priority;
                        $nestedData['image'] = '<img class="img-product" src="' . SM::sm_get_the_src($category_data->image, 80, 80) . '">';
                        $nestedData['fav_icon'] = '<img class="img-product" src="' . SM::sm_get_the_src($category_data->fav_icon, 30, 30) . '">';
                        $nestedData['total_products'] = $category_data->total_products;

                        if ($category_data->status == 1) {
                            $selected1 = "Selected";
                        } else {
                            $selected1 = '';
                        }
                        if ($category_data->status == 2) {
                            $selected2 = "Selected";
                        } else {
                            $selected2 = "";
                        }
                        if ($category_data->status == 3) {
                            $selected3 = "Selected";
                        } else {
                            $selected3 = "";
                        }
                        if ($status_update != 0) {
                            $nestedData['status'] = '<select class="form-control change_status"
                                            route="' . config('constant.smAdminSlug') . '/category_status_update' . '"
                                            post_id="' . $category_data->id . '">
                                        <option value="1" ' . $selected1 . '>Published </option>
                                        <option value="2" ' . $selected2 . '>Pending </option>
                                        <option value="3" ' . $selected3 . '>Canceled </option>
                                        </select>';
                        }
                        if ($per != 0) {
                            if ($edit_category != 0) {
                                $edit_data = '<a href="' . url(config('constant.smAdminSlug') . '/categories') . '/' . $category_data->id . '/edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
                            } else {
                                $edit_data = '';
                            }
                            if ($delete_category != 0) {
                                $delete_data = '<a href="' . url(config('constant.smAdminSlug') . '/categories/delete') . '/' . $category_data->id . '" 
                  title="Delete" class="btn btn-xs btn-default delete_data_row" delete_message="Are you sure to delete this data?" delete_row="tr_' . $v_data->id . '">
                     <i class="fa fa-times"></i>
                    </a> ';
                            } else {
                                $delete_category = '';
                            }
                            $nestedData['action'] = $edit_data . ' ' . $delete_data;
                        } else {
                            $nestedData['action'] = '';
                        }
                        $data[] = $nestedData;
                    }
                }
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
        $data['rightButton']['text'] = 'Category List';
        $data['rightButton']['link'] = 'categories';
        $data["categories"] = Category_model::where("parent_id", 0)->get();

        return view("nptl-admin/common/category/add_category", $data);
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
            'title' => 'required|max:100',
            "parent_id" => "required",
            'seo_title' => 'max:70',
            'meta_description' => 'max:215'
        ]);
        $category = $request->all();
        $permission = SM::current_user_permission_array();
        if (SM::is_admin() || isset($permission) &&
            isset($permission['categories']['category_status_update'])
            && $permission['categories']['category_status_update'] == 1) {
            $category['status'] = $request->status;
        }
//        if (isset($request->image) && $request->image != '') {
//            $category['image'] = $request->image;
//        }
//        if (isset($request->image_gallery) && $request->image_gallery != '') {
//            $category->image_gallery = $request->image_gallery;
//        }

        $slug = (trim($request->slug) != '') ? $request->slug : $request->title;
        $category['slug'] = SM::create_uri('categories', $slug);
        $category['is_featured'] = isset($request->is_featured) && $request->is_featured == 'on' ? 1 : 0;
        $category['is_catalogue'] = isset($request->is_catalogue) && $request->is_catalogue == 'on' ? 1 : 0;
        $category['created_by'] = SM::current_user_id();
        $category['seo_title'] = $request->input("seo_title", "");
        $category['meta_key'] = $request->input("meta_key", "");
        $category['meta_description'] = $request->input("meta_description", "");
        $cat = Category_model::create($category);
        if ($cat) {
            $this->removeThisCache();

            return redirect(SM::smAdminSlug("categories/$cat->id/edit"))
                ->with('s_message', 'Category Saved Successfully!');
        } else {
            return redirect(SM::smAdminSlug("categories"))
                ->with('s_message', 'Category Save Failed!');
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
        $data["category_info"] = Category_model::find($id);
        if (count($data["category_info"]) > 0) {
            $data['rightButton']['iconClass'] = 'fa fa-list-alt';
            $data['rightButton']['text'] = 'Category List';
            $data['rightButton']['link'] = 'categories';
            $data['rightButton2']['iconClass'] = 'fa fa-eye';
            $data['rightButton2']['text'] = 'View';
            $data['rightButton2']['link'] = "/products/category/" . $data['category_info']->slug;

            $data["categories"] = Category_model::where("parent_id", 0)->get();

            return view("nptl-admin/common/category/edit_category", $data);
        } else {
            return redirect(SM::smAdminSlug('categories'))
                ->with('s_message', 'Category not found!');
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
            'title' => 'required|max:100',
            "parent_id" => "required",
            'seo_title' => 'max:70',
            'meta_description' => 'max:215'
        ]);

        $category = Category_model::find($id);

        if (count($category) > 0) {
            $this->removeThisCache($category->slug);
            $category->title = $request->title;
            $category->parent_id = $request->parent_id;
            $category->color_code = $request->color_code;
            $category->priority = $request->priority;
            $category->description = $request->description;
            $category->is_featured = isset($request->is_featured) && $request->is_featured == 'on' ? 1 : 0;
            $category->seo_title = $request->input("seo_title", "");
            $category->meta_key = $request->input("meta_key", "");
            $category->meta_description = $request->input("meta_description", "");
            $permission = SM::current_user_permission_array();
            if (SM::is_admin() || isset($permission) &&
                isset($permission['categories']['category_status_update'])
                && $permission['categories']['category_status_update'] == 1) {
                $category->status = $request->status;
            }
            if (isset($request->image) && $request->image != '') {
                $category->image = $request->image;
            }
//            if (isset($request->image_gallery) && $request->image_gallery != '') {
            $category->image_gallery = $request->image_gallery;
//            }
            if (isset($request->fav_icon) && $request->fav_icon != '') {
                $category->fav_icon = $request->fav_icon;
            }

            $slug = (trim($request->slug) != '') ? $request->slug : $request->title;
            $category->slug = SM::create_uri('categories', $slug, $id);
            $category->modified_by = SM::current_user_id();

            if ($category->update() > 0) {
                $this->removeThisCache();

                return redirect(SM::smAdminSlug("categories/$category->id/edit"))
                    ->with('s_message', 'Category Update Successfully!');
            } else {
                return redirect(SM::smAdminSlug("categories/$category->id/edit"))
                    ->with('s_message', 'Category Update Failed!');
            }
        } else {
            return redirect(SM::smAdminSlug('categories'))
                ->with('w_message', 'Category not found!');
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
        $cat = Category_model::find($id);
        if (count($cat) > 0) {
            $catgoryables = Categoryable::where('category_id', $id)->get();
            if (count($catgoryables) > 0) {
                foreach ($catgoryables as $catgoryable) {
                    $catgoryable->delete();
                }
            }

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
    public function category_status_update(Request $request)
    {
        $this->validate($request, [
            "post_id" => "required",
            "status" => "required",
        ]);

        $cat = Category_model::find($request->post_id);
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
            SM::removeCache('category_' . $slug);
        }
        SM::removeCache('categories_have_posts');
        SM::removeCache('categories_have_not_post');
        SM::removeCache(['category'], 1);
        SM::removeCache(['categoryBlogs'], 1);
    }
}
