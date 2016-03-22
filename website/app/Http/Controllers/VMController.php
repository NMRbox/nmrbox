<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\VMRequest;
use App\Http\Controllers\Controller;

Use App\VM;

class VMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_vms = VM::all();
        // Show the page
        return View('admin.vms.index', compact('all_vms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vm = new VM($request->all());
        $vm->name = $vm->major . "." . $vm->minor . "." . $vm->variant;
        $vm->save();
        return redirect('admin/vm');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(VM $vm)
    {
        return view('admin.vms.edit', compact('vm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VMRequest $request, VM $vm)
    {
        $vm->update($request->all());
        $vm->name = $vm->major . "." . $vm->minor . "." . $vm->variant;
        $vm->save(); // yes, this means two writes to db. Can be refactored.
        return redirect('admin/vm');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VM $vm)
    {
        $vm->delete();
        return redirect('admin/vm');
    }
}
