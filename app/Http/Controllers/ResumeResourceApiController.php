<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;
use App\Resume;
use App\Http\Resources\ResumeResource;

class ResumeResourceApiController extends Controller
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
            $resume = new Resume;
            $resume->applicant_id = $request->input('applicant_id');
            $resume->experience = $request->input('experience');
            $resume->education = $request->input('education');
            $resume->skills = $request->input('skills');
            if($resume->save()){
                return new ResumeResource($resume);
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
        $resume = Resume::find($request->input('resume_id'));
        return new ResumeResource($resume);
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
            $resume = Resume::find($request->input('resume_id'));
            $resume->applicant_id = $request->input('applicant_id');
            $resume->experience = $request->input('experience');
            $resume->education = $request->input('education');
            $resume->skills = $request->input('skills');
            if($resume->save()){
                return new ResumeResource($resume);
            }
        }else{
            return response('Forbiden', 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(Role::find($request->input('role_id'))->name == 'applicant'){
            $resume = Resume::find($request->input('resume_id'));
            if($resume->delete()){
                return response("Deleted", 204);
            }
           
        }else{
            return response("Forbidden", 403);
        }
    }
}
