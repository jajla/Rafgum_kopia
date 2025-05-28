<?php

return [

    'title' => 'Zarejestruj się',

    'heading' => 'Rejestracja',

    'actions' => [

        'login' => [
            'before' => 'lub',
            'label' => 'zaloguj się na swoje konto',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'Adres e-mail',
        ],

        'first_name' => [
            'label' => 'imie',
        ],

        'last_name' => [
            'label' => 'nazwisko',
        ],

        'phone_number'=>[
            'label' => 'numer telefonu',
        ],

        'password' => [
            'label' => 'Hasło',
        ],

        'password_confirmation' => [
            'label' => 'Potwierdź hasło',
        ],

        'actions' => [

            'register' => [
                'label' => 'Zarejestruj się',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Zbyt dużo prób rejestracji',
            'body' => 'Spróbuj ponownie za :seconds sekund.',
        ],

    ],

];
