<?php

/*
|--------------------------------------------------------------------------
| LARAVEL ELOQUENT - SAVING PHP DEVELOPERS SINCE 2011
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('book_create', function(){

   echo "Creating the records....";

   $title = 'Eze goes to College';
   $pages_count = 800;
   $price = 15.5;
   $description = 'This is a very interesting book about Eze going to College and killing it';
   $author_id = 1;
   $publisher_id = 1;

    // Method 1 of inserting records into the database via a Model - Mass Assignment
    $book = new \App\Book([
       'title' => $title,
       'pages_count' => $pages_count,
       'price' => $price,
       'description' => $description,
       'author_id' => $author_id,
       'publisher_id' => $publisher_id
    ]);
    $book->save(); // You have to call the save method here if using Method 1 technique


    // Use either of them to insert records into the database
    // For security issues it won't allow you create those records just like that, so...
    // Make sure you have properties $fillable or $guarded in your Model
    // e.g protected $fillable  = ['title','pages_count','price','description','author_id','publisher_id']

    // Method 2 of inserting records into the database via a Model - Mass Assignment
    $book = \App\Book::create([
       'title' => $title,
       'price' => $price,
       'pages_count' => $pages_count,
       'description' => $description,
       'author_id' => $author_id,
       'publisher_id' => $publisher_id
    ]);

    echo "Done....";

});

Route::get('book_get_all', function(){
       return \App\Book::all();
});

Route::get('book_get_2', function(){
       return \App\Book::findOrFail(2);
});

Route::get('book_get_3', function(){
       $results = \App\Book::find(3);
       echo $results;
});

Route::get('book_get_where', function(){
         $result = \App\Book::where('pages_count', '<', 1000)->get();
         return $result;
});

Route::get('book_get_where_first', function(){
         $result = \App\Book::where('pages_count', '<', 1000)->first();
         return $result;
});

Route::get('book_get_where_chained', function(){
         $result = \App\Book::where('pages_count', '<', 1000)
                 ->where('title', '=', 'My First Book!')
                 ->get();
         return $result;
});

Route::get('book_get_where_iterate', function(){
         $results = \App\Book::where('pages_count', '<', 1000)->get();
         if(count($results) > 0)
         {
           foreach($results as $book){
               echo 'Book: ' . $book->title . ' - Pages:
               ' . $book->pages_count . ' <br/>';
            }
        }
        else
           echo 'No Results!';
         return '';
});

Route::get('book_update', function() {
     $book = \App\Book::find(3);
     $book->title = 'My Updated First Book!';
     $book->pages_count = 150;
     $book->save();
});

Route::get('book_delete_3', function() {
    $result = \App\Book::find(3)->delete();
    return $result;
});

Route::get('book_get_where_complex', function(){
     $results = \App\Book::where('title', 'LIKE', '%ook%')
             ->orWhere('pages_count', '>', 190)
             ->get();
     return $results;
});

Route::get('book_get_where_more_complex', function(){
     $results = \App\Book::where(function($query){
                        $query->where('pages_count', '>', 120)->where('title', 'LIKE', '%Book%');
                 })->orWhere(function($query){
                        $query->where('pages_count', '<', 200)->orWhere('description', '=', '');
                 })->get();

    return $results;
});

Route::get('book_get_whereBetween', function(){
    $results = \App\Book::whereBetween('pages_count', [170, 200])->get();

    return $results;
});

// Return all results that have title that exist in this array
Route::get('book_get_whereIn', function(){
    $results = \App\Book::whereIn('title', ['My Third Book!','My Second Book!'])->get();

    return $results;
});

// Fetching all records with the where clause in conjunction with a column Name a.k.a magic Where
Route::get('book_get_whereColumnName', function(){
    $results = \App\Book::whereTitle('My Fourth Book!')->get();

    return $results;
});

// Return all books that dont exist. .ie books that have the title column as NULL
Route::get('book_get_whereNull', function() {
   $results = \App\Book::whereNull('title')->get();

   return $results;
});

/**
 * AGGREGATES
 */
// Get the number of books in the database
Route::get('book_get_books_count', function(){
    $booksCount = \App\Book::count();

    return $booksCount;
});

// Get the number of books that have page count greater than 140
Route::get('book_get_bookPages_count', function(){
    $booksCount = \App\Book::where('pages_count', '>', 140)->count();

    return $booksCount;
});

// Get the minimum number of pages i.e books with pages above 120, at least ..but the minimum this
// will return 122
Route::get('book_get_books_min_pages_count', function(){
     $minPagesCount = \App\Book::where('pages_count', '>', 120)->min('pages_count');

     return $minPagesCount;
});

// Get the maximum number of pages i.e  books with pages above 120, return the highest number of pages
// this will return 200
Route::get('book_get_books_max_pages_count', function(){
     $maxPagesCount = \App\Book::where('pages_count', '>', 120)->max('pages_count');

     return $maxPagesCount;
});

// Get the average price of all the books
Route::get('book_get_books_avg_price', function(){
   $avgPrice = \App\Book::where('title', 'LIKE', '%Book%')->avg('price');

    return $avgPrice;
});

// Get the sum of all pages of books that have pages count greater than 170
Route::get('book_get_books_sum_price', function(){
   $countTotal = \App\Book::where('pages_count', '>', 170)->sum('pages_count');

   return $countTotal;
});

/**
 *  Utility Methods - Eager Loading Techniques. more gonna be added
 */
// Skip nothing and take 3 records
Route::get('book_skip_and_take', function(){

    $books = \App\Book::skip(0)->take(2)->get();

    return $books;
});

// Skip the first two records and take the next 3 records
Route::get('book_skip_and_take_again', function(){

    $books = \App\Book::skip(2)->take(3)->get();

    return $books;
});

// Order the books in ascending order according to their title, `desc` is also an alternative
Route::get('book_orderBy', function(){

    $books = \App\Book::orderBy('title', 'asc')->get();

    return $books;
});

// Group the books by the price...e.g if 3 books have thesame price, it groups them together as one
Route::get('book_groupBy', function(){

    $books = \App\Book::groupBy('price')->get();

    return $books;
});

// Return all books that have pages_count less than 150
Route::get('book_having', function(){

    $books = \App\Book::having('pages_count', '<', 150)->get();

    return $books;
});

// Return all books including the ones that have been deleted
// Listen: this requires your migration already has $table->softDeletes();
// and your Model also uses the Eloquent SoftDeletes trait
Route::get('all_books_including_those_that_have_been_deleted', function(){
    $books = \App\Book::withTrashed()->get();

    return $books;
});

// Return only all the books that have been deleted
Route::get('only_deleted_books', function(){
    $books = \App\Book::onlyTrashed()->get();

    return $books;
});

// Restore a record that has been deleted provided you have the id
Route::get('restore_deleted_book', function(){
    $trashedBook = \App\Book::find($trashedBookId);
    $trashedBook->restore();
});

// Truly delete a record, I mean really really delete..I mean Bye Bye to the record
Route::get('truly_delete_a_record', function(){
    // $bookId refers to the id of the book you want to truly delete
    $book = \App\Book::find($bookId);
    $book->forceDelete();
});

/**
 *  Laravel Eloquent For Days: Query Scopes....Simple like Cake but Powerful as Hell
 */

/**
 * Laravel Eloquent For Days: Attributes Casting, Accessors and Mutators
 */

Route::get('book', function(){
    $book = \App\Book::find(7);

    return $book;
});

// Supported types for casting: integer, float, double, string, boolean, object and array



