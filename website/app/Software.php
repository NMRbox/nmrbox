<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Software extends NmrModel implements SluggableInterface
{
    use SluggableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'software';

    protected $fillable = [
        'name',
        'short_title',
        'long_title',
        'synopsis',
        'doc',
        'public_release',
        'description',
        'license_comment',
        'free_to_redistribute',
        'devel_contacted',
        'devel_include',
        'custom_license',
        'uchc_legal_approve',
        'devel_redistrib_doc',
        'devel_active'
    ];

    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];

    public function files() {
        return $this->hasMany('App\File');
    }

    public function versions() {
        return $this->hasMany('App\SoftwareVersion');
    }

    public function people() {
        return $this->belongsToMany('App\Person');
    }

}
