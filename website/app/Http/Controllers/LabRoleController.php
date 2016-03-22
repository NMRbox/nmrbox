<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\LabRole;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LabRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lab_roles = LabRole::All();
        return View::make('admin.lab_roles.index', compact('lab_roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.lab_roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lab_role = new LabRole($request->all());
        $lab_role->save();
        return redirect('admin/lab_roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(LabRole $lab_role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  LabRole  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(LabRole $lab_role)
    {
        return view('admin.lab_roles.edit', compact('lab_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LabRole $lab_role)
    {
        $lab_role->update($request->all());
        $lab_role->save();;
        return redirect('admin/lab_roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(LabRole $lab_role)
    {
        $lab_role->delete();
        return redirect("admin/lab_roles");
    }
}
