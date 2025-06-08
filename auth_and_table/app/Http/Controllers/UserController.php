<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::get();

            return response()->json([
                'data' => UserResource::collection($user)
            ]);
        }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
       $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);
        if(!$user){
            return response()->json([
                'status' => 'failed',
                'message' => 'User not created'
            ]);
        }else{
        return response()->json([
            'status' => 'success',
            'message' => 'user create successful',
            'data' =>  new UserResource($user)
        ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found'
            ]);
        }else{
            return response()->json([
                'message' => 'success',
                'data' => new UserResource($user)
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found'
            ],404);
        }else{
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User update successfully!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'message' => 'failed',
                'message' => 'User not found'
            ]);
        }else{
            $user->delete();

            return response()->json([
                'success' => 'success',
                'message' => 'User deleted successfully!' 
            ]);
        }
    }
}
