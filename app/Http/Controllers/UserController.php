<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResourse;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        return DB::transaction(function () use ($request) {
        
            $user = User::create($request->safe()->all());
    
            event(new Registered($user));
    
            return $user->createToken($request->device_name)->plainTextToken;   
            });
    }

    public function updateUser(User $user, UpdateUserRequest $request)
    {
        return DB::transaction(function () use ($user, $request) {

            $user->update($request->safe()->all());

            $this->emailVerificationReset($user);

            return new UserResourse($user);

        });
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        $user->delete();

        return response()->json([
            'data' => 'This Item has been deleted successfuly'
        ]);
    }
}
