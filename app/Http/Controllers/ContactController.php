<?php

namespace App\Http\Controllers;

use App\Events\ContactCreated;
use App\Events\ContactUpdated;
use App\Events\ContactDeleted;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        $trashed = Contact::onlyTrashed()->get();
        return view('contacts.index', compact(['contacts', 'trashed']));
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:contacts',
            'contact_number' => 'required',
            'address' => 'required',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $contact = new Contact($validated_data);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $contact->avatar = $avatarPath;
        }

        $contact->save();

        event(new ContactCreated($contact));

        return redirect()->route('contacts.index');
    }

    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validated_data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:contacts,email,' . $contact->id,
            'contact_number' => 'required',
            'address' => 'required',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('avatar')) {
            if ($contact->avatar) {
                Storage::delete('public/' . $contact->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated_data['avatar'] = $avatarPath;
        }

        $contact->update($validated_data);

        event(new ContactUpdated($contact));

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        event(new ContactDeleted($contact));
        
        return redirect()->route('contacts.index');
    }

    public function restore($id)
    {
        $contact = Contact::withTrashed()->findOrFail($id);
        $contact->restore();

        return redirect()->route('contacts.index');
    }
}
