<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request) {
        $book  = Book::create($this->validateRequest($request));
        return $book->toJson();
    }

    public function update(Request $request, Book $book) {

        $book->update($this->validateRequest($request));

        return $book->toJson();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function validateRequest(Request $request): array
    {
        return $request->validate([
            'title' => 'required',
            'author' => 'required',
        ]);
    }


}
