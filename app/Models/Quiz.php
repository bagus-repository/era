<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quizzes';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['remaining_time'];

    public function questions()
    {
        return $this->hasManyThrough(
            Question::class, 
            QuizQuestion::class,
            'quiz_id',
            'id',
            'id',
            'question_id'
        )->withoutGlobalScopes();
    }

    public function raw_questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function questions_yet()
    {
        return $this->hasMany(QuizQuestion::class)->whereNull('answer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the remaining time in seconds
     *
     * @return mixed|null
     */
    public function getRemainingTimeAttribute()
    {
        if ($this->start_time !== null) {
            $due = \Carbon\Carbon::parse($this->start_time)->addMinutes($this->duration);
            if (now() <= $due) {
                $remaining = $due->diffInSeconds(now());
                return $remaining;
            }
        }
        return null;
    }
}
