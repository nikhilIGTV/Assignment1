<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = Employee::with('departments')
            ->when($request->email_filter, function ($query) {
                $query->where('email', request()->email_filter);
            })
            ->when($request->department_filter, function ($query) {
                $query->whereHas('departments', function ($q1) {
                    $q1->where('id', request()->department_filter);
                });
            })
            ->get();

        $departments=Department::get();

        return view('employees.index',compact('departments','employees'));
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
        $validated = $request->validate([
            'name' => 'required',
            'email'=> 'required|unique:employees',
            'code' => 'required'
        ]);
        $employee=Employee::create($request->all());
        $employee->departments()->attach($request->department_ids);
        return $employee;
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
        $employee=Employee::with('departments')->findOrFail($id);
        return $employee;

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
        $validated = $request->validate([
            'name' => 'required',
            'email'=> 'required',
            'code' => 'required'
        ]);
        $employee=Employee::findOrFail($id);
        $employee->update($request->all());
        $employee->departments()->detach();
        $employee->departments()->attach($request->department_ids);
       return $employee;
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
    public function filterData(Request $request)
    {
        if($request->email=="" || $request->department=="")
        {
            if($request->email=="" && $request->department=="")
            {
                // $employees=Employee::where('email',$request->email)->whereHas('departments',function($query)use $department{
                //     $query->where('id',$department);
                // })->get();
                return $employees;
            }
        }
        return $request;
    }
}
