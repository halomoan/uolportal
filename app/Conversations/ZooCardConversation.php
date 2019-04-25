<?php
/**
 * Created by PhpStorm.
 * User: K.halomoan
 * Date: 25/4/2019
 * Time: 3:40 PM
 */

namespace App\Conversations;


use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Illuminate\Support\Facades\Auth;
use App\ZooCard;


class ZooCardConversation extends Conversation
{

    protected $stopsConversation = false;


    public function run()
    {
        $this->ask('For Singapore Zoo Booking, What is the date?',function($answer){

            $usersay = $answer->getText();

            if ($usersay == 'cancel') {
                $this->say('We cancelled the request. Thank you');
                $this->stopsConversation = true;

            } else {
                if( $this->checkZooCard($answer)) {
                    $this->confirmZooCard();
                }
            }


        });
    }

    private function checkZooCard($answer){

        $usersay = $answer->getText();
        $value = preg_replace('/\s+|-+|\/+/', ' ',  $usersay);
        $this->fordate = $this->validateDate($value);
        if(!$this->fordate){
            return $this->repeat('Invalid date. Please enter a valid date, like ' . date('d M Y'));
        } elseif($this->fordate < strtotime("now") ) {

            return $this->repeat('You cannot choose past date, please reenter a future date');
        }

        $zoocards = Zoocard::where('fordate','=', date('Y-m-d',$this->fordate))->where('status','=','')->first();

        if ($zoocards) {
            $this->say('The Singapore Zoo card had been reserved by ' . $zoocards->user->name);
            return $this->repeat('any other date?');
        } else{
            return true;
        }
    }

    private function confirmZooCard(){
        $this->ask('You choose <b>' . date('D, d M Y',$this->fordate) . '</b>.Please type \'confirm\' to do confirmation or \'change\' to do change', function($answer){
            $usersay = $answer->getText();
            if ($usersay == 'confirm') {
                Zoocard::create(['user_id' => Auth::User()->id, 'fordate' => date('Y-m-d',$this->fordate), 'status' => '']);


                $this->say('Thank you, You have successfully booked the Singapore Zoo Card on <b>' . date('D, d M Y',$this->fordate) . '</b>. Remember to collect the card from HR.');
                return true;

            } elseif($usersay == 'change') {

                $this->ask('Ok. What is the new date?',function($answer){

                    if( $this->checkZooCard($answer)) {
                        $this->confirmZooCard();
                    }
                });
            } elseif($usersay == 'cancel'){
                $this->say('We cancelled the request. Thank you');
                $this->stopsConversation = true;
            }else {
                $this->repeat("Type 'confirm' to confirm or 'change' to change or 'cancel' to cancel");
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


    public function stopsConversation(IncomingMessage $message)
    {


        return $this->stopsConversation;
    }

}