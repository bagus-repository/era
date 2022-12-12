<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Imports\QuestionImport;
use App\Services\QuestionService;
use App\Http\Requests\QuestionRequest;

class QuestionController extends Controller
{
    private $questionService;

    public function __construct() {
        $this->questionService = new QuestionService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('question.index_question', [
            'questions' => $this->questionService->getQuestions()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('question.create_question');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  QuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        $objResult = $this->questionService->createQuestion($request->all());
        if (!$objResult->Status) {
            return back()->with('error', $objResult->Message);
        }

        return redirect()->route('questions.index')->with('success', $objResult->Message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        return view('question.edit_question', [
            'question' => $question->load('answers'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  QuestionRequest  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, Question $question)
    {
        $objResult = $this->questionService->updateQuestion($request->all(), $question->id);
        if (!$objResult->Status) {
            return back()->with('error', $objResult->Message);
        }

        return redirect()->route('questions.edit', $question)->with('success', $objResult->Message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $objResult = $this->questionService->deleteQuestion($question->id);
        return redirect()->route('questions.index')->with($objResult->Status ? 'success':'error', $objResult->Message);
    }

    public function import()
    {
        return view('question.import_question');
    }

    public function import_do(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx|max:1024'
        ]);

        $objResult = $this->questionService->importQuestions($request->file('file'));
        if (!$objResult->Status) {
            return back()->with('error', $objResult->Message);
        }

        return redirect()->route('questions.index')->with('success', $objResult->Message);
    }
}
