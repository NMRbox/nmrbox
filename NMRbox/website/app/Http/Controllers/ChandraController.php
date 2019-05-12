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
    public function __construct() {
        // CSRF Protection
        $this->beforeFilter('csrf', array('on' => 'post'));

        //
        $this->messageBag = new MessageBag;
    }

    public function showHome() {
        return View::make('admin/index');
    }

    public function showHomepage($name=null) {
        // this is a special case for the home page. If more special cases arise, refactor into a more structured solution
        if($name == '') {
            $name = 'homepage';
            $page = Page::where('slug', $name)->get()->first();
            return View::make('blank')->with('page', $page);
        }

        // prevent users from viewing homepage dynamic page outside of site root
        if($name == 'homepage') {
            return Redirect::to('/');
        }

        if( Page::where('slug', '=', $name)->exists() ) {
            // $name is the page's slug

            $this->getPage($name);
        } else {
            return response()-> json( array(
                'message' => 'page_not_found.',
                'type' => 'error' ),
                401 );

        }
    }

    public function getPage( $name=null ) {
        if( Page::where('slug', '=', $name)->exists() ) {
            // $name is the page's slug
            $page = Page::where('slug', $name)->get()->first();

            return response()-> json( array(
                'data' => $page,
                'type' => 'success' ),
                200 );
        } else {
            return response()-> json( array(
                'message' => 'Page not found.',
                'type' => 'error' ),
                404 );

        }
    }

}