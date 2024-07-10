<?php
namespace Simcify\Controllers;

use Simcify\Controllers\Sales;
use Simcify\Database;
use Simcify\Auth;
use Simcify\Mail;

class Team {
    
    /**
     * Render team page
     * 
     * @return \Pecee\Http\Response
     */
    public function get() {
        
        $title = "Team Members";
        $user  = Auth::user();
        
        if ($user->role == "Staff") {
            return view('errors/404');
        }
        
        if($user->role == "Owner" || $user->role == "Admin"){
            $members = Database::table('users')->where('company', $user->company)->orderBy("id", false)->get();
        }else{
            $members = Database::table('users')->where('company', $user->company)->where('branchid', $user->branchid)->where('role',"!=", "Owner")->orderBy("id", false)->get();
        }
        
        foreach ($members as $key => $member) {
            $member->sales = Database::table('servicesales')->where('provided_by', $member->id)->count("id", "total")[0]->total;
            $member->branch = Database::table('branches')->where('id', $member->branchid)->first();
        }
        $branches = Database::table('branches')->where('company', $user->company)->orderBy("id", false)->get();
        
        return view("team", compact("user", "title", "members","branches"));
        
    }
    
    /**
     * Create team member account 
     * 
     * @return Json
     */
    public function create() {
        
        $user = Auth::user();
        $password = rand(111111, 999999);

        if (!empty(input("email"))) {
            $account = Database::table('users')->where('email', input("email"))->first();
            if (!empty($account)) {
                return response()->json(responder("warning", "Hmmm!", "This email address already exists."));
            }
        }

        if (input("role") != "Staff" && empty(input("email"))) {
            return response()->json(responder("warning", "Hmmm!", "An email is required for ".input("role")." role for login purposes."));
        }
        
        $data = array(
            "company" => $user->company,
            "fname" => escape(input('fname')),
            "lname" => escape(input('lname')),
            "phonenumber" => escape(input('phonenumber')),
            "type" => escape(input('type')),
            "role" => escape(input('role')),
            "branchid" => escape(input('branchid')),
            "status" => escape(input('status')),
            "address" => escape(input('address')),
            "password" => Auth::password($password)
        );
        
        if(!empty(input('email'))){
            $data["email"] = escape(input('email'));
        }
        
        
        Database::table('users')->insert($data);
        $teamid = Database::table('users')->insertId();

        if (!empty($teamid) && input("role") != "Staff") {
            Mail::send(
                input('email'),
                "Welcome to ".env("APP_NAME")."!",
                array(
                    "title" => "Welcome to ".env("APP_NAME")."!",
                    "subtitle" => "A new account has been created for you at ".env("APP_NAME").".",
                    "buttonText" => "Login Now",
                    "buttonLink" => env("APP_URL"),
                    "message" => "These are your login Credentials:<br><br><strong>Email:</strong>".input('email')."<br><strong>Password:</strong>".$password."<br><br>Cheers!<br>".env("APP_NAME")." Team."
                ),
                "withbutton"
            );
        }
        
        return response()->json(responder("success", "Alright!", "Team Member account successfully created.", "redirect('" . url('Team@details', array(
            'teamid' => $teamid
        )) . "')"));
        
    }
    
    /**
     * Render member's details page
     * 
     * @return \Pecee\Http\Response
     */
    public function details($teamid) {
        
        $sales = $payments = $services = array();
        $user   = Auth::user();
        $member = Database::table('users')->where('company', $user->company)->where('id', $teamid)->first();
        
        if (empty($member)) {
            return view('errors/404');
        }
        
        $title = $member->fname." ".$member->lname;
        $member->sales = Database::table('servicesales')->where('provided_by', $member->id)->count("id","total")[0]->total;
        $member->branch = Database::table('branches')->where('id', $member->branchid)->first();

        $notes = Database::table('notes')->where('item', $teamid)->where('type', "Team")->where('company', $user->company)->orderBy("id", false)->get();

        if (isset($_GET["view"]) && $_GET["view"] == "sales") {
            $sales = Sales::sales($user, "team", $member);
        }elseif (isset($_GET["view"]) && $_GET["view"] == "payments") {

            $payments = Database::table('teampayments')->where('company', $user->company)->where('member', $member->id)->orderBy("id", false)->get();

        }

        return view("team-details", compact("user", "title", "member","notes","sales","payments","services"));
        
    }
    
    
    /**
     * Team member update view
     * 
     * @return \Pecee\Http\Response
     */
    public function updateview() {
        
        $user   = Auth::user();
        $member = Database::table('users')->where('company', $user->company)->where('id', input("teamid"))->first();
        $branches = Database::table('branches')->where('company', $user->company)->orderBy("id", false)->get();
        
        return view('modals/update-member', compact("member", "user","branches"));
        
    }
    
    /**
     * Update team member account
     * 
     * @return Json
     */
    public function update() {
        
        $user = Auth::user();
        
        $data = array(
            "fname" => escape(input('fname')),
            "lname" => escape(input('lname')),
            "phonenumber" => escape(input('phonenumber')),
            "type" => escape(input('type')),
            "role" => escape(input('role')),
            "status" => escape(input('status')),
            "address" => escape(input('address')),
            "branchid" => escape(input('branchid')),
            "balance" => escape(input('balance'))
        );
        
        if(!empty(input('email'))){
            $data["email"] = escape(input('email'));
        }else{
            $data["email"] = "NULL";
        }
        
        Database::table('users')->where('id', input('teamid'))->where('company', $user->company)->update($data);
        return response()->json(responder("success", "Alright!", "Team member account successfully updated.", "reload()"));
        
    }
    
    /**
     * Delete team member account
     * 
     * @return Json
     */
    public function delete() {
        
        $user = Auth::user();
        if ($user->id == input("teamid")) {
            return response()->json(responder("error", "Hmmm!", "You can not delete your own account."));
        }

        $account = Database::table('users')->where('id', input("teamid"))->where('company', $user->company)->first();
        if ($account->role == "Owner") {
            $owners = Database::table('users')->where('role', "Owner")->where('company', $user->company)->count("id", "total")[0]->total;
            if ($owners == 1) {
                return response()->json(responder("error", "Hmmm!", "The system needs atleast one owner account."));
            }
        }

        Database::table('users')->where('id', input('teamid'))->where('company', $user->company)->delete();
        Database::table('notes')->where('item', input('teamid'))->where('type', "Team")->where('company', $user->company)->delete();
        
        return response()->json(responder("success", "Alright!", "Team member account successfully deleted.", "redirect('" . url("Team@get") . "', true)"));
        
    }
    
}