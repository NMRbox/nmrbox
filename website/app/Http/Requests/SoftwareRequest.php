<?php

namespace App\Http\Requests;

use Session;
use App\Software;
use App\Http\Requests\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class SoftwareRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Session::has('user_is_admin')){
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
        $software_id = $this->route('software');
        $software = Software::where('id', $software_id)->get()->first();

        if( $software == null ) {
            // then we are creating a new resource
            return [
                'name' => 'required|min:3|regex:/[A-Z]+/|unique:software,name',
                'short_title' => 'required|min:3|unique:software,short_title',
                'long_title' => 'required|min:3',
            ];
        }
        else {
            // we are editing an old one, so skip unique checks on this record only
            return [
                'name' => 'required|min:3|regex:/[A-Z]+/|unique:software,name,' . $software->id,
                'short_title' => 'required|min:3|unique:software,short_title,' . $software->id,
                'long_title' => 'required|min:3',
            ];
        }
    }

}
