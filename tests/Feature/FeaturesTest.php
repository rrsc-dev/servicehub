<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Ticket;

class FeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_tickets(): void
    {
        $response = $this->get('/tickets');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_create_ticket(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $response = $this->actingAs($user)->post('/tickets', [
            'project_id' => $project->id,
            'user_id' => $user->id,
            'title' => 'Erro no servidor',
            'description' => 'O sistema travou',
            'status' => 1
        ]);

        $this->assertDatabaseHas('tickets', [
            'title' => 'Erro no servidor',
            'created_by' => $user->id
        ]);

        $this->assertDatabaseHas('ticket_details', [
            'ticket_id' => Ticket::first()->id
        ]);
        
        $response->assertRedirect(route('tickets.show', Ticket::first()->id));
    }

    public function test_only_creator_or_responsible_can_delete_ticket(): void
    {
        $creator = User::factory()->create();
        $stranger = User::factory()->create();
        
        $ticket = Ticket::factory()->create([
            'created_by' => $creator->id,
            'user_id' => $creator->id
        ]);

        $response1 = $this->actingAs($stranger)->delete("/tickets/{$ticket->id}");
        $response1->assertStatus(403);

        $response2 = $this->actingAs($creator)->delete("/tickets/{$ticket->id}");
        $response2->assertRedirect(route('tickets.index'));
        
        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }
}