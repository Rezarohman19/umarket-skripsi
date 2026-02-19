<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All application API logic has been moved to routes/web.php under the 
| 'api' prefix to ensure perfect session synchronization and authentication 
| in local development environments.
|
*/

Route::get('/ping', function () {
    return response()->json(['message' => 'API stack is alive but logic moved to web.php']);
});
