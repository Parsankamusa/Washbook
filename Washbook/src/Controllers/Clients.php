<?php
namespace Simcify\Controllers;

use Simcify\Controllers\Sales;
use Simcify\Database;
use Simcify\Auth;

class Clients {
    
    /**
     * Render clients page
     * 
     * @return \Pecee\Http\Response
     */
    public function get() {
        
        $title = 'Clients';
        $user  = Auth::user();
        if (isset($_GET["search"])) {
            $clients = Database::table('clients')->fetch("SELECT * FROM `clients` WHERE `company` = ".$user->company." AND `fullname` LIKE '%".$_GET["search"]."%' OR `company` = ".$user->company." AND `phonenumber` LIKE '%".$_GET["search"]."%'");
        }else{
            $clients = Database::table('clients')->where('company', $user->company)->orderBy("id", false)->get();
        }
        foreach ($clients as $key => $client) {
            $client->payments = Database::table('sales')->where('client', $client->id)->where('company', $user->company)->where("paid", "Yes")->sum("total", "total")[0]->total;
            $client->balance = Database::table('sales')->where('client', $client->id)->where('company', $user->company)->where("paid", "No")->sum("total", "total")[0]->total;
            $client->sales = Database::table('sales')->where('client', $client->id)->where('company', $user->company)->count("total", "total")[0]->total;
        }
        
        return view("clients", compact("user", "title", "clients"));
        
    }
    
    /**
     * Create client account 
     * 
     * @return Json
     */
    public function create() {
        
        $user = Auth::user();
        
        $data = array(
            "company" => $user->company,
            "branch" => $user->branchid,
            "fullname" => escape(input('fullname')),
            "email" => escape(input('email')),
            "phonenumber" => escape(input('phonenumber')),
            "address" => escape(input('address'))
        );
        Database::table('clients')->insert($data);
        $clientid = Database::table('clients')->insertId();
        
        return response()->json(responder("success", "Alright!", "Client account successfully created.", "redirect('" . url('Clients@details', array(
            'clientid' => $clientid
        )) . "')"));
        
    }
    
    /**
     * Render client's details page
     * 
     * @return \Pecee\Http\Response
     */
    public function details($clientid) {
        
        $sales = array();
        $user   = Auth::user();
        $client = Database::table('clients')->where('company', $user->company)->where('id', $clientid)->first();
        
        if (empty($client)) {
            return view('errors/404');
        }
        
        $title = $client->fullname;
        $client->payments = Database::table('sales')->where('client', $client->id)->where('company', $user->company)->where("paid", "Yes")->sum("total", "total")[0]->total;
        $client->balance = Database::table('sales')->where('client', $client->id)->where('company', $user->company)->where("paid", "No")->sum("total", "total")[0]->total;
        $client->sales = Database::table('sales')->where('client', $client->id)->where('company', $user->company)->count("total", "total")[0]->total;
            
        $notes = Database::table('notes')->where('item', $clientid)->where('type', "Client")->where('company', $user->company)->orderBy("id", false)->get();

        if (isset($_GET["view"]) && $_GET["view"] == "sales") {

            $sales = Sales::sales($user, "client", $client);

        }
        
        return view("client-details", compact("user", "title", "client", "notes", "sales"));
        
    }
    
    
    /**
     * Client update view
     * 
     * @return \Pecee\Http\Response
     */
    public function updateview() {
        
        $user   = Auth::user();
        $client = Database::table('clients')->where('company', $user->company)->where('id', input("clientid"))->first();
        
        return view('modals/update-client', compact("client"));
        
    }
    
    /**
     * Update Client account
     * 
     * @return Json
     */
    public function update() {
        
        $user = Auth::user();
        
        $data = array(
            "fullname" => escape(input('fullname')),
            "email" => escape(input('email')),
            "phonenumber" => escape(input('phonenumber')),
            "address" => escape(input('address'))
        );
        
        Database::table('clients')->where('id', input('clientid'))->where('company', $user->company)->update($data);
        return response()->json(responder("success", "Alright!", "Client account successfully updated.", "reload()"));
        
    }
    
    /**
     * Delete client account
     * 
     * @return Json
     */
    public function delete() {
        
        $user = Auth::user();
        Database::table('clients')->where('id', input('clientid'))->where('company', $user->company)->delete();
        Database::table('notes')->where('item', input('clientid'))->where('type', "Client")->where('company', $user->company)->delete();
        
        return response()->json(responder("success", "Alright!", "Client account successfully deleted.", "redirect('" . url("Clients@get") . "', true)"));
        
    }
    
}