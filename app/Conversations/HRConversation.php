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
use App\ZooCard;
use Illuminate\Support\Facades\Auth;

class HRConversation  extends Conversation
{

    protected $helplist = array('singaporezoocard','hrdpolicy');
    protected $fordate;

    public function run()
    {
        $question = Question::create('HR Matters')
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

        $this->ask('For Singapore Zoo Booking, What is the date?',function($answer){

            $usersay = $answer->getText();


            $value = preg_replace('/\s+|-+|\/+/', ' ',  $usersay);

            $this->fordate = $this->validateDate($value);

            if(!$this->fordate){
                return $this->repeat('Invalid date. Please enter a valid date, like ' . date('d M Y'));
            }



            $zoocards = Zoocard::where('fordate','=', date('Y-m-d',$this->fordate))->where('status','=','')->first();

            if ($zoocards) {
                $this->say('The Singapore Zoo card had been reserved by ' . $zoocards->user->name);
                return $this->repeat('any other date?');
            } else {
                // $this->getBot()->typesAndWaits(2);

                $this->ask('You choose ' . date('D, d m Y',$this->fordate) . '.Please type \'confirm\' to do confirmation', function($answer){

                    if ($answer->getText() == 'confirm') {
                        Zoocard::create(['user_id' => Auth::User()->id, 'fordate' => date('Y-m-d',$this->fordate), 'status' => '']);


                        $this->say('Thank you, You have successfully booked the Singapore Zoo Card on ' . date('D, d m Y',$this->fordate));
                    } else {
                        $this->repeat("Type 'confirm' to confirm or 'cancel' to cancel");
                    }

                });
            }


        });
    }




    private function validateDate($value){


        try {
            $timestamp = strtotime($value);
            return $timestamp;
        } catch (Exception $e) {

        }
        return false;
    }


}