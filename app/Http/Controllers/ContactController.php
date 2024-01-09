<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('setting.contact.index', [
            'title' => 'Contact',
            'contacts' => Contact::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:60|unique:contacts,name',
            'type' => 'required',
            'description' => 'required|max:90|'
        ]);

        Contact::create([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description
        ]);

        return redirect('/setting/contacts')->with('success', 'Contact has been added');
    }

    public function edit($id)
    {
        // Fetch the contact based on the provided ID
        $contact = Contact::find($id);

        // Pass the retrieved contact to the view for editing
        return view('setting.contact.edit', [
            'title' => 'Edit Contact',
            'contact' => $contact
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:60,' . $id,
            'type' => 'required',
            'description' => 'required|max:90|'
        ]);

        $contact = Contact::find($id);

        $contact->update([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description
        ]);

        return redirect('/setting/contacts')->with('success', 'Contact has been updated');
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);
        $contact->delete();

        return redirect('/setting/contacts')->with('success', 'Contact has been deleted');
    }
}
