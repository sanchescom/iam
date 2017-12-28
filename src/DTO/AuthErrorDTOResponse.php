<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 12/26/17
 * Time: 15:34
 */

namespace thiagovictorino\IAM\DTO;


use thiagovictorino\MyArch\Contracts\ValidatorInterface;
use thiagovictorino\MyArch\DTO\DTOAbstract;

class AuthErrorDTOResponse extends DTOAbstract
{
    public $message;

    public $code;

    public function getValidator()
    {
        // TODO: Implement getValidator() method.
    }
}