<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Contact;

class NoteController extends Controller
{
    public function store(Request $request, Contact $contact)
    {
        $request->validate([
            'content' => 'required',
        ]);
    
        $contact->notes()->create([
            'title' => $request->title,
            'note' => $request->content,
        ]);

        return redirect()->route('contacts.show', $contact->id);
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $note->title = $request->title;
        $note->note = $request->content;
        $note->save();

        return redirect()->back()->with('success', 'Note updated successfully.');
    }
}
