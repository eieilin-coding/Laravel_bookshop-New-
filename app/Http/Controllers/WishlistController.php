<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\MOdels\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{

    public function index()
    {
        $wishlist = Wishlist::with('book')->where('user_id', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->paginate(4);
        return view('wishlist.index', compact('wishlist'));
    }

    public function toggle(Request $request)
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            // Return a JSON response with a specific status and message
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
                'redirect_url' => route('login') // or '/auth/login'
            ], 401);
        }

        $bookId = $request->input('book_id');
        $userId = Auth::id();

        // Check if the book is already in the wishlist
        $wishlistItem = Wishlist::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->first();

        $action = '';
        if ($wishlistItem) {
            // Book is in the wishlist, so we remove it
            $wishlistItem->delete();
            $action = 'removed';
            $message = 'Product
             removed from Wishlist';
        } else {
            // Book is not in the wishlist, so we add it
            Wishlist::create([
                'user_id' => $userId,
                'book_id' => $bookId,
            ]);
            $action = 'added';
            $message = 'Product added to Wishlist';
        }

        $wishlistCount = Wishlist::where('user_id', $userId)->count();

        return response()->json([
            'success' => true,
            'action' => $action,
            'message' => $message,
            'count' => $wishlistCount
        ]);
    }

    public function getCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Wishlist::where('user_id', Auth::id())->count();
        return response()->json(['count' => $count]);
    }

    public function remove($id)
    {
        Wishlist::where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Book removed from wishlist.');
    }


    public function checkStatus(Request $request)
    {
        $bookIds = $request->input('book_ids');
        $status = [];

        if (Auth::check()) {
            foreach ($bookIds as $bookId) {
                $status[$bookId] = Wishlist::where('user_id', Auth::id())
                    ->where('book_id', $bookId)
                    ->exists();
            }
        }

        return response()->json(['wishlist_status' => $status]);
    }
}
