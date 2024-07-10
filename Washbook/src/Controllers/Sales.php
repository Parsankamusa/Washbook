<?php
namespace Simcify\Controllers;

use Simcify\Database;
use Simcify\System;
use Simcify\Auth;
use Simcify\Sms;

class Sales {


    /**
     * Create a sale  
     * 
     * @return Json
     */
    public function create() {

        $saleid = rand(11111111, 999999999);
        $user = Auth::user();
        
        if(empty($_POST["services"])){
            return response()->json(responder("warning", "Hmmm!", "Select atleast one service."));
        }
        
        $client   = Database::table('clients')->where('phonenumber', escape(input('phonenumber')) )->first();
        if(!empty($client)){

            Database::table('clients')->where('id',$client->id)->update(array('fullname' => escape(input('client_name'))));
            $clientid = $client->id;

        } else {

            $newclient = array(
                "company" => $user->company,
                "branch" => $user->branchid,
                "fullname" => escape(input('client_name')),
                "phonenumber" => escape(input('phonenumber'))
            );

            Database::table('clients')->insert($newclient);
            $clientid = Database::table('clients')->insertId();
        }
        
        $data = array(
            "company" => $user->company,
            "branch" => $user->branchid,
            "client" => $clientid,
            "item" => escape(input('item')),
            "created_at" => escape(input('date')." ".input('time')),
            "payment_method" => escape(input('payment_method')),
            "reference" => escape(input('reference'))
        );
        
        if(!empty(input("paid"))){
            $data["paid"] = "Yes";
        }
        
        Database::table("sales")->insert($data);
        $saleid = Database::table("sales")->insertId();
        if(empty($saleid)){
            return response()->json(responder("error", "Hmmm!", "Something went wrong, please try again."));
        }
        
        $total = $commission = 0;
        
        foreach($_POST["services"] as $serviceid){
            
            $total = $total + input('cost-'.$serviceid);
            $commission = $commission + input('commission-'.$serviceid);
            
            $data = array(
                'company'   => $user->company,
                'branch'   => $user->branchid,
                'client'   => $clientid,
                'sale'   => $saleid,
                'amount'        => escape(input('cost-'.$serviceid)),
                'commission'  => escape(input('commission-'.$serviceid)),
                'provided_by' => escape(input('perfomed_by-'.$serviceid)),
                'service'  => escape($serviceid)
            );
    
            Database::table('servicesales')->insert($data);
            
            $this->addcommission(input('perfomed_by-'.$serviceid), input('commission-'.$serviceid));
            
        }
        
        Database::table('sales')->where("id", $saleid)->update(array(
                "total" => $total,
                "commission" => $commission,
            ));
        
        // Send Thank you message
        if($user->parent->send_thankyou == "Enabled" && !empty(input('phonenumber'))){
            
            $thankyou_message = str_replace(
                    array("{customer_name}","{company_name}"), 
                    array(input('client_name'), $user->parent->name), 
                    $user->parent->thankyou_message
                );
            
            if(env('SMS_PROVIDER') == "twilio"){
                $response = Sms::twilio(input("phonenumber"), $thankyou_message);
            }else{
                $response = Sms::africastalking(input("phonenumber"), $thankyou_message);
            }
            System::queue(array(
                        "phonenumber" => input('phonenumber'),
                        "name" => input('client_name')
                    ), $thankyou_message, $user, "NULL", $response);
            
        }

        return response()->json(responder("success", "Alright!", "Sale successfully created.", "reload()"));

    }
    
    /**
     * Create sale form  
     * 
     * @return Json
     */
    public function addcommission($perfomed_by, $commission) {
        
        $staff = Database::table('users')->where('id', $perfomed_by)->first();
        
        if(empty($staff)){
            return;
        }
        
        Database::table('users')->where("id", $perfomed_by)->update(array(
                "balance" => ($staff->balance + $commission)
            ));
            
        return;
        
    }
    
    /**
     * Update Commission 
     * 
     * @return Json
     */
    public function updatecommission($saleid) {
        
        $servicesales = Database::table('servicesales')->where("sale", $saleid)->get();
        
        if(!empty($servicesales)){
            foreach($servicesales as $servicesale){
                
                $staff = Database::table('users')->where('id', $servicesale->provided_by)->first();
                
                Database::table('users')->where("id", $servicesale->provided_by)->update(array(
                        "balance" => ($staff->balance - $servicesale->commission)
                    ));
                
            }
        }
        
        return;
        
    }
    
