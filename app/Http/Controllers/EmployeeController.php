<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\City;
use App\Models\Department;
use Illuminate\Http\Request;
use DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Employee::all();
        return view('backend.employee.view', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = DB::table('department')->get()->pluck('name','id');
        $city = DB::table('city')->get()->pluck('name','id');
        $state = DB::table('state')->get()->pluck('name','id');
        $country = DB::table('country')->get()->pluck('name','id');
        return view('backend.employee.add',compact('department','city','state','country'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee = Employee::find($request->id);
        $id_proof = (!empty($employee))?$employee->id_proof:'';
        $address_proof = (!empty($employee))?$employee->address_proof:'';
        $letter = (!empty($employee))?$employee->letter:'';
        $picture = (!empty($employee))?$employee->picture:'';
        $form11 = (!empty($employee))?$employee->form11:'';
        if (($request->file('id_proof'))) {
            $upload_path = public_path() . '/id_proof/';
            if(!is_dir($upload_path)){
                mkdir($upload_path, 0777, true);
            }
            $file = $request->file('id_proof');
            $destinationPath = $upload_path;
            $originalFile = $file->getClientOriginalName();
            $filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
            $file->move($destinationPath, $filename);
            $id_proof = '/id_proof/'.$request->client_id.'/'.$filename;
        }
        if (($request->file('address_proof'))) {
            $upload_path = public_path() . '/address_proof/';
            if(!is_dir($upload_path)){
                mkdir($upload_path, 0777, true);
            }
            $file = $request->file('address_proof');
            $destinationPath = $upload_path;
            // foreach ($files as $file) {
                $originalFile = $file->getClientOriginalName();
                $filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
                $file->move($destinationPath, $filename);
                $address_proof = '/address_proof/'.$request->client_id.'/'.$filename;
            // }
        }
        if (($request->file('letter'))) {
            $upload_path = public_path() . '/letter/';
            if(!is_dir($upload_path)){
                mkdir($upload_path, 0777, true);
            }
            $file = $request->file('letter');
            $destinationPath = $upload_path;
            // foreach ($files as $file) {
                $originalFile = $file->getClientOriginalName();
                $filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
                $file->move($destinationPath, $filename);
                $letter = '/letter/'.$request->client_id.'/'.$filename;
            // }
        }
        if (($request->file('picture'))) {
            $upload_path = public_path() . '/picture/';
            if(!is_dir($upload_path)){
                mkdir($upload_path, 0777, true);
            }
            $file = $request->file('picture');
            $destinationPath = $upload_path;
            // foreach ($files as $file) {
                $originalFile = $file->getClientOriginalName();
                $filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
                $file->move($destinationPath, $filename);
                $picture = '/picture/'.$request->client_id.'/'.$filename;
            // }
        }
        if (($request->file('form11'))) {
            $upload_path = public_path() . '/form11/';
            if(!is_dir($upload_path)){
                mkdir($upload_path, 0777, true);
            }
            $file = $request->file('form11');
            $destinationPath = $upload_path;
            // foreach ($files as $file) {
                $originalFile = $file->getClientOriginalName();
                $filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
                $file->move($destinationPath, $filename);
                $form11 = '/form11/'.$request->client_id.'/'.$filename;
            // }
        }
        $employee = Employee::find($request->id);
        if (empty($employee)) {
            $employee = new Employee();
        }
        $employee->employeeidno = $request->employeeidno;
        $employee->name = $request->name;
        $employee->id_proof = $id_proof;
        $employee->address_proof = $address_proof;
        $employee->address = $request->address;
        $employee->letter = $letter;
        $employee->contact1 = $request->contact1;
        $employee->contact2 = $request->contact2;
        $employee->country_id = $request->country_id;
        $employee->state_id = $request->state_id;
        $employee->city_id = $request->city_id;
        $employee->zip = $request->zip;
        $employee->age = $request->age;
        $employee->birthdate = $request->birthdate;
        $employee->date_hired = $request->date_hired;
        $employee->department_id = $request->department_id;
        $employee->picture = $picture;
        $employee->bankname = $request->bankname;
        $employee->bankaccountno = $request->bankaccountno;
        $employee->ifsccode = $request->ifsccode;
        $employee->bankcity = $request->bankcity;
        $employee->branch = $request->branch;
        $employee->form11 = $form11;
        $employee->panno = $request->panno;
        $employee->aasharcardno = $request->aadharcardno;
        $employee->salary_status = $request->salary_status;
        $employee->salary = $request->salary;
        $employee->save();
        return redirect()->route('employee.view')->with('success', 'data Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($employee)
    {
        $department = DB::table('department')->get()->pluck('name','id');
        $employee = Employee::find($employee);
        $city = DB::table('city')->get()->pluck('name','id');
        $state = DB::table('state')->get()->pluck('name','id');
        $country = DB::table('country')->get()->pluck('name','id');
        return view('backend.employee.add',compact('department','city','state','country','employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
