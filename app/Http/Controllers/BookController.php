<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return response()->json($books, 200);
    }

    public function show(Book $book)
    {
        return response()->json($book, 200);
    }

    public function create(Request $request) 
    {
        $validator = Validator::make($request->all(), [ 
            'title' => 'required', 
            'description' => 'required'
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 422);         
        } else {
            $input = $validator->valid();

            $query = DB::table('books')->where('title', $input['title'])->first();

            if($query == null) {
                $book = Book::create([
                    'title' => $input['title'],
                    'description' => $input['description']
                ]);
    
                return response()->json($book, 201);
            } else {
                return response()->json(['error'=> "No se puede insertar"], 422);         
            }
        } 
    }
}
