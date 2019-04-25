<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Schema;

class RoleMigrationTest extends TestCase
{
     /**
     * Test if 'roles' table exists
     *
     * @return void
     */
    public function testRoleDatabaseExist()
    {
        $this->assertTrue(Schema::hasTable('roles'));
    }

    /**
     * Test 'roles' table columns
     *
     * @return void
     */
    public function testRoleDatabaseColumnsExist()
    {
        $this->assertTrue(Schema::hasColumn('roles','id'));
        $this->assertTrue(Schema::hasColumn('roles','name'));
    }
}
