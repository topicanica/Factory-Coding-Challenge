<?php

namespace App\Services;

use App\Http\Requests\MealRequest;
use App\Http\Resources\MealCollection;
use App\Models\Meal;
use App\Http\Resources\MealResource;
use App\Pagination\CustomPaginator;
use Illuminate\Pagination\LengthAwarePaginator;


class MealService
{
    public function filterMeals ($perPage , $page, $category, $tags, $with, $lang, $diffTime)
    {
        $query = Meal::query();

        // Filter by category
        if ($category !== null) {
            if ($category === 'NULL') {
                $query->whereNull('category_id');
            } elseif ($category === '!NULL') {
                $query->whereNotNull('category_id');
            } else {
                $query->where('category_id', $category);
            }
        }
        //echo("<script>console.log('PHP: " . json_encode($query->get()) . "');</script>");

        // Filter by tags
        if ($tags !== null) {
            $tagIds = explode(',', $tags);
            $query->whereIn('id', function ($innerQuery) use ($tagIds) {
                $innerQuery->select('meal_id')
                    ->from('meal_tag')
                    ->whereIn('tag_id', $tagIds);
            });
        }

        // Additional information in the response
        if ($with !== null) {
            $withKeywords = explode(',', $with);
            $query->with($withKeywords);
        }

        // Change meal status by provided diffTime
        if ($diffTime > 0) {
            $query->withTrashed()
                ->where(function ($query) use ($diffTime) {
                    $query->where('created_at', '>', now()->subMinutes($diffTime))
                        ->update(['status' => 'created']);
                })
                ->orWhere(function ($query) use ($diffTime) {
                    $query->where('updated_at', '>', now()->subMinutes($diffTime))
                        ->update(['status' => 'modified']);
                })
                ->orWhere(function ($query) use ($diffTime) {
                    $query->where('deleted_at', '>', now()->subMinutes($diffTime))
                        ->update(['status' => 'deleted']);
                });

        }
        return $query;
    }
    public function getMealsData(MealRequest $request)
    {
        $validatedData = $request->validated();

        $perPage = $validatedData['per_page'] ?? 10;
        $page = $validatedData['page'] ?? 1;
        $category = $validatedData['category'] ?? null;
        $tags = $validatedData['tags'] ?? null;
        $locale = $validatedData['lang'];
        $with = $validatedData['with'] ?? null;
        $diffTime = $validatedData['diff_time'] ?? null;
  
        app()->setLocale($locale);
        
        $data = $this->filterMeals($perPage, $page, $category, $tags, $with, $locale, $diffTime);
        return new CustomPaginator(
            $data->get(),
            count($data->get()),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
    }
}
