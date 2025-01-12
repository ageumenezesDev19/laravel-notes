<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $id = session('user.id');

        if (!$id) {
            return redirect()->route('login')->with('error', 'Please log in.');
        }

        $notes = User::find($id)
            ->notes()
            ->whereNull('deleted_at')
            ->get()
            ->toArray();

        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        return view('new_note');
    }

    public function newNoteSubmit(Request $request)
    {
        $request->validate(
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],
            [
                'text_title.required' => 'The title is required',
                'text_title.min' => 'The title requires at least :min characters',
                'text_title.max' => 'The title can have only a maximum of :max characters',
                'text_note.required' => 'The note is required',
                'text_note.min' => 'The note requires at least :min characters',
                'text_note.max' => 'The note can have only a maximum of :max characters',
            ]
        );

        $id = session('user.id');

        if (!$id) {
            return redirect()->route('login')->with('error', 'Please log in.');
        }

        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        return redirect()->route('home');
    }

    public function editNote($id)
    {
        $id = Operations::decryptedId($id);

        if($id === null) {
            return redirect()->route('home');
        }

        $note = Note::find($id);

        return view('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(Request $request)
    {
        $request->validate(
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],
            [
                'text_title.required' => 'The title is required',
                'text_title.min' => 'The title requires at least :min characters',
                'text_title.max' => 'The title can have only a maximum of :max characters',
                'text_note.required' => 'The note is required',
                'text_note.min' => 'The note requires at least :min characters',
                'text_note.max' => 'The note can have only a maximum of :max characters',
            ]
        );

        $id = session('user.id');

        if (!$id) {
            return redirect()->route('login')->with('error', 'Please log in.');
        }

        if (!$request->note_id) {
            return redirect()->route('home')->with('error', 'Invalid note ID.');
        }

        $noteId = Operations::decryptedId($request->note_id);

        if($id === null) {
            return redirect()->route('home');
        }

        $note = Note::find($noteId);

        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        return redirect()->route('home')->with('success', 'Note updated successfully.');
    }
    public function deleteNote($id)
    {
        $id = Operations::decryptedId($id);

        if($id === null) {
            return redirect()->route('home');
        }

        $note = Note::find($id);

        return view('delete_note', ['note' => $note]);
    }

    public function deleteNoteConfirm($id)
    {
        $id = Operations::decryptedId($id);

        if($id === null) {
            return redirect()->route('home');
        }

        $note = Note::find($id);

        // Hard delete:
        // $note->delete();

        // Soft delete:
        // $note->deleted_at = date('Y-m-d H:i:s');
        // $note->save();

        // Soft delete 2 (property in model):
        $note->delete();

        return redirect()->route('home');
    }
}