    /**
     * Create sale form  
     * 
     * @return Json
     */
    public function checkout() {

        $user     = Auth::user();
        
        if($user->role == "Owner" || $user->role == "Admin"){
            $staff    = Database::table('users')->where('company',$user->company)->orderBy("id", false)->get();
        }else{
            $staff    = Database::table('users')->where('branchid',$user->branchid)->orderBy("id", false)->get();
        }
        
        if($user->role == "Owner" || $user->role == "Admin"){
            $services = Database::table('services')->where('company', $user->company)->orderBy("id", false)->get();
        }else{
            $serviceids = array(0);
            $branchservices = Database::table('branchservices')->where('company', $user->company)->where('branch', $user->branchid)->get("service");
            foreach($branchservices as $branchservice){
                $serviceids[] = $branchservice->service;
            }
            $services = Database::table('services')->where('company', $user->company)->where("id","IN", "(".implode(",", $serviceids).")")->orderBy("id", false)->get();
        }

        return view("modals/create-sale", compact("user","services","staff"));
    }
    
    /**
     * Get Sales view page  
     * 
     * @return Json
     */
    public function get() {

        $user  = Auth::user();
        $title = "Service Sales";

        $sales = self::sales($user);
        
        return view("sales", compact("user","title","sales"));

    } 

    /**
     * Fetch Sales
     * 
     * @return Json
     */
    public static function sales($user, $type = "sales", $payload = NULL) {

        if ($type == "sales") {
            if($user->role == "Owner" || $user->role == "Admin"){
                $sales = Database::table('sales')->where('company',$user->company)->orderBy("id", false)->get();
            }else{
                $sales = Database::table('sales')->where('company',$user->company)->where('branch',$user->branch)->orderBy("id", false)->get();
            }
        }elseif($type == "client"){
            if($user->role == "Owner" || $user->role == "Admin"){
                $sales = Database::table('sales')->where('company',$user->company)->where('client',$payload->id)->orderBy("id", false)->get();
            }else{
                $sales = Database::table('sales')->where('company',$user->company)->where('branch',$user->branch)->where('client',$payload->id)->orderBy("id", false)->get();
            }
        }elseif($type == "branch"){
            $sales = Database::table('sales')->where('company',$user->company)->where('branch',$payload->id)->orderBy("id", false)->get();
        }elseif($type == "team"){

            if($user->role == "Owner" || $user->role == "Admin"){
                $servicesales = Database::table('servicesales')->where('company',$user->company)->where('provided_by', $payload->id)->orderBy("id", false)->get("sale");
            }else{
                $servicesales = Database::table('servicesales')->where('branch',$user->branchid)->where('provided_by', $payload->id)->orderBy("id", false)->get("sale");
            }
            
            $saleids = array(0);
            foreach($servicesales as $servicesale){
                $saleids[] = $servicesale->sale;
            }
            $sales = Database::table('sales')->where('id',"IN", "(".implode(",", $saleids).")")->orderBy("id", false)->get();

        }
        
        foreach($sales as $sale){
            $sale->client = Database::table('clients')->where('id',$sale->client)->first();
            $sale->branch  = Database::table('branches')->where('id',  $sale->branch)->first();
            $sale->servicesales = Database::table('servicesales')->where('sale',$sale->id)->get();
            if(!empty($sale->servicesales)){
                foreach($sale->servicesales as $servicesale){
                    $servicesale->staff  = Database::table('users')->where('id',  $servicesale->provided_by)->first();
                    $servicesale->service  = Database::table('services')->where('id',  $servicesale->service)->first();
                }
            }
            
        }

        return $sales;

    }

