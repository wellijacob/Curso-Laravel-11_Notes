<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Parser\Value;
use Illuminate\Http\Request;

class MainController extends Controller
{

     public function index()
     {
          // Carrega as notas do usuário
          $id = session('user.id');
          $user = User::find($id)->toArray();
          $notes = User::find($id)->notes()->get()->toArray();

          echo '<pre>';
          print_r($user);
          print_r($notes);
          echo '</pre>';

          die();

          // Exibe a pagina inicial
          return view('home');
     }

     public function newNote()
     {
          echo "New Note";
     }
}
