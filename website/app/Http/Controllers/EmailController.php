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
use App\Email;
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
                'content' => $request->content,

            ));

            $email->save();
            //$this->messageBag->add('email', Lang::get('emails/message.success.create'));
        }
        catch (UserExistsException $e) {
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
    public function edit(Request $request, $name)
    {
        $email = Email::where('name', $name)->first();

        return view('admin.emails.edit', compact('email'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string $name
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $name)
    {
        $email = Email::where('name', $name)->first();
        $email->name = $request->input('name');
        $email->content = $request->input('content');

        $email->save();

        return redirect('admin/email');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string name
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email $email, $name)
    {
        $email->where('name', $name)->first()->delete();
        return redirect("admin/email");
    }

}
