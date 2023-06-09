<?php

if (! function_exists('faker_translation')) {
    function faker_translation($property, $functionName) 
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
