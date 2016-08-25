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
    return [
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'email'          => $faker->safeEmail,
        'phone'          => $faker->phoneNumber,
        'role'           => $faker->jobTitle,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'company_id'     => rand(2, 10),
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
        'category_id'     => rand(1, 4),
        'active'          => rand(0, 1),
        'public'          => rand(0, 1),
    ];
});

$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    return [
        'type'        => ['article', 'video'][$video = rand(0,1)],
        'title'       => $faker->words(3, true),
        'description' => $faker->paragraph,
        'youtube_id'  => $video ? str_random(6) : null,
        'img'     => $video ? null :'/img/ue/square_logo.png',
        'company_id' => array_rand([\App\Models\Company::pluck('id')->random(), null])
    ];
});