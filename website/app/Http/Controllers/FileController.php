<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
Use App\User;
Use App\File;

class FileController extends Controller
{
    /**
     * Show the requested file
     *
     * @param  File $file
     * @return \Illuminate\Http\Response
     */
    public function getFile(File $file)
    {
        $headers = array('Content-type' => $file->mime_type, 'Content-length' => $file->size);

        $data = $file->bdata;
        $unescape = $file->binary_unsql($data);
        $un64 = base64_decode($unescape);

        return response($un64, 200, $headers);
    }

    /**
     * Force browser to download a specified file
     *
     * @param  Software $software, File $file
     * @return \Illuminate\Http\RedirectResponse
     */
    public function downloadFile(Software $software, File $file) {

        $headers = array('Content-type' => $file->mime_type, // 'application/octet-stream' if need to force for older browsers
            'Content-length' => $file->size,
            'Content-Disposition'=>'attachment;filename="' . $file->name . '"',
        );
        $data = $file->bdata;
        $unescape = $file->binary_unsql($data);
        $un64 = base64_decode($unescape);
        return response($un64, 200, $headers);
    }


    /**
     * Create a File from Symfony's UploadedFile
     *
     * @param  UploadedFile $f, string $name
     * @return \App\File
     */
    public function makeFileFromUploadedFile(UploadedFile $f, string $name) {
        $newfile = new File();
        $newfile->name = $f->getClientOriginalName();
        $newfile->bdata = File::binary_sql(base64_encode(file_get_contents($f->getRealPath())));
        $newfile->label = $name;
        $newfile->mime_type = $f->getMimeType();
        $newfile->size = $f->getSize();
        $newfile->user_id = Sentinel::getUser()->id;
        $newfile->role_id = Sentinel::findRoleBySlug('admin')->id; // change to some value from input
        return $newfile;
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