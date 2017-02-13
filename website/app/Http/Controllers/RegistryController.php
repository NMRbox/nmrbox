<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

Use App\Software;
Use App\Keyword;
Use App\VM;
Use App\SoftwareVersion;
Use App\Author;
Use App\Citation;
use Symfony\Component\Debug\Exception\UndefinedFunctionException;Use View;

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


    /**
     * Display the search result of a particular software package.
     *
     * @return \Illuminate\Http\Response
     */
    public function postRegistrySearch(Request $request) {

        /* Menu listings */
        $fields = $request->input('field');


        /* Request input var */
        $fields_value = $request->input('fields_value');
        $category = $request->input('menus');
        $vm_ver = $request->input('vm_version');
        $author_name = $request->input('author_name');

        /* Instantiating new software object */
        $software = new Software;

        /* Pulling out the data based on fields */
        foreach($fields as $key => $field) {
            /* Software name - field search*/
            if($field == 'name') {

                $software =$software->where(function($qry) use ($fields_value){
                    foreach($fields_value as $key => $val){
                        $qry->where($key, 'ILIKE', '%'.$val.'%');
                    }
                });
            }

            /* Category search */
            if($field == 'software_category') {
                // menu_category relation
                if($category != null){
                    $menus = new Keyword();
                    $menus = $menus->software();
                    foreach ($category as $key => $val){
                        $menus = $menus->orWherePivot('menu_id', '=', $val);
                    }
                    $menus = $menus->get();
                }

                // fetching menu_ids
                foreach ($menus as $data){
                    $menu_id[] = $data->id;
                }

                // fetching software details
                $software = $software->whereIn('id', $menu_id);
            }

            /* VM Version search */
            if($field == 'vm_version') {

                // VM_softwareVersion relation
                if($vm_ver != null){
                    $vms = new VM();
                    $vms = $vms->softwareVersions();

                    foreach ($vm_ver as $key => $val){
                        $vms = $vms->orWherePivot('vm_id', '=', $val);
                    }
                    $vms = $vms->get();
                }

                // software_softwareVersion relation
                if($vms != null){
                    $soft_ver = new SoftwareVersion();
                    $soft_ver = $soft_ver->software();
                    foreach ($vms as $key => $val){
                        $soft_ver = $soft_ver->orWherePivot('id', '=', $val->id);
                    }
                    $soft_ver = $soft_ver->get();
                }

                // fetching software details
                foreach ($soft_ver as $data){
                    $soft_ver_id[] = $data->id;
                }

                $software = $software->whereIn('id', $soft_ver_id);
            }

            /* Author search */
            if($field == 'author_name') {

                // finding author ID based one name search
                if($author_name != null){

                    $author = new Author();
                    $author =$author->where(function($qry) use ($author_name){
                        foreach($author_name as $key => $val){
                            if(strrpos($val, " ") != null){
                                $split_name = explode(" ", $val);
                                $first_name = $split_name[0];
                                $last_name = $split_name[1];

                                $qry->where('first_name', 'ILIKE', '%'.$first_name.'%');
                                $qry->orWhere('last_name', 'ILIKE', '%'.($last_name != null)?$last_name:$first_name.'%');
                            } else {
                                $qry->where('first_name', 'ILIKE', '%'.$val.'%');
                                $qry->orWhere('last_name', 'ILIKE', '%'.$val.'%');
                            }
                        }
                    });
                    $author = $author->get();
                }

                // author_citation relation
                if($author != null){
                    $author_citation = new Author();
                    $author_citation = $author_citation->citations();
                    foreach ($author as $key => $val){
                        $author_citation = $author_citation->orWherePivot('author_id', '=', $val->id);
                    }
                    $author_citation = $author_citation->get();
                }

                // citation_software relation
                if($author_citation != null){
                    $software_citation = new Citation();
                    $software_citation = $software_citation->software();
                    foreach ($author_citation as $key => $val){
                        $software_citation = $software_citation->orWherePivot('citation_id', '=', $val->id);
                    }
                    $software_citation = $software_citation->get();
                }

                // fetching software details
                foreach ($software_citation as $data){
                    $soft_ver_id[] = $data->id;
                }

                $software = $software->whereIn('id', $soft_ver_id);
            }
        }
        $all_software = $software->get();
        //dd($all_software);

        return View::make("registry.index", compact('all_software'));
    }
}

