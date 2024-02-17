<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(Contact::all());
    }

    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:contacts',
            'phone' => 'required|string|min:10|max:14',
        ]);

        DB::beginTransaction();
        try {
            $contact = Contact::create($request->all());

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Successfully created',
                'data' => $contact,
            ], 201);
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'issue' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact): JsonResponse
    {
        return response()->json($contact);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws ValidationException
     */
    public function update(Request $request, Contact $contact): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:contacts,id,'. $contact->id,
            'phone' => 'required|string|min:10|max:14',
        ]);

        DB::beginTransaction();
        try {
            $contact->update($request->all());

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Successfully updated',
                'data' => $contact,
            ], 200);
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'issue' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact): JsonResponse
    {
        DB::beginTransaction();
        try {
            $contact->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted',
            ], 200);
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'issue' => $e->getMessage(),
            ]);
        }
    }
}
