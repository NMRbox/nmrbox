<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentTaggable\Contracts\Taggable;
use Cviebrock\EloquentTaggable\Traits\Taggable as TaggableImpl;

class Blog extends model implements SluggableInterface, Taggable {

    use SoftDeletes;
    use SluggableTrait;
    use TaggableImpl;

    protected $dates = ['deleted_at'];

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    protected $table = 'blogs';

    protected $guarded  = array('id');

    protected $casts = [ 'featured' => 'boolean'];

    public function comments()
    {
        return $this->hasMany('App\BlogComment');
    }
    public function category()
    {
        return $this->belongsTo('App\BlogCategory');
    }
    public function author()
    {
        return $this->belongsTo('App\Person', 'user_id');
    }
    public function getBlogcategoryAttribute()
    {
        return $this->category->lists('id');
    }
}