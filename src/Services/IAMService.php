<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 9/26/17
 * Time: 13:59
 */

namespace thiagovictorino\IAM\Services;


use thiagovictorino\IAM\DTO\AuthDTORequest;

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

}