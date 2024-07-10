<?php
namespace Simcify\Controllers;

use Simcify\Auth as Authenticate;
use Pecee\Http\Request;
use Simcify\Database;
use Simcify\Mail;
use Simcify\Str;

class Auth {
    
    /**
     * Render login page view
     * 
     * @return \Pecee\Http\Response
     */
    public function get() {
        $title = "Sign In";
        return view('auth-login', compact("title"));
    }
    
    /**
     * Render getstarted page view
     * 
     * @return \Pecee\Http\Response
     */
    public function getstarted() {
        $title = "Create an Account";
        return view('auth-getstarted', compact("title"));
    }
    
    /**
     * User signin
     * 
     * @return Json
     */
    public function signin() {
        $signin = Authenticate::login(input('email'), input('password'), array(
            "rememberme" => true,
            "redirect" => url(''),
            "status" => "Active"
        ));
        
        return response()->json($signin);
    }
    
    
    /**
     * Render forgot password page view
     * 
     * @return \Pecee\Http\Response
     */
    public function forgot() {
        $title = "Forgot Password";
        return view('auth-forgot', compact("title"));
    }
    
    /**
     * Forgot password - send reset password email
     * 
     * @return Json
     */
    public function forgotvalidation() {
        $forgot = Authenticate::forgot(input('email'), env('APP_URL') . "/reset/[token]");
        return response()->json($forgot);
    }
    
    /**
     * Create a user account
     * 
     * @return Json
     */
    public function createaccount() {

        $account = Database::table('users')->where('email', input("email"))->first();
        if (!empty($account)) {
            return response()->json(responder("error", "Hmmm!", "An account already exists with this email ".input("email")));
        }

        $company = array(
            "thankyou_message" => escape("Hello {customer_name}, thank you for visiting {company_name}. We sincerely appreciate your business and hope you come back soon!"),
            "name" => escape(input('company')),
            "email" => escape(input('email')),
            "phone" => escape(input('phonenumber'))
        );

        Database::table('companies')->insert($company);
        $companyid = Database::table('companies')->insertId();

        if (empty($companyid)) {
            return response()->json(responder("error", "Hmmm!", "Something went wrong, please try again and contact support if issue persists."));
        }

        $branch = array(
            "company" => $companyid,
            "name"       => 'Headquarters',
            "phone"      =>  escape(input('phonenumber'))
        );

        Database::table('branches')->insert($branch);
        $branchid = Database::table('branches')->insertId();

        $create = array(
            "company" => $companyid,
            "branchid" => $branchid,
            "fname" => escape(input('fname')),
            "lname" => escape(input('lname')),
            "email" => escape(input('email')),
            "phonenumber" => escape(input('phonenumber')),
            "password" => Authenticate::password(input('password')),
            "role" => "Owner"
        );

        Database::table('users')->insert($create);
        $userid = Database::table('users')->insertId();

        $user = Database::table("users")->where("id",$userid)->first();
        Authenticate::authenticate($user);

        Mail::send(
            input('email'),
            "You're in ".env("APP_NAME")." :)",
            array(
                "message" => "Thank you for signing up, ".input('fname')."<br><br>We built <a href='".env("APP_URL")."'>".env("APP_NAME")."</a> to help car wash businesses around the world automate their daily operations while increasing perfomance and accountability. We're here to ensure your success and increased perfomance. ".env("APP_URL")." is for you.<br><br>All the best,<br> ".env("APP_NAME")." Team"
            )
        );

        return response()->json(responder("success", "Account Created!", "Your account was successfully created.","redirect('".url("Settings@get")."', true)", false));
        
    }
    
    
    /**
     * signout User
     * 
     * @return \Pecee\Http\Response
     */
    public function signout() {
        Authenticate::deauthenticate();
        redirect(url('Auth@get'));
    }
    
    
    /**
     * Get reset password page
     * 
     * @return \Pecee\Http\Response
     */
    public function resetpage($token) {
        $title = "Reset Password";
        return view('auth-reset', compact("token","title"));
    }
    
    /**
     * Reset password
     * 
     * @return Json
     */
    public function reset() {
        $reset = Authenticate::reset(input('token'), input('password'));
        return response()->json($reset);
    }
    
    
}