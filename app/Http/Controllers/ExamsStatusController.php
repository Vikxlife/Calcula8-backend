<?php

namespace App\Http\Controllers;

use App\Models\ExamStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExamsStatusController extends Controller
{
    public function ExamsResponse(Request $request){

        $data = $request->all();
        
        $validatedData = [];

        foreach ($data as $key => $item) {
            $validator = Validator::make($item, [
                'question_id' => 'string|required',
                'skipped' => 'boolean|required',
                'answered' => 'boolean|required',
                'option_chosen' => 'nullable|string',
                'correct_option' => 'nullable|string' 
            ]);
            
            if($validator->fails()){
                return response()->json([
                    "error" => $validator->errors(),
                    "failed_index" => $key
                ],400);
            }

            $validatedData[] = $validator->validated();
        }


        $createData = $this->create($validatedData);

        return response([
            'data' => $createData,
        ]);
    }

    public function create(array $data){
        $user = Auth::user();
        
        $createdRecords = [];

        foreach ($data as $item) {
            $examStatus = new ExamStatus([
                'question_id' => $item['question_id'],
                'skipped' => $item['skipped'],
                'answered' => $item['answered'],
                'option_chosen' => $item['option_chosen'],
                'correct_option' => $item['correct_option'],
            ]);

            $user->ExamStatus()->save($examStatus);
            $createdRecords[] = $examStatus;
        }
        // ExamStatus::create
        
        return $createdRecords;

        // $examStatus->user()->save();
    }


    public function getexamresult(){
        $user = Auth::user();

        return response()->json([
            // 'data'=>$request->user()->load('userPoints')

             $user
        ]);
    }

}
