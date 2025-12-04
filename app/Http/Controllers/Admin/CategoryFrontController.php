<?php
/* 
* Front Controller File for the category page connected to the Back Office section 
*/

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Nette\Utils\Json;

class CategoryFrontController extends Controller
{
    /**
    * Show category details view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function show(Request $request): Response|RedirectResponse
    {
        $category = Category::where('slug', $request->slug)->firstOrFail();

        if(!$category) {
            redirect('not-found', 404);
        }

        $tree = Category::All()->map(function ($cat) {
            return [
                $cat->id => [
                    'text' => $cat->name,
                    'children' => $cat->subCategories->map(function ($sub) {
                        return "$sub->id";
                    }),
                    'state' => [
                        'checked' => false,
                        'indeterminate'=> false,
                        'draggable'=> true,
                        'dropable'=> false
                    ]
                ]
            ];
        });

        Json::encode($tree, true);

        return Inertia::render('admin/CategoryDetails', [
            'slug' => $category->slug,
            'category' => $category,
            'categories' => $tree
        ]);
    }

    /**
    * Show sub categories list view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function showSubCategories(Request $request): Response|RedirectResponse
    {
        $subCategories = Category::where('parent_id', $request->id)->get();

        if(!$subCategories) {
            redirect('not-found', 404);
        }

        return Inertia::render('admin/Categories', [
            'subCategories' => $subCategories
        ]);
    }

    /**
    * Create category view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function newCategory(Request $request): Response|RedirectResponse
    {
        $categories = Category::All();

        $tree = $categories->map(function ($cat) {
            return [
                $cat->id => [
                    'text' => $cat->name,
                    'children' => $cat->subCategories->map(function ($sub) {
                        return "$sub->id";
                    }),
                    'state' => [
                        'checked' => false,
                        'indeterminate'=> false,
                        'draggable'=> true,
                        'dropable'=> false
                    ]
                ]
            ];
        });

        Json::encode($tree, true);

        return Inertia::render('admin/NewCategory', [
            'categories' => $tree
        ]);
    }

    /**
    * This method validate every fields used in the new category form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function create(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'string|min:0|max:500',
            'id' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/categories')
                ->withErrors($validator)
                ->withInput();
        }

        $category = new Category;
        $category->parent_id = $request->get('parent_id');
        $category->name = $request->get('name');
        $category->description = $request->get('description');
        $category->save();

        return redirect('/admin/back-office/categories');
    }

    /**
    * This method validate every fields used in the category details form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function update(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'string|min:0|max:500',
            'parent_id' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/categories')
                ->withErrors($validator)
                ->withInput();
        }

        $category = Category::where('name', $request->get('name'))->first();
        $category->parent_id = $request->get('parent_id');
        $category->name = $request->get('name');
        $category->description = $request->get('description');
        $category->save();

        return redirect('/admin/back-office/categories');
    }

        /**
    * This method validate data and confirm the deletion.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function destroy(Request $request): RedirectResponse
    {
        $category = Category::where('name', $request->get('name'))->first();
        $category->delete();

        return redirect('/admin/back-office/categories');
    }

    /**
    * This method validate data and confirm the deletion.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function destroyBulk(Request $request): RedirectResponse
    {
        $categories = Category::whereIn('name', $request->get('names'))->get();
        foreach($categories as $category) {
            $category->delete();
        }

        return redirect('/admin/back-office/categories');
    }
}