<?php namespace App\Http\Controllers;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Redirect;
use Sentinel;
use View;
use App\Page;

class ChandraController extends Controller {

	/**
     * Message bag.
     *
     * @var MessageBag
     */
    protected $messageBag = null;

    /**
     * Initializer.
     *
     * @return void
     */
    public function __construct()
    {
        // CSRF Protection
        $this->beforeFilter('csrf', array('on' => 'post'));

        //
        $this->messageBag = new MessageBag;
    }

    public function showHome()
    {
    	if(Sentinel::check())
			return View::make('admin/index');
		else
			return Redirect::to('admin/login')->with('error', 'You must be logged in!');
    }

    public function showView($name=null)
    {

    	if(View::exists('admin/'.$name))
		{
			if(Sentinel::check())
				return View::make('admin/'.$name);
			else
				return Redirect::to('admin/login')->with('error', 'You must be logged in!');
		}
		else
		{
			return View::make('admin/404');
		}
    }

    public function showFrontEndView($name=null)
    {
        if( Page::where('slug', '=', $name)->exists() ) {
            // $name is the page's slug
            $page = Page::where('slug', $name)->get()->first();
            return View::make('basic_page')->with('page', $page);
        }
        else
        {
            if(View::exists($name))
            {
                return View($name);
            }
            else {
                return View('404');
            }
        }
    }


}