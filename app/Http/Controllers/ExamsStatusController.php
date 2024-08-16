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
        $data = Validator::make($request->all(), [
   
            'question_id' => 'string|required',
            'skipped' => 'boolean|required',
            'answered' => 'boolean|required',
            'option_chosen' => 'string|required',
            'correct_option' => 'string|required' 
        ]);


        $data = $request->post();
        $createData = $this->create($data,);

        return response([
            'data' => $createData,
        ]);
    }

    public function create(array $data){
        $user = Auth::user();

        $examStatus = ExamStatus::create([
            'question_id' => $data['question_id'],
            'skipped' => $data['skipped'],
            'answered' => $data['answered'],
            'option_chosen' => $data['option_chosen'],
            'correct_option' => $data['correct_option'],

        ]);

        $user->ExamStatus()->save($examStatus);

        // $examStatus->user()->save();
    }


    public function getexamstatuses(){
        $data = ExamStatus::all();

        return response()->json([
            $data
        ]);
    }
}
