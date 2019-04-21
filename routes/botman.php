<?php

$botman = resolve('botman');

$botman->hears('(Hi)|(Hello)|(Helo)', function ($bot) {
    $username = Auth::user()->name;
    $bot->reply('Hello '. $username . '! How can I help you?');
});

$botman->hears('I(.*)good', function ($bot) {

    $bot->reply('Great to hear that. How can I help you?');
});

$botman->hears('help[s]?$', function ($bot) {

  $bot->startConversation(new \App\Conversations\HelpConversation());
});


$botman->hears('hr|about hr',function($bot) {
    $bot->startConversation(new \App\Conversations\HRConversation());
});

$botman->hears('exit|stop|quit|bye', function($bot){
   $bot->reply('Ok. We stop our conversation.');
})->stopsConversation();


$botman->hears('cancel', function($bot){
    $bot->reply('Ok. The request has been cancelled');
})->stopsConversation();

