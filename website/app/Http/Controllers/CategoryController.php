<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Category;
use App\Keyword;
use View;
use Redirect;
use Input;
use Lang;
use App\Http\Requests;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
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
        $this->messageBag = new MessageBag;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_keywords = Keyword::All();
        $all_categories = Category::All();
        return View::make('admin.categories.index', compact('all_keywords', 'all_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_keywords = Keyword::All();
        return view('admin.categories.create', compact(''));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            $category = new Category(array(
                'name' => $request->name
            ));
            $category->save();

            return redirect("admin/categories")->withSuccess(Lang::get('softwares/message.success.create_category'));

        }
        catch (CategoryExistsException $e) {
            $this->messageBag->add('name', 'Category already exists');
        }

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($category_id)
    {
        $category = Category::where('id', $category_id)->get()->first();
        $all_keywords = Keyword::All();
        $category_keywords = $category->keywords()->get();
        $keyword_map = collect([ ]);

        $keyed = $category_keywords->keyBy("label");

        foreach( $all_keywords as $keyword ) {
            if($keyed->has($keyword->label)) {
                $keyword_map->push($keyword->label);
                $keyword->present = true;
            }
            else {
//                $keyword_map->push($keyword->label, false);
            }
        }

        return view('admin.categories.edit', compact('category', 'all_keywords', 'category_keywords', 'keyword_map'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category_id)
    {
        $category = Category::where('id', $category_id)->get()->first();
        // Update title
        $category->update($request->all());
        $category->save();

        $category_checkboxes = $request->except(["name", "_token", "_method"]);

        foreach($category_checkboxes as $keyword_id => $checked_status) {
            $keywd = Keyword::where("id", "=", $keyword_id)->get()->first();
            if($checked_status == "on") {
                try {
                    $category->keywords()->attach($keywd->id);
                }
                catch(\Illuminate\Database\QueryException $e) {
                    // silently ignore trying to ignore a dupe because it doesn't matter and that's what good software engineers do right?
                }
            }
            else {
                $category->keywords()->detach($keywd->id);
            }
        }

        return redirect()->back()->withSuccess(Lang::get('softwares/message.success.update_category'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($category_id)
    {
        $category = Category::where('id', $category_id)->get()->first();
        $category->delete();
        return redirect("admin/categories");
    }
}
