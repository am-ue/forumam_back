<?php

Route::resource('companies', 'CompanyController', ['only' => ['index', 'show']]);
