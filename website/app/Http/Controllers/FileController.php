<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
Use App\User;
Use App\File;
Use App\FileMetadata;
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
        //ini_set('memory_limit','256M');
        $all_files = File::select('id', 'name','label', 'slug', 'mime_type', 'size')->get()->sortBy('name');

        // all keywords
        $all_keywords = Category::All();

        // all metadata
        $all_metadata = FileMetadata::All();

        return View::make("admin.files.index", compact('all_files', 'all_keywords', 'all_metadata'));
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
            $file = File::where('slug', 'like', $file_name)->first();

            $headers = array('Content-type' => $file->mime_type, 'Content-length' => $file->size);

            $data = $file->bdata;
            $unescape = $file->binary_unsql($data);
            $un64 = base64_decode($unescape);


            return response($un64, 200, $headers);
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
        $filename = $request->input('label');
        foreach( $all_files as $name => $f ) {
            $newfile = $this->makeFileFromUploadedFile($f, $filename);
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
        $file = File::select('id', 'name','label', 'slug', 'mime_type', 'size')->where('id', '=', $id)->get()->first();

        // Keywords Mapping
        $all_keywords = Category::All();
        $file_keywords = $file->keyword_categories()->get();
        $keyword_map = collect([ ]);

        $keyed = $file_keywords->keyBy("name");

        foreach( $all_keywords as $keyword ) {
            if($keyed->has($keyword->name)) {
                $keyword_map->push($keyword->name);
                $keyword->present = true;
            }
            else {
//              $keyword_map->push($keyword->label, false);
            }
        }

        /* All File metadata */
        $all_metadata = FileMetadata::All();
        $file_metadata = $file->metadatas()->get();
        $metadata_map = collect([ ]);

        $metad = $file_metadata->keyBy("metadata");

        foreach( $all_metadata as $metadata ) {
            if($metad->has($metadata->metadata)) {
                $metadata_map->push($metadata->metadata);
                $metadata->present = true;
            }
            else {
//              $keyword_map->push($keyword->label, false);
            }
        }

        // view
        return view('admin.files.edit',compact('file','all_keywords', 'file_keywords', 'keyword_map', 'all_metadata', 'file_metadata', 'metadata_map' ));
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

        // all the files that are included to upload
        $all_files = Input::file();

        /* parsing the inputs from form submission */
        parse_str(urldecode($request->input('data')), $file_keyword_metadata);

        $file_label = $file_keyword_metadata['label'];

        // uploading all the files using file handler
        if($all_files){
            foreach( $all_files as $name => $f ) {
                $updatefile = $this->replaceFileFromUploadedFile($f, $id, $file_label);
            }
        }

        /* keyword mapping */
        foreach($file_keyword_metadata['keyword'] as $keyword_id => $checked_status) {
            $keywd = Category::where("id", "=", $keyword_id)->get()->first();
            if($checked_status == "on") {

                try {
                    $file->keyword_categories()->attach($keywd->id);
                }
                catch(\Illuminate\Database\QueryException $e) {
                    // silently ignore trying to ignore a dupe because it doesn't matter and that's what good software engineers do right?
                    //dd($e);
                }
            }
            else {
                $file->keyword_categories()->detach($keywd->id);
            }
        }

        /* metadata mapping */
        foreach($file_keyword_metadata['metadata'] as $metadata_id => $checked_status) {
            $metad = FileMetadata::where("id", "=", $metadata_id)->get()->first();
            if($checked_status == "on") {

                try {
                    $file->metadatas()->attach($metad->id);
                }
                catch(\Illuminate\Database\QueryException $e) {
                    // silently ignore trying to ignore a dupe because it doesn't matter and that's what good software engineers do right?
                    //dd($e);
                }
            }
            else {
                $file->metadatas()->detach($metad->id);
            }
        }


        // returning back to the page
        //return redirect()->back()->withSuccess(Lang::get('files/message.success.update'));
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
        $file = File::where('id', $file_id)->first();
        $file->delete();
        return back()->withInput();
    }
}
