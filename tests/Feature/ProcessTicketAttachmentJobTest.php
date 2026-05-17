<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\TicketDetail;
use App\Jobs\ProcessTicketAttachment;

class ProcessTicketAttachmentJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_processes_json_attachment_and_updates_ticket_detail(): void
    {
        Storage::fake('local');

        $detail = TicketDetail::factory()->create([
            'attachment_path' => 'reports/test.json',
            'more_information' => []
        ]);

        $fakeJsonData = json_encode([
            'start_date' => '2026-05-18',
            'end_date' => '2026-05-20',
            'error' => 'Null Pointer Exception'
        ]);

        Storage::put('reports/test.json', $fakeJsonData);

        $job = new ProcessTicketAttachment($detail);
        $job->handle();

        $detail->refresh();

        $this->assertEquals('2026-05-18', $detail->start_date);
        $this->assertEquals('2026-05-20', $detail->end_date);
        $this->assertIsArray($detail->more_information);
        $this->assertEquals('Null Pointer Exception', $detail->more_information['error']);
    }

    public function test_job_processes_txt_attachment_and_updates_raw_text(): void
    {
        Storage::fake('local');

        $detail = TicketDetail::factory()->create([
            'attachment_path' => 'reports/log.txt',
            'more_information' => []
        ]);

        $fakeTextData = "Stack trace: Fatal error na linha 42 do sistema.";
        Storage::put('reports/log.txt', $fakeTextData);

        $job = new ProcessTicketAttachment($detail);
        $job->handle();

        $detail->refresh();

        $this->assertNull($detail->start_date);
        $this->assertIsArray($detail->more_information);
        $this->assertEquals($fakeTextData, $detail->more_information['raw_text']);
    }
}