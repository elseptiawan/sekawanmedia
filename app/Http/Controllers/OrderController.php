<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Order, Employee, Vehicle};
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(){
        try {
            $order = Order::latest();

            if (request('filter')){
                if (request('filter') == 'Hari Ini'){
                    $order = $order->whereDate('date_start', Carbon::today());
                }
                else if (request('filter') == 'Minggu Ini'){
                    $order = $order->whereBetween('date_start', [Carbon::today()->startOfWeek(), Carbon::today()->endOfWeek()]);
                }
                else if (request('filter') == 'Bulan Ini'){
                    $order = $order->whereMonth('date_start', Carbon::today());
                }
                else if (request('filter') == 'Tahun Ini'){
                    $order = $order->whereYear('date_start', Carbon::today());
                }
            }

            $order = $order->get();

            return response()->json(['message' => 'success get data', 'data' => $order], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th], 400);
        }
    }

    public function show(Order $order){
        try {
            return response()->json(['message' => 'success get data', 'data' => $order], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th], 400);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|numeric',
            'approver1' => 'required|numeric',
            'approver2' => 'required|numeric',
            'approver3' => 'nullable|numeric',
            'vehicle_id' => 'required|numeric',
            'date_start' => 'required|date',
            'date_end' => 'required|date'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        try {
            $approvers = [
                $request->approver1,
                $request->approver2,
                $request->approver3,
            ];
            $json_approvers = array();
            $level = 1;
            foreach ($approvers as $value){
                if (!empty($value)){
                    if ($level == 1){
                        array_push($json_approvers, [
                            'level' => $level++,
                            'approver_id' => $value,
                            'status' => 'Requested'
                        ]);
                    }

                    else{
                        array_push($json_approvers, [
                            'level' => $level++,
                            'approver_id' => $value,
                            'status' => 'Pending'
                        ]);
                    }
                }
            }

            $order = Order::create([
                'employee_id' => $request->employee_id,
                'approver' => $json_approvers,
                'vehicle_id' => $request->vehicle_id,
                'date_start' => $request->date_start,
                'date_end' => $request->date_end,
            ]);

            return response()->json(['message' => 'success insert data', 'data' => $order], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th], 400);
        }
    }

    public function export(){
        // try {
            $order = Order::latest();

            if (request('filter')){
                if (request('filter') == 'Hari Ini'){
                    $order = $order->whereDate('date_start', Carbon::today());
                }
                else if (request('filter') == 'Minggu Ini'){
                    $order = $order->whereBetween('date_start', [Carbon::today()->startOfWeek(), Carbon::today()->endOfWeek()]);
                }
                else if (request('filter') == 'Bulan Ini'){
                    $order = $order->whereMonth('date_start', Carbon::today());
                }
                else if (request('filter') == 'Tahun Ini'){
                    $order = $order->whereYear('date_start', Carbon::today());
                }
            }

            $order = $order->with('employee', 'vehicle')->get();

            $data = [];
            foreach ($order as $value){
                $employee = Employee::where('id', $value->employee_id)->first();
                $vehicle = Vehicle::where('id', $value->vehicle_id)->first();
                array_push($data, [
                    'employee' => $employee->name,
                    'vehicle' => $vehicle->name,
                    'date_start' => $value->date_start,
                    'date_end' => $value->date_end,
                ]);
            }

            return Excel::download(new OrderExport($data), 'Order.xlsx');
        // } catch (\Throwable $th) {
        //     return response()->json(['message' => $th], 400);
        // }
    }
}
