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

    /**
     * Generate a slug from the given source string.
     *
     * @param string $source
     * @return string
     * @throws \UnexpectedValueException
     */
    protected function generateSlug($source)
    {
        $config = $this->getSluggableConfig();
        $separator = $config['separator'];
        $method = $config['method'];
        $max_length = $config['max_length'];

        // added to handle file extensions
        $extension = pathinfo($source, PATHINFO_EXTENSION);
        $filename = pathinfo($source, PATHINFO_FILENAME);

        if (empty($source)) {
            $slug = null;
        } elseif ($method === null) {
            $slugEngine = $this->getSlugEngine();

            if(is_null($extension) || strlen($extension) == 0) {
                $slug = $slugEngine->slugify($source, $separator);
            }
            else {
                $slug = $slugEngine->slugify($filename, $separator);
                $slug = $slug . "." . $extension;
            }

        } elseif (is_callable($method)) {
            $slug = call_user_func($method, $source, $separator);
        } else {
            throw new \UnexpectedValueException('Sluggable method is not callable or null.');
        }

        if (is_string($slug) && $max_length) {
            $slug = substr($slug, 0, $max_length);
        }

        return $slug;
    }

    /**
     * Checks if the slug should be unique, and makes it so if needed.
     *
     * @param string $slug
     * @return string
     */
    protected function makeSlugUnique($slug)
    {
        $config = $this->getSluggableConfig();
        if (!$config['unique']) {
            return $slug;
        }

        $separator = $config['separator'];

        // find all models where the slug is like the current one
        $list = $this->getExistingSlugs($slug);



        // see if there is a file extension, if so, create slug on file name only
        $extension = pathinfo($slug, PATHINFO_EXTENSION);
        $filename = pathinfo($slug, PATHINFO_FILENAME);


        // if ...
        // 	a) the list is empty
        // 	b) our slug isn't in the list
        // 	c) our slug is in the list and it's for our model
        //  d) our slug doesn't contain a filename ...
        //  e) ... or extension -dj
        // ... we are okay
        if (
            count($list) === 0 ||
            !in_array($slug, $list) ||
            (array_key_exists($this->getKey(), $list) && $list[$this->getKey()] === $slug) ||
            is_null($extension) ||
            strlen($extension) == 0
        )
        {
            return $slug;
        }

        // if there's no extension just treat it normally
        if(is_null($extension) || strlen($extension) == 0) {
            $suffix = $this->generateSuffix($slug, $list);
            return $slug . $separator . $suffix;
        }
        else {
            // find all models where the slug is like the current one
            $file_list = $this->getExistingSlugs($filename);

            $filenames = [];
            foreach( $file_list as $fname ) {
                // uses FileUploader trait's method
                array_push($filenames, pathinfo($fname, PATHINFO_FILENAME));
            }

            $suffix = $this->generateSuffix($filename, $filenames);
            return $filename. $separator . $suffix . "." . $extension;

        }


    }
}
