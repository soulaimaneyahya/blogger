<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserCommentController;
use App\Http\Controllers\Api\V1\BlogPostCommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->name('api.v1.')->group(function(){
    Route::get('status', function(){
        return response()->json([
            'status' => 200
        ]);
    })->name('status');

    Route::apiResource('blog_posts.comments', BlogPostCommentController::class);
    Route::apiResource('users.comments', UserCommentController::class);
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Not found'
    ], 404);
})->name('api.fallback');
