<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{
    public function index() 
{
    $id = session('user.id');
        $notes = User::find($id)
                    ->notes()
                    ->whereNull('deleted_at')
                    ->get()
                    ->toArray();

        // show home view
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

        echo "I`m editing a note with id = $id!";
    }

    public function deleteNote($id)
    {
        $id = Operations::decryptedId($id);

        echo "I`m deleting a note with id = $id!";
    }
}
