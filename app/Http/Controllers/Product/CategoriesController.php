<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditCategory;
use App\Http\Requests\StoreCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function categories(Request $request)
    {
        $pages = $request->get('pages', 10);

        if ($request->has('search')) {
            $search = $request->get('search');
            $categories = Category::like('description', $search)->sortable()->paginate($pages);
        } else {
            $categories = Category::sortable()->paginate($pages);
        }

        return view('product/category/categories', ['categories' => $categories]);
    }

    public function newCategory(Request $request)
    {
        return view('product/category/new');
    }

    public function storeCategory(StoreCategory $request)
    {
        Category::create([
            'description' => $request->get('description'),
        ]);

        return redirect('product/categories')->with([
            'status' => 'Nueva categoría agregada exitosamente'
        ]);
    }

    public function editCategory($id)
    {
        $category = Category::find($id);

        if ($category) {
            return view('product/category/edit', ['category' => $category]);
        }

        return response('', 404);
    }

    public function saveEditCategory(EditCategory $request, $id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->description = $request->get('description');
            $category->save();

            return redirect('product/categories')->with([
                'status' => 'Categoría acutalizada exitosamente'
            ]);
        }

        return response('', 505);
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if ($category) {
            return view('product/category/delete', ['category' => $category]);
        }

        return response('', 404);
    }

    public function proceedDeleteCategory($id)
    {
        $category = Category::find($id);

        if ($category) {

            if (count($category->products)) {
                $count = $category->products->count();
                return redirect("product/categories/delete/{$category->id}")->with([
                    'error' => "Esta categoría no puede ser eliminada ya que esta referenciada en $count productos."
                ]);
            } else {
                $category->delete();

                return redirect('product/categories')->with([
                    'status' => 'Categoría eliminada exitosamente'
                ]);
            }
        }

        return response('', 404);
    }
}
