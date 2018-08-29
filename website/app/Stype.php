<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stype extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stype';

    protected $fillable = [
        'id',
        'stype'
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
