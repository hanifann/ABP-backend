<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recomendation;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class RecomendationController extends Controller
{
    public function index()
    {
        return Recomendation::all();
    }

    public function create(Request $request)
    {
        $data = $request->only('title', 'content', 'author', 'image');

        $validator = Validator::make($data, [
            'title' => 'required|string|max:100',
            'content' => 'required|string',
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

        $recomendation = Recomendation::create([
            'title' => $request->title,
            'content' => $request->content,
            'author' => $request->author,
            'image' => $path
        ]);

        //response success
       return response()->json([
            'success' => true,
            'message' => 'recomendation created',
            'data' => $recomendation
        ], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {

        $data = $request->only('title', 'content', 'author');

        $validator = Validator::make($data, [
            'title' => 'string|max:100',
            'content' => 'string|max:100',
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


        $recomendation = Recomendation::findOrFail($id);
        $recomendation->update($request->all());

       return response()->json([
        'success' => true,
        'message' => "recomendation update",
        'data' => $request->all()
    ], Response::HTTP_OK);
    }

    public function delete($id)
    {
        Recomendation::find($id)->delete();

        return response()->json([
            'success' => true,
            'message' => "recomendation with id $id deleted",
        ], Response::HTTP_OK);
    }
}
