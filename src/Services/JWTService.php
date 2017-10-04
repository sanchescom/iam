<?php

namespace thiagovictorino\IAM\Services;
use Firebase\JWT\JWT;
use thiagovictorino\IAM\DTO\JwtDTO;
use thiagovictorino\IAM\Enums\JWTAlgTypes;
use thiagovictorino\IAM\Exceptions\JWTAlgNotSupportedException;

/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 9/26/17
 * Time: 12:57
 */
class JWTService {



    /**
     * @var JWTSignService
     */
    private $tokenizer;

    /**
     * @var JwtDTO
     */
    private $dto;

    /**
     * @var string
     */
    private $secret;

    private $alg;

    /**
     * @return mixed
     */
    public function getAlg()
    {
        return $this->alg;
    }

    /**
     * @param mixed $alg
     */
    public function setAlg($alg)
    {

        if(!JWTAlgTypes::isValidValue($alg)){
            throw new JWTAlgNotSupportedException('Algorithm type '.$alg. ' is not supported by this library');
        }
        $this->alg = $alg;
    }


    function __construct($alg = JWTAlgTypes::HS256, $secret = null){
        $this->tokenizer = new JWTSignService();
        $this->setAlg($alg);
        $this->dto = new JwtDTO($this->alg);
        $this->secret = $secret;
    }

    public function getSignToken(){
        return $this->tokenize();
    }

    public function getTokenDecoded(string $token): JwtDTO{
        return $this->tokenizer->decode($token, $this->secret, $this->alg);
    }


    private function tokenize(){
        return $this->tokenizer->encode($this->dto, $this->secret);
    }

    public function getJwtDTO(): JwtDTO{
        return $this->dto;
    }


    /**
     * @return string
     */
    public function getSecret(): ?string
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     */
    public function setSecret(string $secret)
    {
        $this->secret = $secret;
    }

    /**
     * @param string $typ
     */
    public function setTyp(?string $typ)
    {
        $this->dto->setTyp($typ);
    }

    /**
     * @param string $sub
     */
    public function setSub(?string $sub)
    {
        $this->dto->setSub($sub);
    }

    /**
     * @param string $aud
     */
    public function setAud(?string $aud)
    {
        $this->dto->setAud($aud);
    }

    /**
     * @param int $exp
     */
    public function setExp(?int $exp)
    {
        $this->dto->setExp($exp);
    }

    public function setExpirationDateInMinutes(int $minutes){

        $this->dto->setExp($this->getTimeStampAddingMinutes($minutes));
    }

    private function getTimeStampAddingMinutes(int $minutes): int{
        $date = new \DateTime();
        $date->modify("+$minutes minutes");
        return $date->getTimestamp();
    }


    /**
     * @param string $iss
     */
    public function setIss(?string $iss)
    {
        $this->dto->setIss($iss);
    }

    /**
     * @param int $nbf
     */
    public function setNbf(?int $nbf)
    {
        $this->dto->setNbf($nbf);
    }

    public function setNotBeforeDateInMinutes(int $minutes){

        $this->dto->setNbf($this->getTimeStampAddingMinutes($minutes));
    }

    /**
     * @param int $iat
     */
    public function setIat(int $iat)
    {
        $this->dto->setIat($iat);
    }

    public function setIssueAtDateInMinutes(int $minutes){

        $this->dto->setIat($this->getTimeStampAddingMinutes($minutes));
    }

    /**
     * @param string $jti
     */
    public function setJti(string $jti)
    {
        $this->dto->setJti($jti);
    }

    public function setOrRemoveClaim($index,$value){
        $this->dto->setOrRemoveClaim($index,$value);
    }
    public function addClaims(array $arr){
        $this->dto->addClaims($arr);
    }

    public function generateRandomJti(){
        $this->dto->generateRandomJti();
    }

    public function removeClaims(string $index){
        $this->dto->removeClaims($index);
    }

    public function setData($data){
        $this->dto->setData($data);
    }

}