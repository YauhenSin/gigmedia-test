<?php

namespace App\Http\Controllers;

use App\Http\Filters\PostFilter;
use App\Http\Resources\GetResponseResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostsController extends Controller
{
    public function index(Request $request, PostFilter $filter): JsonResource
    {
        return new GetResponseResource(
            Post::query()->filter($filter)->paginate($request->input('limit'))
        );
    }

    public function destroy(Post $post): JsonResponse
    {
        return new JsonResponse($post->delete());
    }
}
