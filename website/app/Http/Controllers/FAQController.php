<?php


namespace App\Http\Controllers;

use App\Software;
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
use App\FAQ;
Use App\FileMetadata;
use App\Keyword;
use App\Category;

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
        /*echo "<pre>";
        print_r($faqs);
        echo "</pre>";*/
        /*echo "<pre>";
        $my_bytea = stream_get_contents($all_faqs[0]['answer']);
        $my_string = pg_unescape_bytea($my_bytea);
        $html_data = htmlspecialchars($my_string);
        print_r($html_data);
        echo "</pre>";*/

        foreach($faqs as $key => $value){
            $all_faqs[] = $this->convert_to_string($value->id);
        }
        /*echo "<pre>";
        print_r($all_faqs);
        echo "</pre>";
        die();*/

        // all keywords
        $all_softwares = Software::All();

        // all metadata
        $all_metadata = FileMetadata::All();


        // make index view
        return view::make('admin.faqs.index', compact('all_faqs', 'all_softwares'));
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
        echo "store";
        /* try & catch process for new faq */
        try {
            $faq = new FAQ(array(
                'question' => $request->question,
                'answer' => $request->answer
            ));

            $faq->save();
            //$this->messageBag->add('email', Lang::get('emails/message.success.create'));
        }
        catch (UserExistsException $e) {
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
        /* all faqs*/
        $faqs = FAQ::All();

        foreach($faqs as $key => $value){
            $all_faqs[] = $this->convert_to_string($value->id);
        }

        // all keywords
        $all_softwares = Software::All();

        // all metadata
        $all_metadata = FileMetadata::All();

        // make index view
        return view::make('faq', compact('all_faqs', 'all_softwares'));
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

        // Keywords Mapping
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

        /* All File metadata */
        /*$all_metadata = FileMetadata::All();
        $faq_metadata = $faq->metadatas()->get();
        $metadata_map = collect([ ]);
        $metad = $faq_metadata->keyBy("metadata");

        foreach( $all_metadata as $metadata ) {
            if($metad->has($metadata->metadata)) {
                $metadata_map->push($metadata->metadata);
                $metadata->present = true;
            }
            else {
//              $keyword_map->push($keyword->label, false);
            }
        }*/

        //return view::make('admin.faqs.edit', compact('faq', 'all_keywords', 'keyword_map', 'file_keywords', 'keyword_map', 'all_metadata', 'faq_metadata', 'metadata_map'));
        return view::make('admin.faqs.edit', compact('faq', 'all_softwares', 'software_map', 'faq_softwares'));
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

            $request_software_data = $request->input('software');
            /*echo "<pre>";
            print_r($request_software_data);
            echo "</pre>";
            die();*/
            /* software mapping */
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

        } catch ( QueryException $e){

            // something went wrong - probably has entries in email_person table
            return redirect()->back()->withError(Lang::get('faqs/message.error.delete'));
        }

        // redirect with success message
        return redirect()->back()->withSuccess(Lang::get('faqs/message.success.delete'));
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
        $all_metadata = FileMetadata::All();*/

        // make index view
        return view::make('faq', compact('all_faqs'));
    }
}
