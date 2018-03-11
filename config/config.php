<?php
return [
    "dbConf" => [
        'user' => 'root',
        'password' => '',
        'dsn' => 'mysql:dbname=enrollee;host=127.0.0.1',

    ],
    "formFields" => [
        'LOGIN' => 'Логин',
        'PASS' => 'Пароль',
        'NAME' => 'Имя',
        'SURNAME' => 'Фамилия',
        'EMAIL' => 'Email',
        'FACULTY' => 'Факультет',
        'PHONE' => 'Телефон',
        'SCORE' => 'Средний бал успеваемости',
        'SEX' => [
            'male' => 'мужской',
            'female' => 'женский'
        ],
        'VISA' => [
            'city' => 'Городской',
            'vilage' => 'Иногородний'
        ]
    ],
    "validationRules" => [
        'LOGIN' => [
            'rule' => ['/[^a-zA-Z0-9]+/'],
            'check_empty' => true,
            'check_rule' => true,
            'min_length' => 5,
            'max_length' => 15,
            'text' => 'должно содержать только символы латинского алфавита и числа в диапазоне от 0 до 9'
        ],
        'PASS' => [
            'rule' => [
                '/[a-z]+/',
                '/[A-Z]+/',
                '/[0-9]+/',
                '/[%?#$!_]+/'
            ],
            'check_empty' => true,
            'check_rule' => true,
            'min_length' => 8,
            'max_length' => 25,
            'text' => 'должно содержать символы латинского алфавита, числа в диапазоне от 0 до 9 и хотябы один из специальных символы(%?#$!-_)'
        ],
        'NAME' => [
            'rule' => ['/[^a-zA-zа-яА-я]+/'],
            'check_empty' => true,
            'check_rule' => true,
            'min_length' => 1,
            'max_length' => 25,
            'text' => 'должно содержать только символы латинского и русского алфавитов'
        ],
        'SURNAME' => [
            'rule' => ['/[^a-zA-zа-яА-я]+/'],
            'check_empty' => true,
            'check_rule' => true,
            'min_length' => 1,
            'max_length' => 25,
            'text' => 'должно содержать только символы латинского и русского алфавитов'
        ],
        'SEX' => [
            'rule' => [],
            'check_empty' => false,
            'check_rule' => true,
            'min_length' => 1,
            'max_length' => 25,
            'text' => ''
        ],
        'YEAR' => [
            'rule' => ['/[^0-9]+/'],
            'check_empty' => false,
            'check_rule' => true,
            'min_length' => 4,
            'max_length' => 4,
            'text' => 'должно содержать только 4 символа'
        ],
        'VISA' => [
            'rule' => [],
            'check_empty' => false,
            'check_rule' => true,
            'min_length' => 1,
            'max_length' => 25,
            'text' => ''
        ],
        'EMAIL' => [
            'rule' => ['/@/', '/.+@.+\../'],
            'check_empty' => true,
            'check_rule' => true,
            'min_length' => 5,
            'max_length' => 32,
            'text' => 'некорректно заполнено'
        ],
        'FACULTY' => [
            'rule' => ['/[^a-zA-zа-яА-я0-9-]+/'],
            'check_empty' => true,
            'check_rule' => true,
            'min_length' => 1,
            'max_length' => 25,
            'text' => 'должно содержать только символы латинского и русского алфавитов и числа в диапазоне от 0 до 9'
        ],
        'PHONE' => [
            'rule' => ['/[^+0-9\s()-]+/'],
            'check_empty' => true,
            'check_rule' => true,
            'min_length' => 10,
            'max_length' => 23,
            'text' => 'может содержать только числа в диапазоне от 0 до 9, знак + или круглые скобки'
        ],
        'SCORE' => [
            'rule' => [40, 150],
            'check_empty' => true,
            'check_rule' => true,
            'min_length' => 2,
            'max_length' => 3,
            'text' => 'должно содержать только числа в диапазоне от 40 - до 150.'
        ],
        'COMMENT' => [
            'rule' => [],
            'check_empty' => false,
            'check_rule' => true,
            'min_length' => 0,
            'max_length' => 1000,
            'text' => ''
        ],
    ],
    'template' => 'main',
    'pages' => [
        'main' => [
            'title' => 'Главная страница',
            'headre' => ''
        ],
        'registration' => [
            'title' => 'Страница регистрации',
            'header' => 'Регистрация нового пользователя'
        ]
    ],
];