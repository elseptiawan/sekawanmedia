<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

class ApproverController extends Controller
{
    public function index(){
        try {
            $order = Order::whereJsonContains('approver', ['approver_id' => auth()->user()->id])->get();

            return response()->json(['message' => 'success get data', 'data' => $order], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th], 400);
        }
    }

    public function approve($id){
        try {
            $order = Order::where('id', $id)->first();

            $new_approver = array();
            foreach ($order->approver as $key => $value){
                if ($value['approver_id'] == auth()->user()->id){
                    if($value['status'] == 'Pending') {
                        return response()->json(['message' => 'the approvement still pending'], 400);
                    }

                    $value['status'] = 'Approved';
                }

                array_push($new_approver, $value);
            }

            $order->update([
                'approver' => $new_approver
            ]);
            
            $new_approver = array();
            foreach ($order->approver as $key => $value){
                if ($value['status'] == 'Pending'){
                    $value['status'] = 'Requested';
                }

                array_push($new_approver, $value);
            }

            $order->update([
                'approver' => $new_approver
            ]);

            return response()->json(['message' => 'success update data', 'data' => $order], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th], 400);
        }
    }
}
