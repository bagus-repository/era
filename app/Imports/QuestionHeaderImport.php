<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuestionHeaderImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Question([
            'id' => $row['id_question'],
            'question' => $row['question'],
            'score' => $row['score'],
        ]);
    }

    public function rules(): array
    {
        return [
            'id_question' => 'required',
            'question' => 'required',
        ];
    }
}
