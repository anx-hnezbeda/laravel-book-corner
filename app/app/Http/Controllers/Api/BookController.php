<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

/**
 * Class BookController
 * @package App\Http\Controllers\Api
 */
class BookController extends BaseController {

	/**
	 * @param Request $request
	 *
	 * @return JsonResponse
	 */
	public function index( Request $request ): JsonResponse {

		$books = Book::all();

		return response()->json( $books );
	}

	/**
	 * @param Request $request
	 *
	 * @return JsonResponse
	 */
	public function store( Request $request ): JsonResponse {
		$book = Book::create( $request->all() );

		return response()->json( $book, 201 );
	}

	/**
	 * @param Request $request
	 * @param string $id
	 *
	 * @return JsonResponse
	 */
	public function update( Request $request, string $id ): JsonResponse {
		$book = Book::find( $id );

		if ( ! $book ) {
			aboort( 404 );
		}

		$book->update( $request->all() );
		$book->save();

		return response()->json( $book, 200 );
	}

	/**
	 * @param Request $request
	 * @param string $id
	 *
	 * @return JsonResponse
	 */
	public function delete( Request $request, string $id ): JsonResponse {
		$book = Book::find( $id );

		if ( ! $book ) {
			aboort( 404 );
		}

		$book->delete();

		return response()->json( null, 204 );
	}

}