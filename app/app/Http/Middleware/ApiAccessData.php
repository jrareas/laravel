<?php

namespace App\Http\Middleware;

use Closure;
use App\RequestUri;
use App\Request;
use Lcobucci\JWT\Parser;
use function PHPSTORM_META\type;

class ApiAccessData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }


    public function terminate($request, $response) {
        if ($response->getStatusCode() == 200) {
            $requestModel = new Request;
            $requestModel->request_uri_id = $this->getUriId($request->path());
            $requestModel->size =  mb_strlen($response->getContent(), '8bit');
            $requestModel->oauth_client_id = $this->getOauthClientId($request);
            $content = $response->getContent();
            if(is_object($content)) {
                $requestModel->content = \serialize($content);
            } else {
                $requestModel->content = $content;
            }

            $requestModel->response_time = microtime(true) - LARAVEL_START;
            $requestModel->save();
        }
    }

    private function getOauthClientId($request) {
        $bearerToken = $request->bearerToken();
        $token = (new Parser())->parse((string) $bearerToken);

        return $token->getClaim('aud');
    }

    private function addRequestUri($uri) {
        try{
            $uriModel = new RequestUri;
            $uriModel->request_uri = $uri;
            $uriModel->save();
            return $uriModel->id;
        } catch (\PDOException $e ) {
            return false;
        }

    }
    private function getUriId($uri) {
        $requestUri = RequestUri::where("request_uri",$uri)
            ->first();

        if ($requestUri) {
            return $requestUri->id;
        } else {
            return $this->addRequestUri($uri);
        }
    }
}
