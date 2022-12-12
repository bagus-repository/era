<?php

use App\Models\User;
use Illuminate\Support\Str;

if (!function_exists('user_role_badge')) {
    function user_role_badge(string $role)
    {
        if ($role == User::ROLE_ADMIN) {
            return '<span class="badge badge-primary">ADMIN</span>';
        }
        return '<span class="badge badge-secondary">' .strtoupper($role). '</span>';
    }
}

if (!function_exists('question_truncate')) {
    function question_truncate(string $question)
    {
        return Str::limit(strip_tags($question), 160, '...');
    }
}