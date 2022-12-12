<?php

namespace App\Http\Controllers;

use App\Services\QuizService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $quizzes = (new QuizService())->getCurDateQuizes(auth()->id());
        return view('dashboard', compact('quizzes'));
    }

    public function redirect()
    {
        return redirect()->route('home.index');
    }
}
