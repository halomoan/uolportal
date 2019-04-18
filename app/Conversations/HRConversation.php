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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

            //$usersay = $answer->getText();


            $value = preg_replace('/\s+|-+|\/+/', ' ',  $answer->getText());

            $this->fordate = $this->validateDate($value);

            if(!$this->fordate){
                return $this->repeat('Invalid date. Please enter a valid date, like ' . Carbon::now()->format('d M Y'));
            }

            $zoocards = Zoocard::where('fordate','=', $this->fordate->toDateString())->where('status','=','')->first();

            if ($zoocards) {
                $this->say('The Singapore Zoo card had been reserved by ' . $zoocards->user->name);
                return $this->repeat('any other date?');
            } else {
                // $this->getBot()->typesAndWaits(2);

                Log::debug($this->fordate);
                $this->ask('You choose ' . $this->fordate->format('D , d M Y'),function($answer){

                    if (true) {
                        Zoocard::create(['user_id' => Auth::User()->id, 'fordate' => $this->fordate->toDateString()]);


                        $this->say('Thank you, You have successfully booked the Singapore Zoo Card on ' . $this->fordate->format('D , d M Y'));
                    } else {
                        $this->repeat("Type 'confirm' to confirm or 'cancel' to cancel");
                    }

                });
            }


        });
    }




    private function validateDate($value){


        try {
            //$d = $carbon::createFromFormat('d M Y',$value);
            $carbon = new Carbon($value);
            return $carbon;
        } catch (Exception $e) {


        }


       /* try {
            $d =  Carbon::parse($value);

            return $d;
        } catch (Exception $e) {

        }*/

        return false;
    }


}