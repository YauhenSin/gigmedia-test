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
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\Response;

class CommentsController extends Controller
{
    #[Endpoint('View all comments')]
    #[QueryParam('limit', 'int', 'Number of items per page', required: false, example: 3)]
    #[QueryParam('page', 'int', 'Page number', required: false, example: 2)]
    #[QueryParam('id', 'int', 'Filter: id (strict)', required: false, example: 1)]
    #[QueryParam('content', 'string', 'Filter: content (partial)', required: false, example: 'cool funny')]
    #[QueryParam('abbreviation', 'string', 'Filter: abbreviation (partial)', required: false, example: 'cf')]
    #[QueryParam('post', 'string', 'Filter: returns comments that have post that contain the word (partial)', required: false, example: 'post content')]
    #[QueryParam('created_at', 'string', 'Filter: created at date (partial)', required: false, example: '2024-06-19')]
    #[QueryParam('updated_at', 'string', 'Filter: comment (partial)', required: false, example: '2024-06-19')]
    #[QueryParam('with', 'string', 'Including relational data', required: false, enum: ['post'])]
    #[Response([
        'result' => [
            [
                'id' => 2055,
                'post_id' => 5,
                'content' => 'cool funny laughing nice awesome great horrible',
                'abbreviation' => 'cflnagh',
                'created_at' => '2024-06-19T17:29:09.000000Z',
                'updated_at' => '2024-06-19T17:29:09.000000Z',
                'post' => [
                    'id' => 5,
                    'topic' => 'Eum et minus soluta aliquam.',
                    'created_at' => '2024-06-19T17:29:09.000000Z',
                    'updated_at' => '2024-06-19T17:29:09.000000Z',
                ],
            ]
        ],
        'count' => 1,
    ])]
    public function index(Request $request, CommentFilter $filter): JsonResource
    {
        return new GetResponseResource(
            Comment::query()->filter($filter)->paginate($request->input('limit'))
        );
    }

    #[Endpoint('Delete a comment')]
    #[Response("true")]
    #[Response([
        'errors' => [
            [
                'status' => 404,
                'title' => 'Resource not found',
            ]
        ],
    ], 404)]
    public function destroy(Comment $comment): JsonResponse
    {
        return new JsonResponse($comment->delete());
    }

    #[Endpoint('Create a comment')]
    #[BodyParam('post_id', 'int', 'The ID of the post.', required: true, example: 1)]
    #[BodyParam('content', 'string', 'Content.', required: true, example: 'nice awesome great')]
    #[BodyParam('abbreviation', 'string', 'Short (unique) version of the content. Generates automatically. Ignored if sent.', required: false, example: 'No-example')]
    #[Response([
        'id' => 2055,
        'post_id' => 1,
        'content' => 'nice awesome great',
        'abbreviation' => 'nag',
        'created_at' => '2024-06-19T17:29:09.000000Z',
        'updated_at' => '2024-06-19T17:29:09.000000Z',
    ], 201)]
    #[Response([
        'errors' => [
            [
                'status' => 422,
                'source' => [
                    'pointer' => 'post_id',
                ],
                'detail' => 'The selected post id is invalid.',
            ],
            [
                'status' => 422,
                'source' => [
                    'pointer' => 'abbreviation',
                ],
                'detail' => 'The abbreviation generated for the specified content already exists.',
            ],
        ],
    ], 422)]
    public function store(StoreCommentRequest $request): Model
    {
        return Comment::query()->create($request->validated());
    }
}
