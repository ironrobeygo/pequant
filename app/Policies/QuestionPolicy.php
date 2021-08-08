<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Question $question){
        return $user->id === $question->user_id || $question->user->hasRole('admin');
    }

    public function update(User $user, Question $question)
    {
        return $user->id === $question->user_id;
    }

    public function delete(User $user, Question $question)
    {
        return $user->id === $question->user_id;
    }

}
