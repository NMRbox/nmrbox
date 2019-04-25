<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Keyword;
use App\Category;
use View;
use Lang;
use App\Http\Requests;
use App\Http\Requests\KeywordRequest;
use App\Http\Controllers\Controller;

class KeywordController extends Controller
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
        $all_keywords = Keyword::All();
        $all_categories = Category::All();
        return View::make('admin.keywords.index', compact('all_keywords', 'all_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.keywords.create', compact(''));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KeywordRequest $request)
    {
        try {
            
            $keyword = new Keyword(array(
                'label' => $request->label
            ));
            
            $keyword->save();

            return redirect("admin/keyword")->withSuccess(Lang::get('softwares/message.success.create_keyword'));
        }
        catch (KeywordExistsException $e) {
            $this->messageBag->add('label', 'Keyword already exists');
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
    public function show(Keyword $keyword)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Keyword  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($keyword_id)
    {
        $keyword = Keyword::where('id', $keyword_id)->get()->first();

        return view('admin.keywords.edit', compact('keyword'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $keyword_id)
    {
        $keyword = Keyword::where('id', $keyword_id)->get()->first();

        $keyword->update($request->all());
        $keyword->save();

        return redirect()->back()->withSuccess(Lang::get('softwares/message.success.update_keyword'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Keyword $keyword
     * @return \Illuminate\Http\Response
     */
    public function destroy($keyword_id)
    {
        $keyword = Keyword::where('id', $keyword_id)->get()->first();
        $keyword->delete();
        return redirect("admin/keyword");
    }

    /**
     * Populate all the keywords
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllKeywords()
    {
        $keywords = Keyword::All();

        $all_keywords = array();
        foreach ($keywords as $key => $val){

            $all_keywords[] = array('id' => $val->id, 'label' => $val->label);
        }

        return response( json_encode( array( 'message' => $all_keywords ) ), 200 )
            ->header( 'Content-Type', 'application/json' );
    }
}
