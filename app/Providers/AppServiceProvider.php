<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /** @var \Illuminate\Http\Request $request */
        // \Illuminate\Http\Request extends Symfony\Component\HttpFoundation\Request.
        // get ip address call Symfony\Component\HttpFoundation\Request only.
        $request = request();

        // don't get origin ips, but it's ok.
        $ips = $request->ips();
        logger()->info('get ip address in HTTP HEADER "REMOTE_ADDR"', compact('ips'));

        // Call Symfony\Component\HttpFoundation::setTrustedProxies method if you take the original IP via proxy.
        $request->setTrustedProxies($request->ips());

        // don't get origin ips and I don't know ip address, because not found in http header.
        $ips = $request->ips();
        logger()->info('unknown ip address', compact('ips'));

        {
            // I found EC2 parameter in Symfony\Component\HttpFoundation
            $request->setTrustedProxies($request->ips(), Request::HEADER_X_FORWARDED_AWS_ELB);

            // get origin ips, I found origin ip address in HTTP_X_FORWARDED_FOR
            $ips = $request->ips();
            logger()->info('get ip address in HTTP HEADER "HTTP_X_FORWARDED_FOR"', compact('ips'));

            // get stack top ip address in stack, but don't get origin ip address.
            // get ip is maybe ALB(in aws) ip address.
            $ip = $request->ip();
            logger()->info('get ip address may be alb', compact('ip'));

            // get origin ips, so array_reverse.
            $ip = array_last($request->ips());
            logger()->info('get origin ip address', compact('ip'));

        }



    }
}
