<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use View;
use Input;
use Sentinel;
use Mail;
use Lang;
use App\Person;
use App\Institution;
use App\Timezone;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class PersonController extends Controller
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
        $all_people = Person::All();
        return View::make('admin.people.index', compact('all_people'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $timezones = Timezone::all();
        $timezones = $timezones->sortBy("zone"); // want these sorted for frontend
        $timezones_for_select = [];

        // The goal here is to pair each vm's id with its friendly name, so the name can be displayed in a select
        //  to choose the actual vm id.
        foreach( $timezones as $tz ) {
            $timezones_for_select[$tz->id] = $tz->zone; // pair VM ID with human friendly VM name
        }

        $person_positions = Person::positions;
        $person_institution_types = Institution::institution_types;


        return view('admin.people.create', compact('person', 'timezones_for_select', 'person_positions',
            'person_institution_types', 'person_institution_type_number'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $person = new Person($request->all());
//        $person->save();
//        return redirect('admin/people');

        $activate = true; //make it false if you don't want to activate user automatically

        try {
            $person = new Person(array(
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'pi' => $request->pi,
//                'nmrbox_acct' => $request->nmrbox_acct,
                'institution_id' => 9, // set to unassigned, but update immediately after saving the model
                'department' => $request->department,
                'job_title' => $request->job_title,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'address3' => $request->address3,
                'city' => $request->city,
                'state_province' => $request->state_province,
                'zip_code' => $request->zip_code,
                'country' => $request->country,
                'time_zone_id' => $request->time_zone_id
            ));
            $person->save();


            $inputInstitution = $request->institution;
            $inputInstitutionType = $request->institution_type;
            $existing_institution = Institution::where('name', $inputInstitution)->get();

            if( $existing_institution->isEmpty() ) {
                // then make a new institution like normal
                $institution = new Institution(array(
                    'name' => $request->institution,
                    'institution_type' => Institution::institution_types[$request->institution_type]
                ));

                $institution->save();
                $person->institution()->associate($institution);
            }
            else {
                // use the existing institution
                $existing_institution = $existing_institution->first();
                $person->institution()->associate($existing_institution);
                $existing_institution->institution_type = Institution::institution_types[$request->institution_type];
                $existing_institution->save();
            }

            $person->save();


            // Register the user
            $user = Sentinel::register(array(
                'person_id' => $person->id,
                'email' => $request->email,
                'password' => "NMR-2016!" // TODO: good god make people change this
            ), $activate);

            //add user to 'User' group
            $role = Sentinel::findRoleByName('User');
            $role->users()->attach($user);

//            $this->messageBag->add('person', "Created " . $person->first_name . " " . $person->last_name . "successfully!");

            return redirect("admin/people");
        }
        catch (UserExistsException $e) {
            $this->messageBag->add('email', Lang::get('auth/message.account_already_exists'));
        }

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if(!$request->ajax()){
            return App::abort(500, 'error in show');
        }

        $id = $request->input('id');
        //print_r($id);

        //retrieving person details
        $user = Person::where('id', $id)->first();

        //json_encode($user);
        return response( json_encode( array( 'user' => $user)), 200 )
            ->header( 'Content-Type', 'application/json' );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Person  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        $timezones = Timezone::all();
        $timezones = $timezones->sortBy("zone"); // want these sorted for frontend
        $timezones_for_select = [];

        // The goal here is to pair each vm's id with its friendly name, so the name can be displayed in a select
        //  to choose the actual vm id.
        foreach( $timezones as $tz ) {
            $timezones_for_select[$tz->id] = $tz->zone; // pair VM ID with human friendly VM name
        }

        $person_positions = Person::positions;
        $person_institution_types = Institution::institution_types;

        $person_institution_name = $person->institution()->get()->first()->institution_type;
        $person_institution_type_number = collect($person_institution_types)->search($person_institution_name);


        return view('admin.people.edit', compact('person', 'timezones_for_select', 'person_positions',
            'person_institution_types', 'person_institution_type_number'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        $person->update($request->except(['institution', 'institution_type']));


        $inputInstitution = Input::get('institution');
        $inputInstitutionType = Input::get('institution_type');

        $existing_institution = Institution::where('name', $inputInstitution)->get();

        if( $existing_institution->isEmpty() ) {
            // then make a new institution like normal
            $institution = new Institution(array(
                'name' => Input::get('institution'),
                'institution_type' => Institution::institution_types[Input::get('institution_type')]
            ));

            $institution->save();
            $person->institution()->associate($institution);
        }
        else {
            // use the existing institution
            $existing_institution = $existing_institution->first();
            $person->institution()->associate($existing_institution);
            $existing_institution->institution_type = Institution::institution_types[Input::get('institution_type')];
            $existing_institution->save();
        }

        $person->save();

        return redirect('admin/people');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Person $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        if(!$person->user()->get()->isEmpty()) {
            $person->user()->forceDelete(); // forceDelete because soft deletes are on for the User class
        }

        $person->delete();
        return redirect("admin/people");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(Request $request)
    {
        if(!$request->ajax()) {
            return App::abort(403);
        }

        $ids = json_decode($request->input('ids'), true);


        $users = Person::whereIn('id', $ids)->get();
//        print_r($users);

        /* Email processing */
        // Data to be used on the email view
        $mail_count = 0;
        foreach ($users as $user){
            $recipient = $user['first_name'] . ' ' . $user['last_name'] . '<' . $user['email'] . '>';

            //Send mail
            $send_mail = Mail::send('emails.group-email', compact('user'), function ($m) use ($user) {
                            $m->from(env('MAIL_USERNAME'), 'NMRbox');
                            $m->to('schowdhury@uchc.edu', $user['first_name'] . ' ' . $user['last_name']);
                            $m->subject('Welcome ' . $user['first_name']);

                        });

            if($send_mail) {
                $mail_count++;
            }
        }

        return response( json_encode( array( 'message' => 'Successfully sent ' . $mail_count . ' emails. ' ) ), 200 )
            ->header( 'Content-Type', 'application/json' );
    }
}
