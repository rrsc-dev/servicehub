<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use Inertia\Inertia;
use App\Models\Project;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Project::with('company')->withCount('tickets');

        $projects = $query->orderBy('name')->get();

        return Inertia::render('Project/Index', [
            'projects' => $projects
        ]);
    }

    public function indexByCompany(Company $company, Request $request)
    {
        $query = $company->projects()->withCount('tickets');

        $projects = $query->orderBy('name')->withQueryString();

        return Inertia::render('Project/CompanyIndex', [
            'company' => $company,
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Project/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return Inertia::render('Project/Edit', [
            'project' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index');
    }
}
