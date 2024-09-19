<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Função para exibir uma lista de livros
    public function index()
    {
        $books = Book::with(['author', 'publisher', 'categories'])->get();
        return view('books.index', compact('books'));
    }

    // Função para exibir um livro específico
    public function show($id)
    {
        $book = Book::with(['author', 'publisher', 'categories'])->findOrFail($id);
        return view('books.show', compact('book'));
    }

    // Função para exibir o formulário de criação de um novo livro
    public function create()
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('books.create', compact('authors', 'publishers', 'categories'));
    }

    // Função para armazenar um novo livro no banco de dados
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|integer',
            'publisher_id' => 'required|integer',
            'published_year' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'categories' => 'required|array',
        ]);
        // Instância do livro
        $book = new Book();
        $book->title = $request->input('title');
        $book->author_id = $request->input('author_id');
        $book->publisher_id = $request->input('publisher_id');
        $book->published_year = $request->input('published_year');
     

        // Verifica se há uma imagem no request
        if ($request->file('image')) {
            // Armazena a imagem no diretório 'uploads' dentro de 'storage/app/public'
            $imagePath = $request->file('image')->store('uploads', 'public');
            $book->image_url = $imagePath;  // Salva o caminho da imagem no banco
        }

        // Salva o livro no banco de dados
        $book->save();

        // Redireciona de volta com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Livro cadastrado com sucesso!');
    }

    // Função para exibir o formulário de edição de um livro
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'publishers', 'categories'));
    }

    // Função para atualizar um livro no banco de dados
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    }



    // Função para excluir um livro do banco de dados
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->categories()->detach();
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso!');
    }
}
