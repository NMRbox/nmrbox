<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

Use App\Software;
use App\Category;
Use App\Keyword;
Use App\VM;
Use App\SoftwareVersion;
Use App\Author;
Use App\Citation;
use Symfony\Component\Debug\Exception\UndefinedFunctionException;
Use View;

class RegistryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        /*$all_software = Software::All()->sortBy('short_title', SORT_NATURAL|SORT_FLAG_CASE);
        return View::make("registry.index", compact('all_software'));*/

        /* test for Angular response */
        $all_software = Software::orderBy('short_title', 'ASC')
            ->select('id', 'name', 'short_title', 'long_title', 'synopsis', 'description', 'slug')
            ->where('display', '=', 'true')
            ->get();
            //->sortBy('short_title', SORT_NATURAL|SORT_FLAG_CASE);

        //dd($all_software);
        return response( json_encode( array( 'data' => $all_software ) ), 200 )
            ->header( 'Content-Type', 'application/json' );

    }

    /**
     * Display the index of a particular software package.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSoftware($param) {

        $software = Software::select('id', 'name', 'short_title', 'long_title', 'synopsis', 'description', 'slug', 'url')
        //$software = Software::where('slug', $param)
            ->where('slug', $param)
            ->where('display', 'true')
            ->first();

        $all_files = $software->files()->get();
        $attached_citations = $software->citations;

        foreach($attached_citations as $citation) {
            $citation->authors = $citation->authors()->get();
        }
        
        $vm_version_pairs = $software->vmVersionPairs();

        $all_keywords = $software->keywords()->get();

        /*return View::make("registry.software", compact('software', 'all_files', 'vm_version_pairs', 'attached_citations',
            'all_keywords'));*/
        return response( json_encode( array('data' => $software, ) ), 200 )->header( 'Content-Type', 'application/json' );

    }

    /**
     * Display the index of a particular software package.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSoftwareMetaData($param) {

        $software = Software::select('id', 'name', 'short_title', 'long_title', 'synopsis', 'description', 'slug', 'url')
            ->where('slug', $param)
            ->where('display', 'true')
            ->first();


        $all_files = $software->files()->get();
        $attached_citations = $software->citations;

        foreach($attached_citations as $citation) {
            $citation->authors = $citation->authors()->get();
        }


        $vm_version_pairs = $software->vmVersionPairs();

        foreach ($vm_version_pairs as $key => $vm){

            $vm_version_pairs['nmrbox_version'][] = $key;
            $vm_version_pairs['software_version'][] = $vm;
        }

        foreach ($attached_citations as $key => $vm){

            $vm_version_pairs['citation'][] = $vm;

        }

        $all_keywords = $software->keywords()->get();

      return response( json_encode( array( 'data' => $vm_version_pairs ) ), 200 )
            ->header( 'Content-Type', 'application/json' );

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filterSoftwares($param)
    {
        /*$all_software = Software::All()->sortBy('short_title', SORT_NATURAL|SORT_FLAG_CASE);
        return View::make("registry.index", compact('all_software'));*/

        /* test for Angular response */
        if ($param != null) {
            $all_software = Software::orderBy('short_title', 'ASC')
                ->select('id', 'name', 'short_title', 'synopsis', 'description', 'slug')
                ->where('short_title', 'ILIKE', '%' . $param . '%')
                ->where('display', '=', 'true')
                ->get();
        } else {
            $all_software = Software::orderBy('short_title', 'ASC')
                ->select('id', 'name', 'short_title', 'synopsis', 'description', 'slug')
                ->where('short_title', 'ILIKE', '%' . $param . '%')
                ->where('display', '=', 'true')
                ->get();
        }

        //dd($all_software);
        return response( json_encode( array( 'data' => $all_software ) ), 200 )
            ->header( 'Content-Type', 'application/json' );

    }


    /**
     * Display the search result of a particular software package.
     *
     * @return \Illuminate\Http\Response
     */
    public function postRegistrySearch(Request $request) {
        if(!$request->ajax()) {
            return App::abort(403);
        }

        /* Menu listings */
        $fields = $request->input('field');

        /* Request input var */
        $fields_value = $request->input('fields_value');
        $category = $request->input('menus');
        $vm_ver = $request->input('vm_version');
        $author_name = $request->input('author_name');

        /* Instantiating new software object */
        $software = new Software();

        /* Pulling out the data based on fields */
        foreach($fields as $key => $field) {
            /* Software name - field search*/
            if($field == 'name') {

                foreach ($fields_value as $key => $value){
                    $software =$software->where(function($qry) use ($value){
                        foreach($value as $key => $val){
                            $qry->where('short_title', 'ILIKE', '%'.$val.'%');
                            $qry->where('display', '=', 'TRUE');
                        }
                    });
                }

            }

            /* Category search */
            if($field == 'software_category') {
                // menu_category relation
                if($category != null){
                    $cat = new Category();
                    $cat = $cat->keywords();
                    foreach ($category as $key => $val){
                        $cat = $cat->orWherePivot('keyword_category_id', '=', $val);
                    }
                    $cat = $cat->get();

                    if(count($cat) > 0){
                        $menus = new Keyword();
                        $menus = $menus->software();
                        foreach ($cat as $key => $val){
                            $menus = $menus->orWherePivot('menu_id', '=', $val->id);
                        }
                        $menus = $menus->get();
                        // fetching menu_ids
                        foreach ($menus as $data){
                            $menu_id[] = $data->id;
                        }
                    } else {
                        $menu_id[]=array();
                    }

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
        $all_software = $software->where('display', '=', 'TRUE')
                                 ->orderBy('short_title', 'ASC')
                                 ->get();

        $soft_array=array();
        foreach ($all_software as $software){
            $soft_array[] = array('id' => $software->id, 'name' => $software->short_title, 'synopsis' => $software->synopsis, 'slug' => $software->slug);
        }


        return response( json_encode( array( 'message' => $soft_array ) ), 200 )
            ->header( 'Content-Type', 'application/json' );
    }
}

