<?php namespace App\Http\Middleware;


use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
class UserMiddleware {
	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if($this->auth->check() && $request->user()->user_type == '0' && $request->user()->type == '1' && $request->user()->is_active == '1'){
			return $next($request);
			
		}
		return redirect ('/');
		//$this->auth->logout();
		//return redirect ('/')->with('message', 'Account Disable!');
	}

}
