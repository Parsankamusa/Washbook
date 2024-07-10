<?php
namespace Simcify\Controllers;

use Simcify\Database;
use Simcify\Auth;
use Simcify\Mail;

class Companies {
    
    /**
     * Render team page
     * 
     * @return \Pecee\Http\Response
     */
    public function get() {
        
        $title = "Companies";
        $user  = Auth::user();
        
        if($user->role != "Admin"){
            return view('errors/404');
        }

        $companies = Database::table('companies')->orderBy("id", false)->get();
        foreach ($companies as $key => $company) {
            $company->owner = Database::table("users")->where("company", $company->id)->where("role", "Owner")->first();
            $company->branches = Database::table('branches')->where("company", $company->id)->count("id", "total")[0]->total;
            $company->staff = Database::table('branches')->where("company", $company->id)->count("id", "total")[0]->total;
        }
        
        return view("companies", compact("user", "title", "companies"));
        
    }
    
    
    /**
     * Render company's details page
     * 
     * @return \Pecee\Http\Response
     */
    public function details($companyid) {
        
        $branches = $members = array();
        $user   = Auth::user();
        $company = Database::table('companies')->where('id', $companyid)->first();
        if (empty($company)) {
            return view('errors/404');
        }
        
        $title = $company->name;
        $company->owner = Database::table("users")->where("company", $company->id)->where("role", "Owner")->first();
        $company->branches = Database::table('branches')->where("company", $company->id)->count("id", "total")[0]->total;
        $company->staff = Database::table('branches')->where("company", $company->id)->count("id", "total")[0]->total;

        $notes = Database::table('notes')->where('item', $company->id)->where('type', "Company")->orderBy("id", false)->get();

        if (isset($_GET["view"]) && $_GET["view"] == "branches") {

            $branches = Database::table('branches')->where('company', $company->id)->orderBy("id", false)->get();

        }elseif (isset($_GET["view"]) && $_GET["view"] == "members") {

            $members = Database::table('users')->where('company', $company->id)->orderBy("id", false)->get();
            foreach ($members as $key => $member) {
                $member->sales = Database::table('servicesales')->where('provided_by', $member->id)->count("id", "total")[0]->total;
                $member->branch = Database::table('branches')->where('id', $member->branchid)->first();
            }

        }

        return view("company-details", compact("user", "title", "company","notes","branches","members"));
        
    }
    
    
    /**
     * Company update view
     * 
     * @return \Pecee\Http\Response
     */
    public function updateview() {
        
        $user   = Auth::user();
        $company = Database::table("companies")->where('id', input("companyid"))->first();
        $branches = Database::table("branches")->where("company", $company->id)->orderBy("id", false)->get();
        
        $timezones  = Database::table("timezones")->get();
        $currencies = Database::table("currencies")->get();
        $countries  = Database::table("countries")->get();

        return view("modals/update-company", compact("company", "user","branches","timezones","currencies","countries"));
        
    }
    
    /**
     * Update team member account
     * 
     * @return Json
     */
    public function update() {
        
        $user = Auth::user();
        
        $data = array(
            "name" => escape(input("name")),
            "email" => escape(input("email")),
            "country" => escape(input("country")),
            "phone" => escape(input("phone")),
            "address" => escape(input("address")),
            "city" => escape(input("city")),
            "status" => escape(input("status")),
            "currency" => escape(input("currency")),
            "timezone" => escape(input("timezone"))
        );
        
        Database::table('companies')->where('id', input('companyid'))->update($data);
        return response()->json(responder("success", "Alright!", "Company account successfully updated.", "reload()"));
        
    }
    
    /**
     * Delete company account
     * 
     * @return Json
     */
    public function delete() {
        
        $user = Auth::user();
        if ($user->parent->id == input("companyid")) {
            return response()->json(responder("error", "Hmmm!", "You can not delete your own company account."));
        }

        Database::table('companies')->where('id', input('companyid'))->delete();
        Database::table('notes')->where('company', input('companyid'))->delete();
        
        return response()->json(responder("success", "Alright!", "Company account successfully deleted.", "redirect('" . url("Companies@get") . "', true)"));
        
    }
    
}