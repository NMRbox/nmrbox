<?php

namespace App\Http\Controllers;

use App\Http\Requests;

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
use App\User;
use App\Person;
use App\Timezone;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Reminder;


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
            'email' => 'required|email',
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
            // Try to log the user in
            if (Sentinel::authenticate(Input::only('email', 'password'), Input::get('remember-me', 0))) {
                return Redirect::route("my-account")->with('success', Lang::get('auth/message.login.success'));
            } else {
                return Redirect::to('login')->with('error', 'Username or password is incorrect.');
                //return Redirect::back()->withInput()->withErrors($validator);
            }

        } catch (UserNotFoundException $e) {
            $this->messageBag->add('email', Lang::get('auth/message.account_not_found'));
        } catch (NotActivatedException $e) {
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
        return View::make('user_account', compact('user'));
    }

    /**
     * update user details and display
     */
    public function updateAccount()
    {
        //$user = Sentinel::findById($id);
        $user = Sentinel::getUser();
        //validatoinRules are declared at beginning
        if (Input::get('email')) {
            $this->validationRules['email'] = "required|email|unique:users,email,{$user->email},email";
        } else {
            unset($this->validationRules['email']);
        }

        if (!$password = Input::get('password')) {
            unset($this->validationRules['password']);
            unset($this->validationRules['password_confirm']);
        }

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $this->validationRules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        // Update the user
        $user->first_name = Input::get('first_name');
        $user->last_name = Input::get('last_name');
        $user->email = Input::get('email');
        $user->gender = Input::get('gender');
        $user->phone = Input::get('phone');
        $user->dob = Input::get('dob');
        $user->country = Input::get('country');
        $user->address = Input::get('address');
        $user->state = Input::get('state');
        $user->city = Input::get('city');
        $user->zip = Input::get('zip');
        $user->facebook = Input::get('facebook');
        $user->twitter = Input::get('twitter');
        $user->google_plus = Input::get('google_plus');
        $user->skype = Input::get('skype');
        $user->flickr = Input::get('flickr');
        $user->youtube = Input::get('youtube');
        $user->subscribed = Input::get('subscribed') ? 1 : 0;

        // Do we want to update the user password?
        if ($password = Input::get('password')) {
            $user->password = Hash::make($password);
        }

        // is new image uploaded?
        if ($file = Input::file('pic')) {
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
        $person_institution_types = Person::institution_types;
        
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
            'email' => 'required|email|unique:users',
            'institution' =>  'required|min:1',
            'pi' =>  'required|min:1'
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $activate = true; //make it false if you don't want to activate user automatically

        try {
            // register the person
            $person = new Person(array(
                'first_name' => Input::get('first_name'),
                'last_name' => Input::get('last_name'),
                'pi' => Input::get('pi'),
//                'nmrbox_acct' => Input::get('nmrbox_acct'),
                'institution' => Input::get('institution'),
                'institution_type' => Input::get('institution_type'),
                'department' => Input::get('department'),
                'position' => Input::get('position'),
                'address1' => Input::get('address1'),
                'address2' => Input::get('address2'),
                'address3' => Input::get('address3'),
                'city' => Input::get('city'),
                'state_province' => Input::get('state_province'),
                'zip_code' => Input::get('zip_code'),
                'country' => Input::get('country'),
                'time_zone_id' => Input::get('time_zone_id'),
            ));
            $person->save();

            // Register the user
            $user = Sentinel::register(array(
                'person_id' => $person->id,
                'email' => Input::get('email'),
                'password' => "nmrbox2016!" // TODO: good god make people change this
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
            //$user = Sentinel::getUserProvider()->findByLogin(Input::get('email'));
            $user = Sentinel::findByCredentials(['email' => Input::get('email')]);

            if (!$user) {
                return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.account_not_found'));
            }

            $reminder = Reminder::exists($user) ?: Reminder::create($user);

            // Data to be used on the email view
            $data = array(
                'user' => $user,
                //'forgotPasswordUrl' => URL::route('forgot-password-confirm', $user->getResetPasswordCode()),
                'forgotPasswordUrl' => URL::route('forgot-password-confirm', [$user->id, $reminder->code]),
            );

            // Send the activation code through email
            Mail::send('emails.forgot-password', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Account Password Recovery');
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
    public function getForgotPasswordConfirm($userId, $passwordResetCode = null)
    {
        if (!$user = Sentinel::findById($userId)) {
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
    public function postForgotPasswordConfirm($userId, $passwordResetCode = null)
    {
        // Declare the rules for the form validation
        $rules = array(
            'password' => 'required|between:3,32',
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


        $user = Sentinel::findById($userId);

        if (!$reminder = Reminder::complete($user, $passwordResetCode, Input::get('password'))) {
            // Ooops.. something went wrong
            return Redirect::route('login')->with('error', Lang::get('auth/message.forgot-password-confirm.error'));
        }

        // Password successfully reseted
        return Redirect::route('login')->with('success', Lang::get('auth/message.forgot-password-confirm.success'));
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
            $m->from('test@test.com', 'TestSiteName');
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
