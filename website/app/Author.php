<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends NmrModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'authors';

    protected $fillable = [
        'first_name',
        'last_name'
    ];

    public function citations() {
        return $this->belongsToMany('App\Citation', 'author_id', 'citation_id');
    }
}
