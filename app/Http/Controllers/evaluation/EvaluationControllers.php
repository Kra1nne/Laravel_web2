<?php

namespace App\Http\Controllers\evaluation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Evaluation;
use Illuminate\Support\Facades\DB;

class EvaluationControllers extends Controller
{
    public function index()
    {
        return view('content.evaluation.questionnaire');
    }
    public function display()
    {
        $data = Evaluation::select([
            'email',
            'created_at',
            DB::raw('(question1 + question2 + question3 + question4) AS A'),
            DB::raw('(question5 + question6 + question7) AS B'),
            DB::raw('(question8 + question9 + question10) AS C'),
            DB::raw('(question11 + question12 + question13) AS D'),
            DB::raw('(question14 + question15 + question16) AS E'),
            DB::raw('(question17 + question18 + question19) AS F'),
            DB::raw('(question20 + question21 + question22) AS G'),
            DB::raw('(question23 + question24 + question25) AS H'),
            DB::raw('(
                question1 + question2 + question3 + question4 +
                question5 + question6 + question7 +
                question8 + question9 + question10 +
                question11 + question12 + question13 +
                question14 + question15 + question16 +
                question17 + question18 + question19 +
                question20 + question21 + question22 +
                question23 + question24 + question25
            ) AS total')
        ])
        ->get();
        return view('content.evaluation.display_evaluation', compact('data'));
    }
    public function store(Request $request){
        
        $user = User::where('email', $request->email)->first();
        $duplicate = Evaluation::where('email', $request->email)->first();
        
        if(!$user){
            return redirect()->route('evaluate')->with('show_modal', true);
        }
        if($duplicate){
            return redirect()->route('evaluate')->with('show_modal_duplicate', true);
        }

        $data = [
            'email' => $request->email,
            'question1'  => $request->q1,
            'question2'  => $request->q2,
            'question3'  => $request->q3,
            'question4'  => $request->q4,
            'question5'  => $request->q5,
            'question6'  => $request->q6,
            'question7'  => $request->q7,
            'question8'  => $request->q8,
            'question9'  => $request->q9,
            'question10' => $request->q10,
            'question11' => $request->q11,
            'question12' => $request->q12,
            'question13' => $request->q13,
            'question14' => $request->q14,
            'question15' => $request->q15,
            'question16' => $request->q16,
            'question17' => $request->q17,
            'question18' => $request->q18,
            'question19' => $request->q19,
            'question20' => $request->q20,
            'question21' => $request->q21,
            'question22' => $request->q22,
            'question23' => $request->q23,
            'question24' => $request->q24,
            'question25' => $request->q25,
            'created_at' => now(),
        ];
        $result = Evaluation::insert($data);

        if($result){
            return redirect()->route('evaluate')->with('success_modal', true);
        }
    }
}
