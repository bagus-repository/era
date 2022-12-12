<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class QuestionImport implements WithMultipleSheets
{
    protected $schema = [];

    public function __construct() {
        $this->schema['Questions'] = new QuestionHeaderImport();
        $this->schema['Answers'] = new QuestionDetailImport();
    }
    
    public function sheets(): array
    {
        return $this->schema;
    }
}
