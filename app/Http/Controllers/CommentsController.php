<?php

namespace App\Http\Controllers;

use App\Http\Filters\CommentFilter;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\GetResponseResource;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentsController extends Controller
{
    public function index(Request $request, CommentFilter $filter): JsonResource
    {
        return new GetResponseResource(
            Comment::query()->filter($filter)->paginate($request->input('limit'))
        );
    }

    public function destroy(Comment $comment): JsonResponse
    {
        return new JsonResponse($comment->delete());
    }

    public function store(StoreCommentRequest $request): Model
    {
        return Comment::query()->create($request->validated());
    }
}
