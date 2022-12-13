<?php
namespace App\Services;

use App\Utils\LogUtil;
use App\Models\Question;
use App\Domain\MessageData;
use App\Models\Answer;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class QuizService
{
    public function createQuiz(array $objParam)
    {
        $objMsg = new MessageData();
        DB::beginTransaction();
        try {
            $quiz = Quiz::create([
                'user_id' => $objParam['user_id'],
                'batch_date' => $objParam['batch_date'],
                'duration' => $objParam['duration'],
                'subject' => $objParam['subject'],
                'desc' => $objParam['desc'],
                'total_score' => 0,
            ]);

            $questions = (new QuestionService())->getRandomQuestions()->get();
            foreach ($questions as $item) {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question_id' => $item->id,
                ]);
            }

            DB::commit();
            $objMsg->Status = true;
            $objMsg->Message = 'Berhasil membuat quiz';
            $objMsg->Payload = $quiz;
        } catch (\Exception $ex) {
            DB::rollBack();
            $objMsg->Status = false;
            $objMsg->Message = 'Gagal membuat quiz, silahkan coba lagi';
            LogUtil::logError($objMsg->Message, $ex);
        }

        return $objMsg;
    }

    public function updateQuiz(array $objParam, $id)
    {
        $objMsg = new MessageData();
        DB::beginTransaction();
        try {
            $quiz = Quiz::find($id);
            $quiz->update([
                'user_id' => $objParam['user_id'],
                'batch_date' => $objParam['batch_date'],
                'duration' => $objParam['duration'],
                'subject' => $objParam['subject'],
                'desc' => $objParam['desc'],
            ]);

            DB::commit();
            $objMsg->Status = true;
            $objMsg->Message = 'Berhasil mengubah quiz';
            $objMsg->Payload = $quiz;
        } catch (\Exception $ex) {
            DB::rollBack();
            $objMsg->Status = false;
            $objMsg->Message = 'Gagal mengubah quiz, silahkan coba lagi';
            LogUtil::logError($objMsg->Message, $ex);
        }

        return $objMsg;
    }

    /**
     * Delete quiz
     *
     * @param string|int $id
     * @return MessageData
     */
    public function deleteQuiz($id): MessageData
    {
        $objMsg = new MessageData();
        DB::beginTransaction();
        try {
            Quiz::find($id)->delete();
            QuizQuestion::where('quiz_id', $id)->delete();

            DB::commit();
            $objMsg->Status = true;
            $objMsg->Message = 'Berhasil menghapus quiz';
        } catch (\Exception $ex) {
            DB::rollBack();
            $objMsg->Status = false;
            $objMsg->Message = 'Gagal menghapus quiz, silahkan coba lagi';
            LogUtil::logError($objMsg->Message, $ex);
        }

        return $objMsg;
    }

    /**
     * Get quizes
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getQuizes()
    {
        return Quiz::with('user');
    }

    public function getCurDateQuizes($user_id)
    {
        return Quiz::where([
            'user_id' => $user_id,
            'batch_date' => now()->format('Y-m-d'),
        ])->get();
    }

    /**
     * Check Quiz 
     *
     * @param string|int $user_id
     * @param string|int $quiz_id
     * @return Quiz
     */
    public function checkQuizGranted($user_id, $quiz_id)
    {
        return $this->getCurDateQuizes($user_id)->firstWhere('id', $quiz_id);
    }

    /**
     * Do Quiz
     *
     * @param Quiz $quiz
     * @param int $user_id
     * @return void
     */
    public function doQuiz(Quiz $quiz, $user_id)
    {
        $objMsg = new MessageData();
        try {
            $quiz = $this->checkQuizGranted($user_id, $quiz->id);
            if ($quiz === null) {
                $objMsg->Status = false;
                $objMsg->Message = 'Kuis tidak tersedia';
                $objMsg->Payload = (object) [
                    'redirect' => true,
                    'redirect_url' => route('home.index'),
                ];
                return $objMsg;
            }
            $quiz->load('questions_yet.question.answers');
            if (count($quiz->questions_yet) < 1) {
                $objMsg->Status = false;
                $objMsg->Message = 'Kuis selesai';
                $objMsg->Payload = (object) [
                    'redirect' => true,
                    'redirect_url' => route('quizzes.summary', $quiz),
                ];
                return $objMsg;
            }

            $objMsg->Status = true;
            $objMsg->Message = 'OK';
            $objMsg->Payload = $quiz->questions_yet->first();
        } catch (\Exception $ex) {
            $objMsg->Status = false;
            $objMsg->Message = 'Gagal memuat soal, silahkan coba lagi';
            LogUtil::logError($objMsg->Message, $ex);
        }

        return $objMsg;
    }

    public function updateQuizScore(Quiz $quiz): MessageData
    {
        $objMsg = new MessageData();
        DB::beginTransaction();
        try {
            $score = 0;
            $quiz->load('raw_questions.question.answers');
            foreach ($quiz->raw_questions as $q) {
                if ($q->question->correct_answer !== null) {
                    if ($q->answer_id == $q->question->correct_answer->id) {
                        $score += $q->question->score;
                    }
                }
            }

            $quiz->update([
                'total_score' => $score
            ]);

            DB::commit();
            $objMsg->Status = true;
            $objMsg->Message = 'Berhasil menghapus quiz';
            $objMsg->Payload = $quiz;
        } catch (\Exception $ex) {
            DB::rollBack();
            $objMsg->Status = false;
            $objMsg->Message = 'Gagal menghapus quiz, silahkan coba lagi';
            LogUtil::logError($objMsg->Message, $ex);
        }

        return $objMsg;
    }

    /**
     * Check remaining time
     *
     * @param Quiz $quiz
     * @return MessageData
     */
    public function checkRemainingTime(Quiz $quiz): MessageData
    {
        $objMsg = new MessageData();
        if ($quiz->remaining_time == null) {
            $objMsg->Status = false;
            $objMsg->Message = 'Kuis telah berakhir';
            $objMsg->Payload = (object) [
                'redirect' => true,
                'redirect_url' => route('home.index'),
            ];
            return $objMsg;
        }
        $objMsg->Status = true;
        $objMsg->Message = 'Kuis OK';
        return $objMsg;
    }

    public function submitAnswer($quiz_id, $question_id, $answer_id, $user_id): MessageData
    {
        $objMsg = new MessageData();
        DB::beginTransaction();
        try {
            $quiz = $this->checkQuizGranted($user_id, $quiz_id);
            if ($quiz === null) {
                $objMsg->Status = false;
                $objMsg->Message = 'Kuis tidak tersedia';
                $objMsg->Payload = (object) [
                    'redirect' => true,
                    'redirect_url' => route('home.index'),
                ];
                return $objMsg;
            }

            $CheckTime = $this->checkRemainingTime($quiz);
            if (!$CheckTime->Status) {
                return $CheckTime;
            }
            
            $quiz->load('questions_yet.question.answers');
            $question = $quiz->questions_yet->where('question_id', $question_id)->first();
            if ($question == null) {
                $objMsg->Status = false;
                $objMsg->Message = 'Pertanyaan sudah dijawab';
                $objMsg->Payload = (object) [
                    'redirect' => true,
                    'redirect_url' => route('quizzes.do', $quiz),
                ];
                return $objMsg;
            }

            $nextQuestion = $quiz->questions_yet->firstWhere('question_id', '!=', $question->question_id);
            if ($nextQuestion === null) {
                $quiz->update(['end_time' => now()]);
            }

            QuizQuestion::where([
                'question_id' => $question->question_id,
                'quiz_id' => $quiz->id,
            ])->update(['answer_id' => $answer_id]);

            DB::commit();
            $objMsg->Status = true;
            $objMsg->Message = 'Berhasil submit answer';
            $objMsg->Payload = $nextQuestion;
        } catch (\Exception $ex) {
            DB::rollBack();
            $objMsg->Status = false;
            $objMsg->Message = 'Gagal submit answer, silahkan coba lagi';
            LogUtil::logError($objMsg->Message, $ex);
        }

        return $objMsg;
    }
}