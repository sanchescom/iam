<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 10/16/17
 * Time: 17:24
 */

namespace thiagovictorino\IAM\Validators;


use thiagovictorino\IAM\Exceptions\ValidatorException;
use thiagovictorino\MyArch\Validators\ValidatorAbstract;

class AuthDTOResponseValidator extends ValidatorAbstract
{
    public function validate($data)
    {
        if(empty($data['token'])){
            throw new ValidatorException('You need one token to build it');
        }
    }


}