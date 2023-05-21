<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Symfony\Component\HttpFoundation\JsonResponse;


class CommentsController extends Controller
{
    public function getCommentsByBriefcase($id)
    {
        $comments = Comment::where('briefcase', $id)->get();

        return new JsonResponse([
            'status' => 'success',
            'data' => ['comments' => $comments]
        ], 200);
    }


    public function createComment(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'briefcase' => 'required|integer',
        ]);

        try {
            Comment::create(array_merge(
                $request->all(),
                ['created_by' => auth()->user()->id]
            ));

            return response()->json([
                'status' => 'success',
                'message' => 'Comentario agregado con éxito'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el comentario: ' . $e->getMessage()
            ]);
        }
    }
}
