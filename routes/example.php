Route::get('/articles', [ArticleController::class,'index']);

Route::get('/articles/detail/{id}', [ArticleController::class, 'detail']);

Route::get('/', [ArticleController::class,'index']);

Route::get('/articles/add', [ArticleController::class, 'add']);

Route::post('/articles/add', [ArticleController::class, 'create']);

Route::get('/articles/delete/{id}', [ArticleController::class, 'delete']);

Route::post('/comments/add', [CommentController::class, 'create']);


Route::get('/comments/delete/{id}',[ CommentController::class, 'delete']);

Route::get('/articles/edit/{id}', [ArticleController::class, 'edit']);

Route::post('/articles/edit/{id}', [ArticleController::class, 'update']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');