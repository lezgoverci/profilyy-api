<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Schema;

class ApplicantMigrationTest extends TestCase
{
    /**
     * Test if 'applicants' table exists
     *
     * @return void
     */
    public function testApplicantsDatabaseExist()
    {
        $this->assertTrue(Schema::hasTable('applicants'));
    }

    /**
     * Test 'applicants' table columns
     *
     * @return void
     */
    public function testApplicantsDatabaseColumnsExist()
    {
        $this->assertTrue(Schema::hasColumn('applicants','id'));
        $this->assertTrue(Schema::hasColumn('applicants','account_id'));
        $this->assertTrue(Schema::hasColumn('applicants','resume_id'));
    }
}
