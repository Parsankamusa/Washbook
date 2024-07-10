<?php
namespace Simcify\Controllers;

use Simcify\File;
use Simcify\Auth;
use Simcify\Database;
use DotEnvWriter\DotEnvWriter;

class Settings {
    
    /**
     * Render settings page
     * 
     * @return \Pecee\Http\Response
     */
    public function get() {
        
        $title = "Settings";
        $user = Auth::user();
        $company = Database::table("companies")->where("id", $user->company)->first();
        $timezones = Database::table("timezones")->get();
        $currencies = Database::table("currencies")->get();
        $countries = Database::table("countries")->get();
        
        return view('settings', compact("user", "title", "company", "timezones", "currencies", "countries"));
        
    }
    
    /**
     * Update profile infomation
     * 
     * @return Json
     */
    public function updateprofile() {
        
        $user = Auth::user();
        
        $account = Database::table("users")->where("email", input("email"))->first();
        if (!empty($account) && $account->id != $user->id) {
            return response()->json(responder("error", "Oops", input("email") . " already exists."));
        }
        
        $data = array(
            "fname" => escape(input("fname")),
            "lname" => escape(input("lname")),
            "email" => escape(input("email")),
            "phonenumber" => escape(input("phonenumber")),
            "address" => escape(input("address"))
        );
        
        Database::table("users")->where("id", $user->id)->update($data);
        return response()->json(responder("success", "Alright", "Profile successfully updated", "reload()"));
        
    }
    
    /**
     * Update company on settings page
     * 
     * @return Json
     */
    public function updatecompany() {
        
        $user = Auth::user();
        
        $data = array(
            "name" => escape(input("name")),
            "email" => escape(input("email")),
            "country" => escape(input("country")),
            "phone" => escape(input("phone")),
            "address" => escape(input("address")),
            "city" => escape(input("city")),
            "currency" => escape(input("currency")),
            "thankyou_message" => escape(input("thankyou_message")),
            "timezone" => escape(input("timezone"))
        );

        if (!empty(input("send_thankyou"))) {
            $data["send_thankyou"] = "Enabled";
        }else{
            $data["send_thankyou"] = "Disabled";
        }
        
        Database::table("companies")->where("id", $user->company)->update($data);

        return response()->json(responder("success", "Alright", "Company settings successfully updated", "reload()"));
        
    }
    
    
    /**
     * Update password on settings page
     * 
     * @return Json
     */
    public function updatepassword() {
        
        $user = Auth::user();
        if (hash_compare($user->password, Auth::password(input("current")))) {
            Database::table(config('auth.table'))->where("id", $user->id)->update(array(
                "password" => Auth::password(input("password"))
            ));
            return response()->json(responder("success", "Alright", "Password successfully updated", "reload()"));
        } else {
            return response()->json(responder("error", "Oops", "You have entered an incorrect password."));
        }
        
    }

    /**
     * Update system settings
     * 
     * @return Json
     */
    public function updatesystem() {

        $envPath = str_replace("src/Controllers", ".env", dirname(__FILE__));
        $env = new DotEnvWriter($envPath);
        $env->castBooleans();

        $envitems = array("APP_NAME", "MAIL_USERNAME", "MAIL_SENDER","SMTP_HOST","SMTP_PORT","SMTP_PASSWORD","MAIL_ENCRYPTION","SMS_PROVIDER","AFRICASTALKING_USERNAME","AFRICASTALKING_KEY","AFRICASTALKING_SENDERID","TWILIO_SID","TWILIO_AUTHTOKEN","TWILIO_PHONENUMBER");

        foreach ($envitems as $key => $envitem) {
            $env->set($envitem, $_POST[$envitem]);
        }

        if (!empty(input("SMTP_AUTH"))) {
            $env->set("SMTP_AUTH", true);
        }else{
            $env->set("SMTP_AUTH", false);
        }

        $uploaditems = array("APP_LOGO", "APP_ICON");
        foreach ($uploaditems as $key => $uploaditem) {
            if (!empty($_POST[$uploaditem])) {
                $upload = File::upload(
                    $_POST[$uploaditem], 
                    "app",
                    array(
                        "source" => "base64",
                        "extension" => "png"
                    )
                );

                if ($upload['status'] == "success") {
                    File::delete(env($uploaditem), "app");
                    $env->set($uploaditem, $upload['info']['name']);
                }
            }
        }
        $env->save();

        return response()->json(responder("success", "Alright", "System settings successfully updated", "reload()"));

    }
    
    
}