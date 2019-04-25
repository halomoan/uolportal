<?php
/**
 * Created by PhpStorm.
 * User: K.halomoan
 * Date: 25/4/2019
 * Time: 3:34 PM
 */

namespace App\Conversations;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Attachments\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;

class ChangePhotoConversation extends Conversation
{

    protected $stopsConversation = false;

    public function run()
    {
        $user = Auth::user();
        $attachment = new Image("/storage/avatars/" . $user->userprofile->avatar);
        // Build message object
        $message = OutgoingMessage::create('This is your current photo')
            ->withAttachment($attachment);

        // Reply message object
        $this->getBot()->reply($message);

        $this->askForImages('If you want to change, please send me the new photo now',function($images){



            foreach($images as $image) {
                $data = $image->getUrl();
                $pos  = strpos($data, ';');
                $type = explode(':', substr($data, 0, $pos))[1];

                $ext = '.jpg';

                switch($type) {
                    case 'image/jpeg':
                        $ext = '.jpg';
                        break;
                    case 'image/png':
                        $ext = '.png';
                        break;
                    case 'image/bmp':
                        $ext = '.bmp';
                        break;
                }


                $encodedData = str_replace(' ','+',$data);
                $encodedData =  substr($encodedData,strpos($encodedData,",")+1);
                $avatarName = Auth::user()->name . $ext;

                if(Storage::disk('public')->put('avatars/' . $avatarName ,  base64_decode($encodedData))) {
                    $user = Auth::user();

                    $user->userprofile->avatar = $avatarName;
                    $user->userprofile->save();

                    $this->say('Your photo has been successfully changed. Please refresh this page');
                }else{
                    $this->say('Something is wrong. We can\'t change your photo');
                }
            }



        },function($answer){
            $usersay = $answer->getText();
            if($usersay == 'cancel'){
                $this->say('We cancelled the request. Thank you');
                $this->stopsConversation = true;
            } else {
                $this->say('Ummm this does not look like a valid image to me.' . $usersay);
                $this->repeat();
            }
        });

    }

    public function stopsConversation(IncomingMessage $message)
    {

        return $this->stopsConversation;
    }
}