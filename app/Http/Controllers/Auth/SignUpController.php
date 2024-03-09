<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SignUpController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SignUpRequest $request)
    {
        /** @var User $user */
        $user = User::create($request->except('password_confirmation'));

        Auth::login($user, false);

        /** @var \App\Models\Space $space */
        $space = $user->spaces()->create([
            'name' => $user->name,
        ]);

        $space->columns()->createMany([
            [
                'name' => 'Triage',
                'status' => 'triage',
                'order' => 0,
            ],
            [
                'name' => 'To Do',
                'status' => 'todo',
                'order' => 1,
            ],
            [
                'name' => 'Doing',
                'status' => 'doing',
                'order' => 2,
            ],
            [
                'name' => 'Done',
                'status' => 'done',
                'order' => 3,
            ],
            [
                'name' => 'Abandon',
                'status' => 'abandon',
                'order' => 4,
            ],
        ]);

        return response()->redirectTo(route('web.space.index'));
    }

    public function page()
    {
        return Inertia::render('auth/signup/page');
    }
}
