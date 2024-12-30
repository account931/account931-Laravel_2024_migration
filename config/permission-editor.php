<?php
//setting from package https://github.com/LaravelDaily/laravel-permission-editor. Since we dont use it, can be deleted
return [
    'middleware' => ['web', 'spatie-permission',],  //added 'auth' to keep for logged users only
];
