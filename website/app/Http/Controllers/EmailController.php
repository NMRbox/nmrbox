<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
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
use App\Email;
use App\EmailPerson;
use App\Institution;
use App\Timezone;


class EmailController extends Controller
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
        // Retrieving all the emails
        $email_templates = Email::All();

        return View::make('admin.emails.index', compact('email_templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.emails.create', compact('email'));
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
            $email = new Email(array(
                'name' => $request->name,
                'subject' => $request->subject,
                'content' => $request->content
            ));

            $email->save();
            //$this->messageBag->add('email', Lang::get('emails/message.success.create'));
        }
        catch (\Exception $e) {
            $this->messageBag->add('email', Lang::get('emails/message.error.create'));

        }
        // Ooops.. something went wrong
        //return redirect('admin/email')->withSuccess($this->messageBag);
        return redirect('admin/email');
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
     * @param  string $name
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // email object
        $email = Email::where('id', $id)->first();

        // email_person object
        $email_person = EmailPerson::where('email_id', $id)->orderBy('sent', 'desc')->get();

        $email_log = array();
        foreach ($email_person as $data){
            $person_data = Person::where('id', $data->person_id)->get();
            $person_email = $data->email;
            $email_sent = $data->sent;

            $email_log[$data->sent][] = array(
                'person_name' => $person_data[0]['first_name']. " " . $person_data[0]['last_name'],
                'person_email' => $person_email,
                'person_nmrbox_acct' => $person_data[0]['nmrbox_acct'],
                'person_email_sent' => $email_sent,
            );
        }

        return view('admin.emails.edit', compact('email', 'email_log'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string $name
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            /* Input request content */
            $email = Email::where('id', $id)->first();
            $email->name = $request->input('name');
            $email->subject = $request->input('subject');
            $email->content = $request->input('content');

            $email->save();
        } catch ( \Exception $e){

            // something went wrong - probably has entries in email_person table
            return redirect()->back()->withError(Lang::get('emails/message.error.update'));
        }

        // redirect with success message
        //return redirect('admin/email');
        return redirect()->back()->withSuccess(Lang::get('emails/message.success.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string name
     * @return \Illuminate\Http\Response
     */
    public function destroy($param)
    {
        try{
            $email = Email::where('id', $param)->delete();

        } catch ( \Exception $e){

            // something went wrong - probably has entries in email_person table
            return redirect()->back()->withError(Lang::get('emails/message.error.delete'));
        }

        // redirect with success message
        return redirect()->back()->withSuccess(Lang::get('emails/message.success.delete'));
    }

}
