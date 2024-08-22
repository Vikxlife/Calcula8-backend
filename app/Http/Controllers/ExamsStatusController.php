<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
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
        
        $examRecords = [];
        $resultRecords = [];

        foreach ($data as $item) {
            $examStatus = new ExamStatus([
                'exam_type' => 'wassce/gce',
                'question_id' => $item['question_id'],
                'skipped' => $item['skipped'],
                'answered' => $item['answered'],
                'option_chosen' => $item['option_chosen'],
                'correct_option' => $item['correct_option'],
            ]);
        
            if($item['skipped'] == true){
                $examResult = new ExamResult([
                    'exam_type' => 'wassce/gce',
                    'question_id' => $item['question_id'],
                    'answered' => null,
                    'skipped' => 1, 
                    'correct' => null,
                    'incorrect' => null,
                ]);

            } else{
                
                $examResult = new ExamResult([
                    'exam_type' => 'wassce/gce',
                    'question_id' => $item['question_id'],
                    'answered' => $item['answered'] == 1 ? 1 : 0,
                    'skipped' => $item['skipped'] == 1 ? 1 : 0, 
                    'correct' => $item['correct_option'] == $item['option_chosen'] ? 1 : 0,
                    'incorrect' => $item['correct_option'] != $item['option_chosen'] ? 1 : 0,
                ]);
            }
           


            $user->ExamStatus()->save($examStatus);
            $examRecords[] = $examStatus;


            $user->ExamResults()->save($examResult);
            $resultRecords[] = $examResult;

        }     
        
        return response()->json([
            'exam_record' => $examRecords,
            'result_records' =>$resultRecords
        ]);
    }


    public function getexamresult(Request $request){
        return response()->json([
            'data' => $request->user()->load(['ExamResults', 'ExamStatus'])
        ]);
    }
}
