<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Account;
use App\Http\Resources\AccountResource;

class AccountResourceApiController extends Controller
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
        $count = Account::where('username', $request->input('username'))->count();
        if($count == 0){
            $account = new Account;
            $account->fname = $request->input('fname');
            $account->lname = $request->input('lname');
            $account->address = $request->input('address');
            $account->phone = $request->input('phone');
            $account->gender = $request->input('gender');

            if($account->save()){
                return (new AccountResource($account))->response("success", 201);
            }
        }else{
            return response("Account already exists", 409);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Account::find($id) != null){
            return (new AccountResource(Account::find($id)))->response("Success", 200);
        }else{
            return response("Not found", 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $account = Account::find($request->input('id'));
        $account->password = Hash::make($request->input('password'));
        if($account->save()){
            return (new AccountResource($account))->response("Success", 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if($request->input('role') == 'admin' || 'applicant'){
            $account = Account::find($request->input('id'));
            
            if($account->delete()){
                return response("Deleted", 204);
            }
        }else{
            return response("Forbidden", 403);
        }
    }
}
