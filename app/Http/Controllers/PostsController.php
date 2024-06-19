<?php

namespace App\Http\Controllers;

use App\Http\Filters\PostFilter;
use App\Http\Resources\GetResponseResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\Response;

class PostsController extends Controller
{
    #[Endpoint('View all posts')]
    #[QueryParam('limit', 'int', 'Number of items per page', required: false, example: 3)]
    #[QueryParam('page', 'int', 'Page number', required: false, example: 2)]
    #[QueryParam('id', 'int', 'Filter: id (strict)', required: false, example: 1)]
    #[QueryParam('topic', 'string', 'Filter: topic (partial)', required: false, example: 'minus')]
    #[QueryParam('comment', 'string', 'Filter: returns posts that have one or multiple comments that contain the word (partial)', required: false, example: 'laughing')]
    #[QueryParam('created_at', 'string', 'Filter: created at date (partial)', required: false, example: '2024-06-19')]
    #[QueryParam('updated_at', 'string', 'Filter: comment (partial)', required: false, example: '2024-06-19')]
    #[QueryParam('with', 'string', 'Including relational data', required: false, example: 'No-example', enum: ['comments'])]
    #[Response([
        'result' => [
            [
                'id' => 2,
                'topic' => 'Eum et minus soluta aliquam.',
                'created_at' => '2024-06-19T17:29:09.000000Z',
                'updated_at' => '2024-06-19T17:29:09.000000Z',
                'comments' => [
                    [
                        'id' => 2055,
                        'post_id' => 2,
                        'content' => 'cool funny laughing nice awesome great horrible',
                        'abbreviation' => 'cflnagh',
                        'created_at' => '2024-06-19T17:29:09.000000Z',
                        'updated_at' => '2024-06-19T17:29:09.000000Z',
                    ],
                ],
            ]
        ],
        'count' => 1,
    ])]
    public function index(Request $request, PostFilter $filter): JsonResource
    {
        return new GetResponseResource(
            Post::query()->filter($filter)->paginate($request->input('limit'))
        );
    }

    #[Endpoint('Delete a post')]
    #[Response("true")]
    #[Response([
        'errors' => [
            [
                'status' => 404,
                'title' => 'Resource not found',
            ]
        ],
    ], 404)]
    public function destroy(Post $post): JsonResponse
    {
        return new JsonResponse($post->delete());
    }
}
