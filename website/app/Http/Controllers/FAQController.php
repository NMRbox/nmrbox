<?php


namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\MessageBag;
use View;
use Input;
use Session;
use Sentinel;
use Mail;
use Lang;
use App\FAQ;
Use App\SearchKeyword;
use App\Keyword;
use App\Category;
use App\Person;
use App\Software;

class FAQController extends Controller
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
        /* all faqs*/
        $faqs = FAQ::All();


        foreach($faqs as $key => $value){
            $all_faqs[] = $this->convert_to_string($value->id);
        }

        // all softwares
        $all_softwares = Software::All();

        // all search keywords
        $all_search_keywords = SearchKeyword::All();

        // all person
        $all_person = Person::All();


        // make index view
        return view::make('admin.faqs.index', compact('all_faqs', 'all_softwares', 'all_search_keywords', 'all_person'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //make create view
        return view::make('admin.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* try & catch process for new faq */
        try {
            $faq = new FAQ(array(
                'question' => $request->question,
                'answer' => $request->answer
            ));

            $faq->save();
            //$this->messageBag->add('email', Lang::get('emails/message.success.create'));
        }
        catch (QueryException $e) {
            $this->messageBag->add('faq', Lang::get('faqs/message.error.create'));

        }

        return redirect('admin/faq')->withSuccess(Lang::get('faqs/message.success.create'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Pulling out the object
        $faq = $this->convert_to_string($id);

        // All user details
        $all_person = Person::All();

        // All ratings
        /*$faq_ratings = $faq->ratings()->get();
        /*echo "<pre>";
        print_r($faq_ratings);
        echo "</pre>";*/


        /*foreach ($faq->ratings as $rating){
            $data[] = $rating->pivot->person_id;

        }*/


        // Software / FAQ Mapping
        $all_softwares = Software::All();
        $faq_softwares = $faq->softwares()->get();
        $software_map = collect([ ]);
        $keyed = $faq_softwares->keyBy("name");

        foreach( $all_softwares as $software ) {
            if($keyed->has($software->name)) {
                $software_map->push($software->name);
                $software->present = true;
            }
            else {
//              $keyword_map->push($keyword->label, false);
            }
        }

        /* All File Search Keywords */
        $all_search_keywords = SearchKeyword::All();
        $faq_search_keywords = $faq->search_keywords()->get();
        $search_keywords_map = collect([ ]);

        $keyed = $faq_search_keywords->keyBy("metadata");

        foreach( $all_search_keywords as $keyword ) {
            if($keyed->has($keyword->metadata)) {
                $search_keywords_map->push($keyword->metadata);
                $keyword->present = true;
            }
        }

        //return view::make('admin.faqs.edit', compact('faq', 'all_keywords', 'keyword_map', 'file_keywords', 'keyword_map', 'all_metadata', 'faq_metadata', 'metadata_map'));
        return view::make('admin.faqs.edit', compact('faq', 'all_person', 'faq_ratings', 'all_softwares', 'software_map', 'faq_softwares', 'all_search_keywords', 'search_keywords_map', 'faq_search_keywords'));
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
        /* Request data */
        //$request_data = $request->input();

        try{
            /* Input request content */
            $faq = FAQ::where('id', $id)->get()->first();
            $faq->question = $request->input('question');
            $faq->answer = $request->input('answer');
            $faq->save();

            /* software mapping */
            $request_software_data = $request->input('software');
            if($request_software_data){
                foreach($request_software_data as $software_id => $checked_status) {
                    $software = Software::where("id", "=", $software_id)->get()->first();
                    if($checked_status == "on") {
                        try {
                            $faq->softwares()->attach($software->id);
                        }
                        catch(\Illuminate\Database\QueryException $e) {
                            // silently ignore trying to ignore a dupe because it doesn't matter and that's what good software engineers do right?
                            //dd($e);
                        }
                    }
                    else {
                        $faq->softwares()->detach($software->id);
                    }
                }
            }

            /* search keyword mapping */
            $faq_search_keyword = $request->input('metadata');
            if($faq_search_keyword){
                foreach($faq_search_keyword as $keyword_id => $checked_status) {
                    $metad = SearchKeyword::where("id", "=", $keyword_id)->get()->first();
                    if($checked_status == "on") {

                        try {
                            $faq->search_keywords()->attach($metad->id);
                        }
                        catch(\Illuminate\Database\QueryException $e) {
                            // silently ignore trying to ignore a dupe because it doesn't matter and that's what good software engineers do right?
                            //dd($e);
                        }
                    }
                    else {
                        $faq->search_keywords()->detach($metad->id);
                    }
                }
            }
        } catch ( QueryException $e){

            // something went wrong - probably has entries in email_person table
            return redirect()->back()->withError(Lang::get('faqs/message.error.update'));
        }

        // redirect with success message
        //return redirect('admin/email');
        return redirect()->back()->withSuccess(Lang::get('faqs/message.success.update'));
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
            $faq = FAQ::where('id', $id)->get()->first();
            
            $faq->delete();

            // redirect with success message
            return redirect()->back()->withSuccess(Lang::get('faqs/message.success.delete'));
        } catch ( QueryException $e){

            // something went wrong - probably has entries in email_person table
            return redirect()->back()->withError(Lang::get('faqs/message.error.delete'));
        }

    }

    /**
     * Converting the bytea resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function convert_to_string($id){

        /* Getting the original faq */
        $faq = FAQ::where('id', $id)->get()->first();

        /* converting bytea to string */
        $answer_bytea = stream_get_contents($faq->answer);
        $answer_string = pg_unescape_bytea($answer_bytea);
        $answer = htmlspecialchars($answer_string);

        /* New faq object */
        $new_faq = new FAQ(array(
            'id' => $faq->id,
            'question' => $faq->question,
            'answer' => $answer
        ));

        /* Returing the converted result */
        return $new_faq;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAllFAQs()
    {
        /* all faqs*/
        $faqs = FAQ::All();

        foreach($faqs as $key => $value){
            $all_faqs[] = $this->convert_to_string($value->id);
        }

        /*// all keywords
        $all_keywords = Category::All();

        // all metadata
        $all_metadata = SearchKeyword::All();*/

        // make index view
        return view::make('faq', compact('all_faqs'));
    }

    /**
     * Count the specific FAQ ratings
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function countFAQRatings(Request $request){

        if(!$request->ajax()) {
            return App::abort(403);
        }

        // input fields
        $vote = $request->input('vote');
        $comment = $request->input('comment');


        // FAQ id
        $id = $request->input('id');
        $faq = FAQ::where('id', $id)->get()->first();

        // Retrieving the logged users id from session variable
        $person = Session::get('person');
        $faq_rating = $faq->ratings()->wherePivot('person_id', $person->id)->get()->first();

        echo "<pre>";
        print_r($faq_rating);
        echo "</pre>";
        die();

        /* Saving vote to db if not yet cast */
        if(!$faq_rating){
            $faq->ratings()->attach(array(
                    $person->id => array(
                        'upvote' => $vote,
                        'comment' => $comment
                    )
                )
            );

            return response( json_encode( array( 'message' => 'Thank you for your time to give us your feedback. ' ) ), 200 )
                ->header( 'Content-Type', 'application/json' );

        } else {
            return response( json_encode( array( 'message' => 'You have already cast your vote. ' ) ), 401 )
                ->header( 'Content-Type', 'application/json' );
        }
    }


}
