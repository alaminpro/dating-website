<?php

namespace App\Http\Controllers\Admin;

use App\AdminFeature;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class FeatureController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $features = AdminFeature::where('is_premimum', 1)->get();
        return view('admin.features.features', compact('features'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.features.add-feature');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'text' => 'required',
            'coin' => 'required',
            'value' => 'required|integer|unique:admin_features,value',
            'days' => 'required',
        ]);
        $feature = new AdminFeature();
        $feature->text = $request->text;
        $feature->coin = $request->coin;
        $feature->value = $request->value;
        $feature->days = $request->days;
        $feature->is_premimum = 1;
        $feature->save();
        if ($feature) {
            Session::flash('message', 'Feature Added SuccessFully!');
            return redirect(route('admin_feature', "tab=premium"));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = AdminFeature::where('id', $id)->firstOrFail();
        return view('admin.features.edit-feature', compact('edit'));
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
        $this->validate($request, [
            'text' => 'required',
            'coin' => 'required',
            'value' => 'required|integer',
            'days' => 'required',
        ]);
        $feature = AdminFeature::find($id);
        $feature->text = $request->text;
        $feature->coin = $request->coin;
        $feature->value = $request->value;
        $feature->days = $request->days;
        $feature->is_premimum = 1;
        $feature->save();
        if ($feature) {
            Session::flash('message', 'Feature Updated SuccessFully!');
            return redirect(route('admin_feature', "tab=premium"));
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if ($id) {
            $destroy = AdminFeature::where('id', $id)->first();
            if ($destroy) {
                $destroy->delete();
                Session::flash('delete', 'Delete succefully!');
                return redirect(route('admin_feature', "tab=premium"));
            }
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function admin_feature_free_store(Request $request)
    {
        $this->validate($request, [
            'text' => 'required',
            'days' => 'required',
        ]);
        if ($request->id) {
            $feature = AdminFeature::find($request->id);
            $feature->text = $request->text;
            $feature->days = $request->days;
            $feature->is_premimum = 0;
            $feature->save();
            if ($feature) {
                Session::flash('message', 'Feature Updated SuccessFully!');
                return redirect(route('admin_feature', "tab=free"));
            }
        } else {
            $feature = new AdminFeature();
            $feature->text = $request->text;
            $feature->days = $request->days;
            $feature->is_premimum = 0;
            $feature->save();
            if ($feature) {
                Session::flash('message', 'Feature Added SuccessFully!');
                return redirect(route('admin_feature', "tab=free"));
            }
        }

    }

}
