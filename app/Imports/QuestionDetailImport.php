<?php

namespace App\Imports;

use App\Models\Answer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuestionDetailImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Answer([
            'question_id' => $row['id_question'],
            'answer' => $row['answer'],
            'is_answer' => $row['is_answer'],
        ]);
    }

    public function rules(): array
    {
        return [
            'id_question' => 'required',
            'answer' => 'required',
            'is_answer' => 'required|in:1,0',
        ];
    }
}
