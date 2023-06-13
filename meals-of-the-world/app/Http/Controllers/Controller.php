<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealRequest;
use App\Services\MealService;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    private $mealService;

    public function __construct(MealService $mealService)
    {
        $this->mealService = $mealService;    
    }

    public function getMealsData(MealRequest $request)
    {
        $data = $this->mealService->getMealsData($request);

        $jsonResponse = new JsonResponse($data, 200, [], JSON_PRETTY_PRINT);
        return $jsonResponse;

    }
}

