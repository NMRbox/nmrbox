<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use View;
use Input;
use Redirect;
use URL;
use Sentinel;
use Debugbar;
use App\Http\Requests;
use App\Http\Controllers\Controller;
Use App\Software;
Use App\User;
Use App\File;
Use App\VM;
Use App\SoftwareVersion;
use App\Person;
use App\Http\Requests\SoftwareRequest;
use App\Http\Requests\SoftwarePeopleRequest;
use App\Http\Requests\SoftwareVersionRequest;
use App\Http\Requests\SoftwareVersionPairRequest;
use App\Http\Requests\SoftwareLegalRequest;

class SoftwareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_software = Software::All();
        return View::make('admin.software.index', compact('all_software'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $blogcategory = "";
        return view('admin.software.create',compact('blogcategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SoftwareRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SoftwareRequest $request)
    {
        $software = new Software($request->except('image','tags','featured'));
        $software->save();
        return redirect()->route("software.edit", array("software"=>$software->id));
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
     * Show the requested file
     *
     * @param  Software $software
     * @param  File $file
     * @return \Illuminate\Http\Response
     */
    public function getFile(Software $software, File $file)
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
     * Delete a specified file
     *
     * @param  Software $software, File $file
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteFile(Software $software, File $file)
    {
        $file->delete();
        return back()->withInput();
    }

    public function storeFiles(Request $request, Software $software) {
        $all_files = Input::file();

        foreach( $all_files as $name => $f ) {
            $newfile = $this->makeFileFromUploadedFile($f, $name);
            $software->files()->save($newfile);
        }

        // redirect back to editing the same page when done
        return back()->withInput();
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
     * Show the form for editing the specified resource.
     *
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function edit(Software $software)
    {
        $files = $software->files()->get();

        // return lab_roles
        // return people already attached to the software
        $people = $software->people()->get();

        // sort all people for html select element
        $all_people = Person::all();
        $all_people = $all_people->sortBy("name");
        $people_for_select = [];
        foreach( $all_people as $person ) {
            $people_for_select[$person->id] = $person->name; // pair VM ID with human friendly VM name
        }

        $vm_versions = VM::all();
        $vm_versions = $vm_versions->sortBy("name"); // want these sorted for frontend
        $vm_versions_for_select = [];

        // The goal here is to pair each vm's id with its friendly name, so the name can be displayed in a select
        //  to choose the actual vm id.
        foreach( $vm_versions as $vm ) {
            $vm_versions_for_select[$vm->id] = $vm->name(); // pair VM ID with human friendly VM name
        }

        $software_versions = $software->versions()->get();
        $software_versions = $software_versions->sortBy("version"); // want these sorted for frontend
        $software_versions_for_select = [];

        // Same goal as above, just with software
        foreach( $software_versions as $s ) {
            $software_versions_for_select[$s->id] = $s->version; // pair software id with
        }

        return view('admin.software.edit',compact('software', 'files', 'vm_versions',
            'software_versions', "vm_versions_for_select", "software_versions_for_select", "people_for_select",
            'people'));
    }

    public function storeSoftwareVersion(SoftwareVersionRequest $request, Software $software)
    {
        $submitted_versions = $request->version;

        foreach( $submitted_versions as $version ) {
            if( $version != null ) {
                $v = new SoftwareVersion();
                $v->version = $version;
                $software->versions()->save($v);
            }
        }
        return back();
    }

    public function editSoftwareVersion(Software $software, SoftwareVersion $sv, string $text) {
        $sv->version = $text;
        $sv->update();
        return back();
    }

    public function destroySoftwareVersion(Software $software, SoftwareVersion $sv) {
        $sv->delete();
        return back();
    }

    public function storeSoftwareVersionPair(SoftwareVersionPairRequest $request,
                                             Software $software,
                                             SoftwareVersion $sv)
    {
        $submitted_versions = $request->version;

        $vm_version = $request->vm_version;
        $software_version = $request->software_version;

        $software_version_entry = $software->versions()->where("id", $software_version)->get()->first();

        if($software_version_entry == null) {
            dd("No existing software record found for that id. How did you enter it?");
        }

        try {
            $software_version_entry->VMVersions()->attach($vm_version);
        }
        catch(\Illuminate\Database\QueryException $e) {
//            dd($vm_version, $e);
            if( str_contains($e->getMessage(), "Unique violation") ) {
                // then this record already exists
                return back()->withErrors(array('Version Pairing' => "That pair of versions already exists.",
                    "vm_version"=>$vm_version,
                    "vm_name"=>VM::where("id", "=", $vm_version)->get()->first()->name,
                    "software_version"=>$software_version,
                    "software_name"=>SoftwareVersion::where("id", "=", $software_version)->get()->first()->version,
                    "message"=>$e->getMessage()));
            }
            else {
                return back()->withErrors(array('Version Pairing'=>"Unknown database error with that version pair. Please don your tin hat and hide under your desk until help arrives.",
                    "vm_version"=>$vm_version,
                    "software_version"=>$software_version,
                    "message"=>$e->getMessage()));
            }
        }

        return back()->withInput();
    }

    public function destroySoftwareVersionPair(Software $software, VM $vm, SoftwareVersion $sv) {
//        dd($software, $sv, $vm);
        $sv->VMVersions()->detach($vm->id);
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SoftwareRequest $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function update(SoftwareRequest $request, Software $software)
    {
        $software->update($request->all());
        return back();
    }

    /**
     * Add a new person and attach him or her to the software.
     *
     * @param  SoftwareDeveloperRequest  $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function addNewPerson(SoftwarePeopleRequest $request, Software $software)
    {
        $new_person = new Person( $request->all() );
        $new_person->save();

        try {
            $software->people()->attach($new_person->id);
        }
        catch(\Illuminate\Database\QueryException $e) {
            dd($e);
        }

        return back();
    }

    /**
     * Add a person to the specified resource in storage.
     *
     * @param  SoftwareDeveloperRequest  $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function addExistingPerson(SoftwarePeopleRequest $request, Software $software)
    {

        $existing_person_id = $request->existing_person;

        try {
            $software->people()->attach($existing_person_id);
        }
        catch(\Illuminate\Database\QueryException $e) {
            dd($e);
        }

        return back();
    }

    /**
     * Detach a person from the specified resource in storage.
     *
     * @param  SoftwareDeveloperRequest  $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function detachPerson(Software $software, Person $person)
    {
        try {
            $software->people()->detach($person->id);
        }
        catch(\Illuminate\Database\QueryException $e) {
            dd($e);
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SoftwareDeveloperRequest  $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function updatePeople(SoftwarePeopleRequest $request, Software $software)
    {
        dd($request->all());
        $existing_person_id = $request->existing_person;

        try {
            $software->people()->attach($existing_person_id);
        }
        catch(\Illuminate\Database\QueryException $e) {
            dd($e);
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SoftwareLegalRequest  $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function updateLegal(SoftwareLegalRequest $request, Software $software)
    {
        $software->update($request->all());
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
