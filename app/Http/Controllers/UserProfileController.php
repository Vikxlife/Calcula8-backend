<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfile\UserProfileRequest;
use App\Models\User;
use App\Models\UserProfile;
use MongoDB\BSON\ObjectId;
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
            $fileName = null;

            if($request->hasFile('user_image')){

                $fileName = time() . '.' . $request->user_image->extension();
                $request->user_image->storeAs('public/images', $fileName);
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


    public function create(array $validatedData, $fileName, $userId)
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
                'user_image'        => $fileName,
            ]);

            $userId->UserProfile()->save($userprofile);

        return response()->json([
            $userprofile,
        ]);
    }

    public function getuserprofile(){
        $data = UserProfile::all();


        // $formattedUserProfile = $data->map(function ($data) {

        //     return [
        //         "image" => asset('storage/images/' . $data->user_image),
                
        //     ];
        // });


        return response()->json([
            $data,
            // $formattedUserProfile
        ]);
    }


    public function updateuserprofile(UserProfileRequest $request, $id)
    {

           // Convert the string ID to a MongoDB ObjectId
        try {
            $_id = new ObjectId($id);
            } 
        catch (\Exception $e) {
                return response()->json(['error' => 'Invalid ID format'], 400);
            }

            $data = Validator::make($request->all(), $request->rules());

            $validatedData = $data->validated();
            $foundUserId = UserProfile::find($_id);

        // $data = Validator::make($request->all(), $request->rules());
        
        // $validatedData = $data->validated();

        //     if ($data->fails()) {
        //         return response()->json(['errors' => $data->errors()], 422);
        //     }
            

        //     $_id = UserProfile::find($validatedData[$id])->first();


        //     $foundUserId = UserProfile::find($_id);
        //     $profile = UserProfile::all();

        //     dd($foundUserId);


            if (!$foundUserId) {
                return response()->json(['error' => 'Not found'], 404);
            }

            $foundUserId->update([

                'firstname'         => $request->input('firstname'),
                'lastname'          => $request->input('lastname'),
                'school'            => $request->input('school'),
                'gender'            => $request->input('gender'),
                'age'               => $request->input('age'),
                'state'             => $request->input('state'),
                'lga'               => $request->input('lga'),
            ]);


            if($request->hasFile('user_image')){

                $fileName = time() . '.' . $request->user_image->extension();
                $request->user_image->storeAs('public/images', $fileName);
            

                $foundUserId->update(['user_image' => $fileName]);
            }

            $newprofile = UserProfile::all();

            return response()->json([
                'message' => 'Role updated successfully',
                'data'      => $newprofile
            ]);
    }
}
