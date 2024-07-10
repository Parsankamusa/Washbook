<?php
namespace Simcify\Controllers;

use Simcify\Database;
use Simcify\Auth;
use Simcify\Mail;

class Services {
    
    /**
     * Render team page
     * 
     * @return \Pecee\Http\Response
     */
    public function get() {
        
        $title = 'Services';
        $user  = Auth::user();
        
        if($user->role == "Admin" || $user->role == "Owner"){
            $branches = Database::table('branches')->where('company', $user->company)->orderBy("id", false)->get();
        }else{
            $branches = Database::table('branches')->where('company', $user->company)->where('id', $user->branchid)->orderBy("id", false)->get();
        }
        
        if($user->role == "Admin" || $user->role == "Owner"){
            $services = Database::table('services')->where('company', $user->company)->orderBy("id", false)->get();
        }else{
            $serviceIds = array(0);
            $branchservices = Database::table('branchservices')->where('company', $user->company)->where("branch", $user->branchid)->get("service");
            foreach($branchservices as $branchservice){
                $serviceIds[] = $branchservice->service;
            }
            $services = Database::table('services')->where('company', $user->company)->where("id","IN", "(".implode(",", $serviceIds).")")->orderBy("id", false)->get();
        }
        
        foreach($services as $service){
            $service->revenue = Database::table("servicesales")->where("service", $service->id)->sum("amount", "total")[0]->total;
            $service->sales = Database::table("servicesales")->where("service", $service->id)->count("id", "total")[0]->total;
            $service->branches = Database::table("branchservices")->where("service", $service->id)->count("id", "total")[0]->total;
        }
        
        return view("services", compact("user", "title","services","branches"));
        
    }
    
    /**
     * Create service 
     * 
     * @return Json
     */
    public function create() {
        
        $user = Auth::user();

        if( input('cost') < input('commission') ){

            return response()->json(responder("error", "Oops!", "Service cost must be greater than the commission."));

        }

        $data = array(
            "company"  => $user->company,
            "name"        => escape(input('name')),
            "cost"        => escape(input('cost')),
            "commission"  => escape(input('commission')),
        );
        
        Database::table('services')->insert($data);
        $serviceid = Database::table('services')->insertId();

        if(!empty($_POST["branches"])){
            foreach($_POST["branches"] as $branch){
                
                $data = array(
                        "company" => $user->company,
                        "branch" => $branch,
                        "service" => $serviceid,
                    );
                Database::table('branchservices')->insert($data);
                
            }
        }
        
        return response()->json(responder("success", "Alright!", "Service successfully created.", "reload()"));
        
    }
    
    /**
     * Service update view
     * 
     * @return \Pecee\Http\Response
     */
    public function updateview() {

        $user    = Auth::user();
        $service = Database::table('services')->where('id', input("serviceid"))->first();
        
        if($user->role == "Owner" || $user->role == "Admin"){
            $branches = Database::table('branches')->where('company', $user->company)->orderBy("id", false)->get();
        }else{
            $branches = Database::table('branches')->where('company', $user->company)->where('id', $user->branchid)->orderBy("id", false)->get();
        }
        
        $branchids = array(0);
        $branchservices = Database::table('branchservices')->where('company', $user->company)->where('service', $service->id)->get("branch");
        foreach($branchservices as $branchservice){
            $branchids[] = $branchservice->branch;
        }
        
        return view("modals/update-service", compact("service", "user","branches","branchids"));
        
    }
    
    /**
     * Update service
     * 
     * @return Json
     */
    public function update() {
        
        $user = Auth::user();

        if( input('cost') < input('commission') ){
            return response()->json(responder("error", "Oops!", "Service cost must be greater than the commission."));
        }

        $data = array(
            "company"  => $user->company,
            "name"        => escape(input('name')),
            "cost"        => escape(input('cost')),
            "commission"  => escape(input('commission')),
        );
        Database::table('services')->where("id", input("serviceid"))->update($data);

        Database::table('branchservices')->where("service", input("serviceid"))->delete();
        if(!empty($_POST["branches"])){
            foreach($_POST["branches"] as $branch){
                
                $data = array(
                        "company" => $user->company,
                        "branch" => $branch,
                        "service" => input("serviceid"),
                    );
                Database::table('branchservices')->insert($data);
                
            }
        }
        
        return response()->json(responder("success", "Alright!", "Service successfully updated.", "reload()"));
        
    }
    
    /**
     * Delete service
     * 
     * @return Json
     */
    public function delete() {
        
        Database::table('services')->where("id", input("serviceid"))->delete();

        return response()->json(responder("success", "Alright!", "Service successfully deleted.", "reload()"));
        
    }
    
}