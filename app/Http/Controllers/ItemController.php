<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    // Get all items belonging to the Authenticated User
    public function index()
    {
        $items = auth('api')->user()->items;
        return response()->json([
            'message' => 'All items belonging to the authenticated user',
            'data' => $items,
        ], 201);
    }

    // Create a new item with status which will be "pending" by default
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validatedData->errors(),
            ], 422);
        }

        $item = auth('api')->user()->items()->create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Success, One new item is added successfully!',
            'data' => $item,
        ], 201);
    }

    // Update an existing item owned by the authenticated user
    public function update(Request $request, $id)
    {
        $item = Item::where('id', $id)->where('user_id', auth('api')->id())->firstOrFail();

        $validatedData = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validatedData->errors(),
            ], 422);
        }

        $item->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Success! Item has been updated successfully.',
            'data' => $item,
        ]);
    }

    // Delete an item owned by the authenticated user
    public function destroy($id)
    {
        $item = Item::where('id', $id)->where('user_id', auth('api')->id())->firstOrFail();
        $item->delete();

        return response()->json(['message' => 'Item deleted successfully']);
    }
}
