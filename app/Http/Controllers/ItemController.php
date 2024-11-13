<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    // Get all items belonging to the authenticated user
    public function index()
    {
        $items = auth('api')->user()->items;
        return response()->json($items);
    }

    // Create a new item with status set to "pending" by default
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $item = auth('api')->user()->items()->create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'status' => 'pending', // Default to "pending" status
        ]);

        return response()->json($item, 201);
    }

    // Update an existing item owned by the authenticated user
    public function update(Request $request, $id)
    {
        $item = Item::where('id', $id)->where('user_id', auth('api')->id())->firstOrFail();

        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
        ]);

        $item->update($validatedData);

        return response()->json($item);
    }

    // Delete an item owned by the authenticated user
    public function destroy($id)
    {
        $item = Item::where('id', $id)->where('user_id', auth('api')->id())->firstOrFail();
        $item->delete();

        return response()->json(['message' => 'Item deleted successfully']);
    }
}
