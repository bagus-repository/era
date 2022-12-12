<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('active', function(Builder $builder){
            $builder->where('sts', 1);
        });
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['correct_answer'];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Get the correct answer
     *
     * @return string
     */
    public function getCorrectAnswerAttribute()
    {
        return $this->answers->where('is_answer', 1)->first();
    }
}
