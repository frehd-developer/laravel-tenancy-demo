<?php

use Illuminate\Http\Request;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tenants', function () {
	$website = new Website;
	// $website->managed_by_database_connection = 'system.asia';
	app(WebsiteRepository::class)->create($website);
	// dd($website->uuid); // Unique id
	$hostname = new Hostname;
	$hostname->fqdn = 'demo.127.0.0.1:8000';
	$hostname = app(HostnameRepository::class)->create($hostname);
	app(HostnameRepository::class)->attach($hostname, $website);
	dd($website->hostnames); // Collection with $hostname
});
