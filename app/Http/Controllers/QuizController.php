<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizRequest;
use App\Models\Quiz;
use App\Services\QuizService;
use App\Services\UserService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    private $userService;
    private $quizService;

    public function __construct() {
        if ($this->userService === null) {
            $this->userService = new UserService();
        }
        if ($this->quizService === null) {
            $this->quizService = new QuizService();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizes = $this->quizService->getQuizes()->get();

        return view('quiz.index_quiz', [
            'quizes' => $quizes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = $this->userService->getUsersNotAdmin()->get();

        return view('quiz.create_quiz', [
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  QuizRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuizRequest $request)
    {
        $objResult = $this->quizService->createQuiz($request->all());

        if (!$objResult->Status) {
            return back()->with('error', $objResult->Message);
        }

        return redirect()->route('quizzes.index')->with('success', $objResult->Message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        $users = $this->userService->getUsersNotAdmin()->get();
        return view('quiz.edit_quiz', compact('quiz', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  QuizRequest  $request
     * @param  Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(QuizRequest $request, Quiz $quiz)
    {
        $objResult = $this->quizService->updateQuiz($request->all(), $quiz->id);

        if (!$objResult->Status) {
            return back()->with('error', $objResult->Message);
        }

        return redirect()->route('quizzes.edit', $quiz)->with('success', $objResult->Message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        $objResult = $this->quizService->deleteQuiz($quiz->id);

        if (!$objResult->Status) {
            return back()->with('error', $objResult->Message);
        }

        return redirect()->route('quizzes.index')->with('success', $objResult->Message);
    }

    public function view_questions(Quiz $quiz)
    {
        return view('question.view_question', [
            'quiz' => $quiz->load(['questions' => function($query){
                $query->with('answers');
            }])
        ]);
    }

    public function do(Quiz $quiz)
    {
        $quiz = $this->quizService->checkQuizGranted(auth()->id(), $quiz->id);
        if ($quiz === null) {
            return redirect()->route('home.index')->with('error', 'Kuis sudah tidak tersedia');
        }
        $questions = $quiz->load(['questions_yet.question']);
        if (count($questions->questions_yet) < 1) {
            return redirect()->route('quizzes.summary', $quiz)->with('success', 'Quiz Selesai');
        }
        $total = $questions->raw_questions()->count();

        if ($quiz->start_time === null) {
            $quiz->update([
                'start_time' => now()
            ]);
        }

        return view('quiz.do_quiz', [
            'quiz' => $quiz,
            'question' => $quiz->questions_yet->first()->question,
            'from' => $total - count($questions->questions_yet) + 1,
            'to' => $total,
        ]);
    }

    public function summary(Quiz $quiz)
    {
        $quiz = $this->quizService->updateQuizScore($quiz);
        return view('quiz.summary_quiz', [
            'quiz' => $quiz->Payload
        ]);
    }

    public function do_ajax(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required',
            'question_id' => 'required',
            'answer_id' => 'required',
        ]);

        $objResult = $this->quizService->submitAnswer(
            $request->quiz_id,
            $request->question_id,
            $request->answer_id,
            auth()->id()
        );

        return response()->json($objResult);
    }

    public function finish(Quiz $quiz)
    {
        $quiz->update([
            'end_time' => now()
        ]);

        return redirect()->route('home.index');
    }
}
