<?php
namespace Simcify;

use Simcify\Sms;

class System {

    /**
     * Return zero of empty
     * 
     * @param   mixed $variable
     * @return  int
     */
    public static function zero($variable) {

        if (empty($variable)) {
            $variable = 0;
        }

        return $variable;

    }
    
    /**
     * Save / Queue message
     * 
     * @return Json
     */
    public static function queue($receipient, $message, $user, $campaignid, $response = NULL) {

        $data = array(
            "company" => $user->company,
            "phonenumber" => escape($receipient["phonenumber"]),
            "name" => escape($receipient["name"]),
            "message" => escape($message),
            "campaign" => escape($campaignid)
        );

        if (!is_null($response)) {
            if ($response->status == "success") {
                $data["status"] = "Sent";
            }else{
                $data["status"] = "Failed";
            }
            
        }else{
            $data["status"] = "Queued";
        }

        Database::table('messages')->insert($data);

    }
    
    /**
     * Check & Update SMS balance
     * 
     * @return Json
     */
    public static function smsbalance($companyid, $cost = NULL) {

        $company = Database::table("companies")->where("id", $companyid)->first();

        if (is_null($cost)) {
            return $company->sms_balance;
        }else{

            $balance = $company->sms_balance - $cost;

            Database::table("companies")->where("id", $companyid)->update(array(
                "sms_balance" => $balance
            ));

            return;

        }

    }
    
    
    /**
     * Get the name of a plan
     * 
     * @return array
     */
    public static function plan($cycle) {

        $plans = array(
            "monthly" => array(
                "name" => "Premium Monthly",
                "price" => env("PRICE_MONTHLY"),
                "cycle" => "monthly"
            ),
            "biannually" => array(
                "name" => "Premium Biannually",
                "price" => env("PRICE_BIANNUALLY"),
                "cycle" => "biannually"
            ),
            "annually" => array(
                "name" => "Premium Annually",
                "price" => env("PRICE_ANNUALLY"),
                "cycle" => "annually"
            )
        );
        
        if(isset($plans[$cycle])){
            return $plans[$cycle];
        }else{
            return NULL;
        }
        
    }
    
    /**
     * Get plan start end date
     * 
     * @return date (string)
     */
    public static function period($company, $cycle) {
        
        if($company->subscription_status == "Active" || $company->subscription_status == "Cancelled"){
            $start = $company->subscription_end;
        }else{
            $start = date('Y-m-d');
        }

        if ($cycle == "monthly") {
            $end = date('Y-m-d', strtotime($start. ' + 30 days'));
        }elseif ($cycle == "biannually") {
            $end = date('Y-m-d', strtotime($start. ' + 180 days'));
        }elseif ($cycle == "annually") {
            $end = date('Y-m-d', strtotime($start. ' + 365 days'));
        }

        return array(
            "start" => $start,
            "end" => $end
            );
        
    }
    

}

