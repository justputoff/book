<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('landing', compact('books'));
    }
}
