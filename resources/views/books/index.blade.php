@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de livros</h1>
    <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Adicionar Novo Livro</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Imagem</th>
                <th>Título</th>
                <th>Nome do Autor</th>
                <th>Comentários</th> <!-- Adiciona uma nova coluna para comentários -->
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
            <tr>
                <td><img src="{{ Storage::url($book->image_url) }}" alt="Capa do Livro"></td>

                <td>{{ $book->title }}</td>
                <td>{{ $book->author->name }}</td>
                <td>
                    <!-- Seção de comentários -->
                    <div>
                        <h5>Comentários:</h5>
                        <ul>
                            @foreach ($book->comments as $comment) <!-- Acessa os comentários do livro -->
                            <li>{{ $comment->comment }}</li> <!-- Exibe o comentário -->
                            @endforeach
                        </ul>
                    </div>
                    <!-- Formulário para adicionar novo comentário -->
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <div class="form-group">
                            <textarea name="comment" class="form-control" rows="2" placeholder="Deixe seu comentário aqui..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-secondary btn-sm">Comentar</button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection