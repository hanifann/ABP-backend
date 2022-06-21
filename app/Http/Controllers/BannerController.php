<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class BannerController extends Controller
{
    public function index()
    {
        return Banner::all();
    }

    public function create(Request $request)
    {
        $data = $request->only('title', 'caption', 'author', 'image');

        $validator = Validator::make($data, [
            'title' => 'required|string|max:100',
            'caption' => 'required|string|max:100',
            'author' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->messages()
             ],
                400
            );
        }

        $uploadedFileUrl = cloudinary()->upload($request->file('image')->getRealPath());
        $path = $uploadedFileUrl->getSecurePath();
        $banner = Banner::create([
            'title' => $request->title,
            'caption' => $request->caption,
            'author' => $request->author,
            'image' => $path
        ]);

        //response success
       return response()->json([
            'success' => true,
            'message' => 'banner created',
            'data' => $banner
        ], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {

        $data = $request->only('title', 'caption', 'author');

        $validator = Validator::make($data, [
            'title' => 'string|max:100',
            'caption' => 'string|max:100',
            'author' => 'string',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->messages()
             ],
                400
            );
        }


        $banner = Banner::findOrFail($id);
        $banner->update($request->all());

       return response()->json([
        'success' => true,
        'message' => "banner update",
        'data' => $request->all()
    ], Response::HTTP_OK);
    }

    public function delete($id)
    {
        Banner::find($id)->delete();

        return response()->json([
            'success' => true,
            'message' => "banner with id $id deleted",
        ], Response::HTTP_OK);
    }
}
