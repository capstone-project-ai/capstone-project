<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\QuizAnswer;

class QuizController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'roomId' => 'required|exists:rooms,room_id',
            'question' => 'required|string',
        ]);
        
        $quiz = Quiz::create([
            'title' => $validated['title'],
            'question' => $validated['question'],
            'user_id' => auth()->id(),
            'room_id' => $validated['roomId'],
        ]);
        
        if ($request->questionType === "multiple-choice") {
            QuizAnswer::create([
                'correct_answer' => $request->correct_answer,
                'options' => $request->options,
                'quiz_id' => $quiz->id,
            ]);
        } else {
            QuizAnswer::create([
                'correct_answer' => $request->questionType === "fill-in-the-blank" ? $request->correct_answer : "All",
                'fill_in_the_blank' => $request->questionType === "fill-in-the-blank" ?? "",
                'essay' => $request->questionType === "essay" ?? "",
                'quiz_id' => $quiz->id,
            ]);
        }
        // Save questions to the quiz (you would need to adjust this based on your database structure)
        // Loop through $validated['questions'] and save them to the database

        return response()->json(['message' => 'Quiz created successfully', 'quiz' => $quiz], 201);
    }

    public function submitAnswers(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
        ]);

        $points = 0;

        foreach ($validated['answers'] as $questionId => $userAnswer) {
            // Fetch the correct answer (assumes you have a way to get it)
            // $correctAnswer = /* Fetch the correct answer from the database based on question ID */;
            // $isCorrect = ($userAnswer == $correctAnswer);

            // Answer::create([
            //     'quiz_id' => $quiz->id,
            //     'user_id' => auth()->id(),
            //     'question_id' => $questionId,
            //     'user_answer' => $userAnswer,
            //     'is_correct' => $isCorrect,
            // ]);

            // if ($isCorrect) {
            //     $points++;
            // }
        }

        // Save points or perform other logic
        return response()->json(['message' => 'Answers submitted successfully', 'points' => $points], 200);
    }
}

