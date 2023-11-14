<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSalary;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($employee_id)
    {
        $employee_data = Employee::find($employee_id);
        $data = EmployeeSalary::where('employee_id',$employee_id)->get();
        return view('backend.employee.payment',compact('data','employee_id','employee_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::all();
        return view('backend.employee.payment-add',compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        EmployeeSalary::create($request->all());
        return redirect()->back()->with('success', 'employee Added Successfully');
        echo "<pre>"; print_r($request->all()); echo "</pre>"; die('anil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmployeeSalary  $employeeSalary
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeSalary $employeeSalary)
    {
        $data = $request->all();
        unset($data['_token']);
        $employee_data = EmployeeSalary::find($employeeSalary);
        EmployeeSalary::where('id',$employee->id)->update($data);
        return redirect()->back()->with('success', 'employee Updated Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmployeeSalary  $employeeSalary
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeSalary $employeeSalary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeSalary  $employeeSalary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeSalary $employeeSalary)
    {
        $data = $request->all();
        unset($data['_token']);
        unset($data['id']);
        // echo "<pre>"; print_r($data); echo "</pre>"; die('anil');
        $employee_data = EmployeeSalary::find($request->id);
        EmployeeSalary::where('id',$employee_data->id)->update($data);
        return redirect()->back()->with('success', 'employee Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployeeSalary  $employeeSalary
     * @return \Illuminate\Http\Response
     */
    public function delete($employeeSalary)
    {
        $employeeSalary = EmployeeSalary::find($employeeSalary);
        $employeeSalary->delete();
        // Redirect 
        return redirect()->back()->with('error', 'data Deleted Successfully');
    }
}
