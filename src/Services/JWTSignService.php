<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 9/26/17
 * Time: 22:14
 */

namespace thiagovictorino\IAM\Services;


use Firebase\JWT\JWT;
use League\Flysystem\Exception;
use thiagovictorino\IAM\DTO\JwtDTO;
use thiagovictorino\IAM\Enums\JWTAlgTypes;
use thiagovictorino\IAM\Exceptions\JWTAlgNotSupportedException;
use thiagovictorino\IAM\Exceptions\JWTMountException;
use thiagovictorino\IAM\Exceptions\JWTSignWithNullSecretException;

class JWTSignService
{


    public function encode(JwtDTO $dto, ?string $secret): string {

        if(empty($secret)){
            throw new JWTSignWithNullSecretException('You must define an secret to sign the token');
        }


        if(!JWTAlgTypes::isValidValue($dto->getAlg())){
            throw new JWTAlgNotSupportedException('Algorithm type '.$dto->getAlg(). ' is not supported by this library');
        }

        return JWT::encode($dto->getClaims(),$secret,$dto->getAlg());

    }

    public function decode(string $token, $secret, $alg): JwtDTO{

        if(empty($secret)){
            throw new JWTSignWithNullSecretException('You must define an secret to sign the token');
        }


        if(!JWTAlgTypes::isValidValue($alg)){
            throw new JWTAlgNotSupportedException('Algorithm type '.$alg. ' is not supported by this library');
        }

        return $this->mountDTO(JWT::decode($token,$secret,[$alg]));
    }

    private function mountDTO(\stdClass $jwt): JwtDTO{

        $dto = new JwtDTO();
        $vars = get_object_vars($jwt);

        try{
            foreach ($vars as $key => $value){
                $functionName = "set".ucfirst($key);
                $dto->$functionName($value);
            }
        }catch (Exception $exception){
            throw new JWTMountException($exception->getMessage(), $exception->getCode(), $exception);
        }


        return $dto;
    }

}