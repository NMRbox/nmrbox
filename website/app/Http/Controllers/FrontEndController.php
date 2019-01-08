<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\VMDownload;
use Illuminate\Http\Request;
use App\Institution;
//use Cartalyst\Sentinel\Laravel\Facades\Activation;

//use Sentinel;
use JWTAuth;
use View;
use Validator;
use Input;
use Session;
use Cookie;
use Redirect;
use Lang;
use URL;
use Mail;
use File;
use Hash;
use Crypt;
use App\Person;
use App\Timezone;
use App\Classification;
use App\ClassificationPerson;
use App\Reminder;
use App\Workshop;
use App\VM;
use App\NmrboxSession;
//use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use App\Library\Ldap;

class FrontEndController extends Controller
{

    protected $validationRules = array(
        'first_name' => 'required|min:3|unique:persons,first_name',
        'last_name' => 'required|min:3|unique:persons,last_name',
        'email' => 'required|email',
        'password' => 'required|between:3,32',
        'password_confirm' => 'required|same:password',
        'pic' => 'mimes:jpg,jpeg,bmp,png|max:10000'
    );


    /**
     * Account Register.
     *
     * @return View
     */
    public function getRegister()
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

        // Show the page
        return View::make('register', compact('timezones_for_select', 'person_positions', 'person_institution_types'));
    }

    /**
     * Person Register.
     *
     * Intended for use at Bio-Physical Society to capture name, email, institution, and PI of interested people
     *
     * @return View
     */
    public function getRegisterPerson()
    {
        // Show the page
        return View::make('register-person');
    }

    /**
     * Account sign up form processing.
     *
     * @return Redirect
     */
    public function postRegister(Request $request)
    {
        
        /* reCaptcha validation */
        $rules = array(
            'g-recaptcha-response' => 'required|recaptcha',
        );
        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        try {
            $email = Input::get('email');
            if( strlen($email) <= 0 ) {
                $email = Input::get('email_institution');
            }

            // register the person
            $person = new Person(array(
                'first_name' => Input::get('first_name'),
                'last_name' => Input::get('last_name'),
                'email' => $email,
                'email_institution' => Input::get('email_institution'),
                'pi' => Input::get('pi'),
                //'nmrbox_acct' => Input::get('nmrbox_acct'),
                'institution_id' => 9, // set to unassigned, but update immediately after saving the model
                'department' => Input::get('department'),
                'job_title' => Input::get('job_title'),
                'address1' => Input::get('address1'),
                'address2' => Input::get('address2'),
                'address3' => Input::get('address3'),
                'city' => Input::get('city'),
                'state_province' => Input::get('state_province'),
                'zip_code' => Input::get('zip_code'),
                'country' => Input::get('country'),
                'time_zone_id' => Input::get('time_zone_id')
            ));

            /* institution check from user given inst. name */
            $inputInstitution = Input::get('institution');
            $inputInstitutionType = Input::get('institution_type');
            $existing_institution = Institution::where('name', 'LIKE', '%'.$inputInstitution.'%')->get()->first();

            /* Existing institution check */
            if( !$existing_institution ) {
                // then add a new institution and associate with person entry
                $institution = new Institution(array(
                    'name' => Input::get('institution'),
                    'institution_type' => Institution::institution_types[Input::get('institution_type')]
                ));

                $institution->save();
                $person->institution()->associate($institution);
            }
            else {
                /* associating old institution data with person entry */
                $person->institution()->associate($existing_institution);
                /*$existing_institution->institution_type = Institution::institution_types[Input::get('institution_type')];
                $existing_institution->save();*/
            }

            /* Save person entry and return to successful page. */
            if($person->save()){
                // Data to be used on the email view
                $data = array(
                    'person' => Person::where('id', $person->id)->get()->first(),
                );
                // Send the registration acknowledge email
                Mail::send('emails.register-activate', $data, function ($m) use ($person) {
                    $m->to($person->email, $person->first_name . ' ' . $person->last_name);
                    $m->subject('NMRbox registration received');
                });

                return View::make('registration-successful')->with('success', Lang::get('auth/message.signup.success'));
            }

        } catch (\Illuminate\Database\QueryException $e) {
            //dd($e);
            return redirect()->back()->withError(Lang::get('auth/message.account_already_exists'));
        }

        // Ooops.. something went wrong
        return redirect()->back()->withError(Lang::get('auth/message.signup.error'));
    }


    /*public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }*/


    /**
     * Account sign in.
     *
     * @return View
     */
    public function getLogin(Request $request)
    {
        /* Retrieving user details from token */
        //$token = JWTAuth::getToken();
        //$user = $this->getAuthenticatedUser();
        //dd(Session::all());


        // Is the user logged in?
        //if (Sentinel::check()) {
        if (Session::has('person')) {
            return Redirect::route('my-account');
        }

        if( Session::has('username')){
            $user['username'] = Session::get('username');
        } else {
            $user['username'] = null;
        }



        // Show the login page
        return View::make('login', compact('user'));
    }

    /**
     * Account sign in form processing.
     *
     * @return Redirect
     */


    public function postLogin(Request $request)
    {
        // Declare the rules for the form validation
        $rules = array(
            'username'    => 'required',
            'password' => 'required|between:3,32',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        try {
            // Adding custom LDAP library class and authenticating
            /*$ldap = new Ldap;
            $ldap_login = $ldap->ldap_authenticate(Input::only('username', 'password'));*/

            /* Test (Localhost login code to skip LDAP authentication) */
            $ldap_login = true;
            /* Eof Test */

            // LDAP login response
            if($ldap_login === true){
                /* collect userid using username from person table */
                $username = $request->input('username');
                $person = Person::where('nmrbox_acct', $username)->first();
                if(!$person) {
                    return redirect()->back()->withError(Lang::get('auth/message.account_not_found'));
                }

                // Adding person table information into session
                Session::put('person', $person);

                // Adding JWT-Auth Token
                $token = JWTAuth::fromUser($person);
                $set_token = JWTAuth::setToken($token);
                $parse_token = JWTAuth::getToken();
                //$parse_token = Sentinel::login($person);

                if ($parse_token == true)
                {
                    // Assigning user classification
                    $user_classification = ClassificationPerson::where('person_id', $person->id)->get();
                    foreach ($user_classification as $key => $value) {
                        if ($value->name == 'admin'){
                            $is_admin = true;
                            Session::put('user_is_admin', $is_admin);
                        }
                    }
                    return View::make('admin/index');

                    return Redirect::route("my-account")
                        ->with('success', Lang::get('auth/message.login.success'))
                        ;
                }
                //return redirect()->back()->withSuccess(Lang::get('auth/message.login.success'));

            } else {
                return redirect()->back()->withError(Lang::get('auth/message.login.error'));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            //dd($e);
            return redirect()->back()->withError(Lang::get('auth/message.account_not_found'));
        } catch (\ErrorException $e) {
            /* trigger an email to support@nmrbox.org */
            $data = array("Password malfunction detected.");

            // Send the registration acknowledge email
            Mail::send('emails.server-malfunction', $data, function ($m) {
                $m->to(env('NMRBOX_SUPPORT_EMAIL'));
                $m->subject('Buildserver malfunction detected');
            });
            //dd($e);
            return redirect()->back()->withError(Lang::get('auth/message.server_conn_error'));
        }
    }

    /**
     * Logout page.
     *
     * @return Redirect
     */
    public function getLogout(Request $request)
    {
        // Log the user out
        //Sentinel::logout(null, true);

        //clear the admin session value
        if(Session::has('user_is_admin')){
            Session::flush();
        }

        if(Session::has('person')){
            Session::flush();
        }

        // clear the jwt auth token
        $token = JWTAuth::getToken();
        //dd($token);
        if($token)
            JWTAuth::invalidate($token);


        // Redirect to the users page
        return Redirect::to('homepage')->with('success', 'You have successfully logged out!');
    }

    /**
     * get user details and display
     */
    public function myAccount(Request $request)
    {
        //dd(Session::all());
        /* Retrieving user details from token */

        $person = JWTAuth::parseToken()->toUser();

        if(!$person){
            $request['token'] = Session::get('auth_token');
            $person = JWTAuth::parseToken()->toUser();
        }

        if(!Session::has('person')){
            return redirect::to('login');
        }

        $person = Person::where('id', Session::get('person')->id)->get()->first();
        //dd($user);

        // taking user information from token and skipping Sentinel check
        /*$user = Sentinel::getUser();
        dd($user);
        // the person attached to the user
        $person = Person::where('id', $user->id)->get()->first();*/

        // fetching all classification groups
        $classifications = Classification::All();

        //Get all the upcoming workshops
        $workshops = Workshop::whereDate('end_date', '>=', date('Y-m-d').' 00:00:00')->orderBy('start_date', 'asc')->get();

        //fetching all the downloadable VMs
        $vms = VM::where('downloadable', 'true')->lists('name', 'id')->all();

        return View::make('user_dashboard', compact('user', 'person', 'classifications', 'workshops', 'vms'));
    }


    /**
     * display form for user general profile update
     *
     * @todo - remove old template
     *
     */
    public function editProfile()
    {
        //dd(Session::get('person')->id);
        //$user = Sentinel::getUser();
        $user = Session::get('person');

        // person details
        $person = Person::where('id', $user->id)->get()->first();

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


        return view('edit_profile', compact('person', 'timezones_for_select', 'person_positions',
            'person_institution_types', 'person_institution_type_number'));

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePersonProfile(Request $request, Person $person)
    {
        try {

            $user = Sentinel::getUser();
            $person = Person::where('id', $user->id)->get()->first();

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

            return redirect()->back()->withSuccess(Lang::get('users/message.success.update_profile'));
        } catch (\Illuminate\Database\QueryException $e) {
            //dd($e);
            return redirect()->back()->withError(Lang::get('auth/message.account_already_exists'));
        }

        // Ooops.. something went wrong
        return redirect()->back()->withError(Lang::get('auth/message.account_already_exists'));
    }


    /**
     * Verifying the LDAP authentication before reseting password
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verifyLdapAuthentication(Request $request)
    {
        if(!$request->ajax()) {
            return App::abort(403);
        }

        $user_session = Sentinel::check();
        //$user = User::where('id', $user_session->id)->first(); // removing user -> person
        $person = Person::where('id', $user_session->id)->first();

        // LDAP credential
        $credential['username'] = $person['nmrbox_acct'];
        $credential['password'] = $request->input('pass');

        // Verifying LDAP password
        $ldap = new Ldap;
        $ldap_login = $ldap->ldap_authenticate($credential);

        // LDAP login response
        if($ldap_login !== false){
            return response( json_encode( array( 'message' => 'Authentication successful. Proceed to reset password. ', 'type' => 'success' ) ), 200 )
                ->header( 'Content-Type', 'application/json' );
        } else {
            return response( json_encode( array( 'message' => 'Sorry, authentication unsuccessful. Try again. ', 'type' => 'error' ) ), 200 )
                ->header( 'Content-Type', 'application/json' );
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postChangePassword(Request $request)
    {
        if(!$request->ajax()) {
            return App::abort(403);
        }

        $user_session = Sentinel::check();
        //$user = User::where('id', $user_session->id)->first(); // removing user -> person
        $person = Person::where('id', $user_session->id)->first();

        $credential['username'] = $person['nmrbox_acct'];
        $credential['password'] = $request->input('pass');

        // Adding custom LDAP library class and authenticating
        $ldap = new Ldap;
        $ldap_login = $ldap->ldap_set_password($credential);

        // LDAP login response
        if($ldap_login !== false){
            return response( json_encode( array( 'message' => 'Password reset successfully. ', 'type' => 'success' ) ), 200 )
                ->header( 'Content-Type', 'application/json' );
        } else {
            return response( json_encode( array( 'message' => 'Sorry, password reset unsuccessful. Try again. ', 'type' => 'error' ) ), 200 )
                ->header( 'Content-Type', 'application/json' );
        }


    }

    /**
     * Forgot password page.
     *
     * @return View
     */
    public function getForgotPassword()
    {
        // Show the page
        return View::make('forgotpwd');
    }

    /**
     * Forgot password form processing page.
     *
     * @return Redirect
     */
    public function postForgotPassword()
    {
        // Declare the rules for the validator
        $rules = array(
            'email' => 'required|email',
        );

        // Create a new validator instance from our dynamic rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::to(URL::previous())->withInput()->withErrors($validator);
        }


        try {
            // Get the user password recovery code
            $user = Person::where('email_institution', Input::get('email'))->first();

            if (!$user) {
                return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.forgot-password.error'));
            }

            $reminder_code = Crypt::encrypt($user->id);

            $reminder = new Reminder(array(
                'user_id' => $user->id,
                'code'    => $reminder_code,
            ));

            $reminder->save();

            // Data to be used on the email view
            $data = array(
                'user' => $user,
                'forgotPasswordUrl' => URL::route('forgot-password-confirm', [$user->id, $reminder_code]),
            );

            // Send the activation code through email
            Mail::send('emails.forgot-password', $data, function ($m) use ($user) {
                $m->to($user->email_institution, $user->first_name . ' ' . $user->last_name);
                $m->subject('NMRbox Account Password Recovery');
            });
        } catch (\Exception $e) {
            // Even though the email was not found, we will pretend
            // we have sent the password reset code through email,
            // this is a security measure against hackers.
        }

        //  Redirect to the forgot password
        return Redirect::to(URL::previous())->with('success', Lang::get('auth/message.forgot-password.success'));
    }

    /**
     * Forgot Password Confirmation page.
     *
     * @param  string $passwordResetCode
     * @return View
     */
    public function getForgotPasswordConfirm($userId, $passwordResetCode)
    {
        // Checking the user entry in person table
        if (!$user = Person::where('id', $userId)->first()) {
            // Redirect to the forgot password page
            return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.account_not_found'));
        }

        // Redirect if password reset request has expired
        if (!$reminder = Reminder::where('user_id', $userId)->where('code', $passwordResetCode)->where('completed', 'false')->first()){
        // Ooops.. something went wrong
            return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.forgot-password-confirm.request_expired'));
        }

        // Show the page
        return View::make('forgotpwd-confirm', compact(['userId', 'passwordResetCode']));
    }

    /**
     * Forgot Password Confirmation form processing page.
     *
     * @param  string $passwordResetCode
     * @return Redirect
     */
    public function postForgotPasswordConfirm($userId, $passwordResetCode, Request $request)
    {
        // Declare the rules for the form validation
        $rules = array(
            'nmrbox_acct' => 'required',
            'password' => 'required',
            'password_confirm' => 'required|same:password'
        );

        // Create a new validator instance from our dynamic rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            //return Redirect::route('forgot-password-confirm', $passwordResetCode)->withInput()->withErrors($validator);
            return Redirect::to(URL::previous())->withInput()->withErrors($validator);
        }

        //$user = Sentinel::findById($userId);
        $user = Person::where('id', $userId)->first();

        // checking whether user has an entry in the DB & pass reset request in Reminder table
        if($user->nmrbox_acct != trim($request->get('nmrbox_acct'))){
            // Ooops.. something went wrong
            return back()->with('error', Lang::get('auth/message.forgot-password-confirm.account_error'));
        } elseif (
            !$reminder = Reminder::where('user_id', $user->id)
                ->where('code', $passwordResetCode)
                ->where('completed', 'false')
                ->first())
        {
            // Ooops.. something went wrong
            return back()->with('error', Lang::get('auth/message.forgot-password-confirm.request_expired'));
        } else {

            try {
                //making credential array for LDAP verification
                $credential['username'] = $user->nmrbox_acct;
                $credential['password'] = $request->get('password');

                // Adding custom LDAP library class and authenticating
                $ldap = new Ldap;
                $ldap_status = $ldap->ldap_set_password($credential);

                // LDAP login response
                if($ldap_status !== false){
                    // update reminder table
                    $reminder_update = Reminder::where('id', $reminder->id)
                        ->update(
                            array(
                                'completed' => true,
                                'completed_at'    => date('Y-m-d H:i:s'),
                            )
                        );

                    // Password successfully reseted
                    return Redirect::route('login')->with('success', Lang::get('auth/message.forgot-password-confirm.success'));
                } else {
                    // Ooops.. something went wrong
                    return back()->with('error', nl2br(Lang::get('auth/message.forgot-password-confirm.complexity_error')) );
                }
            } catch (\ErrorException $e) {
                /* trigger an email to support@nmrbox.org */
                $data = array("Password malfunction detected.");

                // Send the registration acknowledge email
                Mail::send('emails.server-malfunction', $data, function ($m) {
                    $m->to(env('NMRBOX_SUPPORT_EMAIL'));
                    $m->subject('Buildserver malfunction detected');
                });
                //dd($e);
                return redirect()->back()->withError(Lang::get('auth/message.server_conn_error'));
            }
        }
    }



    /**
     * Contact form processing.
     *
     * @return Redirect
     */
    public function postContact()
    {

        // Data to be used on the email view
        $data = array(
            'contact-name' => Input::get('contact-name'),
            'contact-email' => Input::get('contact-email'),
            'contact-msg' => Input::get('contact-msg'),
        );


        // Send the activation code through email
        Mail::send('emails.contact', compact('data'), function ($m) use ($data) {
            $m->from(env('MAIL_USERNAME'), 'TestSiteName');
            $m->to($data['contact-email'], $data['contact-name']);
            $m->subject('Welcome ' . $data['contact-name']);

        });

        //Redirect to login page
        return Redirect::to("contact")->with('success', Lang::get('auth/message.contact.success'));


        // Redirect to the home page with success menu
        return Redirect::route("contact")->with('success', Lang::get('auth/message.contact.success'));
        //return View::make('user_account')->with('success', Lang::get('auth/message.signup.success'));


        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);
    }


    /**
     * Downloadable VM
     *
     * @return Redirect
     */
    public function downloadVM()
    {
        // loggedin checking
        if (!Sentinel::check()) {
            return Redirect::route('my-account');
        }

        try {
            // get user details
            $user = Sentinel::getUser();

            // DB entry goes here
            $downloadable_vm = new VMDownload(
                array(
                    'person_id' => $user->id,
                    'vm_id' => Input::get('vm'),
                    'username' => Input::get('vm_username'),
                    'password' => Input::get('vm_password'),
                )
            );

            $downloadable_vm->save();

            return redirect()->back()->withSuccess('Your request has been received. An email with a custom generated downloadable link will be sent to you in next few hours.');
        } catch (\Illuminate\Database\QueryException $e) {
            //dd($e);
            // Redirect to the user page
            return redirect()->back()->withError('Downloadable VM request has already been received. You will receive an email shortly. ');
            //return redirect()->back()->withError(Lang::get('auth/message.account_already_exists'));
        }

    }

    /*
     *
     *
     *
     * * Angular Frontend signin, signup, forget password, reset password and user_details
     *
     *
     * */
    public function sessionPlayLoad( $id ) {
        // Checking for Session ID
        $session_data = NmrboxSession::where('id', $id)->get()->first();
        if ( empty($session_data)) {
            return response()-> json( array(
                'message' => Lang::get('auth/message.not_autorized'),
                'type' => 'error' ),
                401 );
        }

        // Retrieving session payload
        $session_payload = unserialize(base64_decode($session_data->payload));

        // Replacing session variable for cross domain access
        foreach ( $session_payload['person'] as $key => $value ) {

            if( $value['person_id'] == $id ) {
                // Fetching the user data from person table
                $user_id = $value['user'];
                $person = Person::where('id', $user_id)->get()->first();
                //$person[] = ;
                // TODO: needs to update person session key with session ID.
                Session::put('token', $session_payload['person'][$key]);
                Session::put('person', $person);
                if( $value['user_is_admin'] == true ) {
                    Session::put('user_is_admin', true);
                }
            }
        }

        return $person;
    }

    public function signin(Request $request)
    {
        // Declare the rules for the form validation
        $rules = array(
            'username'    => 'required',
            'password' => 'required|between:3,32',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. validation failed
            return response()->json([
                'message' => Lang::get('auth/message.login.error_validation'),
                'type' => 'error'
            ], 200);
        }

        try {
            // Adding custom LDAP library class and authenticating
            $ldap = new Ldap;
            $ldap_login = $ldap->ldap_authenticate(Input::only('username', 'password'));

            /* Test (Localhost login code to skip LDAP authentication) */
            //$ldap_login = true;
            /* Eof Test */

            // LDAP login response
            if($ldap_login === true){
                /* collect userid using username from person table */
                $username = $request->input('username');
                $person = Person::where('nmrbox_acct', $username)->first();
                if(!$person) {
                    return response()->json([
                        'message' => Lang::get('auth/message.account_not_found'),
                        'type' => 'error'
                    ], 200);
                }


                // Adding JWT-Auth Token
                $token = JWTAuth::fromUser($person);
                $set_token = JWTAuth::setToken($token);
                $parse_token = JWTAuth::getToken();


                if ($parse_token == true)
                {
                    // Assigning user classification
                    $user_classification = ClassificationPerson::where('person_id', $person->id)->get();
                    foreach ($user_classification as $key => $value) {
                        if ($value->name == 'admin'){
                            $is_admin = true;
                        }
                    }
                }

                // Adding person table information into session
                $user_data = array(
                    'token' => $token,
                    'user_is_admin' => $is_admin,
                    'person_id' => Session::getId(),
                    'user' => $person->id,
                    'message' => Lang::get('auth/message.login.success'),
                    'type' => 'success'
                );
                $request->session()->push('person', $user_data);

                return response()->json($user_data, 200);
            } else {
                return response()->json([
                    'message' => Lang::get('auth/message.login.error'),
                    'type' => 'error'
                ], 200);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => Lang::get('auth/message.account_not_found'),
                'type' => 'error'
            ], 200);
        } catch (\ErrorException $e) {
            /* trigger an email to support@nmrbox.org */
            $data = array("Password malfunction detected.");

            // Send the registration acknowledge email
            Mail::send('emails.server-malfunction', $data, function ($m) {
                $m->to(env('NMRBOX_SUPPORT_EMAIL'));
                $m->subject('Buildserver malfunction detected');
            });
            return response()->json([
                'message' => Lang::get('auth/message.server_conn_error'),
                'type' => 'error'
            ], 200);
        }
    }

    /**
     * Logout page.
     *
     * @return Redirect
     */
    public function signOut(Request $request)
    {
        // Log the user out
        Sentinel::logout(null, true);

        //clear the admin session value
        if(Session::has('user_is_admin')){
            Session::flush();
        }

        // clear the jwt auth token
        $token = JWTAuth::getToken();
        //dd($token);
        if($token)
            JWTAuth::invalidate($token);

        // Redirect to the users page
        return Redirect::to('homepage')->with('success', 'You have successfully logged out!');
    }

    // SingUP
    public function signup(Request $request)
    {
        try {
            $email = Input::get('email');
            if( strlen($email) <= 0 ) {
                $email = Input::get('email_institution');
            }

            // register the person
            $person = new Person(array(
                'first_name' => Input::get('first_name'),
                'last_name' => Input::get('last_name'),
                'email' => $email,
                'email_institution' => Input::get('email_institution'),
                'pi' => Input::get('pi'),
                'institution_id' => 9, // set to unassigned, but update immediately after saving the model
                'department' => Input::get('department'),
                'job_title' => Input::get('job_title'),
                'address1' => Input::get('address1'),
                'address2' => Input::get('address2'),
                'address3' => Input::get('address3'),
                'city' => Input::get('city'),
                'state_province' => Input::get('state_province'),
                'zip_code' => Input::get('zip_code'),
                'country' => Input::get('country'),
                'time_zone_id' => Input::get('time_zone_id')
            ));


            /* institution check from user given inst. name */
            $inputInstitution = Input::get('institution');
            $inputInstitutionType = Input::get('institution_type');
            $existing_institution = Institution::where('name', 'LIKE', '%'.$inputInstitution.'%')->get()->first();

            /* Existing institution check */
            if( !$existing_institution ) {
                // then add a new institution and associate with person entry
                $institution = new Institution(array(
                    'name' => Input::get('institution'),
                    'institution_type' => Institution::institution_types[Input::get('institution_type')]
                ));

                $institution->save();
                $person->institution()->associate($institution);
            }
            else {
                /* associating old institution data with person entry */
                $person->institution()->associate($existing_institution);
                /*$existing_institution->institution_type = Institution::institution_types[Input::get('institution_type')];
                $existing_institution->save();*/
            }



            /* Save person entry and return to successful page. */
            if($person->save()){
                // Data to be used on the email view
                $data = array(
                    'person' => Person::where('id', $person->id)->get()->first(),
                );
                // Send the registration acknowledge email
                Mail::send('emails.register-activate', $data, function ($m) use ($person) {
                    $m->to($person->email, $person->first_name . ' ' . $person->last_name);
                    $m->subject('NMRbox registration received');
                });

                //return View::make('registration-successful')->with('success', Lang::get('auth/message.signup.success'));
                return response()->json([
                    'message' => Lang::get('auth/message.signup.success'),
                    'type' => 'success'
                ], 200);
            }

        } catch (\Illuminate\Database\QueryException $e) {
            //dd($e);
            //return redirect()->back()->withError(Lang::get('auth/message.account_already_exists'));
            return response()->json([
                'message' => Lang::get('auth/message.account_already_exists'),
                'type' => 'error'
            ], 200);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request, $person_id)
    {
        try {

            //$user = Sentinel::getUser();
            //$person = Person::where('id', $person_id)->get()->first();
            $person = $this->sessionPlayLoad($person_id);

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

            //return redirect()->back()->withSuccess(Lang::get('users/message.success.update_profile'));
            return response()->json([
                'message' => Lang::get('users/message.success.update_profile'),
                'type' => 'success'
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            //dd($e);
            //return redirect()->back()->withError(Lang::get('auth/message.account_already_exists'));
            return response()->json([
                'message' => Lang::get('auth/message.account_already_exists'),
                'type' => 'error'
            ], 200);
        }

        // Ooops.. something went wrong
        //return redirect()->back()->withError(Lang::get('auth/message.account_already_exists'));

    }

    /**
     * get user details and display
     */
    public function person_details($id)
    {
        $person = $this->sessionPlayLoad( $id );
        // Return error while no person data and person session available
        if (!Session::has('person') && empty($person)) {
            return response()-> json( array(
                'message' => Lang::get('auth/message.not_autorized'),
                'type' => 'error' ),
                401 );
        }


        // Fetching person institution name
        $person['institution'] = $person->institution()->get()->first()->name;

        // Fetching all institution types
        $person['institution_types'] = Institution::institution_types;

        // fetching all classification groups
        $person['classifications'] = $person->classification()->get();

        return response()-> json( array(
            'data' => $person ,
            'type' => 'success' ),
            200 );

    }

    /**
     * Password reset through user dashboard
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        // Declare the rules for the form validation
        $rules = array(
            'current_pass' => 'required',
            'new_pass' => 'required',
            'confirm_new_pass' => 'required|same:new_pass'
        );

        // Create a new validator instance from our dynamic rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return response()->json([
                'message' => 'Validation failed. Please, try again.',
                'type' => 'error'
            ], 200);

        }

        // TODO: refactor fetching person data
        $person_id = $request->get('person_id');
        $person = $this->sessionPlayLoad($person_id);
        //$person = Person::where('id', $person_id)->first();

        // LDAP credential
        $credential['username'] = $person->nmrbox_acct;
        $credential['password'] = $request->input('current_pass');

        try {
            // Verifying LDAP password
            $ldap = new Ldap;
            $ldap_authentication = $ldap->ldap_authenticate($credential);

            // LDAP login response
            if($ldap_authentication !== false){
                $new_credential['username'] = $person->nmrbox_acct;
                $new_credential['password'] = $request->get('new_pass');

                // Adding custom LDAP library class and authenticating
                $ldap = new Ldap;
                $ldap_reset = $ldap->ldap_set_password($credential);

                // LDAP login response
                if($ldap_reset !== false){
                    return response( json_encode( array( 'message' => 'Password reset successfully. ', 'type' => 'success' ) ), 200 )
                        ->header( 'Content-Type', 'application/json' );
                } else {
                    return response( json_encode( array( 'message' => 'Sorry, password reset unsuccessful. Try again. ', 'type' => 'error' ) ), 200 )
                        ->header( 'Content-Type', 'application/json' );
                }
            } else {
                return response( json_encode( array( 'message' => 'Sorry, authentication unsuccessful. Try again. ', 'type' => 'error' ) ), 200 )
                    ->header( 'Content-Type', 'application/json' );
            }
        } catch (\ErrorException $e) {
            /* trigger an email to support@nmrbox.org */
            $data = array("LDAP Server malfunction detected.");

            // Send the registration acknowledge email
            Mail::send('emails.server-malfunction', $data, function ($m) {
                $m->to(env('NMRBOX_SUPPORT_EMAIL'));
                $m->subject('Buildserver malfunction detected');
            });
            return response()->json([
                'message' => Lang::get('auth/message.server_conn_error'),
                'type' => 'error'
            ], 200);
        }
    }

    /**
     * Forgot password form processing page.
     *
     * @return Redirect
     */
    public function forgotPassword(Request $request)
    {
        // Declare the rules for the validator
        $rules = array(
            'email' => 'required|email',
        );

        // Create a new validator instance from our dynamic rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            //return Redirect::to(URL::previous())->withInput()->withErrors($validator);
            return response()->json([
                'message' => 'Invalid Email address. Please, provide your valid institutional email address.',
                'type' => 'error'
            ], 200);

        }

        try {
            // Get the user password recovery code
            $user = Person::where('email_institution', Input::get('email'))->first();

            if (!$user) {
                // something went wrong
                /*return response( json_encode( array(
                    'message' => Lang::get('auth/message.forgot-password.error'),
                    'type' => 'error'
                ) ), 401 )
                    ->header( 'Content-Type', 'application/json' );*/
                return response()->json([
                    'message' => Lang::get('auth/message.forgot-password.error'),
                    'type' => 'error'
                ], 200);

            }

            $reminder_code = Crypt::encrypt($user->id);

            $reminder = new Reminder(array(
                'user_id' => $user->id,
                'code'    => $reminder_code,
            ));

            $reminder->save();

            // Data to be used on the email view
            $data = array(
                'user' => $user,
                'forgotPasswordUrl' => "http://webdev.nmrbox.org:8000/forgot-password-confirm/". $user->id ."/". $reminder_code,
                //'forgotPasswordUrl' => URL::route('forgot-password-confirm', [$user->id, $reminder_code]),
            );

            // Send the activation code through email
            Mail::send('emails.forgot-password', $data, function ($m) use ($user) {
                $m->to($user->email_institution, $user->first_name . ' ' . $user->last_name);
                $m->subject('NMRbox Account Password Recovery');
            });

            // return successful message
            return response()-> json( array( 'message' => 'Forgot password request was successful. ', 'type' => 'success' ), 200 );

        } catch (\Exception $e) {
            // something went wrong
            return response()-> json( array( 'message' => Lang::get('auth/message.forgot-password.error'), 'type' => 'error' ), 200 );
        }
    }

    /**
     * Forgot Password Confirmation form processing page.
     *
     * @param  string $passwordResetCode
     * @return Redirect
     */
    //public function confirmForgotPassword($userId, $passwordResetCode, Request $request)
    public function confirmForgotPassword(Request $request)
    {
        // Declare the rules for the form validation
        $rules = array(
            'nmrbox_acct' => 'required',
            'password' => 'required',
            'password_confirm' => 'required|same:password'
        );

        // Create a new validator instance from our dynamic rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            //return Redirect::route('forgot-password-confirm', $passwordResetCode)->withInput()->withErrors($validator);
            //return Redirect::to(URL::previous())->withInput()->withErrors($validator);
            return response()->json([
                'message' => 'Validate failed. Please, try again.',
                'type' => 'error'
            ], 401);

        }

        // decoding request field
        $userId = $request->get('person_id');
        $user = Person::where('id', $userId)->first();

        // Pass reset code from request
        $passwordResetCode = $request->get('pass_reset_code');

        // checking whether user has an entry in the DB & pass reset request in Reminder table
        if ($user->nmrbox_acct != trim($request->get('nmrbox_acct'))) {
            // Ooops.. something went wrong
            //return back()->with('error', Lang::get('auth/message.forgot-password-confirm.account_error'));
            return response()->json([
                'message' => Lang::get('auth/message.forgot-password-confirm.account_error'),
                'type' => 'error'
            ], 401);

        } elseif (
        !$reminder = Reminder::where('user_id', $user->id)
            ->where('code', $passwordResetCode)
            ->where('completed', 'false')
            ->first()) {
            // Ooops.. something went wrong
            //return back()->with('error', Lang::get('auth/message.forgot-password-confirm.request_expired'));
            return response()->json([
                'message' => Lang::get('auth/message.forgot-password-confirm.request_expired'),
                'type' => 'error'
            ], 401);
        } else {

            try {
                //making credential array for LDAP verification
                $credential['username'] = $user->nmrbox_acct;
                $credential['password'] = $request->get('password');

                // Adding custom LDAP library class and authenticating
                $ldap = new Ldap;
                $ldap_status = $ldap->ldap_set_password($credential);

                // LDAP login response
                if ($ldap_status !== false) {
                    // update reminder table
                    $reminder_update = Reminder::where('id', $reminder->id)
                        ->update(
                            array(
                                'completed' => true,
                                'completed_at' => date('Y-m-d H:i:s'),
                            )
                        );

                    // Password successfully reseted
                    //return Redirect::route('login')->with('success', Lang::get('auth/message.forgot-password-confirm.success'));
                    return response()-> json( array( 'message' => Lang::get('auth/message.forgot-password-confirm.success'), 'type' => 'success' ), 200 );
                } else {
                    // Ooops.. something went wrong
                    //return back()->with('error', nl2br(Lang::get('auth/message.forgot-password-confirm.complexity_error')));
                    return response()-> json( array(
                        'message' => Lang::get('auth/message.forgot-password-confirm.complexity_error'),
                        'type' => 'success' ),
                        200 );
                }
            } catch (\ErrorException $e) {
                /* trigger an email to support@nmrbox.org */
                $data = array("Password malfunction detected.");

                // Send the registration acknowledge email
                Mail::send('emails.server-malfunction', $data, function ($m) {
                    $m->to(env('NMRBOX_SUPPORT_EMAIL'));
                    $m->subject('Buildserver malfunction detected');
                });
                //dd($e);
                //return redirect()->back()->withError(Lang::get('auth/message.server_conn_error'));
                return response()-> json( array(
                    'message' => Lang::get('auth/message.server_conn_error'),
                    'type' => 'success' ),
                    200 );
            }
        }
    }

    /**
     * Downloadable VM
     *
     * @return Redirect
     */
    public function downloadableVM(Request $request)
    {
        try {
            // get user details
            $person_id = $request->get('person_id');
            $person = Person::where('id', $person_id)->get()->first();

            // DB entry goes here
            $downloadable_vm = new VMDownload(
                array(
                    'person_id' => $person->id,
                    'vm_id' => Input::get('vm'),
                    'username' => Input::get('vm_username'),
                    'password' => Input::get('vm_password'),
                )
            );

            $downloadable_vm->save();

            return response()-> json( array(
                'message' => 'Your request has been received. An email with a custom generated downloadable link will be sent to you in next few hours.',
                'type' => 'success'
            ), 200 );
        } catch (\Illuminate\Database\QueryException $e) {
            // Redirect to the user page
            return response()-> json( array(
                'message' => 'Downloadable VM request has already been received. You will receive an email shortly.',
                'type' => 'success'
            ), 200 );

        }

    }

    /*
         *
         *
         *
         * * Eof Angular frontend signin and signup
         *
         *
         * */


}
