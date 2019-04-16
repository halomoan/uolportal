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
use Exception;
use Carbon\Carbon;
use App\ZooCard;

class HRDConversation  extends Conversation
{

    protected $helplist = array('singaporezoocard','hrdpolicy');

    public function run()
    {
        $question = Question::create('HRD Matters')
            ->addButtons([
                Button::create('To Book The Singapore Zoo Card')->value('singaporezoocard'),
                Button::create('To Ask HRD Policy')->value('hrdpolicy')
            ]);

        $this->ask($question,function($answer){

            $value = $answer->getText();

            if ( ! in_array($value,$this->helplist) ){

                $this->say('I cannot help on that. Please pick one from the list on below.');

                return $this->repeat();
            }

            if($value == 'singaporezoocard'){
                $this->askSingaporeZoo();
            }
        });

    }

    protected function askSingaporeZoo(){
        $this->ask('What is the date?',function($answer){


            $value = preg_replace('/\s+|-+|\/+/', ' ',  $answer->getText());

            $date = $this->validateDate($value);

            if(!$date){
               return $this->repeat('Invalid date. What is the date?');
            }

            $zoocards = Zoocard::where('fordate','=', $date->toDateString())->where('status','=','')->first();

            if ($zoocards) {
                $this->say('The Singapore Zoo card had been reserved by ' . $zoocards->requester);
            } else {

                $this->say('Thank you, You have successfully booked the Singapore Zoo Card on ' . $value);
            }

        });
    }

    private function validateDate($date,$format = 'd M Y'){

        try {
            $d = Carbon::createFromFormat($format,$date);
        } catch (Exception $e) {
            return false;
        }



        return $d;
    }
}