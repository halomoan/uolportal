<?php

$botman = resolve('botman');

$botman->hears('(Hi)|(Hello)|(Helo)', function ($bot) {

    if (Auth::guest()) {
        $bot->reply('Hello there. How can I help you?');
    } else {
        $username = Auth::user()->name;
        $bot->reply('Hello '. $username . '! How can I help you?');
    }

});

$botman->group(['recipient' => 'Guest'], function($bot) {
    $bot->hears('i want (to reserve)|(to book) singapore zoo (card)', function ($bot) {

        $bot->userStorage()->save([
            'action' => 'zoocard'
        ]);

        $bot->startConversation(new \App\Conversations\WhoAreYouConversation());
    });

    $bot->hears('I want to (change)|(update) my photo', function ($bot) {

        $bot->userStorage()->save([
            'action' => 'myphoto'
        ]);

        $bot->startConversation(new \App\Conversations\WhoAreYouConversation());
    });

});


$botman->hears('help[s]?$', function ($bot) {

  $bot->startConversation(new \App\Conversations\HelpConversation());
});


$botman->hears('hr|about hr',function($bot) {
    $bot->startConversation(new \App\Conversations\HRConversation());
});

$botman->hears('i want (to reserve)|(to book) singapore zoo (card)',function($bot){
    $bot->startConversation(new \App\Conversations\ZooCardConversation());
});

$botman->hears('exit|stop|quit|bye', function($bot){
   $bot->reply('Ok. We stop our conversation.');
})->stopsConversation();


//$botman->hears('cancel', function($bot){
//    $bot->reply('Ok. The request has been cancelled');
//})->stopsConversation();


$botman->fallback(function($bot){
   $bot->reply('Hmm...I quite don\'t understand what is your command. You can type \'help\' to get help list');
});