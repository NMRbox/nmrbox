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
use Lang;
use App\FileMetadata;
use App\File;

class FileMetadataController extends Controller
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
        $all_metadata = FileMetadata::All();

        return View::make('admin.file_metadata.index', compact('all_metadata'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.file_metadata.create', compact('file_metadata'));
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
            $file_metadata = new FileMetadata(array(
                'metadata' => $request->metadata
            ));

            $file_metadata->save();
            //$this->messageBag->add('email', Lang::get('file_metadata/message.success.create'));
        }
        catch (UserExistsException $e) {
            $this->messageBag->add('email', Lang::get('file_metadata/message.error.create'));

        }
        // Ooops.. something went wrong
        //return redirect('admin/email')->withSuccess($this->messageBag);
        return redirect('admin/file_metadata');
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
    public function edit($id)
    {
        // file metadata object
        $file_metadata = FileMetadata::where('id', $id)->first();
        return view('admin.file_metadata.edit', compact('file_metadata'));

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
        try{
            /* Input request content */
            $file_metadata = FileMetadata::where('id', $id)->first();
            $file_metadata->metadata = $request->input('metadata');

            $file_metadata->save();
        } catch ( QueryException $e){

            // something went wrong - probably has entries in email_person table
            return redirect()->back()->withError(Lang::get('file_metadata/message.error.update'));
        }

        // redirect with success message
        //return redirect('admin/email');
        return redirect()->back()->withSuccess(Lang::get('file_metadata/message.success.update'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $file_metadata = FileMetadata::where('id', $id)->delete();

        } catch ( QueryException $e){

            // something went wrong - probably has entries in email_person table
            return redirect()->back()->withError(Lang::get('file_metadata/message.error.delete'));
        }

        // redirect with success message
        return redirect()->back()->withSuccess(Lang::get('file_metadata/message.success.delete'));
    }


}
