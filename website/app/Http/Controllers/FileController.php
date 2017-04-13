<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
Use App\User;
Use App\File;
use App\Keyword;
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
        $all_files = File::All()->sortBy('name');
        return View::make("admin.files.index", compact('all_files'));
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

        foreach( $all_files as $name => $f ) {
            $newfile = $this->makeFileFromUploadedFile($f, $name);
        }

        if($newfile == true){
            return response( json_encode( array( 'message' => 'Successfully uploaded. ' ) ), 200 )
                ->header( 'Content-Type', 'application/json' );
        }

        return response( json_encode( array( 'message' => 'Files upload unsuccessful.' ) ), 200 )
            ->header( 'Content-Type', 'application/json' );

        /*echo "<pre>";
        print_r($all_files['file_data']);
        echo "</pre>";*/

        /*try{
            // redirect back to the index page when done
            //return redirect()->withSuccess(Lang::get('files/message.success.create'));
        } catch (QueryException $e){
            // something went wrong
            return redirect()->withErrors(Lang::get('files/message.error.create'));
        }*/

        /*return redirect()->withErrors(Lang::get('files/message.error.create'));*/

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
    public function edit($param)
    {
        // All keywords
        $all_keywords = Keyword::All();

        // retrieving file data
        $file = File::where('slug', 'like', $param)->first();

        // view
        return view('admin.files.edit',compact('file','all_keywords'));
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
        echo "<pre>";
        print_r($request->input());
        echo "</pre>";
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
