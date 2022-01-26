<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Food\Application\UseCases\ListFoodsUseCase;
use Src\Food\Domain\Contracts\FoodRepositoryContract;

class FoodController extends Controller
{
    private FoodRepositoryContract $repository;

    public function __construct(FoodRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function index(): JsonResponse
    {
        $useCase = new ListFoodsUseCase($this->repository);
        $foods = $useCase();

        return response()->json((array) $foods->value());
    }
}
