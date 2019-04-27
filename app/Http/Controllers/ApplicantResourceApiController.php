<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ApplicantResource;
use App\Applicant;
use App\Role;

class ApplicantResourceApiController extends Controller
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
        if(Role::find($request->input('role_id'))->name == 'applicant'){
            $applicant = new Applicant;
            $applicant->account_id = $request->input('account_id');
            $applicant->role_id = $request->input('role_id');
            if($applicant->save()){
                return (new ApplicantResource($applicant))->response("success", 201);
            }
        }else{
            return response("Forbidden", 403);
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
        if(Role::find($request->input('role_id'))->name == 'applicant' || Role::find($request->input('role_id'))->name  ==  'admin'){
            return new ApplicantResource(Applicant::find($request->input('id')));
        }else{
            return response("Forbidden", 403);
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
        if(Role::find($request->input('role_id'))->name == 'applicant'){
            $applicant =  Applicant::find($request->input('id'));
            $applicant->resume_id = $request->input('resume_id');
            if($applicant->save()){
                return new ApplicantResource($applicant);
            }
        }else{
            return response("Forbidden", 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(Role::find($request->input('role_id'))->name == 'applicant'){
            $applicant =  Applicant::find($request->input('applicant_id'));
            
            if($applicant->delete()){
                return response("Deleted", 204);
            }
        }else{
            return response("Forbidden", 403);
        }
    }
}
