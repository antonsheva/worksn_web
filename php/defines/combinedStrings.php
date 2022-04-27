<?php

function stringMsgForConfirmEmail($email, $href){
    return 'Для подтверждения почтового ящика '.$email.' для WORKSN.RU: '.PHP_EOL.'пройдите по: '.$href;
}
function stringForConfirmEmail($hash){
    return '<a href="https://worksn.ru/confirm_email/'.$hash.'" target="_blank"> этой ссылке</a>';
}
