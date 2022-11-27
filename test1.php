<?php
/*
  Задание 0.1. Генератор пароля / PIN-кода

Написать на языке PHP функции `makePassword($length)` и `makePIN($length = 4)` (или класс с такими методами),
генерирующие пароль и пин-код заданной длины

`makePassword` использует цифры и буквы в нижнем и верхнем регистре

`makePin` использует только цифры
 */

function makePassword($length)
{
    $chars = [
        'lower' => "abcdefghijklmnopqrstuvwxyz",
        'up' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'digits' => '0123456789'
    ];
    $password = substr(str_shuffle($chars['lower']), 0, 1)
        . substr(str_shuffle($chars['up']), 0, 1)
        . substr(str_shuffle($chars['digits']), 0, 1);
    return str_shuffle($password . substr(str_shuffle(implode('', $chars)), 0, $length - 3));
}

function makePIN($length = 4)
{
    return substr(str_shuffle('0123456789'), 0, $length);
}

//echo makePassword(1);
//echo makePIN(6);
