<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ApplicantResource;
use App\Applicant;

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
        if($request->input('role') == 'applicant'){
            $applicant = new Applicant;
            $applicant->account_id = $request->input('account_id');
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
        if($request->input('role') == 'applicant' || $request->input('role') ==  'admin'){
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
        if($request->input('role') == 'applicant'){
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
