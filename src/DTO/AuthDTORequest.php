<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 10/7/17
 * Time: 05:29
 */

namespace thiagovictorino\IAM\DTO;


use thiagovictorino\IAM\Validators\AuthDTORequestValidator;
use thiagovictorino\MyArch\DTO\DTOAbstract;

class AuthDTORequest extends DTOAbstract {

    public $username;
    public $password;

    public function getValidator() {
        return new AuthDTORequestValidator();
    }


}