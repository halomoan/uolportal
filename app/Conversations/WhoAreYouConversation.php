<?php
/**
 * Created by PhpStorm.
 * User: K.halomoan
 * Date: 30/4/2019
 * Time: 12:25 PM
 */

namespace App\Conversations;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\User;

class WhoAreYouConversation extends Conversation
{

    protected $email;
    protected $passcode;

    public function run()
    {
        $this->ask('Please let me know who are you by telling me your email address',function($answer){

            $this->email = $answer->getText();
            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->say('Your email is invalid');
                $this->repeat();
            } else{
                $this->ask('We have emailed the passcode to your email: <b>' . $answer . '</b>.<br><br> Please enter the passcode on here for validation',function($answer){
                    $this->passcode = $answer->getText();

                    if ($this->passcode == 'abc'){

                        $action = $this->bot->userStorage()->find();

                        $user = $this->getUser($this->email);

                        if($user) {

                            switch($action['action']) {

                                case 'zoocard':
                                    $this->bot->startConversation(new ZooCardConversation($user));
                                    break;
                                case 'myphoto' :
                                    $this->bot->startConversation(new ChangePhotoConversation($user));
                                    break;
                            }
                        } else {
                            $this->say('We cannot find your user id');
                        }


                    } else {
                        $this->repeat('Invalid passcode. Please check your email and enter the passcode on here for validation');
                    }
                });

            }


        });
    }

    private function getUser($email, $passcode = 'abc') {

        return User::where('email','=',$email)->first();

    }
}