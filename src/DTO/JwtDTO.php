<?php

namespace thiagovictorino\IAM\DTO;
use thiagovictorino\IAM\Enums\JWTAlgTypes;

/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 9/29/17
 * Time: 14:56
 */
class JwtDTO {

    /**
     * @var string
     */
    private $alg;

    /**
     * @var string
     */
    private $typ;



    /**
     *
    The "sub" (subject) claim identifies the principal that is the
    subject of the JWT.  The Claims in a JWT are normally statements
    about the subject.  The subject value MAY be scoped to be locally
    unique in the context of the issuer or MAY be globally unique.  The
    processing of this claim is generally application specific.  The
    "sub" value is a case-sensitive string containing a StringOrURI
    value.  Use of this claim is OPTIONAL.
     * @var string
     */
    private $sub;

    /**
     *
    The "aud" (audience) claim identifies the recipients that the JWT is
    intended for.  Each principal intended to process the JWT MUST
    identify itself with a value in the audience claim.  If the principal
    processing the claim does not identify itself with a value in the
    "aud" claim when this claim is present, then the JWT MUST be
    rejected.  In the general case, the "aud" value is an array of case-
    sensitive strings, each containing a StringOrURI value.  In the
    special case when the JWT has one audience, the "aud" value MAY be a
    single case-sensitive string containing a StringOrURI value.  The
    interpretation of audience values is generally application specific.
    Use of this claim is OPTIONAL.
     * @var string
     */
    private $aud;

    /**
    The "exp" (expiration time) claim identifies the expiration time on
    or after which the JWT MUST NOT be accepted for processing.  The
    processing of the "exp" claim requires that the current date/time
    MUST be before the expiration date/time listed in the "exp" claim.
    Implementers MAY provide for some small leeway, usually no more than
    a few minutes, to account for clock skew.  Its value MUST be a number
    containing an IntDate value.  Use of this claim is OPTIONAL.
     * @var int
     */
    private $exp;

    /**
    The "iss" (issuer) claim identifies the principal that issued the
    JWT.  The processing of this claim is generally application specific.
    The "iss" value is a case-sensitive string containing a StringOrURI
    value.  Use of this claim is OPTIONAL.
     * @var string
     */
    private $iss;

    /**
     *
    The "nbf" (not before) claim identifies the time before which the JWT
    MUST NOT be accepted for processing.  The processing of the "nbf"
    claim requires that the current date/time MUST be after or equal to
    the not-before date/time listed in the "nbf" claim.  Implementers MAY
    provide for some small leeway, usually no more than a few minutes, to
    account for clock skew.  Its value MUST be a number containing an
    IntDate value.  Use of this claim is OPTIONAL.
     * @var int
     */
    private $nbf;


    /**
    The "iat" (issued at) claim identifies the time at which the JWT was
    issued.  This claim can be used to determine the age of the JWT.  Its
    value MUST be a number containing an IntDate value.  Use of this
    claim is OPTIONAL.
     * @var int
     */
    private $iat;


    /**
     *
    The "jti" (JWT ID) claim provides a unique identifier for the JWT.
    The identifier value MUST be assigned in a manner that ensures that
    there is a negligible probability that the same value will be
    accidentally assigned to a different data object.  The "jti" claim
    can be used to prevent the JWT from being replayed.  The "jti" value
    is a case-sensitive string.  Use of this claim is OPTIONAL.
     * @var string
     */
    private $jti;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var array
     */
    private $claims = [];

    private $user;

    private $services;

    /*
     *
     */
    private $data;

    public function __construct($alg = JWTAlgTypes::HS256) {
        $this->alg = $alg;
    }

    /**
     * @return string
     */
    public function getAlg(): ?string
    {
        return $this->alg;
    }
    /**
     * @return string
     */
    public function getTyp(): ?string
    {
        return $this->typ;
    }

    /**
     * @param string $typ
     */
    public function setTyp(?string $typ)
    {

        $this->setOrRemoveClaim('typ', $typ);
    }

    /**
     * @return string
     */
    public function getSub(): ?string
    {
        return $this->sub;
    }

    /**
     * @param string $sub
     */
    public function setSub(?string $sub)
    {
        $this->setOrRemoveClaim('sub', $sub);
    }

    /**
     * @return string
     */
    public function getAud(): ?string
    {
        return $this->aud;
    }

    /**
     * @param string $aud
     */
    public function setAud(?string $aud)
    {
        $this->setOrRemoveClaim('aud', $aud);
    }

    /**
     * @return int
     */
    public function getExp(): ?int
    {
        return $this->exp;
    }

    /**
     * @param int $exp
     */
    public function setExp(?int $exp)
    {
        $this->setOrRemoveClaim('exp', $exp);
    }

    /**
     * @return string
     */
    public function getIss(): ?string
    {
        return $this->iss;
    }

    /**
     * @param string $iss
     */
    public function setIss(?string $iss)
    {
        $this->setOrRemoveClaim('iss', $iss);
    }

    /**
     * @return int
     */
    public function getNbf(): ?int
    {
        return $this->nbf;
    }

    /**
     * @param int $nbf
     */
    public function setNbf(?int $nbf)
    {
        $this->setOrRemoveClaim('nbf', $nbf);
    }

    /**
     * @return int
     */
    public function getIat(): ?int
    {
        return $this->iat;
    }

    /**
     * @param int $iat
     */
    public function setIat(int $iat)
    {
        $this->setOrRemoveClaim('iat', $iat);
    }

    /**
     * @return string
     */
    public function getJti(): ?string
    {
        return $this->jti;
    }

    /**
     * @param string $jti
     */
    public function setJti(string $jti)
    {
        $this->setOrRemoveClaim('jti', $jti);
    }

    /**
     * @return array
     */
    public function getHeaders(): ?array
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getClaims(): ?array
    {
        return $this->claims;
    }

    public function addClaims(array $arr){
        $this->claims = array_merge($this->claims,$arr);
    }

    /**
     * @param string $index
     */
    public function removeClaims(string $index){
        if (($key = array_search($index, $this->claims)) !== false) {
            $this->$key = null;
            unset($this->claims[$key]);
        }
    }

    public function setOrRemoveClaim($index,$value){
        if(is_null($value)){
            $this->removeClaims($index);
            return;
        }
        $this->$index = $value;
        $this->addClaims([$index => $value]);
    }


    public function generateRandomJti(){
        $bytes = random_bytes(32);
        $uuid = md5(bin2hex($bytes).microtime());
        $this->setJti($uuid);
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->setOrRemoveClaim('data', $data);
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param mixed $services
     */
    public function setServices($services)
    {
        $this->services = $services;
    }





}