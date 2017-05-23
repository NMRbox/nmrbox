<?php

namespace App\Http\Controllers;

use App\Workshop;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use View;
use Input;
use Sentinel;
use Mail;
use Lang;
use Session;
use DateTime;
use App\Person;
use App\Classification;
use App\ClassificationPerson;


class WorkshopsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //All workshops
        $all_workshops = Workshop::all();

        // View
        return View::make('admin.workshops.index', compact('all_workshops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // All classifications
        $classifications = Classification::where('web_role', false)->orderBy('name')->get();

        //Creating the view
        return View::make('admin.workshops.create', compact('classifications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* try and catch for saving workshops data*/
        try {
            $workshop = new Workshop(array(
                'name' => $request->name,
                'title' => $request->title,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'url' => $request->url,
                'location' => $request->location
            ));

            $workshop->save();
            //$this->messageBag->add('email', Lang::get('emails/message.success.create'));
        }
        catch (UserExistsException $e) {
            $this->messageBag->add('workshop', Lang::get('workshops/message.error.create'));

        }
        // Ooops.. something went wrong
        //return redirect('admin/email')->withSuccess($this->messageBag);
        return redirect('admin/workshop');
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
    public function edit($param)
    {
        // All classifications
        $classifications = Classification::where('web_role', false)->orderBy('name')->get();

        //Workshop object
        $workshop = Workshop::where('name', 'LIKE', '%'.$param.'%')->get()->first();

        return view::make('admin.workshops.edit', compact('workshop', 'classifications'));
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
            $workshop = Workshop::where('name', 'LIKE', '%'.$param.'%')->get()->first();
            $workshop->name = $request->input('name');
            $workshop->title = $request->input('title');
            $workshop->url = $request->input('url');
            $workshop->start_date = $request->input('start_date');
            $workshop->end_date = $request->input('end_date');
            $workshop->location = $request->input('location');


            $workshop->save();
        } catch ( QueryException $e){

            // something went wrong - probably has entries in email_person table
            return redirect()->back()->withError(Lang::get('workshops/message.error.update'));
        }

        // redirect with success message
        //return redirect('admin/email');
        return redirect()->back()->withSuccess(Lang::get('workshops/message.success.update'));
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
}
