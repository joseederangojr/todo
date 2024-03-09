<?php

namespace App\Http\Controllers;

use App\Http\Requests\Space\StoreSpaceRequest;
use App\Http\Requests\Space\UpdateSpaceRequest;
use App\Models\Space;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class SpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Space::class);

        return Inertia::render('space/page', [
            'spaces' => $request->user()->spaces,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpaceRequest $request)
    {
        /** @var User */
        $user = $request->user();

        /** @var Space */
        $space = Space::firstOrCreate(
            [
                'created_by_id' => $user->id,
                'updated_by_id' => $user->id,
                'name' => $request->validated('name'),
            ],
            [
                'type' => $request->validated('type'),
            ]
        );

        if (! $space->wasRecentlyCreated) {
            throw ValidationException::withMessages([
                'name' => 'Space already exist',
            ]);
        }

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

        return back();
    }

    /**
     * Show the specified resource in storage.
     */
    public function show(Space $space)
    {
        Gate::authorize('view', [$space]);

        $space->load('columns', 'columns.tasks');

        return Inertia::render('space/[id]/page', [
            'breadcrumbs' => [
                [
                    'label' => 'Dashboard',
                    'href' => route('web.home', absolute: false),
                    'isCurrentPage' => false,
                ],
                [
                    'label' => 'Space',
                    'href' => route('web.home', absolute: false),
                    'isCurrentPage' => false,
                    'isDisabled' => true,
                ],
                [
                    'label' => $space->name,
                    'href' => route('web.space.show', ['space' => $space->id], false),
                    'isCurrentPage' => true,
                ],
            ],
            'space' => $space,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpaceRequest $request, Space $space)
    {
        $space->update($request->validated());
        $space->refresh();

        return response()->redirectTo(
            route('web.space.show', ['space' => $space->id]),
            303
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Space $space, Request $request)
    {
        Gate::authorize('delete', $space);
        $forceDelete = $request->input('force', false) === true;

        if ($forceDelete && Gate::allows('forceDelete', [$space])) {
            $space->forceDelete();
        }

        $space->delete();

        return back();
    }
}
