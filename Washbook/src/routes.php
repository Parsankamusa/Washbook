<?php

use Simcify\Router;
use Simcify\Exceptions\Handler;
use Simcify\Middleware\Authenticate;
use Simcify\Middleware\RedirectIfAuthenticated;

/**
 * ,------,
 * | NOTE | CSRF Tokens are checked on all PUT, POST and GET requests. It
 * '------' should be passed in a hidden field named "csrf-token" or a header
 *          (in the case of AJAX without credentials) called "X-CSRF-TOKEN"
 *  */
// Router::csrfVerifier(new BaseCsrfVerifier());

Router::group(array(
     'prefix' => '/' . env('URL_PREFIX'),
    'exceptionHandler' => Simcify\Exceptions\Handler::class,
), function() {
    
    Router::group(array(
        'middleware' => Simcify\Middleware\Authenticate::class
    ), function() {
        
        // Overview
        Router::get('/', 'Overview@get');
        
        // Clients
        Router::get('/clients', 'Clients@get');
        Router::post('/clients/create', 'Clients@create');
        Router::post('/clients/update', 'Clients@update');
        Router::get('/clients/{clientid}/details', 'Clients@details', array(
            'as' => 'clientid'
        ));
        Router::post('/clients/update/view', 'Clients@updateview');
        Router::post('/clients/delete', 'Clients@delete');
        
        // Services
        Router::delete('/services/delete/{service}', 'Services@delete',array(
            'as' => 'service'
        ));
        Router::get('/services', 'Services@get');
        Router::post('/services/create', 'Services@create');
        Router::post('/services/update', 'Services@update');
        Router::post('/services/update/view', 'Services@updateview');
        Router::post('/services/delete', 'Services@delete');

        // Branches
        Router::get('/branches', 'Branches@get');
        Router::get('/branches/{branchid}/details', 'Branches@details', array(
            'as' => 'branchid'
        ));
        Router::post('/branches', 'Branches@create');
        Router::post('/branches/update', 'Branches@update');
        Router::post('/branches/update/view', 'Branches@updateview');
        Router::post('/branches/delete', 'Branches@delete');
        
        // Sales
        Router::get('/sales', 'Sales@get');
        Router::post('/sales/paid', 'Sales@paid');
        Router::post('/sales/create', 'Sales@create');
        Router::post('/sales/update', 'Sales@update');
        Router::post('/sales/update/view', 'Sales@updateview');
        Router::post('/sales/checkout', 'Sales@checkout');
        Router::post('/sales/delete', 'Sales@delete');
        
         // Reports
         Router::get('/reports', 'Reports@index');
        // Notes
        Router::post('/notes/create', 'Notes@create');
        Router::post('/notes/delete', 'Notes@delete');
        
        
        // Marketing
        Router::get('/marketing', 'Marketing@get');
        Router::get('/marketing/recipients', 'Marketing@recipients');
        Router::post('/marketing/create', 'Marketing@create');
        Router::post('/marketing/resend', 'Marketing@resend');
        Router::post('/marketing/delete', 'Marketing@delete');
        Router::post('/marketing/delete/message', 'Marketing@deletemessage');

        // Companies
        Router::get('/companies', 'Companies@get');
        Router::post('/companies/create', 'Companies@create');
        Router::post('/companies/update', 'Companies@update');
        Router::get('/companies/{companyid}/details', 'Companies@details', array(
            'as' => 'companyid'
        ));
        Router::post('/companies/update/view', 'Companies@updateview');
        Router::post('/companies/delete', 'Companies@delete');

        // Team
        Router::get('/team', 'Team@get');
        Router::post('/team/create', 'Team@create');
        Router::post('/team/update', 'Team@update');
        Router::get('/team/{teamid}/details', 'Team@details', array(
            'as' => 'teamid'
        ));
        Router::post('/team/update/view', 'Team@updateview');
        Router::post('/team/delete', 'Team@delete');
        
        // Team Payment
        Router::post('/team/payment/create', 'Teampayment@create');
        Router::post('/team/payment/update', 'Teampayment@update');
        Router::post('/team/payment/update/view', 'Teampayment@updateview');
        Router::post('/team/payment/delete', 'Teampayment@delete');
        
        // Settings
        Router::get('settings', 'Settings@get');
        Router::post('/settings/update/profile', 'Settings@updateprofile');
        Router::post('/settings/update/system', 'Settings@updatesystem');
        Router::post('/settings/update/company', 'Settings@updatecompany');
        Router::post('/settings/update/password', 'Settings@updatepassword');
        
        // Auth
        Router::get('/signout', 'Auth@signout');
        
    });
    
    Router::group(array(
        'middleware' => Simcify\Middleware\RedirectIfAuthenticated::class
    ), function() {
        
        /**
         * No login Required for these pages
         **/
        Router::get('/signin', 'Auth@get');
        Router::get('/getstarted', 'Auth@getstarted');
        Router::post('/signin/authenticate', 'Auth@signin');
        Router::get('/forgot', 'Auth@forgot');
        Router::post('/forgot/validate', 'Auth@forgotvalidation');
        Router::post('/createaccount', 'Auth@createaccount');
        Router::post('/reset', 'Auth@reset');
        Router::get('/reset/{token}', 'Auth@resetpage', array(
            'as' => 'token'
        ));
        
    });
    
    Router::get('/404', function() {
        response()->httpCode(404);
        echo view();
    });
    
});