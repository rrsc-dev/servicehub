<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Company;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\TicketDetail;
use App\Models\User;
use App\Models\UserProfile;

class ModelsRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_one_profile_relationship_one_to_one(): void
    {
        $user = User::factory()->create();
        $profile = UserProfile::factory()->create(['user_id' => $user->id, 'role' => 'admin']);

        $this->assertInstanceOf(UserProfile::class, $user->profile);
        $this->assertEquals('admin', $user->profile->role);
    }

    public function test_ticket_has_one_detail_relationship_one_to_one(): void
    {
        $ticket = Ticket::factory()->create();
        TicketDetail::factory()->create(['ticket_id' => $ticket->id, 'attachment_path' => 'test.txt']);

        $this->assertInstanceOf(TicketDetail::class, $ticket->detail);
        $this->assertEquals('test.txt', $ticket->detail->attachment_path);
    }

    public function test_company_has_many_projects_relationship_one_to_many(): void
    {
        $company = Company::factory()->create();
        Project::factory()->count(3)->create(['company_id' => $company->id]);

        $this->assertCount(3, $company->projects);
        $this->assertInstanceOf(Project::class, $company->projects->first());
    }

    public function test_project_has_many_tickets_relationship_one_to_many(): void
    {
        $project = Project::factory()->create();
        Ticket::factory()->count(5)->create(['project_id' => $project->id]);

        $this->assertCount(5, $project->tickets);
    }

    public function test_ticket_belongs_to_creator_and_responsible_user(): void
    {
        $creator = User::factory()->create();
        $responsible = User::factory()->create();
        
        $ticket = Ticket::factory()->create([
            'created_by' => $creator->id,
            'user_id' => $responsible->id
        ]);

        $this->assertEquals($creator->id, $ticket->creator->id);
        $this->assertEquals($responsible->id, $ticket->user->id);
    }
}