<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\PageRequest;
use App\Page;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Sentinel;
use Response;
use Input;
Use DebugBar\DebugBar;


class PageController extends ChandraController {


    private $tags ;

    public function __construct()
    {
        parent::__construct();
//        $this->tags = Page::tagArray();
    }
    /**
     * @return \Illuminate\View\View
     */
    public function getIndexFrontend()
    {
        //featured page
        $featured = Page::where('featured', 1);

        $pages = [];

        if( $featured->count() > 0 ) {
            $featured = $featured->first();
            $pages = Page::latest()->where('id','!=',$featured->id)->simplePaginate(5);
        }
        else {
            $pages = Page::latest()->simplePaginate(5);
        }

        $pages->setPath('page');
        $tags = $this->tags;
        //return $tags;
        $latest = Page::latest()->take(5)->get();
        // Show the page

        if( $featured->count() > 0 ) {
            return View('pages.index', compact('featured','pages','tags','latest'));
        }
        else {
            return View('pages.index', compact('pages','tags','latest'));
        }


    }

    /**
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function getPageFrontend($slug='')
    {
        if($slug=='')
        {
            $page = Page::first();
        }
        try {
            $page = Page::findBySlugOrIdOrFail($slug);
            $page->increment('views');
        }
        catch(ModelNotFoundException $e)
        {
            return Response::view('404', array(), 404);
        }
        $popular = Page::orderBy('views','DESC')->first();
        // Show the page
        return View('pages.show', compact('page','popular'));

    }

    /**
     * @param $tag
     * @return \Illuminate\View\View
     */
    public function getPageTagFrontend($tag)
    {
        $pages = Page::withAnyTags($tag)->simplePaginate(5);
        $pages->setPath('page/'.$tag.'/tag');
        $tags = $this->tags;
        return View('pages.index', compact('pages','tags'));
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        // Grab all the pages
        $pages = Page::all();


        // Do we want to include the deleted pages?
        if (Input::get('withTrashed')) {
            $pages = $pages->merge( Page::withTrashed()->get() );
        } elseif (Input::get('onlyTrashed')) {
            $pages =Page::onlyTrashed()->get();
        }


        // Show the page
        return View('admin.pages.index', compact('pages'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
        return view('admin.pages.create',compact(''));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate(PageRequest $request)
	{

        try {

            $page = new Page($request->except('image','tags','featured','slug'));
            $page->user_id = Sentinel::getUser()->id;
            $page->save();

            // unfortunately need to save twice to get around the auto-slugging
            $slug = $page->_generateSlug($request->slug);
            $slug = $page->_makeSlugUnique($slug);
            $page->slug = $slug;
            $page->save();

            return redirect('admin/pages');

        } catch (\UnexpectedValueException $e) {
            return back()->withInput()->with('error', 'Invalid slug. Please try another.');
        }



	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Page $page
	 * @return view
	 */
	public function show(Page $page)
	{
        $comments = PageComment::all();
        return view('admin.pages.show', compact('page','comments','tags','popular'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Page $page
	 * @return view
	 */
	/*public function getEdit(Page $page)
	{
        return view('admin.pages.edit', compact('page','pagecategory'));
	}*/

	public function getEdit($id = null)
	{
	    try {
            // Get the page information
            $page = Page::where('slug', $id)->first();
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = Lang::get('page/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('pages')->with('error', $error);
        }

        // Show the page
        return view('admin.pages.edit', compact('page','pagecategory', 'page_content'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  PageRequest $request
     * @param Page $page
	 * @return Response
	 */
	public function postEdit(PageRequest $request, Page $page)
	{
//        $picture = "";
//        if ($request->hasFile('image')) {
//            $file = $request->file('image');
//            $filename = $file->getClientOriginalName();
//            $extension = $file->getClientOriginalExtension()?: 'png';
//            $folderName      = '/uploads/page/';
//            $picture = str_random(10).'.'.$extension;
//            $page->image = $picture;
//        }

        // creating the object from input slug
        $slug = $request->input('slug');
        $page = Page::where('slug', $slug)->first();

        $page->user_id = Sentinel::getUser()->id;
        $page->update($request->except('image','_method','tags'));

        return redirect('admin/pages');
	}

    /**
     * Remove page.
     *
     * @param $website
     * @return Response
     */
    public function getModalDelete(String $page_id)
    {
        $model = 'page';
        $confirm_route = $error = null;

        // do query to get page, which may be soft deleted.
        $page = Page::where('id', $page_id)->get()->first();

        if( $page == null ) {
            // then the model may have been soft deleted
            $page = Page::withTrashed()
                ->where('id', $page_id)
                ->get()
                ->first();

            if( $page == null ) {
                // then the page just doesn't exist
                $error = trans('page/message.error.forcedelete', compact('id'));
                return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
            else {
                // the page was soft deleted
                $confirm_route =  route('delete/page',['id'=>$page->id]);
                $model = $model . "-forcedelete";
                return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        }

        try {
            $confirm_route =  route('delete/page',['id'=>$page->id]);
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        } catch (GroupNotFoundException $e) {
            $error = trans('page/message.error.delete', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
    }
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete(String $page_id)
	{

        // do query to get page, which may be soft deleted.
        $page = Page::where('id', $page_id)->get()->first();

        if( $page == null ) {
            // then the model may have been soft deleted
            $page = Page::withTrashed()
                ->where('id', $page_id)
                ->get()
                ->first();

            if( $page == null ) {
                // then the page just doesn't exist
                return View('404');
            }
            else {
                // the page was soft deleted
                $page->forceDelete();
            }
        }
        else {
            // do soft delete
            $page->delete();
        }

        return redirect('admin/pages');
	}

}
