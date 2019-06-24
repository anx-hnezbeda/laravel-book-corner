<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use CloudCreativity\LaravelJsonApi\Http\Controllers\JsonApiController;
use Illuminate\Http\JsonResponse;

/**
 * Class StatsController
 * @package App\Http\Controllers
 */
class StatsController extends JsonApiController {

	/**
	 * @return JsonResponse
	 */
	public function stats(): JsonResponse {
		$data = [
			'books_count' => Book::count(),
			'books_available_count' => Book::doesntHave( 'users' )->count(),
			'books_borrowed_count' => Book::whereHas( 'users' )->count(),
			'categories' => Category::select( 'id', 'name' )
			                                    ->withCount( [
				                                    'books',
				                                    'books_available',
				                                    'books_borrowed'
			                                    ] )
			                                    ->orderBy( 'books_count', 'DESC' )
			                                    ->get(),
			'tags' => Tag::select( 'id', 'name' )
			                         ->withCount( [ 'books', 'books_available', 'books_borrowed' ] )
			                         ->orderBy( 'books_count', 'DESC' )
			                         ->get(),
			'users' => User::select( 'id', 'name' )->withCount( 'books' )->has( 'books', '>', 0 )->orderBy( 'books_count', 'DESC' )->get(),
		];

		return response()->json( $data );
	}
}