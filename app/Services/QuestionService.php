<?php
namespace App\Services;

use App\Models\User;
use App\Models\Answer;
use App\Utils\LogUtil;
use App\Models\Question;
use App\Domain\MessageData;
use App\Imports\QuestionImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class QuestionService
{
    public function createQuestion(array $objParam)
    {
        $objMsg = new MessageData();
        DB::beginTransaction();
        try {
            $question = Question::create([
                'question' => $objParam['question'],
                'sts' => 1,
                'score' => $objParam['score'],
            ]);

            foreach ($objParam['answers'] as $key => $answer) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer' => $answer,
                    'is_answer' => $objParam['is_answer'] - 1 == $key ? 1:0,
                ]);
            }

            DB::commit();
            $objMsg->Status = true;
            $objMsg->Message = 'Berhasil membuat pertanyaan';
            $objMsg->Payload = $question;
        } catch (\Exception $ex) {
            DB::rollBack();
            $objMsg->Status = false;
            $objMsg->Message = 'Gagal membuat pertanyaan, silahkan coba lagi';
            LogUtil::logError($objMsg->Message, $ex);
        }

        return $objMsg;
    }

    /**
     * Update Question
     *
     * @param array $objParam
     * @param string|int $id
     * @return MessageData
     */
    public function updateQuestion(array $objParam, $id): MessageData
    {
        $objMsg = new MessageData();
        DB::beginTransaction();
        try {
            $question = Question::find($id);
            $question->update([
                'question' => $objParam['question'],
                'score' => $objParam['score'],
            ]);

            Answer::where('question_id', $id)->delete();
            foreach ($objParam['answers'] as $key => $answer) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer' => $answer,
                    'is_answer' => $objParam['is_answer'] - 1 == $key ? 1:0,
                ]);
            }

            DB::commit();
            $objMsg->Status = true;
            $objMsg->Message = 'Berhasil mengubah pertanyaan';
            $objMsg->Payload = $question;
        } catch (\Exception $ex) {
            DB::rollBack();
            $objMsg->Status = false;
            $objMsg->Message = 'Gagal mengubah pertanyaan, silahkan coba lagi';
            LogUtil::logError($objMsg->Message, $ex);
        }

        return $objMsg;
    }

    /**
     * Get Questions
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getQuestions()
    {
        return Question::with('answers');
    }

    /**
     * Delete question
     *
     * @param string|int $id
     * @return MessageData
     */
    public function deleteQuestion($id): MessageData
    {
        $objMsg = new MessageData();
        DB::beginTransaction();
        try {
            $question = Question::find($id);
            $question->update([
                'sts' => 0,
            ]);

            $objMsg->Status = true;
            $objMsg->Message = 'Berhasil menghapus pertanyaan';
            $objMsg->Payload = $question;
        } catch (\Exception $ex) {
            DB::rollBack();
            $objMsg->Status = false;
            $objMsg->Message = 'Gagal menghapus pertanyaan, silahkan coba lagi';
            LogUtil::logError($objMsg->Message, $ex);
        }

        return $objMsg;
    }

    /**
     * Get Random Questions
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getRandomQuestions(int $count = 10)
    {
        return Question::whereHas('answers')->inRandomOrder()->limit($count);
    }

    /**
     * Import Question
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return MessageData
     */
    public function importQuestions($file): MessageData
    {
        $objMsg = new MessageData();
        DB::beginTransaction();
        try {
            $now = now();
            $data = Excel::toArray(new QuestionImport(), $file);
            $questions = $data['Questions'];
            $answers = collect($data['Answers']);
            foreach ($questions as $question) {
                $q = Question::create([
                    'question' => $question['question'],
                    'sts' => 1,
                    'score' => $question['question'] ?? 0,
                ]);
                $insertAnswers = [];
                foreach ($answers->where('id_question', $question['id_question'])->all() as $a) {
                    $insertAnswers[] = [
                        'question_id' => $q->id,
                        'answer' => $a['answer'],
                        'is_answer' => $a['is_answer'] ?? 0,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
                Answer::insert($insertAnswers);
            }

            DB::commit();
            $objMsg->Status = true;
            $objMsg->Message = 'Berhasil impor pertanyaan';
        } catch (\Exception $ex) {
            DB::rollBack();
            $objMsg->Status = false;
            $objMsg->Message = 'Gagal impor pertanyaan, silahkan coba lagi. ' . $ex->getMessage();
            LogUtil::logError($objMsg->Message, $ex);
        }

        return $objMsg;
    }
}