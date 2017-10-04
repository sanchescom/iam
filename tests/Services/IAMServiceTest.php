<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 10/4/17
 * Time: 15:39
 */

namespace thiagovictorino\IAM\Test\Services;


use thiagovictorino\IAM\Enums\JWTAlgTypes;
use thiagovictorino\IAM\Test\AbstractTestCase;

class IAMServiceTest extends AbstractTestCase {

    public function setUp(){
        parent::setUp();

        config(['iam.jwt_alg' => JWTAlgTypes::HS256]);
        config(['iam.jwt_secret' => 123]);
        config(['iam.jwt_expiration_time' => 5]);
    }

}