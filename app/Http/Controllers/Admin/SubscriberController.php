<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Subscriber;
use DataTables;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index()
    {
        Subscriber::where('flag', 0)->update(['flag' => 1]);

        return view('admin.subscriber');
    }

    public function datatable()
    {
        return DataTables::of(Subscriber::query())
            ->addColumn('checkbox', function ($subscriber) {
                return '<label class="css-control css-control-primary css-checkbox py-0">
                            <input type="checkbox" class="css-control-input check-all" name="checkbox[]" value="' . $subscriber->id . '">
                            <span class="css-control-indicator mr-0"></span>
                        </label>';
            })
            ->editColumn('created_at', function ($subscriber) {
                return date('Y-m-d H:i:s', strtotime($subscriber->created_at));
            })
            ->addColumn('manage', function ($subscriber) {
                return '<a href="subscriber/' . $subscriber->id . '/destroy" class="btn btn-alt-danger btn-sm"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['checkbox', 'manage'])
            ->make(true);
    }

    public function destroy($id)
    {
        Subscriber::find($id)->delete();

        return redirect()->back()->with('success', 'Record Deleted successfully!');
    }

    public function bulkAction(Request $request)
    {
        if ($request->bulk_action == 2) {

            $subscriber = Subscriber::whereIn('id', $request->checkbox)->delete();

            return redirect()->back()->with('success', 'Record Deleted successfully!');
        }
    }
}
