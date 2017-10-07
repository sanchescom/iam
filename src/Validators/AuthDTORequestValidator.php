<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 10/7/17
 * Time: 05:43
 */

namespace thiagovictorino\IAM\Validators;


use thiagovictorino\IAM\Exceptions\ValidatorException;
use thiagovictorino\MyArch\Validators\ValidatorAbstract;

class AuthDTORequestValidator extends ValidatorAbstract
{
    public function validate($data)
    {
        if(empty($data['username']) || empty($data['password'])){
            throw new ValidatorException('Username or password is empty');
        }

        if(!is_string($data['username']) || !is_string($data['password'])){
            throw new ValidatorException('Username or password must be an string');
        }
    }
}