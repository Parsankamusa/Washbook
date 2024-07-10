<?php
namespace Simcify\Controllers;

use Simcify\Controllers\Sales;
use Simcify\Database;
use Simcify\Auth;
use Simcify\Mail;

class branches {
    
    /**
     * Render team page
     * 
     * @return \Pecee\Http\Response
     */
    public function get() {
        
        $title = 'Branches';
        $user  = Auth::user();
        
        if($user->role == "Staff" || $user->role == "Manager"){
            return view('errors/404');
        }
        
        $branches = Database::table('branches')->where('company', $user->company)->orderBy("id", false)->get();
        foreach($branches as $branch){
            $branch->services = Database::table('branchservices')->where('branch', $branch->id)->count("id", "total")[0]->total;
            $branch->revenue = Database::table('sales')->where('branch', $branch->id)->sum("total", "total")[0]->total;
        }
        
        $services = Database::table('services')->where('company', $user->company)->orderBy("id", false)->get();

        return view("branches", compact("user", "title","branches","services"));
        
    }
    
    /**
     * Create branch 
     * 
     * @return Json
     */
    public function create() {
        
        $user = Auth::user();
        
        $data = array(
            "company"  => $user->company,
            "name"        => escape(input('name')),
            "location"    => escape(input('location')),
            "phone"       => escape(input('phone')),
        );


        Database::table('branches')->insert($data);
        $branchid = Database::table('branches')->insertId();
        
        if(!empty($_POST["services"])){
            foreach($_POST["services"] as $service){
                
                $data = array(
                        "company" => $user->company,
                        "branch" => $branchid,
                        "service" => $service,
                    );
                Database::table('branchservices')->insert($data);
                
            }
        }
        
        return response()->json(responder("success", "Alright!", "Branch successfully created.", "reload()"));
        
    }
    
    
    /**
     * Render branch's details page
     * 
     * @return \Pecee\Http\Response
     */
    public function details($branchid) {
        
        $sales = $members = $payments = array();
        $user   = Auth::user();
        $branch = Database::table('branches')->where("company", $user->company)->where('id', $branchid)->first();
        if (empty($branch)) {
            return view('errors/404');
        }
        
        $title = $branch->name;
        $branch->services = Database::table('branchservices')->where('branch', $branch->id)->count("id", "total")[0]->total;
        $branch->revenue = Database::table('sales')->where('branch', $branch->id)->sum("total", "total")[0]->total;
        $notes = Database::table('notes')->where('item', $branch->id)->where('type', "Branch")->orderBy("id", false)->get();

        if (isset($_GET["view"]) && $_GET["view"] == "sales") {
            $sales = Sales::sales($user, "branch", $branch);
        }elseif (isset($_GET["view"]) && $_GET["view"] == "members") {

            $members = Database::table('users')->where('branchid', $branch->id)->orderBy("id", false)->get();
            foreach ($members as $key => $member) {
                $member->sales = Database::table('servicesales')->where('provided_by', $member->id)->count("id", "total")[0]->total;
                $member->branch = Database::table('branches')->where('id', $member->branchid)->first();
            }

        }

        return view("branch-details", compact("user", "title", "branch","notes","members","sales","payments"));
        
    }
    
    /**
     * Branch update view
     * 
     * @return \Pecee\Http\Response
     */
    public function updateview() {

        $user     = Auth::user();
        $branch   = Database::table('branches')->where('id', input("branchid"))->first();

        $serviceids = array();
        $services = Database::table('branchservices')->where('branch', $branch->id)->orderBy("id", false)->get();
        foreach ($services as $key => $service) {
            $serviceids[] = $service->service;
        }

        $services = Database::table('services')->where('company', $user->company)->get();

        return view("modals/update-branch", compact("branch", "user","services","serviceids"));
        
    }
    
    /**
     * Update team member account
     * 
     * @return Json
     */
    public function update() {
        
        $user = Auth::user();

        $data = array(
            "name" => escape(input('name')),
            "location" => escape(input('location')),
            "phone" => escape(input('phone')),
        );


        Database::table('branches')->where("id", input("branchid"))->update($data);
        Database::table('branchservices')->where("branch", input("branchid"))->delete();
        
        if(!empty($_POST["services"])){
            foreach($_POST["services"] as $service){
                
                $data = array(
                        "company" => $user->company,
                        "branch" => input("branchid"),
                        "service" => $service,
                    );
                Database::table('branchservices')->insert($data);
                
            }
        }

        return response()->json(responder("success", "Alright!", "Branch successfully updated.", "reload()"));
        
    }
    
    /**
     * Delete branch
     * 
     * @return Json
     */
    public function delete() {
        
        $user     = Auth::user();
        $branches = Database::table('branches')->where('company',$user->company)->count("id", "total")[0]->total;
        
        if($branches < 1){
            return response()->json(responder("error", "Hmmm!", "You should have atleast active one branch."));
        }

        if (input("branchid") == $user->branchid) {
            return response()->json(responder("error", "Hmmm!", "You can not delete your active branch. Change your branch and try again."));
        }

        Database::table('branches')->where('id', input("branchid"))->delete();
        return response()->json(responder("success", "Alright!", "Branch successfully deleted.", "reload()"));
        
    }
    
}