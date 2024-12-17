<?php

return [
    'middleware' => ['auth', 'web', 'spatie-permission',],  //added 'auth' to keep for logged users only
];
