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
    public function makeFileFromUploadedFile(UploadedFile $f, $label, $url) {
        /* new file object */
        $newfile = new File();

        // parse out file name with and without extension
        $source = $f->getClientOriginalName();

        /* determining the filename, file_extension, label and slug */
        $file_name = pathinfo($source, PATHINFO_FILENAME);
        $file_ext = pathinfo($source, PATHINFO_EXTENSION);
        $file_label = ($label == NULL) ? $file_name : $label ;
        $file_slug = $url.'.'.$file_ext;
        $slug = ($url == NULL) ? $source : $file_slug ;

        /* Saving file object */
        //$newfile->name = $name;
        $newfile->label = $file_label;
        $newfile->slug = $slug;
        $newfile->bdata = File::binary_sql(base64_encode(file_get_contents($f->getRealPath())));
        $newfile->mime_type = $f->getMimeType();
        $newfile->size = $f->getSize();
        //$newfile->person_id = Sentinel::getUser()->id;
        $newfile->save();

        return $newfile;
    }

    /**
     * Replace a File from Symfony's UploadedFile
     *
     * @param  UploadedFile $f, string $name
     * @return \App\File
     */
    public function replaceFileFromUploadedFile(UploadedFile $f, $id, $label, $url) {
        $newfile = File::where('id', $id)->get()->first();

        // parse out file name with and without extension
        $source = $f->getClientOriginalName();

        /* determining the filename, file_extension, label and slug */
        $file_name = pathinfo($source, PATHINFO_FILENAME);
        $file_ext = pathinfo($source, PATHINFO_EXTENSION);
        $file_label = ($label == NULL) ? $file_name : $label ;
        $file_slug = $url.'.'.$file_ext;
        $slug = ($url == NULL) ? $source : $file_slug ;

        //$newfile->name = $name;
        $newfile->label = $file_label;
        $newfile->slug = $slug;
        $newfile->bdata = File::binary_sql(base64_encode(file_get_contents($f->getRealPath())));
        $newfile->mime_type = $f->getMimeType();
        $newfile->size = $f->getSize();
        //$newfile->person_id = Sentinel::getUser()->id;
        $newfile->update();

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
            $source = $f->getClientOriginalName();
            $newfile->slug = $source;
            $newfile->bdata = File::binary_sql(base64_encode(file_get_contents($f->getRealPath())));
            $newfile->label = $source;
            $newfile->mime_type = $f->getMimeType();
            $newfile->size = $f->getSize();
            //$newfile->person_id = Sentinel::getUser()->id;
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