<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

include_once 'vendor/autoload.php';

use Simcify\Application;
use Simcify\Database;
use Simcify\Sms;


$app = new Application();


/**
 * Send queued messages
 * 
 */
$messages = Database::table("messages")->where("status", "Queued")->orderBy("id", false)->get();
if (!empty($messages)) {
    foreach ($messages as $key => $message) {

        $data = array();

        if(env('SMS_PROVIDER') == "twilio"){
            $sent = Sms::twilio($message->phonenumber, $message->message);
        }else{
            $sent = Sms::africastalking($message->phonenumber, $message->message);
        }

        if ($sent) {
            $data["status"] = "Sent";
        }else{
            $data["status"] = "Failed";
        }

        Database::table('messages')->where("id", $message->id)->update($data);
        
    }

}

/**
 * Mark sending campaign as complete when completed
 * 
 */
$campaigns = Database::table("campaigns")->where("status", "Queued")->orderBy("id", false)->get();
if (!empty($campaigns)) {
    foreach ($campaigns as $key => $campaign) {
        $queuedmessages = Database::table("messages")->where("campaign", $campaign->id)->where("status", "Queued")->count("id","total")[0]->total;
        if ($queuedmessages == 0) {
            Database::table('campaigns')->where("id", $campaign->id)->update(array("status" => "Completed"));
        }
    }
}
















