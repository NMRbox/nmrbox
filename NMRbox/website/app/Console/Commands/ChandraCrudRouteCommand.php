<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use File;

class ChandraCrudRouteCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'crud:route';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Append crud name to routes.php file';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $crudName = strtolower($this->argument('name'));
        $crudNamePlural = str_plural($crudName);
        $crudNamePluralCap = ucwords($crudNamePlural);
        $crudController = $crudNamePluralCap."Controller";
        $path = $this->laravel['path'].'/Http/custom_routes.php';

        $content  = "\nRoute::group(array('prefix' => 'admin'), function () {\n";
        $content .= "\tRoute::resource('$crudNamePlural', '$crudController');\n";
        $content .= "\tRoute::get('$crudNamePlural/{id}/delete', array('as' => 'admin.$crudNamePlural.delete', 'uses' => '$crudController@getDelete'));\n";
        $content .= "\tRoute::get('$crudNamePlural/{id}/confirm-delete', array('as' => 'admin.$crudNamePlural.confirm-delete', 'uses' => '$crudController@getModalDelete'));\n";
        $content .= "});";

        $bytesWritten = File::append($path, $content);
        if ($bytesWritten === false)
        {
            die("Couldn't write to the file.");
        }

        $this->info('custom_routes.php modified successfully.');

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Name of the Crud.'],
        ];
    }

    /*
     * Get the console command options.
     *
     * @return array
     */

    protected function getOptions()
    {
        return [
            ['fields', null, InputOption::VALUE_OPTIONAL, 'The fields of the form.', null],
        ];
    }

}
