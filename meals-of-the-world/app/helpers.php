<?php

if (! function_exists('faker_translation')) {
    function faker_translation($property = 'name', $functionName) 
    {
        $propertyArray= array();
        $faker = \Faker\Factory::create(); 
        $locales=config('translatable.locales');
        $fakerLocales= config('translatable.faker_locales');

        foreach ($locales as $locale) {
            if (array_key_exists($locale, $fakerLocales)) {
                $className = "FakerRestaurant\\Provider\\{$fakerLocales[$locale]}\\Restaurant";
                $faker->addProvider(new $className($faker));
                $propertyArray[$locale] = [
                    $property => $faker->$functionName
                ];
            }
        }
        return $propertyArray;
    }
}

        // $fakerLocales = config('translatable.faker_locales');
        // $propertyArray= array();
        // return collect(config('translatable.locales'))
        // ->map(function ($locale, $key) use ($property, $functionName, $fakerLocales) {
        //     $className = "FakerRestaurant\\Provider\\{$fakerLocales[$locale]}\\Restaurant";
        //     $faker = \Faker\Factory::create();
        //     $faker->addProvider(new $className($faker));
        //     return [
        //         $propertyArray[$locale] = [
        //             $property => $faker->$functionName
        //         ]
        //     ];
        // })
        // ->toArray();

        // return [
        //     'title' => [
        //         'en' => $faker->foodName(),
        //         'it' => $faker->foodName(),
        //     ],   
        // ];
