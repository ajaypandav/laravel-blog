<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Traits\CommonTrait;
use DB;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use CommonTrait;

    public function category($url)
    {
        $category = DB::table('category')->where('url_slug', $url)->first();

        if (empty($category)) {
            return view('404');
        } else {
            $blogs = DB::table('blog_category')
                ->select('blog.*', 'users.name as author')
                ->leftJoin('blog', 'blog.id', '=', 'blog_category.bid')
                ->leftJoin('users', 'users.id', '=', 'blog.uid')
                ->where('blog.status', 1)
                ->where('blog_category.cid', $category->id)
                ->orderBy('blog.created_at', 'desc')
                ->paginate(7);

            foreach ($blogs as $key => $value) {
                $blogCat = DB::table('blog_category')
                    ->select('category.title', 'category.url_slug')
                    ->leftJoin('category', 'category.id', '=', 'blog_category.cid')
                    ->where('blog_category.bid', $value->id)
                    ->get();

                $blogs[$key]->category = $blogCat;
            }

            if (\Request::get('page')) {
                return $blogs;
            } else {
                return view('category')->with(['page_title' => $category->title, 'header_image' => $category->cover_image, 'blogs' => $blogs]);
            }
        }
    }

    public function tag($tag)
    {
        $blogs = DB::table('blog_tag')
            ->select('blog.*', 'users.name as author')
            ->leftJoin('blog', 'blog.id', '=', 'blog_tag.bid')
            ->leftJoin('users', 'users.id', '=', 'blog.uid')
            ->where('blog.status', 1)
            ->where('blog_tag.tag', $tag)
            ->orderBy('blog.created_at', 'desc')
            ->paginate(7);

        foreach ($blogs as $key => $value) {
            $blogCat = DB::table('blog_category')
                ->select('category.title', 'category.url_slug')
                ->leftJoin('category', 'category.id', '=', 'blog_category.cid')
                ->where('blog_category.bid', $value->id)
                ->get();

            $blogs[$key]->category = $blogCat;
        }

        if (\Request::get('page')) {
            return $blogs;
        } else {
            return view('category')->with(['page_title' => $tag, 'header_image' => '', 'blogs' => $blogs]);
        }
    }

    public function author($author)
    {
        $user = DB::table('users')->where('name', $author)->first();

        if (empty($user)) {
            return view('404');
        } else {
            $blogs = DB::table('blog')
                ->select('blog.*', 'users.name as author')
                ->leftJoin('users', 'users.id', '=', 'blog.uid')
                ->where('blog.status', 1)
                ->where('blog.uid', $user->id)
                ->orderBy('blog.created_at', 'desc')
                ->paginate(5);
            
            foreach ($blogs as $key => $value) {
                $blogCat = DB::table('blog_category')
                    ->select('category.title', 'category.url_slug')
                    ->leftJoin('category', 'category.id', '=', 'blog_category.cid')
                    ->where('blog_category.bid', $value->id)
                    ->get();

                $blogs[$key]->category = $blogCat;
            }

            if (\Request::get('page')) {
                return $blogs;
            } else {
                return view('author')->with(['author' => $user, 'blogs' => $blogs]);
            }
        }
    }

    public function search(Request $request) {
        if (isset($request->s)) {
            $s = $request->s;

            $blogs = DB::table('blog')
                ->select('blog.*', 'users.name as author')
                ->leftJoin('users', 'users.id', '=', 'blog.uid')
                ->where('blog.status', 1)
                ->where('blog.title', 'like', '%'.$s.'%')
                ->orderBy('blog.created_at', 'desc')
                ->paginate(7);

            foreach ($blogs as $key => $value) {
                $blogCat = DB::table('blog_category')
                    ->select('category.title', 'category.url_slug')
                    ->leftJoin('category', 'category.id', '=', 'blog_category.cid')
                    ->where('blog_category.bid', $value->id)
                    ->get();

                $blogs[$key]->category = $blogCat;
            }

            $blogs->appends(['s' => $s])->links();

            if ($request->page) {
                return $blogs;
            } else {
                return view('category')->with(['page_title' => $s, 'header_image' => '', 'blogs' => $blogs]);
            }
        }
    }

    public function blog($url)
    {
        $blog = DB::table('blog')->where('url_slug', $url)->first();

        if (!empty($blog)) {
            /// Check if blog session key exists
            // If not, update view_count and create session key
            $blogKey = 'blog_' . $blog->id;
            if (!session()->has($blogKey)) {
                DB::table('blog')->where('id', $blog->id)->increment('view_count');
                session()->put($blogKey, 1);

                $this::createBlogView($blog->id);
            }

            // Get blog author
            $blogAuthor = DB::table('users')->where('id', $blog->uid)->first();

            $blog->author = $blogAuthor;

            // Get blog category
            $blogCategory = DB::table('blog_category')
                ->leftJoin('category', 'category.id', '=', 'blog_category.cid')
                ->select('category.title', 'category.url_slug', 'category.id')
                ->where('blog_category.bid', $blog->id)
                ->where('category.status', 1)
                ->get();

            $blog->category = $blogCategory;

            // Get blog tags
            $blogTags = DB::table('blog_tag')->where('bid', $blog->id)->get();

            $blog->tag = $blogTags;

            // Get blog comments
            $blogComments = DB::table('blog_comment')->where('bid', $blog->id)->orderBy('created_at', 'desc')->limit(10)->get();

            $blog->comments = $blogComments;

            // Get previous post
            $previous = DB::table('blog')->select('title', 'image', 'url_slug')->where('id', '<', $blog->id)->orderBy('id', 'desc')->first();

            // Get next post
            $next = DB::table('blog')->select('title', 'image', 'url_slug')->where('id', '>', $blog->id)->orderBy('id', 'asc')->first();

            // Get related post
            $cids = array();
            foreach ($blogCategory as $key => $value) {
                $cids[] = $value->id;
            }

            if (!empty($cids)) {
                $related = DB::table('blog_category')
                    ->select('blog.id', 'blog.title', 'blog.image', 'blog.url_slug', 'blog.created_at', 'users.name as author')
                    ->leftJoin('blog', 'blog_category.bid', '=', 'blog.id')
                    ->leftJoin('users', 'users.id', '=', 'blog.uid')
                    ->whereIn('cid', $cids)
                    ->where('blog.id', '<>', $blog->id)
                    ->limit(3)
                    ->distinct('blog.id')
                    ->inRandomOrder()
                    ->get();

                foreach ($related as $key => $value) {
                    $blogCat = DB::table('blog_category')
                        ->select('category.title', 'category.url_slug')
                        ->leftJoin('category', 'category.id', '=', 'blog_category.cid')
                        ->where('blog_category.bid', $value->id)
                        ->get();

                    $related[$key]->category = $blogCat;
                }
            }

            return view('blog')->with(['blog' => $blog, 'previous' => $previous, 'next' => $next, 'related' => @$related]);
        } else {
            return view('404');
        }
    }

    public function comment(Request $request)
    {
        $request->validate([
            'name'    => 'required|max:255',
            'email'   => 'required|max:255',
            'website' => 'max:255',
            'message' => 'required',
        ]);

        $data = [
            'bid'        => $request->bid,
            'name'       => $request->name,
            'email'      => $request->email,
            'website'    => $request->website,
            'message'    => $request->message,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        DB::table('blog_comment')->insert($data);

        return redirect()->back()->with('success', 'Message submited successfully.');
    }

    public static function createBlogView($bid)
    {
        $data = [
            'bid'        => $bid,
            'session_id' => \Request::getSession()->getId(),
            'ip'         => \Request::getClientIp(),
            'agent'      => \Request::header('User-Agent'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        DB::table('blog_view')->insert($data);
    }
}
