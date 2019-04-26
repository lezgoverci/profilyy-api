<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Applicant;

class ApplicantModelTest extends TestCase
{
    /**
     * Test Appliant model exists
     *
     * @return void
     */
    public function testApplicantModelExists()
    {
        $applicant = factory(Applicant::class)->create();
        $this->assertNotNull($applicant);

        $applicant->forceDelete();
    }
}
