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


    public function testBasicExample()
    {
        $response = $this->json('GET', '/iam/v1.0/auth/', ['name' => 'Sally']);
        dd($response);
    }

}