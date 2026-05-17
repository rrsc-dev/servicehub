<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Project;
use App\Models\Company;
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
        $companies = Company::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Project/Create', [
            'companies' => $companies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Project::create($validated);

        return redirect()->route('projects.index')->with('message', 'Projeto cadastrado com sucesso!');
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
        $companies = Company::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Project/Edit', [
            'project' => $project,
            'companies' => $companies
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $project->update($validated);

        return redirect()->back()->with('success', 'Projeto atualizado com sucesso!');
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
