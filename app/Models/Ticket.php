<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;

    protected $fillable = ['project_id', 'created_by', 'user_id', 'title', 'description', 'status'];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function detail() {
        return $this->hasOne(TicketDetail::class);
    }
}
