<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;

use View;
use Input;
use Sentinel;
use Mail;
use Lang;
use App\Person;
use App\Classification;



class ClassificationController extends Controller
{
    /**
     * Message bag.
     *
     * @var MessageBag
     */
    protected $messageBag = null;

    /**
     * Initializer.
     *
     * @return void
     */
    public function __construct() {
        $this->messageBag = new MessageBag;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classifications = Classification::All();
        return View::make('admin.classifications.index', compact('classifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.classifications.create', compact('classification'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $classification = new Classification(array(
                'name' => $request->name,
                'definition' => $request->definition
            ));

            $classification->save();

        }
        catch (\Exception $e) {
            /* to-do - need to add lang files */
            $this->messageBag->add('email', Lang::get('classifications/message.error.create'));

        }
        // Ooops.. something went wrong
        //return redirect('admin/email')->withSuccess($this->messageBag);
        return redirect('admin/classification');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($param)
    {



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($param)
    {
        $classification = Classification::where('name', $param)->first();
        $web_role = 0;
        if($classification->web_role != false)
        {
            $web_role = 1;
        }


        return view('admin.classifications.edit', compact('classification', "web_role"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $param)
    {

        try{
            /* Input request content */
            $classification = Classification::where('name', $param)->first();
            $classification->name = $request->input('name');
            $classification->definition = $request->input('definition');
            $classification->web_role = ($request->input('web_role') == 1)?true:false;

            $classification->save();
        } catch (\Exception $e){
            // something went wrong - probably has entries in email_person table
            return redirect()->back()->withError(Lang::get('classifications/message.error.update'));
        }

        // redirect with success message
        //return redirect('admin/email');
        return redirect()->back()->withSuccess(Lang::get('classifications/message.success.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($param)
    {
        $classification = Classification::where('name', $param)->first();
        $count_users = $classification->person()->count();

        if($count_users === 0){
            $delete = $classification->delete();
            return redirect("admin/classification");
        } else {
            $this->messageBag->add('classification', Lang::get('classifications/message.error.delete'));
            return redirect()->back()->withErrors($this->messageBag);

        }


    }
}
