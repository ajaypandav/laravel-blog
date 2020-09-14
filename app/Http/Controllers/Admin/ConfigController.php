<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use File;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        $config     = array();
        $configData = DB::table('config')->get();

        foreach ($configData as $key => $value) {
            $config[$value->option_key] = $value->option_value;
        }

        $config = (object) $config;

        return view('admin.config')->with(['config' => $config]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_title' => 'required|max:255',
            'favicon'    => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'logo'       => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'logo_alt'   => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $config = $request->all();

        unset($config['_token']);

        foreach ($request->file() as $key => $value) {
            $image      = $request->file($key);
            $name       = $key . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('/uploads/');
            $image->move($uploadPath, $name);
            $config[$key] = $name;
        }

        foreach ($config as $key => $value) {
            $checkKey = DB::table('config')->where('option_key', $key)->first();

            if (empty($checkKey)) {
                DB::table('config')->insert(['option_key' => $key, 'option_value' => $value, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            } else {
                DB::table('config')->where('option_key', $key)->update(['option_key' => $key, 'option_value' => $value, 'updated_at' => date('Y-m-d H:i:s')]);
            }
        }

        return redirect()->back()->with('success', 'Record updated successfully');
    }
}
