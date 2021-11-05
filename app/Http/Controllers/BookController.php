<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Resources\BookRresource;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookRresource::collection(Book::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'min:3|max:10',
            'body' => 'min:3|max:50'
        ]);
        $book = new Book();
        $book->title = $request->title;
        $book->body = $request->body;
        $book->author_id = $request->author_id;

        $book->save();
        return response()->json(['sms','Book Created Successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new BookRresource(Book::with('author')->findorfail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'min:3|max:10',
            'body' => 'min:3|max:50'
        ]);
        $book = Book::findorfail($id);
        $book->title = $request->title;
        $book->body = $request->body;
        $book->author_id = $request->author_id;

        $book->save();
        return response()->json(['sms','Book Updated Successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Book::destroy($id);
    }
}
