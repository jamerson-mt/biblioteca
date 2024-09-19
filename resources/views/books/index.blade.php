@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de livros</h1>
    <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Adicionar Nova livro</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>imagem</th>
                <th>title</th>
                <th>nome author</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
            <tr>

                <td><img src="{{ Storage::url($book->image_url) }}" alt="Capa do Livro">
                </td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection