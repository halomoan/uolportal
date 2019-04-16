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

$botman->hears('help[s]?$', function ($bot) {

  $bot->startConversation(new \App\Conversations\HelpConversation());
});


$botman->hears('hrd',function($bot) {
    $bot->startConversation(new \App\Conversations\HRDConversation());
});

$botman->hears('exit|stop|quit|bye', function($bot){
   $bot->reply('We stopped your conversation. How can I help you ?');
})->stopsConversation();


