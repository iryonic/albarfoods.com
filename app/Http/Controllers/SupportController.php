<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('signin', ['redirect' => 'tickets']);
        }

        $tickets = SupportTicket::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('support.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'category' => 'required|string|in:Order Issue,Product Query,Payment Help,Other',
            'priority' => 'required|string|in:Low,Medium,High',
            'message' => 'required|string|min:10'
        ]);

        $ticketNumber = 'TKT-' . rand(100000, 999999);
        while (SupportTicket::where('ticket_number', $ticketNumber)->exists()) {
            $ticketNumber = 'TKT-' . rand(100000, 999999);
        }

        $ticket = SupportTicket::create([
            'user_id' => Auth::id(),
            'ticket_number' => $ticketNumber,
            'subject' => $request->subject,
            'category' => $request->category,
            'priority' => $request->priority,
            'status' => 'Open'
        ]);

        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Support ticket created successfully! Our customer support team will reply shortly.'
        ]);
    }

    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('signin');
        }

        $ticket = SupportTicket::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['replies.user', 'assignedAgent'])
            ->firstOrFail();

        return view('support.show', compact('ticket'));
    }

    public function reply(Request $request, $id)
    {
        if (!Auth::check()) {
            return back()->with('error', 'Unauthenticated.');
        }

        $request->validate([
            'message' => 'required|string|min:2'
        ]);

        $ticket = SupportTicket::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        // Auto-reopen ticket if it was closed or resolved
        if (in_array($ticket->status, ['Closed', 'Resolved'])) {
            $ticket->status = 'Open';
            $ticket->save();
        }

        return back()->with('success', 'Your message reply has been added successfully!');
    }
}
