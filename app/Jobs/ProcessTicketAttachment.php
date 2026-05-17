<?php
namespace App\Jobs;

use App\Models\TicketDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProcessTicketAttachment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ticketDetail;

    public function __construct(TicketDetail $ticketDetail)
    {
        $this->ticketDetail = $ticketDetail;
    }

    public function handle(): void
    {
        if (!$this->ticketDetail->attachment_path || !Storage::exists($this->ticketDetail->attachment_path)) {
            return;
        }

        $contents = Storage::get($this->ticketDetail->attachment_path);
        $parsedJson = json_decode($contents, true);
        $updates = [];

        if (is_array($parsedJson)) {
            if (!empty($parsedJson['start_date'])) {
                $updates['start_date'] = date('Y-m-d', strtotime($parsedJson['start_date']));
            }
            if (!empty($parsedJson['end_date'])) {
                $updates['end_date'] = date('Y-m-d', strtotime($parsedJson['end_date']));
            }
            
            $updates['more_information'] = $parsedJson;
        } else {
            $updates['more_information'] = ['raw_text' => substr($contents, 0, 1000)];
        }

        if (!empty($updates)) {
            $this->ticketDetail->update($updates);
        }

        Log::info("Fila Processada: Ticket Detail #{$this->ticketDetail->id} enriquecido.");
    }
}