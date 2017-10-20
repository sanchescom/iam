<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 10/16/17
 * Time: 17:22
 */

namespace thiagovictorino\IAM\DTO;


use thiagovictorino\IAM\Validators\AuthDTOResponseValidator;
use thiagovictorino\MyArch\DTO\DTOAbstract;

class AuthDTOResponse extends DTOAbstract
{
    public $token;

    public function getValidator()
    {
        return new AuthDTOResponseValidator();
    }

}