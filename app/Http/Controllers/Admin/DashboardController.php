<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $category = DB::table('category')->count();
        $blog     = DB::table('blog')->count();

        $blogViews = array();

        $minDate = DB::table('blog_view')
            ->where('created_at', '>', Carbon::now()->subDays(7))
            ->select(DB::raw('MIN(DATE(created_at)) as date'))
            ->first();

        if ($minDate) {
            $begin = new \DateTime($minDate->date);
            $end   = new \DateTime('now');

            for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
                $views = DB::table('blog_view')->whereDate('created_at', '=', $i->format('Y-m-d'))->count();

                $blogViews['days'][]  = $i->format('D');
                $blogViews['views'][] = $views;
            }
        }

        return view('admin.dashboard')->with(['category' => $category, 'blog' => $blog, 'blog_views' => $blogViews]);
    }

    public function notification()
    {
        $contacts    = DB::table('contacts')->where('flag', 0)->count();
        $subscribers = DB::table('subscribers')->where('flag', 0)->count();
        $comments    = DB::table('blog_comment')->where('flag', 0)->count();

        $notification = array();

        if (!empty($contacts)) {
            $lastData = DB::table('contacts')->select('created_at')->where('flag', 0)->orderBy('created_at', 'desc')->first();

            $notification['contacts']['count']      = $contacts;
            $notification['contacts']['created_at'] = $lastData->created_at;
        }

        if (!empty($subscribers)) {
            $lastData = DB::table('subscribers')->select('created_at')->where('flag', 0)->orderBy('created_at', 'desc')->first();

            $notification['subscribers']['count']      = $subscribers;
            $notification['subscribers']['created_at'] = $lastData->created_at;
        }

        if (!empty($comments)) {
            $lastData = DB::table('blog_comment')->select('created_at')->where('flag', 0)->orderBy('created_at', 'desc')->first();

            $notification['comments']['count']      = $comments;
            $notification['comments']['created_at'] = $lastData->created_at;
        }

        array_multisort(array_column($notification, "created_at"), SORT_DESC, $notification);

        return view('admin.notification')->with(['notification' => $notification]);
    }
}
