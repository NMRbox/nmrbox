<?php

namespace App\Http\Controllers;

use App\ClassificationPerson;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use View;
use Input;
use Sentinel;
use Mail;
use Lang;
use Session;
use App\Person;
use App\Email;
use App\Institution;
use App\Timezone;
use App\Classification;


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
        $email_templates = Email::All();
        $classifications = Classification::All();

        return View::make('admin.people.index', compact('all_people', 'email_templates', 'classifications'));
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
    //public function edit(Request $request, $id)
    public function edit($id)
    {
        $person = Person::where('id', $id)->first();

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
    public function update(Request $request, $id)
    {
        $person = Person::where('id', $id)->first();
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

        $save_template = $request->input('save_template');
        $email_subj = $request->input('subject');
        $msg_body = $request->input('message');
        $email_recipient = $request->input('recipient');


        if($save_template == 'yes')
        {
            // Saving Email template
            $email_template_name = $request->input('email_template_name');
            $email_template_body = $msg_body;

            $email = new Email(array(
                'name' => $email_template_name,
                'content' => $email_template_body,
                'subject' => $email_subj,
            ));
            $email->save();
        }

        $ids = json_decode($request->input('ids'), true);

        // Retrieving the users list from person table
        $users = Person::whereIn('id', $ids)->get();

        /* Email processing */
        // Data to be used on the email view
        $mail_count = 0;

        foreach ($users as $user){
            $email_subj = $request->input('subject');
            $email_recipient_address = ($email_recipient == 'email_institution')? $user['email_institution'] : $user['email'];

            // user institution details
            $person_institution_name = $user->institution()->get()->first()->name;

            // message body str_replace array
            $search = array('%%first_name%%', '%%last_name%%', '%%nmrbox_acct%%', '%%preferred_email%%', '%%institutional_email%%', '%%institution%%', '%%category%%');
            $replace = array('%%first_name%%' => $user->first_name, '%%last_name%%' => $user->last_name,'%%nmrbox_acct%%' => $user->nmrbox_acct, '%%preferred_email%%' => $user->email, '%%institutional_email%%' => $user->email_institution, '%%institution%%' => $person_institution_name, '%%category%%' => $user->category);
            $message = str_replace($search, $replace, $msg_body);

            //Send mail
            $send_mail = Mail::send([], [], function ($m) use ($user, $email_subj, $message, $email_recipient_address) {
                            $m->from(env('MAIL_USERNAME'), 'NMRbox')
                                ->to($email_recipient_address, $user['first_name'] . ' ' . $user['last_name'])
                                ->subject($email_subj)
                                ->setBody($message);
                        });

            if($send_mail) {
                $mail_count++;
            }
        }

        return response( json_encode( array( 'message' => 'Successfully sent ' . $mail_count . ' emails. ' ) ), 200 )
            ->header( 'Content-Type', 'application/json' );
    }

    /**
     * Display the specified email template.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPersonClassification(Request $request){

        if(!$request->ajax()) {
            return App::abort(403);
        }

        // Selected user ids
        $ids = json_decode($request->input('ids'), true);
        // Retrieving the users list from person table
        $users = Person::whereIn('id', $ids)->get();

        $list = array();

        //$group_data = $group->person()->where('name', $group->name)->get();
        foreach($users as $user){
            $group = $user->classification()->get();

            foreach ($group as $item) {

                if(!isset($list[$item['name']]) || !in_array($user->id, $list[$item['name']])){
                    $list[$item['name']][] = $user->id;
                }
            }
        }

        if (Session::has('classification')) {
            Session::forget('classification');
        }

        Session::put('classification', $list);

        $group_session = Session::get('classification');

        return response( json_encode( array( 'message' => $list ) ), 200 )
            ->header( 'Content-Type', 'application/json' );

    }

    /**
     * Assign the selected users into particular classification gourps
     *
     * @return \Illuminate\Http\Response
     */
    public function assignPersonClassification(Request $request){

        if(!$request->ajax()) {
            return App::abort(403);
        }

        $save_classification = $request->input('save_classification');

        if($save_classification == 'yes') {
            // Saving New Classification
            $classification_name = $request->input('classification_name', true);
            $classification_definition = $request->input('classification_definition', true);

            $classification = new Classification(array(
                'name' => $classification_name,
                'definition' => $classification_definition,
            ));
            $classification->save();

            // merging the newly added value in input array
            if($request->input('classifications') == true){
                Input::merge(array('classifications' => array_merge($request->input('classifications'), array($classification_name))));
            } else {
                Input::merge(array('classifications' => array($classification_name)));
            }

        }
        // Selected user ids
        $ids = json_decode($request->input('ids'), true);

        // Retrieving the users list from person table
        $users = Person::whereIn('id', $ids)->get();

        // partial checked values
        $partial_checked = json_decode($request->input('partial_checked'), true);

        // the classification input list
        $classifications = $request->input('classifications', true);

        if(empty($classifications)){
            $classifications = array();
        }

        if(count($ids) > 1){

            /* Saving the data into DB */
            if(!empty($classifications)){
                foreach ($classifications as $key => $value){
                    $classification = Classification::find($value);
                    $classification->person()->sync($users);
                }
            }

            // all the classifications value
            $all_classification = Classification::all();

            // Refining the partial checked and checked users
            foreach($all_classification as $key => $classification){
                if(!in_array($classification->name, $classifications) && !in_array($classification->name, $partial_checked)) {
                    //$classification->person()->detach($users->pluck('id'));
                    ClassificationPerson::where('name', $classification->name)->whereIn('person_id', $users->pluck('id'))->delete();
                }
            }

        } else {
            /* Saving into DB */
            foreach ($users as $user){
                $person = Person::find($user['id']);
                $person->classification()->sync($classifications);
            }
        }

        return response( json_encode( array( 'message' => 'Successfully added people in groups. ' ) ), 200 )
            ->header( 'Content-Type', 'application/json' );

    }

    /**
     * Display the specified email template.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function email_template(Request $request)
    {
        if(!$request->ajax()){
            return App::abort(500, 'error in show');
        }

        $name = $request->input('name');
        $template = Email::where('name', $name)->first();

        $message = $template->content;
        $subject = $template->subject;


        //json_encode($user);
        return response( json_encode( array( 'message' => $message, 'subject' => $subject ) ), 200 )
            ->header( 'Content-Type', 'application/json' );

    }

}
