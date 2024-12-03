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
          // Carrega as notas do usuário
          $id = session('user.id');
          $notes = User::find($id)
               ->notes()
               ->whereNull('deleted_at')
               ->get()
               ->toArray();

          // Exibe a pagina inicial
          return view('home', ['notes' => $notes]);
     }

     public function newNote()
     {
          return view('new_note'); // new_note.blade.php
     }

     public function newNoteSubmit(Request $request)
     {
          // validação dos dados
          $request->validate(
               // rules
               [
                    'text_title' => 'required|min:3|max:200',
                    'text_note' => 'required|min:3|max:3000',
               ],
               // messages
               [
                    'text_title.required' => 'O campo titulo é obrigatório',
                    'text_title.min' => 'O campo titulo deve ter pelo menos :min caracteres',
                    'text_title.max' => 'O campo titulo deve ter no máximo :max caracteres',
                    'text_note.required' => 'O campo nota é obrigatório',
                    'text_note.min' => 'O campo nota deve ter pelo menos :min caracteres',
                    'text_note.max' => 'O campo nota deve ter no máximo :max caracteres',
               ]
          );

          // get user id
          $id = session('user.id');

          // create new note
          $note = new Note();
          $note->user_id = $id;
          $note->title = $request->text_title;
          $note->text = $request->text_note;
          $note->save();

          // redirect
          return redirect()->route('home');
     }

     public function editNote($id)
     {

          $id = Operations::decryptId($id);

          // check if id is null
          if ($id === null) {
               return redirect()->route('home');
          }

          // loaded note
          $note = Note::find($id);

          // show edit note
          return view('edit_note', ['note' => $note]);
     }

     public function editNoteSubmit(Request $request)
     {
          // validação dos dados
          $request->validate(
               // rules
               [
                    'text_title' => 'required|min:3|max:200',
                    'text_note' => 'required|min:3|max:3000',
               ],
               // messages
               [
                    'text_title.required' => 'O campo titulo é obrigatório',
                    'text_title.min' => 'O campo titulo deve ter pelo menos :min caracteres',
                    'text_title.max' => 'O campo titulo deve ter no máximo :max caracteres',
                    'text_note.required' => 'O campo nota é obrigatório',
                    'text_note.min' => 'O campo nota deve ter pelo menos :min caracteres',
                    'text_note.max' => 'O campo nota deve ter no máximo :max caracteres',
               ]
          );

          // check if note_id is exists
          if ($request->note_id == null) {
               return redirect()->route('home');
          }

          // decrypt note_id
          $id = Operations::decryptId($request->note_id);

          // check if id is null
          if ($id === null) {
               return redirect()->route('home');
          }

          // load note
          $note = Note::find($id);

          // update note
          $note->title = $request->text_title;
          $note->text = $request->text_note;
          $note->save();

          //redirect note
          return redirect()->route('home');
     }

     public function deleteNote($id)
     {

          $id = Operations::decryptId($id);

          // check if id is null
          if ($id === null) {
               return redirect()->route('home');
          }

          // load note
          $note = Note::find($id);

          // show delete note
          return view('delete_note', ['note' => $note]);
     }

     public function deleteNoteConfirm($id)
     {
          // check if $id is encrypted
          $id = Operations::decryptId($id);

          // check if id is null
          if ($id === null) {
               return redirect()->route('home');
          }

          // load note
          $note = Note::find($id);

          // 1. hard delete
          //$note->delete();

          // 2. soft delete
          //$note->deleted_at = now();
          //$note->save();

          // 3. soft delete (property in model)
          $note->delete();

          // 4. hard delete (property in model)
          //$note->forceDelete();


          // redirect
          return redirect()->route('home');
     }
}
