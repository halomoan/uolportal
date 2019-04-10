<?php
/**
 * Created by PhpStorm.
 * User: Halomoan
 * Date: 10/4/2019
 * Time: 9:51 PM
 */

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
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

            $value = $answer->getValue();

            if ( ! in_array($value,$this->helplist) ){
                   return $this->repeat('I dont know');
            }
            $this->say('You selected : ' . $answer->getValue());
        });

    }
}