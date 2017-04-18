<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileMetadata extends Model
{
    // defining table name
    protected $table = 'file_metadata';

    // overriding primary keys and turning off auto increment
    protected $primaryKey = 'id';

    // disableing default timestamp for not inserting created_at & updated_at
    public $timestamps = false;

    protected $fillable = [
        'metadata',
    ];

    public function files() {
        return $this->belongsToMany('App\File', 'file_file_metadata', 'metadata_id', 'file_id');
    }
}
