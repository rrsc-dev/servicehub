<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Ticket;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Str;
use App\Jobs\ProcessTicketAttachment;
use Illuminate\Support\Facades\Gate;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with(['project', 'user', 'creator'])->orderBy('id', 'desc')->get();
        
        return Inertia::render('Ticket/Index', [
            'tickets' => $tickets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Ticket/Create', [
            'projects' => Project::orderBy('name')->get(['id', 'name']),
            'users' => User::orderBy('name')->get(['id', 'name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:json,txt|max:4096',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('ticket_attachments');
        }
        
        $ticket = Ticket::create([
            'project_id' => $validated['project_id'],
            'created_by' => auth()->id(),
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => 1
        ]);

        $detail = $ticket->detail()->create([
            'attachment_path' => $path,
            'more_information' => [],
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
        ]);

        if ($path) {
            ProcessTicketAttachment::dispatch($detail);
        }

        return redirect()->route('tickets.show', $ticket->id)->with('message', 'Ticket aberto com sucesso! O anexo foi enviado para a fila.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ticket = Ticket::with(['project.company', 'creator', 'user', 'detail'])->findOrFail($id);
        
        $canEdit = (auth()->id() == $ticket->created_by || auth()->id() == $ticket->user_id);

        return Inertia::render('Ticket/Show', [
            'ticket' => $ticket,
            'canEdit' => $canEdit
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        abort_if(auth()->id() != $ticket->created_by && auth()->id() != $ticket->user_id, 403, 'Ação não autorizada.');

        return Inertia::render('Ticket/Edit', [
            'ticket' => $ticket->load('detail'),
            'projects' => Project::orderBy('name')->get(['id', 'name']),
            'users' => User::orderBy('name')->get(['id', 'name'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        abort_if(auth()->id() != $ticket->created_by && auth()->id() != $ticket->user_id, 403, 'Ação não autorizada.');

        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:json,txt|max:4096',
            'status' => 'required|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('ticket_attachments');
        }

        $ticket->update([
            'project_id' => $validated['project_id'],
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status']
        ]);

        $ticket->detail()->update([
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
        ]);

        if ($path) {
            ProcessTicketAttachment::dispatch($detail);
        }

        return redirect()->route('tickets.show', $ticket->id)->with('message', 'Ticket atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        abort_if(auth()->id() != $ticket->created_by && auth()->id() != $ticket->user_id, 403, 'Ação não autorizada.');
        $ticket->delete();

        return redirect()->route('tickets.index')->with('message', 'Ticket excluído com sucesso!');
    }
}
