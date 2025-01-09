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
        echo 'I`m creating a new note!';
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
