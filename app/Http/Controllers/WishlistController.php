<?php

namespace App\Http\Controllers;

use App\Models\wishlist;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $user_id)
    {
        $item = Wishlist::where('user_id', $user_id)->with(['travel'])->get();
        return response()->json([
            'success' => true,
            'data' => $item
        ], Response::HTTP_OK);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'travel_id' => 'required',
        ]);
        $itemuser = $request->user();
            $inputan = $request->all();
            $inputan['user_id'] = $itemuser->id;
            $itemwishlist = Wishlist::create($inputan);
            return response()->json([
                'success' => true,
                'message' => 'wishlist created',
                'data' => $inputan
            ], Response::HTTP_OK);
        
    }

    public function delete($id)
    {
        $itemwishlist = Wishlist::findOrFail($id);
        if ($itemwishlist->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'data berhasil terhapus',
                'data' => $itemwishlist
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data gagal terhapus',
                'data' => $itemwishlist
            ], Response::HTTP_OK);
        }
    }
}
