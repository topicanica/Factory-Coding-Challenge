<?php

namespace App\Services;

use App\Http\Requests\MealRequest;
use App\Models\Meal;
use Carbon\Carbon;

class MealService {

    public function getMealsByIds($mealIds, $with)
    {
        $relationships = explode(',', $with);
        if (!empty($with)){
            if (empty($mealIds)) {
                return Meal::query()->with($relationships);
            }
            else {
                return Meal::whereIn('id', $mealIds)->with($relationships);
            }
        }
        if (empty($mealIds)) {
            return Meal::query();
        }
        else {
            return Meal::whereIn('id', $mealIds);
        }
    }
    
    public function filterMealsByCategoryId($category){
        return Meal::when($category, function ($query) use ($category) {
            return $query->whereHas('category', function ($query) use ($category) {
                $query->where('category_id', $category);
            });
        });
    }

    public function filterMealsByTagsIds($tags){
        return Meal::when($tags, function ($query) use ($tags) {
            return $query->whereHas('tags', function ($query) use ($tags) {
                if (is_array($tags)) {
                    return $query->whereIn('tags.id', $tags);
                } else {
                    return $query->where('tags.id', $tags);
                }
            });
        });
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
        if ($diffTime > 0) {
            $query->withTrashed()
                ->where(function ($query) use ($diffTime) {
                    $query->where('created_at', '>', now()->subMinutes($diffTime), function ($query) {
                        $query->update(['status' => 'created']);
                    })
                    ->orWhere('updated_at', '>', now()->subMinutes($diffTime), function ($query) {
                        $query->update(['status' => 'modified']);
                    })
                    ->orWhere('deleted_at', '>', now()->subMinutes($diffTime), function ($query) {
                        $query->update(['status' => 'deleted']);
                    });
                });
        }else {
            return $query;
        }
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
        $category = $validatedData['category'] ?? null;
        $tags = $validatedData['tags'] ?? null;
        $locale = $validatedData['lang'];
        $with = $validatedData['with'] ?? null;
        $diffTime = $validatedData['diff_time'] ?? null;
        
        app()->setLocale($locale);
        $mealCategory = $this->filterMealsByCategoryId($category)->pluck('id')->toArray();
        $mealTags = $this->filterMealsByTagsIds($tags)->pluck('id')->toArray();
        $mealIds = $this->collectSameNumbers($mealCategory, $mealTags);

        $response = $this->GetMealsByIds($mealIds,$with);        
        $data = $response->paginate($perPage ?? 10, ['*'], 'page', $page ?? 1);

        return $data;
    }
    
}