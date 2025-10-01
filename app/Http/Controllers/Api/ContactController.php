<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Contact::with('groups');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by group
        if ($request->has('group_id') && $request->group_id) {
            $query->whereHas('groups', function ($q) use ($request) {
                $q->where('group_id', $request->group_id);
            });
        }

        $contacts = $query->orderBy('first_name')->paginate(15);

        return response()->json($contacts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:contacts,email',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'birthday' => 'nullable|date',
                'notes' => 'nullable|string',
                'group_ids' => 'nullable|array',
                'group_ids.*' => 'exists:groups,id',
            ]);

            $contact = Contact::create($validated);

            // Attach groups if provided
            if (isset($validated['group_ids'])) {
                $contact->groups()->attach($validated['group_ids']);
            }

            $contact->load('groups');

            return response()->json([
                'message' => 'Contact created successfully',
                'contact' => $contact
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
    public function show(Contact $contact): JsonResponse
    {
        $contact->load('groups');
        return response()->json($contact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact): JsonResponse
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:contacts,email,' . $contact->id,
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'birthday' => 'nullable|date',
                'notes' => 'nullable|string',
                'group_ids' => 'nullable|array',
                'group_ids.*' => 'exists:groups,id',
            ]);

            $contact->update($validated);

            // Sync groups if provided
            if (isset($validated['group_ids'])) {
                $contact->groups()->sync($validated['group_ids']);
            }

            $contact->load('groups');

            return response()->json([
                'message' => 'Contact updated successfully',
                'contact' => $contact
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
    public function destroy(Contact $contact): JsonResponse
    {
        $contact->delete();

        return response()->json([
            'message' => 'Contact deleted successfully'
        ]);
    }

    /**
     * Search contacts by query string.
     */
    public function search(string $query): JsonResponse
    {
        $contacts = Contact::with('groups')
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'like', "%{$query}%")
                  ->orWhere('last_name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%")
                  ->orWhere('phone', 'like', "%{$query}%");
            })
            ->orderBy('first_name')
            ->get();

        return response()->json($contacts);
    }
}

