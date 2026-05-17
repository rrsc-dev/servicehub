<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    protected $fillable = ['company_id', 'slug', 'name', 'status', 'description', 'start_date', 'end_date'];

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }
}
