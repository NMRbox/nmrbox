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
        'display',
        'description',
        'license_comment',
        'free_to_redistribute',
        'devel_contacted',
        'devel_include',
        'custom_license',
        'uchc_legal_approve',
        'devel_redistrib_doc',
        'devel_active',
        'slug'
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

    public function vmVersionPairs() {
        $versions = $this->versions()->get();
        $pairs = [ ];

        foreach($versions as $sv) {
            $vms = $sv->VMVersions()->get();

            foreach($vms as $vm) {
                $name = $vm->name();

                if(array_has($pairs, $name)) {
                    if( in_array($sv->version, $pairs[$name]) ) {
                        // don't add a dupe
                    }
                    else {
                        array_push($pairs[$name], $sv->version);
                    }
                }
                else {
                    // the array doesn't exist yet, create it and add the software version pair
                    $pairs[$name] = array( $sv->version);
                }
            }
        }

        return $pairs;
    }

    public function people() {
        return $this->belongsToMany('App\Person');
    }

    public function citations() {
        return $this->belongsToMany('App\Citation');
    }
    
    public function _needsSlugging() {
        return $this->needsSlugging();
    }

    public function _generateSlug() {
        $source = $this->getSlugSource();
        return $this->generateSlug( $this->$source );
    }

}
