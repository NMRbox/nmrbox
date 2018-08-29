<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoftwareStype extends NmrModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'software_stype';

    protected $fillable = [
        'software_id',
        'stype_id'
    ];

    /* Keywords pivot relation */
    /*public function keywords() {
        return $this->belongsToMany('App\Keyword', 'keyword_category_menu', 'keyword_category_id', 'menu_id');
    }*/

    /* Files pivot relation */
    /*public function files() {
        return $this->belongsToMany('App\File', 'file_keyword_category', 'keyword_category_id', 'file_id');
    }*/
}
