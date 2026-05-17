<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
    /** @use HasFactory<\Database\Factories\TicketDetailFactory> */
    use HasFactory;

    protected $fillable = ['ticket_id', 'description', 'attachment_path', 'report', 'start_date', 'end_date'];

    
}
