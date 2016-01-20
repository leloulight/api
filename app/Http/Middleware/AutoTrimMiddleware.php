<?php namespace App\Http\Middleware;

use Closure;

class AutoTrimMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		
		$request->merge( array_map( 'trim_if_string', $request->all() ) );
		return $next( $request );
	}

}
