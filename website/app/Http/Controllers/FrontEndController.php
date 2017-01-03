<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Institution;
use Cartalyst\Sentinel\Laravel\Facades\Activation;

use Sentinel;
use View;
use Validator;
use Input;
use Session;
use Redirect;
use Lang;
use URL;
use Mail;
use File;
use Hash;
use Crypt;
//use Reminder;

use App\User;
use App\Person;
use App\Timezone;
use App\Classification;
use App\Reminder;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use App\Library\Ldap;



class FrontEndController extends ChandraController
{

    protected $validationRules = array(
        'first_name' => 'required|min:3',
        'last_name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|between:3,32',
        'password_confirm' => 'required|same:password',
        'pic' => 'mimes:jpg,jpeg,bmp,png|max:10000'
    );

    /**
     * Account sign in.
     *
     * @return View
     */
    public function getLogin()
    {
        // Is the user logged in?
        if (Sentinel::check()) {
            return Redirect::route('my-account');
        }

        // Show the login page
        return View::make('login');
    }

    /**
     * Account sign in form processing.
     *
     * @return Redirect
     */
    public function postLogin()
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
            $ldap = new Ldap;
            $ldap_login = $ldap->ldap_authenticate(Input::only('username', 'password'));

            // LDAP login response
            if($ldap_login !== false){
                return Redirect::route("my-account")->with('success', Lang::get('auth/message.login.success'));
            } else {
                return Redirect::to('login')->with('error', 'Username or password is incorrect.');
            }
        } catch (UserNotFoundException $e) {
            $this->messageBag->add('email', Lang::get('auth/message.account_not_found'));
        } catch (UserNotActivatedException $e) {
            $this->messageBag->add('email', Lang::get('auth/message.account_not_activated'));
        } catch (UserSuspendedException $e) {
            $this->messageBag->add('email', Lang::get('auth/message.account_suspended'));
        } catch (UserBannedException $e) {
            $this->messageBag->add('email', Lang::get('auth/message.account_banned'));
        }

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);
    }

    /**
     * get user details and display
     */
    public function myAccount()
    {
        $user = Sentinel::getUser();
        // the person attached to the user
        $person = $user->person()->get()->first();
        $classifications = Classification::All();

        /*
         * @todo - remove old template
         * */

        return View::make('user_dashboard', compact('user', 'person'));
        //return View::make('user_account', compact('user', 'person'));
    }


    /**
     * display form for user general profile update
     *
     * @todo - remove old template
     *
     */
    public function editProfile()
    {
        $user = Sentinel::getUser();
        // the person attached to the user
        $person = $user->person()->get()->first();

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
        $user = Sentinel::getUser();
        $person = $user->person()->get()->first();

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
     * update user details and display
     */
    public function updateProfile()
    {
        //$user = Sentinel::findById($id);
        $user = Sentinel::getUser();
        $person = $user->person()->get()->first();


        //validatoinRules are declared at beginning
        /*if (Input::get('email')) {
            $this->validationRules['email'] = "required|email|unique:users,email,{$user->email},email";
        } else {
            unset($this->validationRules['email']);
        }*/

        /*if (!$password = Input::get('password')) {
            unset($this->validationRules['password']);
            unset($this->validationRules['password_confirm']);
        }*/

        /*// Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $this->validationRules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }*/

        // Update the user
//        $user->first_name = Input::get('first_name');
//        $user->last_name = Input::get('last_name');
//        $user->email = Input::get('email');
//        $user->gender = Input::get('gender');
//        $user->phone = Input::get('phone');
//        $user->dob = Input::get('dob');
//        $user->country = Input::get('country');
//        $user->address = Input::get('address');
//        $user->state = Input::get('state');
//        $user->city = Input::get('city');
//        $user->zip = Input::get('zip');
//        $user->facebook = Input::get('facebook');
//        $user->twitter = Input::get('twitter');
//        $user->google_plus = Input::get('google_plus');
//        $user->skype = Input::get('skype');
//        $user->flickr = Input::get('flickr');
//        $user->youtube = Input::get('youtube');
//        $user->subscribed = Input::get('subscribed') ? 1 : 0;

        $user->email = Input::get('email');

        // the person attached to the user
        $person->first_name = Input::get('first_name');
        $person->last_name = Input::get('last_name');

        // is new image uploaded?
        /*if ($file = Input::file('pic')) {
            $fileName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $folderName = '/uploads/users/';
            $destinationPath = public_path() . $folderName;
            $safeName = str_random(10) . '.' . $extension;
            $file->move($destinationPath, $safeName);

            //delete old pic if exists
            if (File::exists(public_path() . $folderName . $user->pic)) {
                File::delete(public_path() . $folderName . $user->pic);
            }

            //save new file path into db
            $user->pic = $safeName;
        }*/


        // Was the user's person record updated?
        if ($person->save()) {
            // if so, continue
        }
        else {
            // Prepare the error message
            $error = Lang::get('users/message.error.update');

            // Redirect to the user page
            return Redirect::route('my-account')->withInput()->with('error', $error);
        }

        // Was the user updated?
        if ($user->save()) {
            // Prepare the success message
            $success = Lang::get('users/message.success.update');

            // Redirect to the user page
            return Redirect::route('my-account')->with('success', $success);
        }

        // Prepare the error message
        $error = Lang::get('users/message.error.update');


        // Redirect to the user page
        return Redirect::route('my-account')->withInput()->with('error', $error);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postChangePassword(Request $request)
    {
        //sleep(5);
        if(!$request->ajax()) {
            return App::abort(403);
        }

        $user_session = Sentinel::check();
        $user = User::where('id', $user_session->id)->first();
        $person = Person::where('id', $user['person_id'])->first();

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
            $user = Person::where('email', Input::get('email'))->first();

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
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('NMRbox Account Password Recovery');
            });
        } catch (UserNotFoundException $e) {
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
        //if (!$user = Sentinel::findById($userId)) {
        if (!$user = Person::where('id', $userId)->first()) {
            // Redirect to the forgot password page
            return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.account_not_found'));
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

        if($user->nmrbox_acct != $request->get('nmrbox_acct') ||
            !$reminder = Reminder::where('user_id', $user->id)
                ->where('code', $passwordResetCode)
                ->where('completed', 'false')
                ->first())
        {
            // Ooops.. something went wrong
            return back()->with('error', Lang::get('auth/message.forgot-password-confirm.error'));
        } else {

            //making credential array for LDAP verification
            $credential['username'] = $user->nmrbox_acct;
            $credential['password'] = $request->get('password');

            // Adding custom LDAP library class and authenticating
            $ldap = new Ldap;
            $ldap_login = $ldap->ldap_set_password($credential);

            // LDAP login response
            if($ldap_login !== false){
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
                return back()->with('error', Lang::get('auth/message.forgot-password-confirm.error'));
            }
        }
    }

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
    public function postRegister()
    {
        // Declare the rules for the form validation
        $rules = array(
            'first_name' => 'required|min:1',
            'last_name' =>  'required|min:1',
            'email' => 'email|max:255|unique:persons',
            'email_institution' => 'required|email|max:255|unique:persons|unique:users,email', // need to validate the email isn't taken on the users table either
            'job_title' =>  'required',
            'institution' =>  'required',
            'institution_type' =>  'required',
            'department' =>  'required|min:1|max:256',
            'pi' =>  'required|min:1|max:64',
            'address1' =>  'required|min:1|max:128',
            'address2' =>  'max:128',
            'address3' =>  'max:128',
            'city' =>  'required|min:1|max:64',
            'state_province' =>  'required|min:1|max:32',
            'zip_code' =>  'required|min:1|max:32',
            'country' =>  'required|min:1|max:64',
            'time_zone_id' =>  'required|integer'
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $activate = true; //make it false if you don't want to activate user automatically

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
//                'nmrbox_acct' => Input::get('nmrbox_acct'),
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
            $person->save();


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


            // Register the user
            $user = Sentinel::register(array(
                'person_id' => $person->id,
                'email' => Input::get('email'),
                'password' => "NMR-2016!" // TODO: good god make people change this
            ), $activate);

            //add user to 'User' group
            $role = Sentinel::findRoleByName('User');
            $role->users()->attach($user);


            /*
            //un-comment below if you set $activate=false above

            // Data to be used on the email view
            $data = array(
                'user'          => $user,
                'activationUrl' => URL::route('activate',$user->id, Activation::create($user)->code),
            );

            // Send the activation code through email
            Mail::send('emails.register-activate', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Welcome ' . $user->first_name);
            });

            //Redirect to login page
            return Redirect::to("admin/login")->with('success', Lang::get('auth/message.signup.success'));

            */

            // login user automatically


            // DEFAULT BEHAVIOR

            // Log the user in
//            Sentinel::login($user, false);

            // Redirect to the home page with success menu
//            return Redirect::route("my-account")->with('success', Lang::get('auth/message.signup.success'));
            //return View::make('user_account')->with('success', Lang::get('auth/message.signup.success'));

            return View::make('registration-successful')->with('success', Lang::get('auth/message.signup.success'));

        } catch (UserExistsException $e) {
            $this->messageBag->add('email', Lang::get('auth/message.account_already_exists'));
        }

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);
    }


    /**
     * Account sign up form processing.
     *
     * @return Redirect
     */
    public function postRegisterPerson()
    {
        // Declare the rules for the form validation
        $rules = array(
            'first_name' => 'required|min:3',
            'last_name' =>  'required|min:3',
            'email' => 'required|email|unique:persons',
            'institution' =>  'required|min:3',
            'pi' =>  'required|min:3'
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $person = new Person(Input::all());
        $person->save();
        return View::make('registration-person-successful')->with('success', Lang::get('auth/message.signup.success'));
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
     * Logout page.
     *
     * @return Redirect
     */
    public function getLogout()
    {
        // Log the user out
        Sentinel::logout();

        // Redirect to the users page
        return Redirect::to('login')->with('success', 'You have successfully logged out!');
    }


}
