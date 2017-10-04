<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 9/26/17
 * Time: 20:23
 */

namespace thiagovictorino\IAM\Test\Services;


use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use thiagovictorino\IAM\Enums\JWTAlgTypes;
use thiagovictorino\IAM\Exceptions\JWTAlgNotSupportedException;
use thiagovictorino\IAM\Exceptions\JWTSignWithNullSecretException;
use thiagovictorino\IAM\Services\JWTService;
use thiagovictorino\IAM\Test\AbstractTestCase;

class JWTServiceTest extends AbstractTestCase
{

    private function getValidToken(){
        $a = new JWTService(JWTAlgTypes::HS256);
        $a->setSecret(123);
        $a->setJti('12312');
        $a->setAud('qwqweqw');
        $a->setIss('teste.com');
        $a->setSub('lalala');
        $a->setTyp('xxxxx');
        $a->setData(['user'=>['email'=>'teste@mail.com']]);
        return $a->getSignToken();
    }

    public function test_JWTServiceTest_alg_not_supported_exception(){

        $this->expectException(JWTAlgNotSupportedException::class);
        $a = new JWTService(123123);
        $a->setSecret(123);
        $a->getSignToken();
    }

    public function test_JWTServiceTest_must_have_secret_exception(){

        $this->expectException(JWTSignWithNullSecretException::class);
        $a = new JWTService(JWTAlgTypes::HS256);
        $a->getSignToken();
    }

    public function test_JWTServiceTest_getSignToken(){

        $a = new JWTService(JWTAlgTypes::HS256);
        $a->setSecret(123);
        $a->setJti('12312');
        $a->setAud('qwqweqw');
        $a->setExp(1506535885);
        $a->setIat(1506535885);
        $a->setIss('teste.com');
        $a->setNbf(1506535885);
        $a->setSub('lalala');
        $a->setTyp('xxxxx');
        $a->setOrRemoveClaim('user',['email'=>'teste@mail.com']);
        $b = $a->getSignToken();

        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiIxMjMxMiIsImF1ZCI6InF3cXdlcXciLCJleHAiOjE1MDY1MzU4ODUsImlhdCI6MTUwNjUzNTg4NSwiaXNzIjoidGVzdGUuY29tIiwibmJmIjoxNTA2NTM1ODg1LCJzdWIiOiJsYWxhbGEiLCJ0eXAiOiJ4eHh4eCIsInVzZXIiOnsiZW1haWwiOiJ0ZXN0ZUBtYWlsLmNvbSJ9fQ.eJetPHn4QYq4BQuUE5WwazNF6_51dkzZ2vKZ3yhOhoI";
        $this->assertEquals($token, $b);
    }

    public function test_JWTServiceTest_getJTIUniqueRandonKey(){

        $a = new JWTService(JWTAlgTypes::HS256);
        $a->setSecret(123);

        $values = [];

        $a->generateRandomJti();
        $jti1 = $a->getJwtDTO()->getJti();

        $a->generateRandomJti();
        $jti2 = $a->getJwtDTO()->getJti();

        $a->generateRandomJti();
        $jti3 = $a->getJwtDTO()->getJti();

        $a->generateRandomJti();
        $jti4 = $a->getJwtDTO()->getJti();

        $a->generateRandomJti();
        $jti5 = $a->getJwtDTO()->getJti();

        $a->generateRandomJti();
        $jti6 = $a->getJwtDTO()->getJti();

        $values=[$jti1,$jti2,$jti3,$jti4,$jti5,$jti6];

        $unique = array_unique($values);

        $this->assertEquals(6, count($unique));

    }

    public function test_JWTServiceTest_decodeToken(){
        $token = $this->getValidToken();

        $jwt = new JWTService();
        $jwt->setSecret(123);

        $decoded = $jwt->getTokenDecoded($token);

        $this->assertEquals('teste@mail.com', $decoded->getData()->user->email);
    }

    public function test_JWTServiceTest_setExpiredToken(){
        $a = new JWTService(JWTAlgTypes::HS256);
        $a->setSecret(123);
        $a->setExpirationDateInMinutes(5);
        $token = $a->getSignToken();

        $decoded = $a->getTokenDecoded($token);
        $date = new \DateTime();
        $date->setTimestamp($decoded->getExp());
    }

    public function test_JWTServiceTest_WrongSignature(){
        $this->expectException(SignatureInvalidException::class);
        $a = new JWTService(JWTAlgTypes::HS256);
        $a->setSecret(13);
        $a->getTokenDecoded("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE1MDY5NzAyOTV9.BIwpYapA51WAKgZHBKTk-PCKW5y8LXXAIQgJTECSbG0");
    }

    public function test_JWTServiceTest_brokenToken(){
        $this->expectException(\DomainException::class);
        $a = new JWTService(JWTAlgTypes::HS256);
        $a->setSecret(123);
        $a->getTokenDecoded("eyJ0eXAiOiJKV1QiLCJhbciOiJIUzI1NiJ9.eyJleHAiOjE1MDY5NzAyOTV9.BIwpYapA51WAKgZHBKTk-PCKW5y8LXXAIQgJTECSbG0");
    }

    public function test_JWTServiceTest_expiredToken(){
        $this->expectException(ExpiredException::class);
        $a = new JWTService(JWTAlgTypes::HS256);
        $a->setSecret(123);
        $decoded = $a->getTokenDecoded("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE1MDY5NzAyOTV9.BIwpYapA51WAKgZHBKTk-PCKW5y8LXXAIQgJTECSbG0");
    }

}