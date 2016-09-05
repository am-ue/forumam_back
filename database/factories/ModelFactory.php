<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    $companies = \App\Models\Company::where('id', '!=', 1)->pluck('id');
    return [
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'email'          => $faker->safeEmail,
        'phone'          => $faker->phoneNumber,
        'role'           => $faker->jobTitle,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'company_id'     => $companies->isEmpty() ? 0 : $companies->random(),
    ];
});

$factory->define(App\Models\Company::class, function (Faker\Generator $faker) {
    return [
        'name'            => $faker->company,
        'website'         => $faker->url,
        'description'     => $faker->paragraph,
        'summary'         => $faker->sentence,
        'figures'         => $faker->paragraph,
        'staffing'        => $faker->paragraph,
        'profiles'        => $faker->paragraph,
        'more'            => $faker->paragraph,
        'logo'            => '/img/ue/square_logo_white.png',
        'stand'           => $faker->word,
        'billing_contact' => $faker->paragraph,
        'billing_address' => $faker->paragraph,
        'billing_delay'   => $faker->words(3, true),
        'billing_method'  => $faker->words(3, true),
        'category_id'     => \App\Models\Category::pluck('id')->random(),
        'active'          => rand(0, 1),
        'public'          => rand(0, 1),
    ];
});

$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    $youtube_ids = ['Flzg8GgfB1k', 'NW4a6AfwHPA', 'swVBfayw0xw', 'EEPfKWzHT6Y'];
    $company_ids = [\App\Models\Company::where('id', '!=', 1)->pluck('id')->random(), null];
    return [
        'type'        => ['article', 'video'][$video = rand(0,1)],
        'title'       => $faker->words(3, true),
        'description' => $faker->paragraph,
        'youtube_id'  => $video ? $youtube_ids[array_rand($youtube_ids)] : null,
        'img'     => $video ? null :'http://blog.collectifitem.com/wp-content/uploads/2012/12/01_01-HR1111_96851.jpg',
        'company_id' => $company_ids[array_rand($company_ids)],
    ];
});