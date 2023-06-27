<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealRequest;
use App\Services\MealService;
use Illuminate\Routing\Controller as BaseController;

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
        return $data;
    }
}

