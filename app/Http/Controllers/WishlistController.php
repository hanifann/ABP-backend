<?php

namespace App\Http\Controllers;

use App\Models\wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $user_id)
    {
        $item = Wishlist::where('user_id', $user_id)->paginate(10);
        return response()->json([
            'success' => true,
            'message' => 'wishlist created',
            'data' => $item
        ], Response::HTTP_OK);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'travel_id' => 'required',
        ]);
        $itemuser = $request->user();
        $validasiwishlist = Wishlist::where('travel_id', $request->travel_id)
                                    ->where('user_id', $itemuser->id)
                                    ->first();
        if ($validasiwishlist) {
            $validasiwishlist->delete();
            return back()->with('success', 'Wishlist berhasil dihapus');
        } else {
            $inputan = $request->all();
            $inputan['user_id'] = $itemuser->id;
            $itemwishlist = Wishlist::create($inputan);
            return response()->json([
                'success' => true,
                'message' => 'wishlist created',
                'data' => $inputan
            ], Response::HTTP_OK);
        }
    }

    public function delete($id)
    {
        $itemwishlist = Wishlist::findOrFail($id);
        if ($itemwishlist->delete()) {
            return back()->with('success', 'Wishlist berhasil dihapus');
        } else {
            return back()->with('error', 'Wishlist gagal dihapus');
        }
    }
}
