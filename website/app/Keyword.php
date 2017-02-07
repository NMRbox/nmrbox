<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyword extends NmrModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menus';

    protected $fillable = [
        'label'
    ];

    public function software() {
        return $this->belongsToMany('App\Software', 'menu_software', 'menu_id', 'software_id');
    }

    public function categories() {
        return $this->belongsToMany('App\Category', 'keyword_category_menu', 'menu_id', 'keyword_category_id');
    }
}
