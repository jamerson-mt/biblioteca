<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request) // Apenas um parâmetro
    {
        // Valida o comentário
        $request->validate([
            'comment' => 'required|string|max:255',
            'book_id' => 'required|exists:books,id',
        ]);

        // Cria um novo comentário
        Comment::create([
            'book_id' => $request->book_id,
            'comment' => $request->comment,
            // Se não estiver utilizando autenticação, você pode omitir 'user_id'
        ]);

        return redirect()->back()->with('success', 'Comentário adicionado com sucesso!');
    }
}
