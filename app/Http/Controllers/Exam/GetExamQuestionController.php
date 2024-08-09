<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GetExamQuestionController extends Controller
{
    public function fetchQuestion($paper)
    {
        $paper = strtolower($paper);

        for ($i=0; $i < 5; $i++) { 
            $response = Http::withHeaders([
                'Accept'=> 'application/json',
                'Content-Type'=> 'application/json',
                'AccessToken'=> 'ALOC-30179a09f987a91aa479'
            ])->get("https://questions.aloc.com.ng/api/v2/q?subject=$paper");

        
            if ($response->successful()) {
                $data = $response->json();
                $response = $data;
                
            } else {
                return response()->json(['error' => 'Failed to fetch data'], $response->status());
            }
        }

        return response()->json($data);  
    }


    public function fetchQuestionById($id)
    {
        $id = strtolower($id);
        
        $response = Http::withHeaders([
            'Accept'=> 'application/json',
            'Content-Type'=> 'application/json',
            'AccessToken'=> 'ALOC-30179a09f987a91aa479'
        ])->get("https://questions.aloc.com.ng/api/v2/q-by-id/$id?subject=chemistry");

        if ($response->successful()) {
            $data = $response->json();

            return response()->json($data);
        } else {
            return response()->json(['error' => 'Failed to fetch data'], $response->status());
        }
    }
}





