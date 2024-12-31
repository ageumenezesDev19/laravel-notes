<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;

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
}
