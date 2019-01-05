<?php namespace App\Http\Controllers;

use App\Http\Requests\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Redirect;
use Sentinel;
use Session;
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
        return View::make('admin/index');
    }

    public function showView($name=null)
    {
        if(View::exists('admin/'.$name))
		{
			if(Sentinel::check())
				return View::make('admin/'.$name);
			else
				return Redirect::to('login')->with('error', 'You must be logged in!');
		}
		else
		{
			return View::make('admin/404');
		}
    }

    public function showFrontEndView($name=null)
    {
        // this is a special case for the home page. If more special cases arise, refactor into a more structured solution
        if($name == '') {
            $name = 'homepage';
            $page = Page::where('slug', $name)->get()->first();
            //return View::make('blank')->with('page', $page);
            return response()-> json( array(
                'message' => Lang::get('auth/message.not_autorized'),
                'type' => 'error' ),
                401 );
        }

        // prevent users from viewing homepage dynamic page outside of site root
        if($name == 'homepage') {
            return Redirect::to('/');
        }

        if( Page::where('slug', '=', $name)->exists() ) {
            // $name is the page's slug
            $page = Page::where('slug', $name)->get()->first();
            dd($page);
            //return View::make('basic_page')->with('page', $page);
            return response( json_encode( array( 'data' => $page ) ), 200 )
                ->header( 'Content-Type', 'application/json' );
        }
        else
        {
            return response()-> json( array(
                'message' => Lang::get('auth/message.not_autorized'),
                'type' => 'error' ),
                401 );

            /*if(View::exists($name))
            {
                return View($name);
            }
            else {
                //return View('404');
                return response()-> json( array(
                    'message' => Lang::get('auth/message.not_autorized'),
                    'type' => 'error' ),
                    401 );
            }*/
        }
    }

}