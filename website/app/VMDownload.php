<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VMDownload extends Model
{
    // defining table name
    protected $table = 'download';

    // overriding primary keys and turning off auto increment
    protected $primaryKey = 'person_id, vm_id';
    public $incrementing = false;

    // disableing default timestamp for not inserting created_at & updated_at
    public $timestamps = false;

    protected $fillable = [
        'person_id',
        'vm_id',
        'username',
        'password',
        'url',
        'request_ts',
        'available_ts',
        'notify_sent',
        'build_host',
        'build_pid'
    ];

    public function person() {
        return $this->belongsToMany('App\Person', 'classification_person', 'person_id', 'vm_id')
            ->withPivot('person_id', 'vm_id');
    }

    public function vm() {
        return $this->belongsToMany('App\VM', 'download', 'vm_id', 'person_id')
            ->withPivot('vm_id', 'person_id');
    }
}
