<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Schema;

class ResumeMigrationsTest extends TestCase
{
    /**
     * Test if 'resume' table exists
     *
     * @return void
     */
    public function testResumeDatabaseExist()
    {
        $this->assertTrue(Schema::hasTable('resumes'));
    }

    /**
     * Test 'resume' table columns
     *
     * @return void
     */
    public function testResumeDatabaseColumnsExist()
    {
        $this->assertTrue(Schema::hasColumn('resumes','id'));
        $this->assertTrue(Schema::hasColumn('resumes','applicant_id'));
        $this->assertTrue(Schema::hasColumn('resumes','experience'));
        $this->assertTrue(Schema::hasColumn('resumes','education'));
        $this->assertTrue(Schema::hasColumn('resumes','skills'));
    }
}
