<?php

namespace App\Services;

use App\Http\Requests\MealRequest;
use App\Models\Meal;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class MealService
{
    public function getMealsByIds($mealIds, $with)
    {
        $query = Meal::query();
        if (!empty($with)) {
            $relationships = explode(',', $with);
            $query->with($relationships);
        }
        if (!empty($mealIds)) {
            $query->whereIn('id', $mealIds);
        }
        return $query;
    }

    public function filterMealsByCategoryId($category)
    {
        return Meal::when($category, function ($query) use ($category) {
            return $query->whereHas('category', function ($query) use ($category) {
                $query->where('category_id', $category);
            });
        });
    }

    public function filterMealsByTagsIds($tags, $locale)
    {
        $query = Meal::query();
        if ($tags !== null) {
            $tags = (array) $tags;

            $query->whereIn('id', function ($innerQuery) use ($tags) {
                $innerQuery->select('meal_id')
                    ->from('meal_tag')
                    ->whereIn('tag_id', $tags);
            });
        }
        return $query;
    }

    public function attachRelationships($with, $query)
    {
        return $query->when($with, function ($query) use ($with) {
            $relationships = explode(',', $with);
            return $query->with($relationships);
        });
    }

    public function filterMealsByDiffTime($diffTime, $query)
    {
        $modifiedIds = [];
        if ($diffTime > 0) {
            $query->withTrashed()
                ->where(function ($query) use ($diffTime, &$modifiedIds) {
                    $query->where('created_at', '>', now()->subMinutes($diffTime))
                        ->update(['status' => 'created']);
                    $modifiedIds = $query->pluck('id')->toArray();
                })
                ->orWhere(function ($query) use ($diffTime, &$modifiedIds) {
                    $query->where('updated_at', '>', now()->subMinutes($diffTime))
                        ->update(['status' => 'modified']);
                    $modifiedIds = $query->pluck('id')->toArray();
                })
                ->orWhere(function ($query) use ($diffTime, &$modifiedIds) {
                    $query->where('deleted_at', '>', now()->subMinutes($diffTime))
                        ->update(['status' => 'deleted']);
                    $modifiedIds = $query->pluck('id')->toArray();
                });

            $modifiedIds = $query->pluck('id')->toArray();
        }
        return $modifiedIds;
    }

    public function collectSameNumbers($array1, $array2)
    {
        $intersect = empty($array1) ? $array2 : (empty($array2) ? $array1 : array_intersect($array1, $array2));
        return array_values($intersect);
    }

    public function getMealsData(MealRequest $request)
    {
        $validatedData = $request->validated();

        $perPage = $validatedData['per_page'] ?? null;
        $page = $validatedData['page'] ?? null;
        $category = $validatedData['category'] ?? [];
        $tags = $validatedData['tags'] ?? [];
        $locale = $validatedData['lang'];
        $with = $validatedData['with'] ?? null;
        $diffTime = $validatedData['diff_time'] ?? null;

        app()->setLocale($locale);
        $mealCategory = $this->filterMealsByCategoryId($category)->get()->pluck('id')->toArray();
        $mealTags = $this->filterMealsByTagsIds($tags, $locale)->get()->pluck('id')->toArray();
        $mealIds = $this->collectSameNumbers($mealCategory, $mealTags);
        $query = $this->getMealsByIds($mealIds, $with);
    
        if ($diffTime > 0) {
            $modifiedMeals = $this->filterMealsByDiffTime($diffTime, clone $query);
            $query = $query->get()->concat($modifiedMeals);
        }
    
        $perPage = $perPage ?? 10;
        $page = $page ?? 1;
    
        $offset = ($page - 1) * $perPage;
        $items = $query->slice($offset, $perPage)->all();
    
        $data = new LengthAwarePaginator(
            $items,
            count($query),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );
    
        return $data;
    }
}
