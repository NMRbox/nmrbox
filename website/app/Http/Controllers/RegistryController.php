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
    public function getSoftware($param) {

        $software = Software::where('slug', $param)->first();

        $all_files = $software->files()->get();
        $attached_citations = $software->citations;

        foreach($attached_citations as $citation) {
            $citation->authors = $citation->authors()->get();
        }
        
        $vm_version_pairs = $software->vmVersionPairs();

        $all_keywords = $software->keywords()->get();

        return View::make("registry.software", compact('software', 'all_files', 'vm_version_pairs', 'attached_citations',
            'all_keywords'));
    }
}