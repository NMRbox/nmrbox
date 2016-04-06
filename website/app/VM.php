<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VM extends NmrModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vms';

    protected $fillable = [
        'id',
        'major',
        'minor',
        'variant'
    ];

    public function name() {
        return $this->major . "." . $this->minor . "." . $this->variant;
    }

    public function softwareVersions()
    {
        return $this->belongsToMany('App\SoftwareVersion', 'software_version_vm', 'vm_id', 'software_version_id');
    }
}
