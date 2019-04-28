<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Resume;

class ResumeModelTest extends TestCase
{
    /**
     * Test Resume model exists
     *
     * @return void
     */
    public function testResumeModelExists()
    {
        $resume = factory(Resume::class)->create();
        $this->assertNotNull($resume);

        $resume->forceDelete();
    }
}
