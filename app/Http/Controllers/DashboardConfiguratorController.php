<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DashboardConfiguration;

class DashboardConfiguratorController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function get_image_src()
    {
        $is_upload = (int)$_POST["is_upload"];
        if ($is_upload == 1) {
            $ids = $_POST["ids"];
            ?>
            <img class="media_img" src="<?php echo SM::sm_get_the_src($ids, 112, 112) ?>"
                 width="100px"/>
            <?php
            exit();
        } else {
            $ids = $_POST["ids"];
            $filedId = (int)$_POST["filedId"];
            $image_array = [];
            if (!$image_array = explode(',', $ids)) {
                $image_array = array($ids);
            }
            if (is_array($image_array) && count($image_array) > 0) {
                foreach ($image_array as $img_id) {
                    if (!SM::sm_string($img_id)) {
                        continue;
                    }
                    ?>
                    <span class="gl_img">
                                 <img class="" src="<?php echo SM::sm_get_the_src($img_id, 112, 112) ?>"
                                      width="100px"/>
                                 <span class="displayNone remove">
                                     <i class="fa fa-times-circle remove_img"
                                        data-img="<?php echo $img_id; ?>"
                                        data-input_holder="<?php echo $filedId; ?>"
                                     ></i>
                                 </span>
                              </span>
                    <?php
                }
            }
            exit();
        }
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
        $business_id = request()->session()->get('user.business_id');

        //get the configuration.
        $dashboard = DashboardConfiguration::where('business_id', $business_id)->findorfail($id);
        $dashboard->configuration = json_decode($dashboard->configuration, true);
        
        //Get all widgets
        $available_widgets = [
            'widget1' => ['title' => 'Widget 1'],
            'widget2' => ['title' => 'Widget 2'],
            'widget3' => ['title' => 'Widget 3']
        ];

        return view('dashboard_configurator.edit', compact('dashboard', 'available_widgets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('configure_dashboard')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['configuration']);
            $business_id = $request->session()->get('user.business_id');

            $dashboard = DashboardConfiguration::where('business_id', $business_id)->findOrFail($id);
            $dashboard->configuration = $input['configuration'];
            $dashboard->save();

            $output = ['success' => true,
                        'msg' => __("lang_v1.success")
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
        
            $output = ['success' => false,
                        'msg' => __("messages.something_went_wrong")
                    ];
        }

        return back()->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
