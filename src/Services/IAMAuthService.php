<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 10/16/17
 * Time: 16:56
 */

namespace thiagovictorino\IAM\Services;


use Carbon\Carbon;
use thiagovictorino\IAM\DTO\AuthDTORequest;
use thiagovictorino\IAM\Enums\JWTAlgTypes;
use thiagovictorino\IAM\Repositories\IAMUserRepository;

class IAMAuthService
{

    /**
     * @param AuthDTORequest $authDTORequest
     * @return string
     */
    public function auth(AuthDTORequest $authDTORequest): string{

        /**
         * @var $userRepo IAMUserRepository
         */
        $userRepo = resolve(IAMUserRepository::class);

        $user = $userRepo->auth($authDTORequest->username, $authDTORequest->password);

        /**
         * @var $jwtService JWTService
         */
        $jwtService = new JWTService(config('iam.jwt_alg'), config('iam.jwt_secret'));


        if(config('iam.jwt_expires')){
            $jwtService->setExp(Carbon::now()->addMinute(config('iam.jwt_expiration_minutes_time'))->getTimestamp());
        }

        $claim = [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
            ],
            'services' => $userRepo->getAccess($user)
        ];

        $jwtService->addClaims($claim);

        $token = $jwtService->getSignToken();

        $userRepo->saveToken($token, $user->id);

        return $token;

    }

}