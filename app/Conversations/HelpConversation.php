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


class HelpConversation  extends Conversation
{
    protected $helplist = array('hrd','sapcc');

    public function run()
    {
        $question = Question::create('Help List')
            ->addButtons([
                Button::create('HRD matter')->value('hrd'),
                Button::create('SAPCC matter')->value('sapcc')
            ]);

        $this->ask($question,function($answer){

            /*if ($answer->isInteractiveMessageReply()) {
            }*/
            $value = $answer->getValue();

            if ( ! in_array($value,$this->helplist) ){

                $this->say('I cannot help on that. Please pick one from the list on below.');

                return $this->repeat();
            }
            //$this->say('You selected : ' . $answer->getValue());
        });

    }

    public function stopsConversation(IncomingMessage $message)
    {
        $usersay = $message->getText();

        if (in_array($usersay,$this->helplist)) {
            return true;
        }

        return false;
    }

}