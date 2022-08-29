<?php
namespace GoogleFunctionHelpers;

use GuzzleHttp\Psr7\Response;

class CloudFunctionsHelper
{
    private static $localAddresses = ['127.0.0.1', '::1'];

    /**
     * Verifiy if the current environment is local
     * @return Boolean
     */
    public static function isLocal()
    {
        return in_array($_SERVER['REMOTE_ADDR'], self::$localAddresses) ? TRUE : FALSE;
    }

    /**
     * Set up the env dependency for local enviroments in order to simulate the google cloud environment
     * @return Array
     */
    public static function setUpLocalEnv()
    {
        $isLocal = self::isLocal();
        $env = null;

        //Load the enviroment variables (use the Dotenv dependency for that)
        if ($isLocal){
            $dotenv = \Dotenv\Dotenv::createImmutable('./');
            $env = $dotenv->load();
        }

        return $env;
    }

    /**
     * Build a Response with a HTTP code and a message to be retrieved by the controller
     * @param int $code
     * @param String $message
     * 
     * @return Response
     */
    public static function response($code = 400, $message = 'An error has ocurred')
    {
        return (new Response($code, ['Content-Type' => 'application/json'], $message));
    }
}