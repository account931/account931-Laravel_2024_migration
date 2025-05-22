<?php

namespace App\Http\Middleware;

use Fideloper\Proxy\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array|string
     */
    protected $proxies = '*';   //to fix error on render.com (css/js not loading) with error 'Mixed Content: The page at 'Your_page' was loaded over HTTPS, but requested an insecure stylesheet 'Your_page/public/css/app.css'. This request has been blocked; the content must be served over HTTPS.'

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_FOR |   //same fix as above
	                     Request::HEADER_X_FORWARDED_HOST | 
						 Request::HEADER_X_FORWARDED_PORT | 
						 Request::HEADER_X_FORWARDED_PROTO |  
						 Request::HEADER_X_FORWARDED_AWS_ELB;
}


