<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResourse;
use App\Models\Role;
use App\Models\User;
use App\Traits\EmailUpdate;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use EmailUpdate;

    public function store(StoreUserRequest $request)
    {
        return DB::transaction(function () use ($request) {
        
            if(! Role::exists()){
                $role = Role::create(['role' => 'student']);
            }else{
                $role = Role::where('role', 'student')->first();
            }
    
            $user = User::create(array_merge($request->safe()->all(), ['role_id' => $role->id]));
    
            event(new Registered($user));
    
            return $user->createToken($user->email)->plainTextToken;   
            });
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        return DB::transaction(function () use ($user, $request) {

            $user->update($request->safe()->all());

            $this->emailVerificationReset($user);

            return response()->json([
                'status' => 1,
                'user' => $user
            ]);

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