    /**
     * Get sale update view form 
     * 
     * @return Json
     */
    public function updateview() {

        $user = Auth::user();
        
        $sale = Database::table('sales')->where('id', input("saleid"))->where('company',$user->company)->first();
        
        if($user->role == "Owner" || $user->role == "Admin"){
            $staff    = Database::table('users')->where('company',$user->company)->orderBy("id", false)->get();
        }else{
            $staff    = Database::table('users')->where('branch',$user->branchid)->orderBy("id", false)->get();
        }
        
        if($user->role == "Owner" || $user->role == "Admin"){
            $services = Database::table('services')->where('company', $user->company)->orderBy("id", false)->get();
        }else{
    
            $serviceids = array(0);
            $branchservices = Database::table('branchservices')->where('company', $user->company)->where('branch', $user->branchid)->get("service");
            foreach($branchservices as $branchservice){
                $serviceids[] = $branchservice->service;
            }
            $services = Database::table('services')->where('company', $user->company)->where("id","IN", "(".implode(",", $serviceids).")")->orderBy("id", false)->get();
        }
        
        if(!empty($services)){
            foreach($services as $service){
                $service->sale = Database::table('servicesales')->where('sale',$sale->id)->where('service',$service->id)->first();
                if(!empty($service->sale)){
                    $service->required = "required";
                    $service->cost = $service->sale->amount;
                    $service->commission = $service->sale->commission;
                }else{
                    $service->required = "";
                }
            }
            
        }
        
        $sale->client   = Database::table('clients')->where('id',$sale->client)->first();

        return view("modals/update-sale", compact("user","sale","services","staff"));
    }  

    /**
     * Update a sale 
     * 
     * @return Json
     */
    public function update() {

        $user     = Auth::user();
        
        if(empty($_POST["services"])){
            return response()->json(responder("warning", "Hmmm!", "Select atleast one service."));
        }
        $sale = Database::table('sales')->where('id', input("saleid"))->where('company',$user->company)->first();
        
        $data = array(
            'item'        => escape(input('item')),
            'payment_method'  => escape(input('payment_method')),
            'reference'  => escape(input('reference'))
        );
        
        if(!empty(input("paid"))){
            $data["paid"] = "Yes";
        }else{
            $data["paid"] = "No";
        }
        
        Database::table('sales')->where("id", $sale->id)->update($data);
        $total = $commission = 0;
        $this->updatecommission($sale->id);
        Database::table('servicesales')->where("sale", $sale->id)->delete();
        
        foreach($_POST["services"] as $serviceid){
            
            $total = $total + input('cost-'.$serviceid);
            $commission = $commission + input('commission-'.$serviceid);
            
            $data = array(
                'company'   => $user->company,
                'branch'   => $user->branchid,
                'client'   => $sale->client,
                'sale'   => $sale->id,
                'amount'        => escape(input('cost-'.$serviceid)),
                'commission'  => escape(input('commission-'.$serviceid)),
                'provided_by' => escape(input('perfomed_by-'.$serviceid)),
                'service'  => escape($serviceid)
            );
    
            Database::table('servicesales')->insert($data);
            
            $this->addcommission(input('perfomed_by-'.$serviceid), input('commission-'.$serviceid));
            
        }
        
        Database::table('sales')->where("id", $sale->id)->update(array(
                "total" => $total,
                "commission" => $commission,
            ));

        return response()->json(responder("success", "Alright!", "Sale successfully updated.", "reload()"));
        
    }  

    /**
     * When sale is paid  
     * 
     * @return Json
     */
    public function paid() {

        $user     = Auth::user();

        $data = array(
            'paid'  => "Yes",
            'payment_method'  => escape(input('payment_method')),
            'reference'  => escape(input('reference'))
        );

        Database::table('sales')->where('id',input("saleid"))->update($data);

        return response()->json(responder("success", "Alright!", "Sale successfully marked as paid.", "reload()"));
    }  

    /**
     * Get view page  
     * 
     * @return Json
     */
    public function delete() {
        
        $user = Auth::user();
        
        if (!hash_compare($user->password, Auth::password(input("password")))) {
            return response()->json(responder("error", "Hmmm!", "You have entered an incorrect password."));
        }
        
        $sale = Database::table('sales')->where('id',input("saleid"))->where('company',$user->company)->first();
        if(empty($sale)){
            return response()->json(responder("error", "Hmmm!", "Sale could not be found, please try again."));
        }
        
        if(!empty(input("deduct")) && input("deduct") == "Yes"){
            
            $servicesales = Database::table('servicesales')->where("sale", $sale->id)->get();
            
            if(!empty($servicesales)){
                foreach($servicesales as $servicesale){
                    
                    $staff = Database::table('users')->where('id', $servicesale->provided_by)->first();
                    
                    if(!empty($staff)){
                        Database::table('users')->where("id", $servicesale->provided_by)->update(array(
                                "balance" => ($staff->balance - $servicesale->commission)
                            ));
                    }
                    
                }
            }
            
        }

        Database::table('sales')->where('id',$sale->id)->delete();

        return response()->json(responder("success", "Alright!", "Sale successfully created.", "reload()"));
    }     
}
