<?php

namespace App\Console;

use App\Software;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {

            $all_software = Software::all();

            foreach( $all_software as $name => $software ) {
                if($software->_needsSlugging()) {
                    $new_slug = $software->_generateSlug();
                    $software->slug = $new_slug;
                    $software->save();
                }
            }

        })->everyMinute()
        ->sendOutputTo("/home/vagrant/nmr/cron.log");
    }
}
