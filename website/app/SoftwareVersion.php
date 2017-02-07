<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoftwareVersion extends NmrModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'software_versions';

    protected $fillable = [
        'id',
        'version'
    ];

    public function VMVersions() {
        return $this->belongsToMany('App\VM', 'software_version_vm', 'software_version_id', 'vm_id');
    }

    public function software() {
        return $this->belongsToMany('App\Software', 'software_versions', 'software_id');
    }
}
