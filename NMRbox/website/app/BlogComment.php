<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogComment extends NmrModel {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'blog_comments';

    protected $guarded  = array('id');

    public function blog()
    {
        return $this->belongsTo('App\Blog');
    }

}