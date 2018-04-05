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
use Validator;
use Lang;
use Debugbar;
use App\Http\Requests;
use App\Http\Controllers\Controller;
Use App\Software;
Use App\Keyword;
Use App\KeywordSoftware;
Use App\Category;
Use App\File;
Use App\VM;
Use App\SoftwareVersion;
use App\Person;
use App\Citation;
use App\Http\Requests\SoftwareRequest;
use App\Http\Requests\SoftwarePeopleRequest;
use App\Http\Requests\SoftwareVersionRequest;
use App\Http\Requests\SoftwareVersionPairRequest;
use App\Http\Requests\SoftwareLegalRequest;


class SoftwareController extends Controller
{
    use FileHandler;

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
        return redirect()->route("software.edit", array("software"=>$software->name));
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
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function edit($software_id)
    {
        //Get the software info from DB
        $software = Software::where('slug', $software_id)->first();

        // get the files details
        $files = $software->files()->get();

        // return lab_roles
        // return people already attached to the software
        $people = $software->people()->get();

        // sort all people for html select element
        $all_people = Person::all();
        $all_people = $all_people->sortBy("last_name");
        $people_for_select = [];
        foreach( $all_people as $person ) {
            $people_for_select[$person->id] = $person->last_name . ", " . $person->first_name; // pair VM ID with human friendly VM name
        }

        // VM versions
        $vm_versions = VM::all();
        $vm_versions = $vm_versions->sortBy("name"); // want these sorted for frontend
        $vm_versions_for_select = [];

        // The goal here is to pair each vm's id with its friendly name, so the name can be displayed in a select
        //  to choose the actual vm id.
        foreach( $vm_versions as $vm ) {
            $vm_versions_for_select[$vm->id] = $vm->name(); // pair VM ID with human friendly VM name
        }

        //Software versions
        $software_versions = $software->versions()->get();
        $software_versions = $software_versions->sortBy("version"); // want these sorted for frontend
        $software_versions_for_select = [];

        // Same goal as above, just with software
        foreach( $software_versions as $s ) {
            $software_versions_for_select[$s->id] = $s->version; // pair software id with
        }
        
        // add in citation resources, send to view make
        $all_citations = Citation::all();
        $attached_citations = $software->citations;

        // return keywords already attached to the software
        // NOTE: this is duplicating code from CategoryController, consider refactoring
        $keywords = $software->keywords()->get();

        // sort all keywords for html select element
        $all_keywords = Keyword::All();
        $software_keywords = $software->keywords()->get();
        $keyword_map = collect([ ]);

        // lebeling the keywords
        $keyed = $software_keywords->keyBy("label");
        foreach( $all_keywords as $keyword ) {
            if($keyed->has($keyword->label)) {
                $keyword_map->push($keyword->label);
                $keyword->present = true;
            }
        }

        /* Defining all the related pivot relation with category*/
        $keyword_categories = array();
        foreach ($software_keywords as $key => $keyword){
            $keyword_categories[$keyword->id] = $keyword->categories()->get();

        }

         /* Assigning all categories to related keywords*/
        $all_categories = array();
        foreach ($keyword_categories as $key => $value){
            foreach ($value as $data){
                $all_categories[$data->name] = $data->name;
            }

        }

        /*
         * TODO: Add files for files tab.
         * */
        $software_files = $software->files()->where('software_id', $software->id)->get();
        //dd($software_files);

        /*
         * TODO: Add images for images tab
         * */

        /*
         * FAQ
         * */
        $software_faqs = $software->faqs()->where('software_id', $software->id)->get();
        //dd($software_faqs);

        return view('admin.software.edit',compact('software', 'files', 'vm_versions',
            'software_versions', "vm_versions_for_select", "software_versions_for_select", "people_for_select",
            'people', 'all_citations', 'attached_citations', 'all_keywords', 'all_categories', 'keywords', 'software_faqs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SoftwareRequest $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function update(SoftwareRequest $request, $software_id)
    {
        $software = Software::where('id', $software_id)->get()->first();
        // strip_tags html tags
        $request['description'] = strip_tags($request['description'], '<p><a><br>');
        $software->update($request->all());
        return redirect()->back()->withSuccess(Lang::get('softwares/message.success.update'));
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
     * Attach a citation to this software.
     *
     * @param  Software  $software
     * @param  Citation  $citation
     * @return \Illuminate\Http\Response
     */
    public function attachCitation($software, $citation) {
        try {
            $software->citations()->attach($citation);
            return back();
        }
        catch(\Illuminate\Database\QueryException $e) {
            dd($e);
        }
    }

    /**
     * Detach a citation from this software.
     *
     * @param  Software  $software
     * @param  Citation  $citation
     * @return \Illuminate\Http\Response
     */
    public function detachCitation($software, $citation) {
        try {
            $software->citations()->detach($citation);
            return back();
        }
        catch(\Illuminate\Database\QueryException $e) {
            dd($e);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  SoftwareLegalRequest  $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function updateLegal(SoftwareLegalRequest $request, $software_id)
    {
        //Get the software info from DB
        $software = Software::where('id', '=', $software_id)->get()->first();

        $all = $request->all();

        $software->update($all);
        return redirect()->back()->withSuccess(Lang::get('softwares/message.success.update'));
    }

    /**
     * Add a new person and attach him or her to the software.
     *
     * @param  SoftwareDeveloperRequest  $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function addNewPerson(SoftwarePeopleRequest $request, $software_id)
    {
        $software = Software::where('id', '=', $software_id)->get()->first();

        $new_person = new Person( $request->all() );
        $new_person->save();

        try {
            $software->people()->attach($new_person->id);
        }
        catch(\Illuminate\Database\QueryException $e) {
//            dd($e);
            return back()->withErrors($e);
        }

        return redirect()->back()->withSuccess(Lang::get('softwares/message.success.update_people'));
    }

    /**
     * Add a person to the specified resource in storage.
     *
     * @param  SoftwareDeveloperRequest  $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function addExistingPerson(Request $request, $software_id)
    {
        $software = Software::where('slug', '=', $software_id)->get()->first();

        // TODO: validation doesn't actually work, but the DB won't add a dupe. Fix validation. -dj 4/9/16

        $existing_person_id = $request->existing_person;

        $rules = array(
            'existing_person' => 'unique:person_software,person_id,NULL,person_id, software_id,' . $software->id
        );

        $validator = Validator::make([$existing_person_id], $rules);

        if ($validator->fails()) {
            // Ooops.. something went wrong
//            return var_dump($validator);
            return back()->withErrors($validator);
        }

        try {
            $software->people()->attach($existing_person_id);
        }
        catch(\Illuminate\Database\QueryException $e) {
//            return var_dump($e);
            return back()->withErrors($e);
        }

        return redirect()->back()->withSuccess(Lang::get('softwares/message.success.update_people'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SoftwareDeveloperRequest  $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function updatePeople(SoftwarePeopleRequest $request, $slug)
    {
        //Get the software info from DB
        $software = Software::where('slug', '=', $slug)->get()->first();

        $existing_person_id = $request->existing_person;

        try {
            $software->people()->attach($existing_person_id);
        }
        catch(\Illuminate\Database\QueryException $e) {
        }

        return redirect()->back()->withSuccess(Lang::get('softwares/message.success.update_people'));
    }


    /**
     * Detach a person from the specified resource in storage.
     *
     * @param  SoftwareDeveloperRequest  $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function detachPerson($software_id, $person_id)
    {
        //Get the software info from DB
        $software = Software::where('id', '=', $software_id)->get()->first();

        try {
            $software->people()->detach($person_id);
        }
        catch(\Illuminate\Database\QueryException $e) {
        }

        return redirect()->back()->withSuccess(Lang::get('softwares/message.success.delete_people'));
    }


    /** DEPRECATED
     * Add a new keyword and attach him or her to the software.
     *
     * @param  Request  $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function addNewKeyword(Request $request, $software_id)
    {
        $software = Software::where('id', '=', $software_id)->get()->first();

        $new_keyword = new Keyword( $request->all() );
        $new_keyword->save();

        try {
            $software->keywords()->attach($new_keyword->id);
        }
        catch(\Illuminate\Database\QueryException $e) {
            return back()->withErrors($e);
        }

        return redirect()->back()->withSuccess(Lang::get('softwares/message.success.update_keywords'));
    }

    /** DEPRECATED
     * Add a keyword to the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function addExistingKeyword(Request $request, $software_id)
    {
        $software = Software::where('id', '=', $software_id)->get()->first();

        // TODO: validation doesn't actually work, but the DB won't add a dupe. Fix validation. Or maybe allow user to select only values not already attached to software? Both? -dj 5/5/16

        $existing_keyword_id = $request->existing_keyword;
//
//        $rules = array(
//            'existing_keyword' => 'unique:keyword_software,keyword_id,NULL,keyword_id, software_id,' . $software->id
//        );
//
//        $validator = Validator::make([$existing_keyword_id], $rules);
//
//        if ($validator->fails()) {
//            // Ooops.. something went wrong
////            return var_dump($validator);
//            return back()->withErrors($validator);
//        }

        try {
            $software->keywords()->attach($existing_keyword_id);
        }
        catch(\Illuminate\Database\QueryException $e) {
//            return var_dump($e);
            return back()->withErrors($e);
        }

        return redirect()->back()->withSuccess(Lang::get('softwares/message.success.update_keywords'));
    }

    /**
     * Add or remove keywords.
     *
     * @param  Request  $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function saveKeywords(Request $request, $param)
    {
        $software = Software::where('id', '=', $param)->get()->first();

        $keyword_checkboxes = $request->except(["name", "_token", "_method"]);

        foreach($keyword_checkboxes as $keyword => $checked_status) {

            $keywd = Keyword::where("id", "=", $keyword)->get()->first();

            if($checked_status == "on") {
                try {
                    $software->keywords()->attach($keywd->id);
                }
                catch(\Illuminate\Database\QueryException $e) {
                    // silently ignore trying to ignore a dupe because it doesn't matter and that's what good software engineers do right?
                }
            } else {
                $software->keywords()->detach($keywd->id);
            }
        }

        // redirect with success message
        return redirect()->back()->withSuccess(Lang::get('softwares/message.success.update_keyword'));
    }

    /**
     * Detach a keyword from the specified resource in storage.
     *
     * @param  SoftwareDeveloperRequest  $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function detachKeyword($software_id, Keyword $keyword)
    {
        //Get the software info from DB
        $software = Software::where('id', '=', $software_id)->get()->first();

        try {
            $software->keywords()->detach($keyword->id);
        }
        catch(\Illuminate\Database\QueryException $e) {
        }

        return back();
    }

    /**
     * Add a new person and attach him or her to the software.
     *
     * @param  SoftwareDeveloperRequest  $request
     * @param  Software $software
     * @return \Illuminate\Http\Response
     */
    public function attachFAQ(SoftwarePeopleRequest $request, $software_id)
    {
        $software = Software::where('id', '=', $software_id)->get()->first();

        $new_person = new Person( $request->all() );
        $new_person->save();

        try {
            $software->people()->attach($new_person->id);
        }
        catch(\Illuminate\Database\QueryException $e) {
//            dd($e);
            return back()->withErrors($e);
        }

        return redirect()->back()->withSuccess(Lang::get('softwares/message.success.update_people'));
    }


}
