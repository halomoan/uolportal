<?php
/**
 * Created by PhpStorm.
 * User: Halomoan
 * Date: 10/4/2019
 * Time: 9:51 PM
 */

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Auth;


class HRConversation  extends Conversation
{

    protected $helplist = array(
        'zoocard' => 'To Book The Singapore Zoo Card',
        'changephoto' => 'To Change My Photo',
        'hrdpolicy' => 'To Ask HRD Policy',
        'gardencard' => 'To Book Garden By The Bay Card'
    );
    protected $helpidx = 0;
    protected $maxmenu = 3;
    protected $fordate;

    public function run()
    {
        $this->ask('How can I help you in HR matters',function($answer){
            $usersay = $answer->getText();

            if ($usersay == 'help') {
                $this->showHelp();
            }elseif(preg_match('/I want (to book)|(to reserve) singapore zoo(\scard)?/i', $usersay)){
                $this->askSingaporeZoo();
            }elseif(preg_match('/I want (to change)|(to update) my photo/i', $usersay)){
                $this->askChangePhoto();
            }else{
               $this->repeat('If you are not sure, you may type \'help\' for menu');
            }

        });



    }

    protected function showHelp($start = 0)
    {
        $idx = 0;
        $noofmenu = 0;
        $buttons = array();



        $this->helpidx = $this->helpidx + $start;


        if ($this->helpidx <= 0) {
            $this->helpidx = 0;
        } elseif($this->helpidx >= count($this->helplist)) {
            $this->helpidx = $this->helpidx - $start;
        }



        foreach($this->helplist as $key => $value){


            if(++$idx > $this->helpidx) {
                array_push($buttons, Button::create($value)->value($key));
                if (++$noofmenu >= $this->maxmenu){
                    break;
                }
            }
        }

        if ($idx > $this->maxmenu) {
            array_unshift($buttons, Button::create('Less..')->value('less'));
        }

        if ($idx < count($this->helplist)) {
            array_push($buttons, Button::create('More..')->value('more'));
        }


        $question = Question::create('HR Matters')
            ->addButtons($buttons);
        $this->ask($question, function ($answer) {
            $usersay = $answer->getText();

            if ( !( strcmp($usersay, 'more') == 0  || strcmp($usersay, 'less') == 0  || array_key_exists($usersay,$this->helplist))) {
                $this->say('I cannot help on that. Please pick one from the list on below.' . $usersay);

                return $this->repeat();
            }

            switch($usersay){
                case 'zoocard':
                    $this->askSingaporeZoo(); break;
                case 'changephoto':
                    $this->askChangePhoto(); break;
                case 'more':
                    $this->showHelp($this->maxmenu); break;
                case 'less':
                    $this->showHelp(-1 * $this->maxmenu); break;

            }


        });

        return true;
    }

    protected function askSingaporeZoo(){

        $this->bot->userStorage()->save([
            'action' => 'zoocard'
        ]);
        if (Auth::guest()) {
            $this->bot->startConversation(new WhoAreYouConversation());
        } else {
            $user = Auth::user();
            $this->bot->startConversation(new ZooCardConversation($user));
        }
    }

    private function askChangePhoto(){

        $this->bot->userStorage()->save([
            'action' => 'myphoto'
        ]);

        if (Auth::guest()) {
            $this->bot->startConversation(new WhoAreYouConversation());
        } else {
            $user = Auth::user();
            $this->bot->startConversation(new ChangePhotoConversation($user));
        }

    }


    public function stopsConversation(IncomingMessage $message)
    {


        return false;
    }

}