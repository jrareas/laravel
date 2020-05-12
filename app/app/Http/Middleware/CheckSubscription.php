<?php

namespace App\Http\Middleware;

use Closure;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\StreamFactory;
use Laminas\Diactoros\UploadedFileFactory;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\ResourceServer;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use App\ApiMetadata;
use App\ApiSubscription;


class CheckSubscription
{
    /**
     * The Resource Server instance.
     *
     * @var \League\OAuth2\Server\ResourceServer
     */
    protected $server;
    /**
     * Create a new middleware instance.
     *
     * @param  \League\OAuth2\Server\ResourceServer  $server
     * @param  \Laravel\Passport\TokenRepository  $repository
     * @return void
     */
    public function __construct(ResourceServer $server, TokenRepository $repository)
    {
        $this->server = $server;
        $this->repository = $repository;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $psr = (new PsrHttpFactory(
            new ServerRequestFactory,
            new StreamFactory,
            new UploadedFileFactory,
            new ResponseFactory
        ))->createRequest($request);

        $psr = $this->server->validateAuthenticatedRequest($psr);

        $client_id = $psr->getAttribute('oauth_client_id');

        $route = $request->route();

        $api = ApiMetadata::where('uri',$route->uri)->first();

        if ($api) { //only if api is registred I will check subscription
            $subscription = ApiSubscription::where("api_id",  $api->id)
                ->where('client_id', $client_id)
                ->where('date_subscribed', '<=',  now())
                ->where(function($query){
                    $query->where('date_cancelation' , '>=', now())
                        ->orWhereNull('date_cancelation');
                })
                ->first();

            if (!$subscription) {
                return response(['You need to subscribe to have access to this API endpoint'],400);
            }
        }


        return $next($request);
    }
}
