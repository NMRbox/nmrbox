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
                'location' => $request->location,
                'attendance_max' => ($request->attendance_max == "")?null:$request->attendance_max
            ));

            $workshop->save();
        }
        catch (UserExistsException $e) {
            $this->messageBag->add('workshop', Lang::get('workshops/message.error.create'));

        }
        // Ooops.. something went wrong
        //return redirect('admin/email')->withSuccess($this->messageBag);
        return redirect('admin/workshop');
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

        // Workshop classification details
        $workshop_classification = Classification::where('name', $param)->get()->first();

        //Workshop object
        $workshop = Workshop::where('name', 'LIKE', '%'.$param.'%')->get()->first();


        // All users
        //$workshop_users_list = $classifications->person()->get();


        return view::make('admin.workshops.edit', compact('workshop', 'classifications', 'workshop_classification'));
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
            $workshop->attendance_max = ($request->input('attendance_max') == "")?null:$request->input('attendance_max');
            $workshop->save();
        } catch (\Exception $e){
            // something went wrong - probably has entries in email_person table
            return redirect()->back()->withError(Lang::get('workshops/message.error.update'));
        }

        // redirect with success message
        return redirect()->back()->withSuccess(Lang::get('workshops/message.success.update'));
    }


    /**
     * Display all the workshops for frontend page
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {

        //Get all the upcoming workshops
        $upcoming_workshops = Workshop::whereDate('end_date', '>=', date('Y-m-d').' 00:00:00')->orderBy('start_date', 'asc')->get();

        foreach ($upcoming_workshops as $upcoming){
            // Counting the max attendance
            $upcoming->attendance = ClassificationPerson::where('classification_person.name', $upcoming->name)->count();
            $workshops['upcoming'][] = $upcoming;
        }

        //Get all the completed workshops
        $completed_workshops = Workshop::whereDate('end_date', '<', date('Y-m-d').' 00:00:00')->orderBy('start_date', 'desc')->get();

        foreach ($completed_workshops as $completed){
            $workshops['completed'][] = $completed;
        }

        //$workshops['upcoming']['attendance'] = Workshop::attendance();

        return response( json_encode( array('data' => $workshops, ) ), 200 )->header( 'Content-Type', 'application/json' );

        /*if(Sentinel::check()){

            //$user = Sentinel::getUser(); //removing user->person test
            $user = Sentinel::getUser();

            // the person attached to the user
            $person = Person::where('id', $user->id)->get()->first();
            $classifications = Classification::All();

            //Get all the upcoming workshops
            $upcoming_workshops = Workshop::whereDate('end_date', '>=', date('Y-m-d').' 00:00:00')->orderBy('start_date', 'asc')->get();

            //Get all the completed workshops
            $completed_workshops = Workshop::whereDate('end_date', '<', date('Y-m-d').' 00:00:00')->orderBy('start_date', 'desc')->get();

            // View
            return View::make('workshops', compact('upcoming_workshops', 'completed_workshops', 'user', 'person', 'classifications'));
        } else {
            //Get all the upcoming workshops
            $upcoming_workshops = Workshop::whereDate('end_date', '>=', date('Y-m-d').' 00:00:00')->orderBy('start_date', 'asc')->get();

            //Get all the completed workshops
            $completed_workshops = Workshop::whereDate('end_date', '<', date('Y-m-d').' 00:00:00')->orderBy('start_date', 'desc')->get();

            $person = null;
            // View
            return View::make('workshops', compact('upcoming_workshops', 'completed_workshops', 'person'));
        }*/

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($param)
    {
        try{
            $workshop = Workshop::where('id', $param)->delete();

        } catch ( \Exception $e){

            // something went wrong - probably has entries in email_person table
            return redirect()->back()->withError(Lang::get('workshops/message.error.delete'));
        }

        // redirect with success message
        return redirect()->back()->withSuccess(Lang::get('workshops/message.success.delete'));
    }

    /**
     * Display the specified email template.
     *
     * @return \Illuminate\Http\Response
     */
    public function registerPersonWorkshop(Request $request){

        // Retrieving the users list from person table
        $user_id = $request->input('userid');
        $user = Person::where('id', $user_id)->get()->first();

        // the classification input list
        $classification = $request->input('workshopid');

        /* Check workshop registration */
        $check_registration = ClassificationPerson::where('person_id', $user_id)
            ->where('name', $classification)
            ->get()
            ->first();

        if($check_registration){
            return response( json_encode( array( 'message' => Lang::get('workshops/message.success.already_registered'), 'type' => 'info' ) ), 200 )
                ->header( 'Content-Type', 'application/json' );
        }

        try{

            /* Saving the data into DB */
            if(!empty($classification)){
                $classification = new ClassificationPerson(array(
                    'person_id' => $user->id,
                    'name' => $classification
                ));
            }

            if($classification->save() !== false){
                return response( json_encode( array( 'message' => Lang::get('workshops/message.success.register'), 'type' => 'success' ) ), 200 )
                    ->header( 'Content-Type', 'application/json' );
            }

        } catch ( \Illuminate\Database\QueryException $e ){
                return response( json_encode( array( 'message' => 'Sorry, workshop registration unsuccessful. Try again. ', 'type' => 'error' ) ), 200 )
                    ->header( 'Content-Type', 'application/json' );
        }

    }

    /*
    public function registerPersonWorkshop(Request $request){

        if(!$request->ajax()) {
            return App::abort(403);
        }

        // Retrieving the users list from person table
        $logged_user = Sentinel::getUser();
        $user = Person::where('id', $logged_user->id)->get()->first();

        // the classification input list
        $classification = $request->input('name', true);


        if(!empty($classification)){

            $classification = new ClassificationPerson(array(
                'person_id' => $user->id,
                'name' => $classification
            ));

        }

        if($classification->save() !== false){
            return response( json_encode( array( 'message' => 'Thank you for registering for a workshop.  You will receive more information from NMRbox staff by email as the workshop date approaches.', 'type' => 'success' ) ), 200 )
                ->header( 'Content-Type', 'application/json' );
        } else {
            return response( json_encode( array( 'message' => 'Sorry, workshop registration unsuccessful. Try again. ', 'type' => 'error' ) ), 200 )
                ->header( 'Content-Type', 'application/json' );
        }
    }*/
}
