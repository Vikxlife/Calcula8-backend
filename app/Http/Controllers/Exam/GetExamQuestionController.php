<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GetExamQuestionController extends Controller
{
    public function fetchQuestion($paper)
    {
        $response = Http::withHeaders([
            'Accept'=> 'application/json',
            'Content-Type'=> 'application/json',
            'AccessToken'=> 'ALOC-30179a09f987a91aa479'
        ])->get("https://questions.aloc.com.ng/api/v2/q?subject=$paper");
        

        if ($response->successful()) {
            $data = $response->json();

            return response()->json($data);
        } else {
            return response()->json(['error' => 'Failed to fetch data'], $response->status());
        }
    }
}





