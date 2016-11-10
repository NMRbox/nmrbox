<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentTaggable\Contracts\Taggable;
use Cviebrock\EloquentTaggable\Traits\Taggable as TaggableImpl;

class Page extends model implements SluggableInterface {

    use SoftDeletes;
    use SluggableTrait;

    protected $dates = ['deleted_at'];

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    protected $table = 'pages';

    protected $guarded  = array('id');

    protected $fillable = [
        'title',
        'subheader',
        'content',
        'slug'
    ];

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function _generateSlug($source) {
        return $this->generateSlug( $source );
    }

    public function _makeSlugUnique($source) {
        return $this->makeSlugUnique( $source );
    }
}