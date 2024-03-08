<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $version = App::version();

    return response()->json(["Todo Backend Version" => $version]);
});
