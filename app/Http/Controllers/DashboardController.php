<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\Project;
use App\Models\Ticket;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'companies' => Company::count(),
                'projects' => Project::count(),
                'tickets' => Ticket::count(),
            ]
        ]);
    }
}
