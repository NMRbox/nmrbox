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
use App\SearchKeyword;
use App\File;

class SearchKeywordController extends Controller
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
        $search_keywords = SearchKeyword::All();

        return View::make('admin.search_keyword.index', compact('search_keywords'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.search_keyword.create', compact('search_keyword'));
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
            $search_keyword = new SearchKeyword(array(
                'metadata' => $request->metadata
            ));

            $search_keyword->save();
            //$this->messageBag->add('email', Lang::get('search_keyword/message.success.create'));
            return redirect('admin/search_keyword');
        }
        catch (UserExistsException $e) {
            // something went wrong - probably has entries in search_keyword table
            return redirect()->back()->withError(Lang::get('search_keyword/message.error.create'));
        }catch (QueryException $e) {
            // something went wrong - probably has entries in search_keyword table
            return redirect()->back()->withError(Lang::get('search_keyword/message.file_metadata_exists'));
        }

        return redirect()->back()->withError(Lang::get('search_keyword/message.error.create'));
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
        $search_keyword = SearchKeyword::where('id', $id)->first();
        return view('admin.search_keyword.edit', compact('search_keyword'));

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
            $search_keyword = SearchKeyword::where('id', $id)->first();
            $search_keyword->metadata = $request->input('metadata');

            $search_keyword->save();
        } catch ( QueryException $e){

            // something went wrong - probably has entries in email_person table
            return redirect()->back()->withError(Lang::get('search_keyword/message.file_metadata_exists'));
        }

        // redirect with success message
        //return redirect('admin/email');
        return redirect()->back()->withSuccess(Lang::get('search_keyword/message.success.update'));

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
            $search_keyword = SearchKeyword::where('id', $id)->delete();

        } catch ( QueryException $e){

            // something went wrong - probably has entries in email_person table
            return redirect()->back()->withError(Lang::get('search_keyword/message.error.delete'));
        }

        // redirect with success message
        return redirect()->back()->withSuccess(Lang::get('search_keyword/message.success.delete'));
    }


}
