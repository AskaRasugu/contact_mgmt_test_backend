<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $groups = Group::withCount('contacts')->orderBy('name')->get();
        return response()->json($groups);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:groups,name',
                'description' => 'nullable|string',
                'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            ]);

            $group = Group::create($validated);

            return response()->json([
                'message' => 'Group created successfully',
                'group' => $group
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group): JsonResponse
    {
        $group->load(['contacts' => function ($query) {
            $query->orderBy('first_name');
        }]);
        
        return response()->json($group);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:groups,name,' . $group->id,
                'description' => 'nullable|string',
                'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            ]);

            $group->update($validated);

            return response()->json([
                'message' => 'Group updated successfully',
                'group' => $group
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group): JsonResponse
    {
        $group->delete();

        return response()->json([
            'message' => 'Group deleted successfully'
        ]);
    }

    /**
     * Get all contacts for a specific group.
     */
    public function contacts(Group $group): JsonResponse
    {
        $contacts = $group->contacts()->orderBy('first_name')->get();
        
        return response()->json($contacts);
    }
}

