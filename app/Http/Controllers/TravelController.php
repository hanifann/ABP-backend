<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Travel;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class TravelController extends Controller
{
    public function index()
    {
        return Travel::all();
    }

    public function create(Request $request)
    {
        $data = $request->only('title', 'price', 'description', 'startDate', 'endDate', 'lodging', 'transportation', 'image');

        $validator = Validator::make($data, [
            'title' => 'required|string',
            'price' => 'required|string',
            'description' => 'required|string',
            'startDate' => 'required',
            'endDate' => 'required',
            'lodging' => 'required|string',
            'transportation' => 'required|string',
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

        $nameFile = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('images', $nameFile, 'public');

        $travel = Travel::create([
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'lodging' => $request->lodging,
            'transportation' => $request->transportation,
            'image' => $path
        ]);

        //response success
       return response()->json([
            'success' => true,
            'message' => 'travel created',
            'data' => $travel
        ], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {

        $data = $request->only('title', 'content', 'author');

        $validator = Validator::make($data, [
            'title' => 'string',
            'price' => 'string',
            'description' => 'string',
            'lodging' => 'string',
            'transportation' => 'string',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->messages()
             ],
                400
            );
        }


        $travel = Travel::findOrFail($id);
        $travel->update($request->all());

       return response()->json([
        'success' => true,
        'message' => "travel update",
        'data' => $request->all()
    ], Response::HTTP_OK);
    }

    public function delete($id)
    {
        Travel::find($id)->delete();

        return response()->json([
            'success' => true,
            'message' => "travel with id $id deleted",
        ], Response::HTTP_OK);
    }
}
