<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Account;
use App\Applicant;
use App\User;

class ApplicantRelationshipTest extends TestCase
{
    /**
     * Test Applicant has a Account relationship
     *
     * @return void
     */
    public function testApplicantModelAccountRelationship()
    {
        $account = factory(Account::class)->create();
        $account_username = $account->username;
        $applicant = factory(Applicant::class)->create();

        $applicant->account()->save($account);
        $this->assertNotNull($applicant->account);
        $this->assertEquals($account_username,$applicant->account->username);

        $account->forceDelete();
        $applicant->forceDelete();
    }

    /**
     * Test Applicant Account role relationship
     *
     * @return void
     */
    public function testApplicantModelRoleRelationship()
    {
        $account = factory(Account::class)->create(['role_id' => 1]); // Admin role
        $applicant = factory(Applicant::class)->create();

        $applicant->account()->save($account);
        $this->assertNotNull($applicant->account);
        $this->assertEquals('admin',$applicant->account->role->name);
        

        $account->forceDelete();
        $applicant->forceDelete();
    }

    /**
     * Test Applicant Account user relationship
     *
     * @return void
     */
    public function testApplicantModelUserRelationship()
    {
        $user = factory(User::class)->create();
        $user_fname = $user->fname;
        $account = factory(Account::class)->create();
        $applicant = factory(Applicant::class)->create();

        $account->user()->associate($user);
        $applicant->account()->save($account);

        $this->assertNotNull($applicant->account);
        $this->assertEquals($user_fname,$applicant->account->user->fname);

        $account->forceDelete();
        $applicant->forceDelete();
    }
}
