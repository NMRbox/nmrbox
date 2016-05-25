<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

Use App\Software;
Use App\VM;
Use View;

class RegistryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $all_software = Software::All()->sortBy('name');
        return View::make("registry.index", compact('all_software'));
    }

    /**
     * Display the index of a particular software package.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSoftware(Software $software) {
        $all_files = $software->files()->get();
        $attached_citations = $software->citations;

        foreach($attached_citations as $citation) {
            $citation->authors = $citation->authors()->get();
        }

        $vm_versions = VM::all();

        return View::make("registry.software", compact('software', 'all_files', 'vm_versions', 'attached_citations'));
    }
}