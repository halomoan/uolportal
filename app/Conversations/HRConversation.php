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
use Exception;


class HRConversation  extends Conversation
{

    protected $helplist = array('singaporezoocard','hrdpolicy','changephoto');
    protected $fordate;

    public function run()
    {
        $this->ask('How can I help you in HR matters',function($answer){
            $usersay = $answer->getText();

            if ($usersay == 'help') {
                $this->showHelp();
            }elseif(preg_match('/I want to (book)|(reserve) (the) singapore zoo (card)/i', $usersay)){
                $this->askSingaporeZoo();
            }elseif(preg_match('/I want to (change)|(update) my photo/i', $usersay)){
                $this->askChangePhoto();
            }else{
                $this->say('you said: ' . $usersay);
            }

        });



    }

    protected function showHelp()
    {
        $question = Question::create('HR Matters')
            ->addButtons([
                Button::create('To Book The Singapore Zoo Card')->value('singaporezoocard'),
                Button::create('To Change My Photo')->value('changephoto'),
                Button::create('To Ask HRD Policy')->value('hrdpolicy')
            ]);
        $this->ask($question, function ($answer) {
            $usersay = $answer->getText();
            if ( ! in_array($usersay,$this->helplist) ){

                $this->say('I cannot help on that. Please pick one from the list on below.');

                return $this->repeat();
            }

            switch($usersay){
                case 'singaporezoocard':
                    $this->askSingaporeZoo(); break;
                case 'changephoto':
                    $this->askChangePhoto(); break;

            }


        });
    }

    protected function askSingaporeZoo(){

        $this->bot->startConversation(new ZooCardConversation());
    }

    private function askChangePhoto(){

        $this->bot->startConversation(new ChangePhotoConversation());

    }


    public function stopsConversation(IncomingMessage $message)
    {


        return false;
    }

}