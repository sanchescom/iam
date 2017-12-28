<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 12/26/17
 * Time: 14:49
 */

namespace thiagovictorino\IAM\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use thiagovictorino\IAM\DTO\AuthErrorDTOResponse;
use thiagovictorino\IAM\DTO\JwtDTO;
use thiagovictorino\IAM\Services\JWTService;

class IAMAuthMiddleware
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $service
     * @param  string  $access_level
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $service)
    {

        $token = $request->bearerToken();
        $responseDTO = new AuthErrorDTOResponse();

        if(is_null($token)){
            $responseDTO->message = 'No token provided';
            $responseDTO->code = 422;
            return response(json_encode($responseDTO),$responseDTO->code);
        }

        $tokenDecoded = $this->decodeToken($token);

        if(is_null($tokenDecoded)){
            $responseDTO->message = 'Problem with token decodification';
            $responseDTO->code = 422;
            return response(json_encode($responseDTO),$responseDTO->code);

        }

        $service_arr = $this->getServiceAndAccess($service);

        if(!$this->hasServiceAccess($service_arr,$tokenDecoded->getServices())){
            $responseDTO->message = 'Get away from here!';
            $responseDTO->code = 403;
            return response(json_encode($responseDTO),$responseDTO->code);
        }

        return $next($request);
    }

    private function decodeToken($token): ?JwtDTO{
        /**
         * @var $jwtService JWTService
         */
        $jwtService = resolve(JWTService::class);
        $jwtService->setAlg(config('iam.jwt_alg'));
        $jwtService->setSecret(config('iam.jwt_secret'));

        try{
            /**
             * @var $jwtDTO JwtDTO
             */
            $jwtDTO = $jwtService->getTokenDecoded($token);
        }catch (\Exception $exception){
            return null;
        }

        return $jwtDTO;
    }

    private function hasServiceAccess($pipe, $user_services){

        if(!key_exists('services', $pipe)){
            return true;
        }

        if (!property_exists($user_services, $pipe['services'])){
            return false;
        }

        if(!key_exists('access', $pipe)){
            return true;
        }

        $services = $pipe['services'];
        $access = $pipe['access'];
        $arr = $user_services->$services->access;

        if (in_array($access, $arr) || in_array('all', $arr)){
            return true;
        }

        return false;
    }


    private function hasAccessLevel($service, $access_level, $roles){
        return (array_key_exists('all', $roles[$service]) || array_key_exists($service, $roles[$service]));
    }

    private function getServiceAndAccess($pipe){

        $exploded = explode('_',$pipe);

        $count = count($exploded);

        if($count == 0){
            return [];
        }

        $arr['services'] = $exploded[0];

        if($count > 1){
            $arr['access'] = $exploded[1];
        }

        return $arr;
    }

}