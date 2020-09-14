<?php

namespace App\Http\Controllers\Front;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Subscriber;
use App\Traits\CommonTrait;
use DB;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    use CommonTrait;

    public function index()
    {
        // Hot Posts
        $hotPost = DB::table('blog')
            ->select('blog.*', 'users.name as author')
            ->leftJoin('users', 'users.id', '=', 'blog.uid')
            ->where('blog.status', 1)
            ->where('hot_post', 1)
            ->orderBy('blog.created_at', 'desc')
            ->limit(3)
            ->get();

        foreach ($hotPost as $key => $value) {
            $blogCat = DB::table('blog_category')
                ->select('category.title', 'category.url_slug')
                ->leftJoin('category', 'category.id', '=', 'blog_category.cid')
                ->where('blog_category.bid', $value->id)
                ->get();

            $hotPost[$key]->category = $blogCat;
        }

        // Recent Posts
        $recentPost = DB::table('blog')
            ->select('blog.*', 'users.name as author')
            ->leftJoin('users', 'users.id', '=', 'blog.uid')
            ->where('blog.status', 1)
            ->where('blog.hot_post', '!=', 1)
            ->orderBy('blog.created_at', 'desc')
            ->limit(22)
            ->get();

        foreach ($recentPost as $key => $value) {
            $blogCat = DB::table('blog_category')
                ->select('category.title', 'category.url_slug')
                ->leftJoin('category', 'category.id', '=', 'blog_category.cid')
                ->where('blog_category.bid', $value->id)
                ->get();

            $recentPost[$key]->category = $blogCat;
        }

        return view('index')->with(['hot_post' => $hotPost, 'recent_post' => $recentPost]);
    }

    public function newsletter(Request $request)
    {
        $return = array();

        $email = $request->email;

        $checkEmail = Subscriber::where('email', $email)->first();

        if (!empty($checkEmail)) {
            $return['success'] = 0;
            $return['msg']     = 'This email is already subscried.';
        } else {
            Subscriber::create(['email' => $email]);

            $return['success'] = 1;
            $return['msg']     = 'Email subscribed successfully.';
        }

        return json_encode($return);
    }

    public function aboutus()
    {
        return view('about');
    }

    public function contactus()
    {
        return view('contact');
    }

    public function contactPost(Request $request)
    {
        $request->validate([
            'name'    => 'required|max:255',
            'email'   => 'required|max:255',
            'subject' => 'required|max:255',
            'message' => 'required',
        ]);

        $data = $request->all();

        Contact::create($data);

        return redirect()->back()->with('success', 'Message submited successfully.');
    }
}
