<?php

namespace App\Listeners;

use App\Events\UserValidation;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class ValidateUserData
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function handle(UserValidation $event)
    {
        $request = $event->request;
        $request->validate([
            'name' => 'required|min:2',
            'lastname' => 'required',
            'age' => 'required|numeric|min:12|max:120',
            'city' => 'required',
            'email' => 'required|email',
        ], [
            'name.required' => 'Как Вас зовут?',
            'name.min' => 'Не существует таких маленьких имен.',
            'age.required' => 'Сколько Вам лет?',
            'age.min' => 'Возрастное ограничение минимально от :min лет.',
            'age.max' => 'Возрастное ограничение максимально до :max лет.',
            'lastname.required' => 'Вы не вписали фамилию.',
            'email.required' => 'Вы забыли указать email.',
            'email.email' => 'Не похоже на Email.'
        ]);
    }
}