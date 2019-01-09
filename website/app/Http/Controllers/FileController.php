<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
Use App\File;
Use App\SearchKeyword;
use App\Keyword;
use App\Category;
use Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sentinel;
use View;
use Lang;

class FileController extends Controller
{
    // downloadFile, uploadAndGetURL, makeFileFromUploadedFile methods
    use FileHandler;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $all_files = File::select('id', 'label', 'slug', 'mime_type', 'size')->get()->sortBy('label');

        // all metadata
        $all_search_keywords = SearchKeyword::All();

        return View::make("admin.files.index", compact('all_files', 'all_keywords', 'all_search_keywords'));
    }
    
    /**
     * Show the requested file
     *
     * @param  File $file
     * @return \Illuminate\Http\Response
     */
    public function getFile($file_name)
    {
        if($file_name == 'create'){
            return view('admin.files.create',compact(''));
        } else {
            try{
                $file = File::where('slug', 'like', $file_name)->first();

                $headers = array('Content-type' => $file->mime_type, 'Content-length' => $file->size);

                $data = $file->bdata;
                $unescape = $file->binary_unsql($data);
                $un64 = base64_decode($unescape);


                return response($un64, 200, $headers);
            } catch (\Exception $e) {
                abort(404);
            }

        }
    }

    /**
     * Load the requested file
     *
     * @param  File $file
     * @return \Illuminate\Http\Response
     */
    public function loadFile( $file_name )
    {
        try{
            $file = File::where('slug', 'like', $file_name)->first();

            $headers = array('Content-type' => $file->mime_type, 'Content-length' => $file->size);

            $data = $file->bdata;
            $unescape = $file->binary_unsql($data);
            $un64 = base64_decode($unescape);


            return response($un64, 200, $headers);
        } catch (\Exception $e) {
            abort(404);
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // create view
        return view('admin.files.create',compact(''));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $all_files = Input::file();
        /*$filename = $request->input('label');
        $file_slug = $request->input('slug');*/

        /* parsing the inputs from form submission */
        parse_str(urldecode($request->input('data')), $file_keyword_metadata);

        $file_label = $file_keyword_metadata['label'];
        $file_slug = $file_keyword_metadata['slug'];

        foreach( $all_files as $name => $f ) {
            $newfile = $this->makeFileFromUploadedFile($f, $file_label, $file_slug);
        }

        if($newfile == true){
            return response( json_encode( array( 'message' => 'Successfully uploaded. ' ) ), 200 )
                ->header( 'Content-Type', 'application/json' );
        }

        // returning back to the page
        return redirect()->back()->withSuccess(Lang::get('files/message.success.create'));

    }


    /**
     * Store multiple files from a multipart form upload.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFiles(Software $software) {
        $all_files = Input::file();

        foreach( $all_files as $name => $f ) {
            $newfile = $this->makeFileFromUploadedFile($f, $name);
            $software->files()->save($newfile);
        }

        // redirect back to editing the same page when done
        return back()->withInput();
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
        // retrieving file data
        $file = File::select('id', 'label', 'slug', 'mime_type', 'size')->where('id', '=', $id)->get()->first();

        /* All File Search Keywords */
        $all_search_keywords = SearchKeyword::All();
        $file_search_keywords = $file->search_keywords()->get();
        $search_keywords_map = collect([ ]);

        $keyed = $file_search_keywords->keyBy("metadata");

        foreach( $all_search_keywords as $keyword ) {
            if($keyed->has($keyword->metadata)) {
                $search_keywords_map->push($keyword->metadata);
                $keyword->present = true;
            }
            else {
//              $keyword_map->push($keyword->label, false);
            }
        }

        /* test
        $old_slug = 'benefits-users2.pdf';
        $file_slug = 'benefits-users3.pdf';
        $page = Page::where('content', 'LIKE', '%'.$old_slug.'%')->get()->first();
        //dd($page);

        $str_rpl = str_replace($old_slug, $file_slug, $page->content);
        echo "<pre>";
        print_r($str_rpl);
        echo "</pre>";
        die();
        /* eof test */

        // file view
        return view('admin.files.edit',compact('file','all_search_keywords', 'file_search_keywords', 'search_keywords_map'));
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
        // Retrieving the information for requested file
        $file = File::where('id', $id)->get()->first();

        /* old file data */
        $old_slug = $file->slug;

        // all the files that are included to upload
        $all_files = Input::file();

        /* parsing the inputs from form submission */
        parse_str(urldecode($request->input('data')), $file_keyword_metadata);

        /* parsing label and slug */
        $file_label = $file_keyword_metadata['label'];
        $file_slug = $file_keyword_metadata['slug'];

        /* test */

        /*$page = Page::where('content', 'LIKE', '%'.$old_slug.'%')->get()->first();

        $str_rpl = str_replace($old_slug, $file_slug, $page->content);
        echo "<pre>";
        print_r($str_rpl);
        echo "</pre>";
        die();*/
        /* test */

        // uploading all the files using file handler
        if($all_files){
            foreach( $all_files as $name => $f ) {
                $updatefile = $this->replaceFileFromUploadedFile($f, $id, $file_label, $file_slug);
            }
        } else {
            /* update the file label only */
            $file->label = $file_label;
            $file->slug = $file_slug;
            $file->save();
        }

        /* search keyword mapping */
        if(isset($file_keyword_metadata['metadata'])){

            foreach($file_keyword_metadata['metadata'] as $keyword_id => $checked_status) {
                $metad = SearchKeyword::where("id", "=", $keyword_id)->get()->first();
                if($checked_status == "on") {

                    try {
                        $file->search_keywords()->attach($metad->id);
                    }
                    catch(\Exception $e) {
                        // silently ignore trying to ignore a dupe because it doesn't matter and that's what good software engineers do right?
                        //dd($e);
                    }
                }
                else {
                    $file->search_keywords()->detach($metad->id);
                }
            }
        }

        /* changing the file slug across all the linked pages */
        $pages = Page::where('content', 'LIKE', '%'.$old_slug.'%')->get();

        foreach ($pages as $page){
            $page->content = str_replace($old_slug, $file_slug, $page->content);
            $page->save();
        }

        // returning back to the page
        return response( json_encode( array( 'message' => 'Successfully uploaded. ' ) ), 200 )
            ->header( 'Content-Type', 'application/json' );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($file_id)
    {
        try{
            $file = File::where('id', $file_id)->first();
            $file->delete();

            // redirect with success message
            return redirect()->back()->withSuccess(Lang::get('files/message.success.delete'));

        } catch (\Exception $e){
            return redirect()->back()->withError(Lang::get('files/message.error.delete'));
        }
    }
}
