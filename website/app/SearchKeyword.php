<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchKeyword extends Model
{
    // defining table name
    protected $table = 'search_keywords';

    // overriding primary keys and turning off auto increment
    protected $primaryKey = 'id';

    // disableing default timestamp for not inserting created_at & updated_at
    public $timestamps = false;

    protected $fillable = [
        'metadata',
    ];

    public function files() {
        return $this->belongsToMany('App\File', 'file_search_keyword', 'metadata_id', 'file_id');
    }
}
