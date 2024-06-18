<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Renderable
{
    public function __construct(
        private Throwable $e,
        private Request $request,
    ){}

    public function composeErrorResponse(): JsonResponse
    {
        return match (get_class($this->e)) {
            NotFoundHttpException::class => $this->notFoundException(),
            ValidationException::class => $this->validationException(),
            default => $this->defaultException(),
        };
    }

    private function notFoundException(): JsonResponse
    {
        return response()->json([
            'errors' => [
                [
                    'status' => $this->e->getStatusCode(),
                    'title' => 'Resource not found',
                ],
            ],
        ], $this->e->getStatusCode());
    }

    private function validationException(): JsonResponse
    {
        $errors = [];
        foreach ($this->e->validator->errors()->messages() as $field => $values) {
            $errors = array_merge($errors, array_map(fn ($message) => [
                'status' => $this->e->status,
                'source' => ['pointer' => $field],
                'detail' => $message,
            ], $values));
        }
        return response()->json([
            'errors' => $errors,
        ], $this->e->status);
    }

    private function defaultException(): JsonResponse
    {
        return response()->json([
            'errors' => [
                [
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'title' => $this->e->getMessage(),
                ],
            ],
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
