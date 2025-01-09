<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
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
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect('home');
        }

        echo "I`m editing a note with id = $id!";
    }

    public function deleteNote($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect('home');
        }

        echo "I`m deleting a note with id = $id!";
    }
}
