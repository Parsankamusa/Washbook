<?php
namespace Simcify\Controllers;
use Simcify\Database;
use Simcify\Auth;

class Overview{

    /**
     * Render overview page
     * 
     * @return \Pecee\Http\Response
     */
    public function get() {

        $title = 'Overview';
        $user = Auth::user();

        $revenue = $this->twelve($user);
        $widgets = $this->widgets($user);
        $servicesales = $this->servicesales($user);

        return view('overview', compact("user","title","widgets","revenue","servicesales"));

    }

    /**
     * income for the last 12 months
     * 
     * @return array
     */
    public function servicesales($user) {

        $servicesales = array();

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
            $revenue = Database::table("servicesales")->where("service", $service->id)->sum("amount", "total")[0]->total;
            $servicesales[] = "{value:".$revenue.", name:'".$service->name."'}";
        }

        return $servicesales;

    }
    
    /**
     * income for the last 12 months
     * 
     * @return array
     */
    public function twelve($user) {

        $now = new \DateTime( "11 months ago");
        $interval = new \DateInterval( 'P1M'); 
        $period = new \DatePeriod( $now, $interval, 11); 
        $twelve = array("amount" => array(), "label" => array());
        foreach( $period as $theMonth) {
            $month = $theMonth->format( 'm');
            $year = $theMonth->format( 'Y');
            if($user->role == "Owner" || $user->role == "Admin"){
                $amount = Database::table('sales')->where('MONTH(`created_at`)', $month)->where('YEAR(`created_at`)', $year)->where("company", $user->company)->sum("total","total")[0]->total;
            }else{
                $amount = Database::table('sales')->where('MONTH(`created_at`)', $month)->where('YEAR(`created_at`)', $year)->where("branch", $user->branchid)->where("company", $user->company)->sum("total","total")[0]->total;
            }
            
            $twelve['amount'][] = $amount;
            $twelve['labels'][] = $theMonth->format( 'M');
        }

        return $twelve;

    }

    /**
     * Get company widgets data
     * 
     * @return array
     */
    public function widgets($user) {

        $widgets = array();
        
        if($user->role == "Owner"){
            $widgets["totalrevenue"] = Database::table('sales')->where('company', $user->company)->where('paid', "Yes")->sum("total", "total")[0]->total;
            
            $totalcommission = Database::table('sales')->where('company', $user->company)->sum("commission", "total")[0]->total;
            $widgets["totalprofits"] = $widgets["totalrevenue"] - $totalcommission;
            $widgets["totalclients"] = Database::table('clients')->where('company', $user->company)->count("id", "total")[0]->total;
            $widgets["totalsales"] = Database::table('sales')->where('company', $user->company)->count("id", "total")[0]->total;
            
            $widgets["revenuetoday"] = Database::table('sales')->where('company', $user->company)->where("DATE(`created_at`)", "CURDATE()")->where('paid', "Yes")->sum("total", "total")[0]->total;
            $widgets["unpaid"] = Database::table('sales')->where('company', $user->company)->where('paid', "No")->sum("total", "total")[0]->total;
            $widgets["payouts"] = Database::table('users')->where('company', $user->company)->sum("balance", "total")[0]->total;
            $widgets["salestoday"] = Database::table('sales')->where('company', $user->company)->where("DATE(`created_at`)", "CURDATE()")->count("id", "total")[0]->total;
        }else{
            $widgets["totalrevenue"] = Database::table('sales')->where('company', $user->company)->where('branch', $user->branchid)->where('paid', "Yes")->sum("total", "total")[0]->total;
            
            $totalcommission = Database::table('sales')->where('company', $user->company)->where('branch', $user->branchid)->sum("commission", "total")[0]->total;
            $widgets["totalprofits"] = $widgets["totalrevenue"] - $totalcommission;
            $widgets["totalclients"] = Database::table('clients')->where('company', $user->company)->where('branch', $user->branchid)->count("id", "total")[0]->total;
            $widgets["totalsales"] = Database::table('sales')->where('company', $user->company)->where('branch', $user->branchid)->count("id", "total")[0]->total;
            
            $widgets["revenuetoday"] = Database::table('sales')->where('company', $user->company)->where('branch', $user->branchid)->where("DATE(`created_at`)", "CURDATE()")->where('paid', "Yes")->sum("total", "total")[0]->total;
            $widgets["unpaid"] = Database::table('sales')->where('company', $user->company)->where('branch', $user->branchid)->where('paid', "No")->sum("total", "total")[0]->total;
            $widgets["payouts"] = Database::table('users')->where('company', $user->company)->where('branchid', $user->branchid)->sum("balance", "total")[0]->total;
            $widgets["salestoday"] = Database::table('sales')->where('company', $user->company)->where('branch', $user->branchid)->where("DATE(`created_at`)", "CURDATE()")->count("id", "total")[0]->total;
        }
        
        return ( object ) $widgets;

    }


}
