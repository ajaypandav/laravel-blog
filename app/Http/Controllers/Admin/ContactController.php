<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use DataTables;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        Contact::where('flag', 0)->update(['flag' => 1]);

        return view('admin.contact');
    }

    public function datatable()
    {
        return DataTables::of(Contact::query())
            ->addColumn('checkbox', function ($contact) {
                return '<label class="css-control css-control-primary css-checkbox py-0">
                            <input type="checkbox" class="css-control-input check-all" name="checkbox[]" value="' . $contact->id . '">
                            <span class="css-control-indicator mr-0"></span>
                        </label>';
            })
            ->editColumn('created_at', function ($contact) {
                return date('Y-m-d H:i:s', strtotime($contact->created_at));
            })
            ->addColumn('manage', function ($contact) {
                return '<a href="contact/' . $contact->id . '/destroy" class="btn btn-alt-danger btn-sm"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['checkbox', 'manage'])
            ->make(true);
    }

    public function destroy($id)
    {
        Contact::find($id)->delete();

        return redirect()->back()->with('success', 'Record Deleted successfully!');
    }

    public function bulkAction(Request $request)
    {
        if ($request->bulk_action == 2) {

            $contact = Contact::whereIn('id', $request->checkbox)->delete();

            return redirect()->back()->with('success', 'Record Deleted successfully!');
        }
    }
}
