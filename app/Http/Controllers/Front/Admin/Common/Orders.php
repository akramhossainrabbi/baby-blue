<?php

namespace App\Http\Controllers\Admin\Common;

use App\Mail\InvoiceMail;
use App\Mail\NormalMail;
use App\Model\Common\Media_permissions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Order;
use App\Model\Common\Payment;
use Barryvdh\DomPDF\Facade as PDF;
use App\SM\SM;
use App\Model\Common\Media;

class Orders extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("nptl-admin.common.order.index");
    }

    public function dataProcessing(Request $request)
    {
        $edit_order = SM::check_this_method_access('orders', 'edit') ? 1 : 0;
        $order_status_update = SM::check_this_method_access('orders', 'order_status_update') ? 1 : 0;
        $delete_order = SM::check_this_method_access('orders', 'destroy') ? 1 : 0;
        $per = $edit_order + $delete_order;

        $columns = array(
            0 => 'id',
            1 => 'title',
        );

        $totalData = Order::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $orders = Order::offset($start)
                ->limit($limit)
                //->orderBy($order, $dir)
                ->orderBy('id', 'desc')
                ->get();
            $totalFiltered = Order::count();
        } else {
            $search = $request->input('search.value');

            $orders = Order::where('id', 'like', "%{$search}%")
                ->orWhere('customer_name', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                //->orderBy($order, $dir)
                ->orderBy('id', 'desc')
                ->get();
            $totalFiltered = Order::where('id', 'like', "%{$search}%")->orWhere('customer_name', 'like', "%{$search}%")->count();
        }
        $data = array();

        if ($orders) {
            foreach ($orders as $v_data) {
                $nestedData['id'] = SM::orderNumberFormat($v_data);
                $nestedData['customer'] = 'Name: <strong>' . $v_data->user->firstname . '</strong> M: '.$v_data->user->mobile;
                $nestedData['total'] = SM::order_currency_price_value($v_data->id, $v_data->grand_total);
                $nestedData['paid'] = SM::order_currency_price_value($v_data->id, $v_data->paid, 2);
                $due = $v_data->paid - $v_data->grand_total;
                $dueSign = $due < 0 ? "-" : "+";
                $dueSign = $due == 0 ? "" : $dueSign;

                $nestedData['due'] = SM::order_currency_price_value($v_data->id, $due);
                if ($v_data->order_status == 1) {
                    $selected1 = "Selected";
                } else {
                    $selected1 = '';
                }
                if ($v_data->order_status == 2) {
                    $selected2 = "Selected";
                } else {
                    $selected2 = "";
                }
                if ($v_data->order_status == 3) {
                    $selected3 = "Selected";
                } else {
                    $selected3 = "";
                }
                if ($v_data->order_status == 4) {
                    $selected4 = "Selected";
                } else {
                    $selected4 = "";
                }
                if ($order_status_update != 0) {
                    $nestedData['o_status'] = ' <select class="form-control order_change_status"
                                                id="order_change_status_' . $v_data->id . '"
                                                data-post_id="' . $v_data->id . '"
                                                data-due="' . abs($due) . '"
                                                data-row="' . $v_data->id . '"> 
                                        <option value="1" ' . $selected1 . '>Completed </option>
                                        <option value="2" ' . $selected2 . '>Progress </option>
                                        <option value="3" ' . $selected3 . '>Pending </option>
                                        <option value="4" ' . $selected4 . '>Canceled </option>
                                        </select>';
                }

                if ($v_data->payment_status == 1) {
                    $selected1 = "Selected";
                } else {
                    $selected1 = '';
                }
                if ($v_data->payment_status == 2) {
                    $selected2 = "Selected";
                } else {
                    $selected2 = "";
                }
                if ($v_data->payment_status == 3) {
                    $selected3 = "Selected";
                } else {
                    $selected3 = "";
                }
                if ($order_status_update != 0) {
                    $nestedData['p_status'] = ' <select class="form-control payment_change_status"
                id="payment_change_status_' . $v_data->id . '"
                data-post_id="' . $v_data->id . '"
                data-due="' . abs($due) . '"
                data-row="' . $v_data->id . '">
                <option value="1" ' . $selected1 . '>Published </option>
                <option value="2" ' . $selected2 . '>Pending </option>
                <option value="3" ' . $selected3 . '>Canceled </option>
                </select>';
                }
                if ($per != 0) {
                    $send_mail = '<a href="javascript:void(0)" data-post_id="' . $v_data->id . '" title="Send Mail" class="btn btn-xs btn-success showOrderMailModal">
                                <i class="fa fa-envelope"></i>
                            </a>';
                    $view_invoice = ' <a target="_blank"
                                   href="' . url(config('constant.smAdminSlug') . '/orders') . '/' . $v_data->id . '?isAdmin=1"
                                   title="View Invoice" class="btn btn-xs btn-default" id="">
                                    <i class="fa fa-eye"></i>
                                </a>';
                    $download_invoice = '<a href="' . url(config('constant.smAdminSlug') . '/orders/download/' . $v_data->id) . '"
                                       title="Download Invoice" class="btn btn-xs btn-default" id="">
                                        <i class="fa fa-download"></i>
                                    </a>';
                    if ($delete_order != 0) {
                        $delete_data = '<a href="' . url(config('constant.smAdminSlug') . '/orders/destroy') . '/' . $v_data->id . '" 
                  title="Delete" class="btn btn-xs btn-default delete_data_row" delete_message="Are you sure to delete this data?" delete_row="tr_' . $v_data->id . '">
                     <i class="fa fa-times"></i>
                    </a> ';
                    } else {
                        $delete_data = '';
                    }
                    $nestedData['action'] = $send_mail . ' ' . $view_invoice . ' ' . $download_invoice . ' ' . $delete_data;
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
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data["order"] = Order::with('payment', 'user', 'detail')->find($id);
//        if ( count( $data["order"] ) > 0 ) {
        if (!empty($data["order"])) {
            $data["payment"] = Payment::find($data["order"]->payment_id);

            return view("customer/order_detail", $data);
        } else {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
        $order = Order::find($id);
        if ($order) {
            $error = 0;
            $message = '';
            if ($order->payment_status == 1) {
                $error++;
                $message = " Order payment status is completed";
            }
            if ($order->order_status == 1) {
                $error++;
                $message = ($message != '') ? ' and ' . $message : $message;
                $message .= " Order is Completed";
            }


            if ($error == 0) {
                $order->delete();
            } else {
                return response('We cannot delete order because ' . $message . "!", 422);
            }
            echo 1;
            exit;
        } else {
            echo 0;
            exit;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $data["order"] = Order::with('payment', 'user', 'detail')->find($id);
//        if ( count( $data["order"] ) > 0 ) {
        if (!empty($data["order"])) {
            $data["payment"] = Payment::find($data["order"]->payment_id);
//                return view( "pdf/invoice", $data );
            $view = view("pdf/invoice", $data);
            return PDF::loadHTML($view)
                ->download('buckleup_invoice_' . SM::orderNumberFormat($data["order"]) . '.pdf');
        } else {
            return abort(404);
        }
    }


    /**
     * Order payment status update
     */
    public function payment_status_update(Request $request)
    {
        $this->validate($request, [
            'post_id' => 'required|integer',
            'payment_status' => 'required|integer'
        ]);
        $order = Order::find($request->post_id);
        if ($order) {
            if (!($request->payment_status == 1 && $order->grand_total > $order->paid)) {
                $order->payment_status = $request->payment_status;
                $order->update();

                return response(1, 200);
            } else {
                return response()->json(['errors' => ['payment_status' => ['Order Payment Can not complete because you have a due.']]], 422);
            }
        } else {
            return response()->json(['errors' => ['payment_status' => ['Order Not Found']]], 404);
        }
    }

    /**
     * Order payment info update
     */
    public function payment_info_update(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|integer',
            'payment_status' => 'required|integer',
            'pay' => 'required|numeric'
        ]);
        $order = Order::find($request->order_id);
        if ($order) {
            $order->paid += (float)$request->pay;
            $due = $order->grand_total - $order->paid;
            if ($due <= 0) {
                $order->payment_status = $request->payment_status;
                $info['hasError'] = 0;
                $info['message'] = 'Payment status update completed.';
            } else {
                $order->payment_status = 2;
                $info['hasError'] = 1;
                $info['message'] = 'Payment status cannot update to complete because you have a due $' . $due .
                    '\nYou paid total $' . $order->paid;
            }
            $due *= (-1);
            $dueSign = $due < 0 ? "-" : "+";
            $dueSign = $due == 0 ? "" : $dueSign;
            $info['due'] = $dueSign . " $" . abs(number_format($due, 2));
            $order->update();
            $info['order'] = $order;

            return response($info, 200);

        } else {
            return response()->json(['errors' => ['payment_status' => ['Order Not Found']]], 404);
        }
    }

    /**
     * Order payment status update
     */
    public function order_status_update(Request $request)
    {
        $this->validate($request, [
            'post_id' => 'required|integer',
            'order_status' => 'required|integer'
        ]);
        $order = Order::find($request->post_id);
        if ($order) {
            if (!($request->order_status == 1 && $order->grand_total > $order->paid)) {
                $order->order_status = $request->order_status;
                $order->update();

                return response(1, 200);
            } else {
                return response()->json(['errors' => ['order_status' => ['Order Payment Can not complete because you have a due.']]], 422);
            }
        } else {
            return response()->json(['errors' => ['order_status' => ['Order Not Found.']]], 404);
        }
    }

    /**
     * Order payment status update
     */
    public function order_info_update(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|integer',
            'order_status' => 'required|integer',
            'pay' => 'required|numeric',
            'message' => 'required'
        ]);

        $order = Order::find($request->order_id);

        if ($order) {
            $info['filesHtml'] = '';
            if (trim($request->image) != '') {
                if (trim($order->completed_files) != '') {
                    $order->completed_files .= ',' . $request->image;
                } else {
                    $order->completed_files = $request->image;
                }
                $filesArray = explode(',', $order->completed_files);
                $files = Media::whereIn('slug', $filesArray)->get();

                if (count($files) > 0) {
                    foreach ($files as $fl) {
                        $img = SM::sm_get_galary_src_data_img($fl->slug, $fl->is_private == 1 ? true : false);
                        $src = $img['src'];
                        $info['filesHtml'] .= '<a href="' . url(SM::smAdminSlug('media/download/' . $fl->id)) . '" title="Download ' . $fl->title . '">
													<img src="' . $src . '"
                                                     caption="' . $fl->caption . '" description="' . $fl->description . '"
                                                     class="orderFile" width="50"></a>';

                        $permission = Media_permissions::where('media_id', $fl->id)->where('user_id', $order->user_id)->first();
                        if (!$permission) {
                            $permission = new Media_permissions();
                            $permission->media_id = $fl->id;
                            $permission->user_id = $order->user_id;
                            $permission->save();
                        }
                    }
                }
            }

            $order->paid += (float)$request->pay;
            $due = $order->grand_total - $order->paid;
            if ($due <= 0) {
                $order->order_status = $request->order_status;
                $info['hasError'] = 0;
                $info['message'] = 'Order completed successfully';
            } else {
                $order->payment_status = 2;
                $info['hasError'] = 1;
                $info['message'] = 'Order status cannot update to complete because you have a due $' . $due .
                    '\nYou paid total $' . $order->paid;
            }
            $due *= (-1);
            $dueSign = $due < 0 ? "-" : "+";
            $dueSign = $due == 0 ? "" : $dueSign;
            $info['due'] = $dueSign . " $" . abs(number_format($due, 2));
            $order->update();
            $info['order'] = $order;


            //mail
            $contact_email = $order->contact_email;

            if (filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
                $extra = new \stdClass();
                $extra->message = $request->message;
                \Mail::to($contact_email)->queue(new InvoiceMail($order->id, $extra));
                $info['message'] .= 'And Mail Successfully Send';
            }
            $info['message'] .= '!';

            return response()->json($info, 200);
        } else {
            return response()->json(['errors' => ['order_status' => ['Order Not Found.']]], 404);
        }
    }

    /**
     * Order Mail
     */
    public function order_mail(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|integer',
            'message' => 'required'
        ]);
        $order = Order::with('user')
            ->find($request->order_id);
        if ($order) {
            $info['filesHtml'] = '';

            $extra = new \stdClass();
            if (trim($request->order_image) != '') {
                if (trim($order->completed_files) != '') {
                    $order->completed_files .= ',' . $request->order_image;
                } else {
                    $order->completed_files = $request->order_image;
                }
                $filesArray = explode(',', $order->completed_files);
                $files = Media::whereIn('slug', $filesArray)->get();

                if (count($files) > 0) {
                    $extra->files = $files;
                    foreach ($files as $fl) {
                        $img = SM::sm_get_galary_src_data_img($fl->slug, $fl->is_private == 1 ? true : false);
                        $src = $img['src'];
                        $info['filesHtml'] .= '<a href="' . url(SM::smAdminSlug('media/download/' . $fl->id)) . '" title="Download ' . $fl->title . '">
													<img src="' . $src . '"
                                                     caption="' . $fl->caption . '" description="' . $fl->description . '"
                                                     class="orderFile" width="50"></a>';

                        if ($fl->is_private == 1) {
                            $permission = Media_permissions::where('media_id', $fl->id)
                                ->where('user_id', $order->user_id)
                                ->first();
                            if (!$permission) {
                                $permission = new Media_permissions();
                                $permission->media_id = $fl->id;
                                $permission->user_id = $order->user_id;
                                $permission->save();
                            }
                        }
                    }
                }
            }

            //mail
            $contact_email = $order->contact_email;
            if (filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
                $extra->subject = "Order Invoice id # " . SM::orderNumberFormat($order) . " Mail";
                $extra->message = $request->message;
                \Mail::to($contact_email)->queue(new NormalMail($extra));
                $info['message'] = 'Mail Successfully Send';
            }
            $info['message'] .= '!';

            return response()->json($info, 200);
        } else {
            return response()->json(['errors' => ['order_status' => ['Order Not Found.']]], 404);
        }
    }
}
