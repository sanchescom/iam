<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 12/26/17
 * Time: 15:43
 */

namespace thiagovictorino\IAM\Test\Http\Middleware;

use Illuminate\Http\Request;
use thiagovictorino\IAM\Test\AbstractTestCase;
use thiagovictorino\IAM\Test\Http\Controllers\IAMAuthControllerTest;

class IAMAuthMiddlewareTest extends AbstractTestCase {

    /**
     * @var Request
     */
    private $request;

    /**
     * @var \Closure
     */
    private $closure;

    public function setUp()
    {
        parent::setUp();

        $this->request = resolve(Request::class);


    }

    public function test_IAMAuthMiddleware_handle_no_token(){
        $response = $this->get('/iam/v1/user/');
        $response->assertStatus(422);
        $content = json_decode($response->getContent());
        $this->assertEquals('No token provided',$content->message);
    }

    public function test_IAMAuthMiddleware_handle_wrong_decoded(){
        $response = $this->withHeaders([
            'Authorization' => 'Bearer 123',
        ])->get('/iam/v1/user/');

        $response->assertStatus(422);
        $content = json_decode($response->getContent());
        $this->assertEquals('Problem with token decodification',$content->message);
    }

    public function test_IAMAuthMiddleware_handle_ok(){
        /**
         * @var $iamControllerTest IAMAuthControllerTest
         */
        $iamControllerTest = resolve(IAMAuthControllerTest::class);

        $response = $this->json('GET', '/iam/v1/auth/', ['username' => 'admin', 'password' => 'admin']);
        $content  = json_decode($response->getContent());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$content->token,
        ])->get('/iam/v1/user/');

        $response->assertStatus(200);


    }
}