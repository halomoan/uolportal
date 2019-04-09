<?php
use App\Http\Controllers\BotManController;



$botman = resolve('botman');



$botman->hears('Hi|Hello (.*)', function ($bot) {
    $username = Auth::user()->name;
    $bot->reply('Hello '. $username . '! How can I help you?');
});

$botman->hears('I(.*)good', function ($bot) {

    $bot->reply('Great to hear that. How can I help you?');
});


$botman->hears('Start conversation', BotManController::class.'@startConversation');
