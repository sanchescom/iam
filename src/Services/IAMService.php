<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 9/26/17
 * Time: 13:59
 */

namespace thiagovictorino\IAM\Services;


use thiagovictorino\IAM\DTO\AuthDTORequest;
use thiagovictorino\IAM\Repositories\IAMUserRepository;

class IAMService
{

    /**
     * @var JWTService
     */
    private $jwtService;

    public function __construct(){

        $alg = config('iam.jwt_alg');
        $secret = config('iam.jwt_secret');
        $expiration = config('iam.jwt_expiration_minutes_time');

        $this->jwtService = new JWTService($alg,$secret);
        $this->jwtService->setExpirationDateInMinutes($expiration);
    }

    public function getObjectFromToken($token){
        return $this->jwtService->getTokenDecoded($token);
    }

    public function getIamUserEntityFromToken($token){
        $jwtObject = $this->jwtService->getTokenDecoded($token);
        /**
         * @var $userRepository IAMUserRepository
         */
        $userRepository = resolve(IAMUserRepository::class);
        $user =  $userRepository->getByUserName($jwtObject->getUser()->username);

        if(count($user) == 0){
            return null;
        }

        return $user->first();
    }

}