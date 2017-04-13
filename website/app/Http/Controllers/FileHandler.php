<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\File;
use Input;
use Sentinel;
use Lang;
use Illuminate\Http\Request;
Use App\Software;

trait FileHandler {

    /**
     * Create a File from Symfony's UploadedFile
     *
     * @param  UploadedFile $f, string $name
     * @return \App\File
     */
    public function makeFileFromUploadedFile(UploadedFile $f, $label) {
        $newfile = new File();

        // parse out file name less .extension
        $name = $f->getClientOriginalName();

        $newfile->name = $name;
        $newfile->bdata = File::binary_sql(base64_encode(file_get_contents($f->getRealPath())));
        $newfile->label = $name;
        $newfile->mime_type = $f->getMimeType();
        $newfile->size = $f->getSize();
        $newfile->user_id = Sentinel::getUser()->id;
        $newfile->role_id = Sentinel::findRoleBySlug('admin')->id; // change to some value from input
        $newfile->save();

        return $newfile;
    }


    /**
     * Create a File from Symfony's UploadedFile
     *
     * @param  UploadedFile $f, string $name
     * @return String url
     */
    public function uploadAndGetURL() {
        if (Input::hasFile('image')) {
            $f = Input::file('image');
            $newfile = new File();
            $newfile->name = $f->getClientOriginalName();

            // save file metadata
            $newfile->bdata = File::binary_sql(base64_encode(file_get_contents($f->getRealPath())));
            $newfile->label = $newfile->name;
            $newfile->mime_type = $f->getMimeType();
            $newfile->size = $f->getSize();
            $newfile->user_id = Sentinel::getUser()->id;
            $newfile->role_id = Sentinel::findRoleBySlug('admin')->id; // change to some value from input
            $newfile->save();

            return route('file.get', [$newfile->slug]);
        }
        else {
            return 'error';
        }

    }

    public function storeFiles(Request $request, $software_slug) {
        $software = Software::where('slug', $software_slug)->get()->first();
        $all_files = Input::file();

        foreach( $all_files as $label => $f ) {
            // uses FileUploader trait's method
            $newfile = $this->makeFileFromUploadedFile($f, $label);
            $software->files()->save($newfile);
        }

        // redirect back to editing the same page when done
        //return back()->withInput();
        return redirect()->back()->withSuccess(Lang::get('softwares/message.success.update_files'));
    }

    /**
     * Delete a specified file
     *
     * @param  Software $software, File $file
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteFile($software_slug, $file_slug)
    {
        $file = File::where('slug', $file_slug)->get()->first();
        $file->delete();
        return redirect()->back()->withSuccess(Lang::get('softwares/message.success.delete_files'));
    }

    /**
     * Force browser to download a specified file
     *
     * @param  Software $software, File $file
     * @return \Illuminate\Http\RedirectResponse
     */
    public function downloadFile($file_slug) {
        $file = File::where('slug', $file_slug)->get()->first();
        // To be consistent, for the time being we'll use the slug as the download name
        $headers = array('Content-type' => $file->mime_type, // 'application/octet-stream' if need to force for older browsers
            'Content-length' => $file->size,
            'Content-Disposition'=>'attachment;filename="' . $file->slug,
        );
        $data = $file->bdata;
        $unescape = $file->binary_unsql($data);
        $un64 = base64_decode($unescape);
        return response($un64, 200, $headers);
    }
}