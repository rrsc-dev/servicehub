<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
    /** @use HasFactory<\Database\Factories\TicketDetailFactory> */
    use HasFactory;

    protected $fillable = ['ticket_id', 'attachment_path', 'more_information', 'start_date', 'end_date'];

    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }

    protected function casts(): array
    {
        return [
            'more_information' => 'array',
        ];
    }
}
