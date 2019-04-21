<?php
/**
 * Created by PhpStorm.
 * User: Halomoan
 * Date: 10/4/2019
 * Time: 9:51 PM
 */

namespace App\Conversations;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;
use Exception;
use App\ZooCard;
use Illuminate\Support\Facades\Auth;

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
            }elseif(preg_match('/I want to (book)|(reserve) singapore zoo card/i', $usersay)){
                $this->askSingaporeZoo();
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

        $this->ask('For Singapore Zoo Booking, What is the date?',function($answer){



            if( $this->checkZooCard($answer)) {
                $this->confirmZooCard();
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
        $this->ask('You choose ' . date('D, d M Y',$this->fordate) . '.Please type \'confirm\' to do confirmation', function($answer){
            $usersay = $answer->getText();
            if ($usersay == 'confirm') {
                Zoocard::create(['user_id' => Auth::User()->id, 'fordate' => date('Y-m-d',$this->fordate), 'status' => '']);


                $this->say('Thank you, You have successfully booked the Singapore Zoo Card on ' . date('D, d M Y',$this->fordate));
                return true;

            } if($usersay == 'change') {

                 $this->ask('Ok. What is the new date?',function($answer){

                     if($this->checkZooCard($answer)) {
                        $this->confirmZooCard();
                     }
                 });
            }else {
                $this->repeat("Type 'confirm' to confirm or 'change' to change or 'cancel' to cancel");
            }
        });
    }


    private function askChangePhoto(){
        $user = Auth::user();
        $attachment = new Image("/storage/avatars/" . $user->userprofile->avatar);
        // Build message object
        $message = OutgoingMessage::create('This is your current photo')
            ->withAttachment($attachment);

        // Reply message object
        $this->getBot()->reply($message);

       $this->askForImages('If you want to change, please send me the new photo now',function($image){
            $this->say('Thank you');
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


        return false;
    }

}