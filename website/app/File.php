<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class File extends NmrModel implements SluggableInterface
{
    use SluggableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'files';

    protected $fillable = [
        'label'
    ];

    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];

    public function software() {
        return $this->belongsTo('App\Software');
    }

    // binary functions from an angry shark named Jawsh here:
    //  https://github.com/laravel/framework/issues/10847

    public function is_binary($input)
    {
        if (is_null($input))
        {
            return false;
        }

        if (is_integer($input))
        {
            return false;
        }

        return !ctype_print($input);
    }

    public static function binary_sql($bin)
    {
        if (DB::connection() instanceof \Illuminate\Database\PostgresConnection)
        {
            return pg_escape_bytea($bin);
        }

        return $bin;
    }

    public static function binary_unsql($bin)
    {
        if (is_resource($bin))
        {
            $bin = stream_get_contents($bin);
        }

        if (DB::connection() instanceof \Illuminate\Database\PostgresConnection)
        {
            return pg_unescape_bytea($bin);
        }

        return $bin;
    }

    public function unescapeBinary($bin)
    {
        if (is_resource($bin))
        {
            $bin = stream_get_contents($bin);
        }

        if (DB::connection() instanceof \Illuminate\Database\PostgresConnection)
        {
            $bin = pg_unescape_bytea($bin);
        }

        return $bin;
    }
}
