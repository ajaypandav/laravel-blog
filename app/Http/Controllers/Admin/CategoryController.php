<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use DataTables;
use File;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.category');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categoryAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|unique:category',
            'cover_image' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'status'      => 'required',
        ]);

        $category = request()->all();

        $url_slug = $this->urlSlug($category['title']);

        $category['url_slug'] = $url_slug;

        if ($request->hasFile('cover_image')) {
            $image      = $request->file('cover_image');
            $name       = $url_slug . '-' . rand(9, 99) . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('/uploads/category/');
            $image->move($uploadPath, $name);
            $category['cover_image'] = $name;
        }

        Category::create($category);

        return redirect()->route('category.index')->with('success', 'Category added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);

        return view('admin.categoryEdit')->with(['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|unique:category,title,' . $id,
            'cover_image' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'status'      => 'required',
        ]);

        $category = request()->all();

        $url_slug = $this->urlSlug($category['title']);

        $category['url_slug'] = $url_slug;

        if ($request->hasFile('cover_image')) {
            $image      = $request->file('cover_image');
            $name       = $url_slug . '-' . rand(9, 99) . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('/uploads/category/');
            $image->move($uploadPath, $name);
            $category['cover_image'] = $name;

            $oldImage    = Category::find($id);
            $cover_image = 'public/uploads/category/' . $oldImage->cover_image;
            File::delete($cover_image);
        }

        Category::find($id)->update($category);

        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        try {
            $category->delete();
            $cover_image = 'public/uploads/category/' . $category->cover_image;

            File::delete($cover_image);

            return redirect()->route('category.index')->with('success', 'Record Deleted successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('category.index')->with('error', 'Unable to delete record. Dependent entry exist for the same.');
        }
    }

    public function bulkAction(Request $request)
    {
        if ($request->bulk_action == 1) {
            Category::whereIn('id', $request->checkbox)->update(['status' => 1]);
            return redirect()->route('category.index')->with('success', 'Status updated successfully!');
        } elseif ($request->bulk_action == 0) {
            Category::whereIn('id', $request->checkbox)->update(['status' => 0]);
            return redirect()->route('category.index')->with('success', 'Status updated successfully!');
        } elseif ($request->bulk_action == 2) {
            $unable = 0;

            $categories = Category::whereIn('id', $request->checkbox)->get();

            foreach ($categories as $key => $value) {
                $cover_image = 'public/uploads/category/' . $value->cover_image;

                try {
                    Category::find($value->id)->delete();
                    File::delete($cover_image);
                } catch (\Illuminate\Database\QueryException $e) {
                    $unable++;
                }
            }

            if ($unable == 0) {
                return redirect()->route('category.index')->with('success', 'Record Deleted successfully!');
            } else {
                return redirect()->route('category.index')->with('error', 'Unable to delete ' . $unable . ' records. Dependent entry exist for the same.');
            }
        }
    }

    public static function urlSlug($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public function datatable()
    {
        return DataTables::of(Category::query())
            ->addColumn('checkbox', function ($category) {
                return '<label class="css-control css-control-primary css-checkbox py-0">
                            <input type="checkbox" class="css-control-input check-all" name="checkbox[]" value="' . $category->id . '">
                            <span class="css-control-indicator mr-0"></span>
                        </label>';
            })
            ->editColumn('cover_image', function ($category) {
                if (!empty($category->cover_image)) {
                    return '<a class="img-link img-link-zoom-in img-thumb img-lightbox" href="' . asset('public/uploads/category/' . $category->cover_image) . '">
                                <img src="' . asset('public/uploads/category/' . $category->cover_image) . '" width="100px">
                            </a>';
                }
            })
            ->editColumn('status', function ($category) {
                if ($category->status == 1) {
                    return '<span class="badge badge-success">Active</span>';
                } else {
                    return '<span class="badge badge-danger">Inactive</span>';
                }
            })
            ->addColumn('manage', function ($category) {
                return '<a href="category/' . $category->id . '/edit" class="btn btn-alt-primary btn-sm"><i class="fa fa-edit"></i></a>&nbsp;<a href="category/' . $category->id . '/destroy" class="btn btn-alt-danger btn-sm"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['checkbox', 'manage', 'status', 'cover_image'])
            ->make(true);
    }
}
