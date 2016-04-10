<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class SoftwarePeopleRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Sentinel::inRole('admin')) {
            return true;
        }
        else {
            return false;
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        // not sure any rules are really necessary for the developer section
//        return [
//            'existing_person' => 'unique:person_software,person_id,NULL,software_id'
//        ];


//        $software = $this->route('software');
//
//        if( $software == null ) {
//            // then we are creating a new resource
//            return [
//                'name' => 'required|min:3|regex:/[A-Z]+/|unique:software,name',
//                'short_title' => 'required|min:3|unique:software,short_title',
//                'long_title' => 'required|min:3',
//            ];
//        }
//        else {
//            // we are editing an old one, so skip unique checks on this record only
//            return [
//                'name' => 'required|min:3|regex:/[A-Z]+/|unique:software,name,' . $software->id,
//                'short_title' => 'required|min:3|unique:software,short_title,' . $software->id,
//                'long_title' => 'required|min:3',
//            ];
//        }
    }

}
