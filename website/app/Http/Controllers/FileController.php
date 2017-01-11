<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
Use App\User;
Use App\File;
use Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sentinel;
use View;

class FileController extends ChandraController
{
    // downloadFile, uploadAndGetURL, makeFileFromUploadedFile methods
    use FileHandler;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
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
        echo $file_name;
        $file = File::where('slug', 'like', $file_name)->find();
        echo "<pre>";
        print_r($file);
        echo "</pre>";
        exit;
        $headers = array('Content-type' => $file->mime_type, 'Content-length' => $file->size);

        $data = $file->bdata;
        $unescape = $file->binary_unsql($data);
        $un64 = base64_decode($unescape);


        return response($un64, 200, $headers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {

        $file->delete();
        return back()->withInput();
    }
}
