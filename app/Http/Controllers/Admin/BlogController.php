<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use App\Http\Controllers\Controller;
use DataTables;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.blog');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::table('category')->select('id', 'title')->where('status', 1)->orderBy('title', 'asc')->get();

        return view('admin.blogAdd')->with(['categories' => $categories]);
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
            'title'        => 'required|unique:blog',
            'header_image' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'image'        => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'description'  => 'required',
            'cid.*'        => 'required',
            'status'       => 'required',
        ]);

        $blog = request()->all();

        $url_slug = $this->urlSlug($blog['title']);

        $blog['url_slug'] = $url_slug;
        $blog['uid']      = Auth::id();

        if ($request->hasFile('header_image')) {
            $image      = $request->file('header_image');
            $name       = $url_slug . '-' . rand(9, 99) . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('/uploads/blog/cover/');
            $image->move($uploadPath, $name);
            $blog['header_image'] = $name;
        }

        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $name       = $url_slug . '-' . rand(9, 99) . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('/uploads/blog/');
            $image->move($uploadPath, $name);
            $blog['image'] = $name;
        }

        $create = Blog::create($blog);

        $bid = $create->id;

        // Add blog categories
        foreach ($blog['cids'] as $key => $value) {
            $insert = array('bid' => $bid, 'cid' => $value);

            DB::table('blog_category')->insert($insert);
        }

        // Add blog tag
        if (!empty($blog['tag'])) {
            $tags = explode(',', $blog['tag']);

            foreach ($tags as $key => $value) {
                $insert = array('bid' => $bid, 'tag' => $value);

                DB::table('blog_tag')->insert($insert);
            }
        }

        return redirect()->route('blog.index')->with('success', 'Blog added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cids = $tag = array();

        $blog = Blog::find($id);

        $blogCids = DB::table('blog_category')
            ->select('category.title')
            ->leftJoin('category', 'category.id', '=', 'blog_category.cid')
            ->where('blog_category.bid', $id)
            ->get();

        foreach ($blogCids as $key => $value) {
            $cids[] = $value->title;
        }

        $category = implode(',', $cids);

        $blogTags = DB::table('blog_tag')->where('bid', $id)->get();

        foreach ($blogTags as $key => $value) {
            $tags[] = $value->tag;
        }

        $tags = implode(', ', $tags);

        return view('admin.blogView')->with(['blog' => $blog, 'category' => $category, 'tags' => $tags]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cids = $tag = array();

        $blog = Blog::find($id);

        $categories = DB::table('category')->select('id', 'title')->orderBy('title', 'asc')->get();

        $blogCids = DB::table('blog_category')->where('bid', $id)->get();

        foreach ($blogCids as $key => $value) {
            $cids[] = $value->cid;
        }

        $blogTags = DB::table('blog_tag')->where('bid', $id)->get();

        foreach ($blogTags as $key => $value) {
            $tags[] = $value->tag;
        }

        $tags = implode(',', $tags);

        return view('admin.blogEdit')->with(['blog' => $blog, 'categories' => $categories, 'cids' => $cids, 'tags' => $tags]);
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
            'title'        => 'required|unique:blog,title,' . $id,
            'header_image' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'image'        => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'description'  => 'required',
            'cid.*'        => 'required',
            'status'       => 'required',
        ]);

        $blog = request()->all();

        $url_slug = $this->urlSlug($blog['title']);

        $blog['url_slug'] = $url_slug;

        if ($request->hasFile('header_image')) {
            $image      = $request->file('header_image');
            $name       = $url_slug . '-' . rand(9, 99) . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('/uploads/blog/cover/');
            $image->move($uploadPath, $name);
            $blog['header_image'] = $name;

            $oldImage     = Blog::find($id);
            $header_image = 'public/uploads/blog/cover/' . $oldImage->header_image;
            File::delete($header_image);
        }

        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $name       = $url_slug . '-' . rand(9, 99) . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('/uploads/blog/');
            $image->move($uploadPath, $name);
            $blog['image'] = $name;

            $oldImage = Blog::find($id);
            $image    = 'public/uploads/blog/' . $oldImage->image;
            File::delete($image);
        }

        if (!isset($blog['hot_post'])) {
            $blog['hot_post'] = 0;
        }

        Blog::find($id)->update($blog);

        $bid = $id;

        // Add blog categories
        DB::table('blog_category')->where('bid', $bid)->delete();
        foreach ($blog['cids'] as $key => $value) {
            $insert = array('bid' => $bid, 'cid' => $value);

            DB::table('blog_category')->insert($insert);
        }

        // Add blog tag
        DB::table('blog_tag')->where('bid', $bid)->delete();
        if (!empty($blog['tag'])) {
            $tags = explode(',', $blog['tag']);

            foreach ($tags as $key => $value) {
                $insert = array('bid' => $bid, 'tag' => $value);

                DB::table('blog_tag')->insert($insert);
            }
        }

        return redirect()->route('blog.index')->with('success', 'Blog added successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);

        if ($blog->delete()) {
            $header_image = 'public/uploads/blog/cover/' . $blog->header_image;
            $image        = 'public/uploads/blog/' . $blog->image;

            File::delete($header_image, $image);

            return redirect()->route('blog.index')->with('success', 'Record Deleted successfully!');
        } else {
            return redirect()->route('blog.index')->with('error', 'Unable to delete record. Dependent entry exist for the same.');
        }
    }

    public function bulkAction(Request $request)
    {
        if ($request->bulk_action == 1) {
            Blog::whereIn('id', $request->checkbox)->update(['status' => 1]);
            return redirect()->route('blog.index')->with('success', 'Status updated successfully!');
        } elseif ($request->bulk_action == 0) {
            Blog::whereIn('id', $request->checkbox)->update(['status' => 0]);
            return redirect()->route('blog.index')->with('success', 'Status updated successfully!');
        } elseif ($request->bulk_action == 2) {
            $unable = 0;

            $blogs = Blog::whereIn('id', $request->checkbox)->get();

            foreach ($blogs as $key => $value) {
                $header_image = 'public/uploads/blog/cover/' . $value->header_image;
                $image        = 'public/uploads/blog/' . $value->image;

                if (Blog::find($value->id)->delete()) {
                    File::delete($header_image, $image);
                } else {
                    $unable++;
                }
            }

            if ($unable == 0) {
                return redirect()->route('blog.index')->with('success', 'Record Deleted successfully!');
            } else {
                return redirect()->route('blog.index')->with('error', 'Unable to delete ' . $unable . ' records. Dependent entry exist for the same.');
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
        return DataTables::of(Blog::query())
            ->addColumn('checkbox', function ($blog) {
                return '<label class="css-control css-control-primary css-checkbox py-0">
                            <input type="checkbox" class="css-control-input check-all" name="checkbox[]" value="' . $blog->id . '">
                            <span class="css-control-indicator mr-0"></span>
                        </label>';
            })
            ->editColumn('created_at', function ($blog) {
                return date('Y-m-d H:i:s', strtotime($blog->created_at));
            })
            ->editColumn('status', function ($blog) {
                if ($blog->status == 1) {
                    return '<span class="badge badge-success">Active</span>';
                } else {
                    return '<span class="badge badge-danger">Inactive</span>';
                }
            })
            ->addColumn('manage', function ($blog) {
                $blink = '';

                $checkComment = DB::table('blog_comment')->where('bid', $blog->id)->where('flag', 0)->count();

                if ($checkComment > 0) {
                    $blink = '<i class="fa fa-circle blink"></i>';
                }

                return '<a href="blog/' . $blog->id . '" class="btn btn-alt-info btn-sm"><i class="fa fa-eye"></i></a>&nbsp;<a href="blog/' . $blog->id . '/edit" class="btn btn-alt-primary btn-sm"><i class="fa fa-edit"></i></a>&nbsp;<a href="blog/' . $blog->id . '/destroy" class="btn btn-alt-danger btn-sm"><i class="fa fa-trash"></i></a>&nbsp;<a href="blog/' . $blog->id . '/comment" class="btn btn-alt-secondary btn-sm btn-comment"><i class="fa fa-comments"></i>'.$blink.'</a>';
            })
            ->rawColumns(['checkbox', 'manage', 'status'])
            ->make(true);
    }

    public function comment($bid)
    {
        $blog = Blog::find($bid);

        DB::table('blog_comment')->where('bid', $bid)->where('flag', 0)->update(['flag' => 1]);

        return view('admin.blogComment')->with(['blog' => $blog]);
    }

    public function commentData($bid) {
        return DataTables::of(DB::table('blog_comment')->where('bid', $bid))
            ->addColumn('checkbox', function ($comment) {
                return '<label class="css-control css-control-primary css-checkbox py-0">
                            <input type="checkbox" class="css-control-input check-all" name="checkbox[]" value="' . $comment->id . '">
                            <span class="css-control-indicator mr-0"></span>
                        </label>';
            })
            ->editColumn('created_at', function ($comment) {
                return date('Y-m-d H:i:s', strtotime($comment->created_at));
            })
            ->addColumn('manage', function ($comment) {
                return '<a href="'.url('admin/blogComment/' . $comment->id . '/destroy').'" class="btn btn-alt-danger btn-sm"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['checkbox', 'manage'])
            ->make(true);
    }

    function destroyComment($id) {
        DB::table('blog_comment')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully');
    }

    public function commentBulkAction(Request $request)
    {
        if ($request->bulk_action == 2) {
            DB::table('blog_comment')->whereIn('id', $request->checkbox)->delete();

            return redirect()->back()->with('success', 'Comment deleted successfully!');
        }
    }
}
