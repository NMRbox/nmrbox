<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends NmrModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'keyword_categories';

    protected $fillable = [
        'name'
    ];

    public function keywords() {
        return $this->belongsToMany('App\Keyword', 'keyword_category_menu', 'keyword_category_id', 'menu_id');
    }
}
