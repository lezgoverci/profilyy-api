<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Http\Resources\AdminResource;

use App\Role;


class AdminResourceApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Role::find($request->input('role_id'))->name == 'admin'){
            $admin = new Admin;
            $admin->account_id = $request->input('account_id');
            $admin->role_id = $request->input('role_id');
            if($admin->save()){
                return (new AdminResource($admin));
            }
        }
        else{
            return response("Forbidden",403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if(Role::find($request->input('role_id'))->name == 'admin'){
            return new AdminResource(Admin::find($request->input('admin_id')));
        }else{
            return response("Forbidden", 403);
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(Role::find($request->input('role_id'))->name == 'admin'){
            $admin = Admin::find($request->input('admin_id'));
            if($admin->delete()){
                return response("Deleted", 204);
            }
        }else{
            return response("Forbidden", 403);
        }
    }
}
