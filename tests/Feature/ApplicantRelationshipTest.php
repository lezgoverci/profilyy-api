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
        $account = factory(Account::class)->create(['username' => 'my_username']);
        $applicant = factory(Applicant::class)->create(['account_id' => $account->id]);
        $this->assertNotNull($applicant->account);
        $this->assertEquals('my_username',$applicant->account->username);

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
        $account = factory(Account::class)->create(['role_id' => '1']); // Admin role
        $applicant = factory(Applicant::class)->create(['account_id' => $account->id]);
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
        $user = factory(User::class)->create(['fname' => 'my_fname']);
        $account = factory(Account::class)->create(['user_id' => $user->id]);
        $applicant = factory(Applicant::class)->create(['account_id' => $account->id]);
        $this->assertNotNull($applicant->account);
        $this->assertEquals('my_fname',$applicant->account->user->fname);

        $account->forceDelete();
        $applicant->forceDelete();
    }
}
