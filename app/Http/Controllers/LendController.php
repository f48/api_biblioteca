<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Book;

class LendController extends Controller
{
    public function add(User $user, Book $book)
    {

        $lend = DB::table('lend')->where('user_id', $user->id)->where('book_id', $book->id)->first();

        if($lend == null){
            $user->lends()->attach($book);
            return response()->json("Ok", 200);
        } else {
            return response()->json(['error'=> "No se puede insertar"], 422);         
        }
    }
}
