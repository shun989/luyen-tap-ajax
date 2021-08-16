<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use DataTables;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        $customers = Customer::latest()->get();

        if ($request->ajax()) {
            $allData = Customer::latest()->get();
            return DataTables::of($allData)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'"
                   data-original-title="Edit" class="edit btn btn-warning btn-sm editCustomer">Edit</a>';
                    $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'"
                   data-original-title="Delete" class="btn btn-danger btn-sm mx-1 deleteCustomer">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
        return view('customers', compact('customers'));
    }


    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        Customer::updateOrCreate(['id' => $request->customer_id],
            [
                'fullName' => $request->fullName,
                'phone' => $request->phone,
                'address' => $request->address,
                'email' => $request->email,
                'note' => $request->note,
            ]
        );
        if ($request->fullName == '' || $request->phone == '' || $request->address == '' || $request->email == '' || $request->note == '') {
            return response()->json(['error' => 'Khong duoc de trong cac truong!']);
        }else {
            return response()->json(['success' => 'Customer Added Successfully.']);
        }
    }


    public function edit($id): \Illuminate\Http\JsonResponse
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }


    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        Customer::find($id)->delete();
        return response()->json(['success' => 'Customer Deleted Successfully.']);
    }

}
