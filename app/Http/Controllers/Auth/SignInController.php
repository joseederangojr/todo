<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignInRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SignInController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SignInRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'), $request->validated('remember', false))) {
            throw new BadRequestHttpException('Invalid email or password');
        }

        return response()->redirectTo(route('web.home'));
    }

    public function page()
    {
        return Inertia::render('auth/signin/page');
    }
}
