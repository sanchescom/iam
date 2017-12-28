<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 10/6/17
 * Time: 17:03
 */

namespace thiagovictorino\IAM\Test\Http\Controllers;

use thiagovictorino\IAM\Test\AbstractTestCase;

class IAMAuthControllerTest extends AbstractTestCase {


    public function getToken(){
        return $this->json('GET', '/iam/v1/auth/', ['username' => 'admin', 'password' => 'admin']);
    }

    public function test_IAMAuthControllerTest_no_credentials(){
        $response = $this->json('GET', '/iam/v1/auth/', []);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_IAMAuthControllerTest_auth_fails(){
        $response = $this->json('GET', '/iam/v1/auth/', ['username' => 'Sally', 'password' => 'Sally']);
        $this->assertEquals(401, $response->getStatusCode());

    }

    public function test_IAMAuthControllerTest_auth_success(){
        $response = $this->getToken();
        $this->assertEquals(200, $response->getStatusCode());
    }

}