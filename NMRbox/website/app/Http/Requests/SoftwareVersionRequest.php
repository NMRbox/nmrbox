<?php

namespace App\Http\Requests;

use Session;
use App\Http\Requests\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class SoftwareVersionRequest extends Request {

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

        return [
            'version' => 'required'
        ];

    }

}
