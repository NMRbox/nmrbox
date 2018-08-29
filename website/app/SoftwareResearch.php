<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoftwareResearch extends NmrModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'research_software';

    protected $fillable = [
        'software_id',
        'research_id'
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
