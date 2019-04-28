<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Resume;
use App\Applicant;

class ResumeRelationshipsTest extends TestCase
{
    /**
     * Test Resume and applicant relationship
     *
     * @return void
     */
    public function testResumeModelApplicantRelationship()
    {
        $resume = factory(Resume::class)->create();
        $applicant = factory(Applicant::class)->create();

        $resume->applicant_id = $applicant->id;
        $resume->save();

        $this->assertEquals($resume->applicant->id, $applicant->id);

    }
}
