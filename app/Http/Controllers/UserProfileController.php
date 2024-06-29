<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfile\UserProfileRequest;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends BaseController
{
    public function CreateUserProfile(UserProfileRequest $request){
        $data = Validator::make($request->all(), $request->rules());
        
        $validatedData = $data->validated();

        // $user = Auth::user();
        $user = User::find($validatedData['user_id'])->first();

        if ($user->_id||$user->id = $validatedData['user_id']) {

            if($request->hasFile('user_image')){
                $fileName = time() . '.' . $request->user_image->extension();
                $request->image->storeAs('public/images', $fileName);
            }

            $userId = User::find($request->user_id);


            $validatedData = $request->post();
            $createprofile = $this->create($validatedData, $fileName, $userId);

            return response()->json([
                'user_profile' => $createprofile,
            ],200);
        }
        
        return [
            'status'  => 'Error',
            'message' => 'User Mismatch!',
        ];
    }


    public function create(array $validatedData, $filename, $userId)
    {
        if (!$userId) 
            {
                return response()->json(['error' => 'user not found'], 404);
            }

        $userprofile =  UserProfile::create([
                'firstname'         => $validatedData['firstname'],
                'lastname'          => $validatedData['lastname'],
                'school'            => $validatedData['school'],
                'gender'            => $validatedData['gender'],
                'age'               => $validatedData['age'],
                'state'             => $validatedData['state'],
                'lga'               => $validatedData['lga'],
                'user_image'        => $filename,
            ]);

            $userId->UserProfile()->save($userprofile);

        return response()->json([
            $userprofile,
        ]);
    }
}
