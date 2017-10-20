<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 10/6/17
 * Time: 16:58
 */

namespace thiagovictorino\IAM\Http\Controllers;

use Illuminate\Http\Request;
use thiagovictorino\IAM\DTO\AuthDTORequest;
use thiagovictorino\IAM\DTO\AuthDTOResponse;
use thiagovictorino\IAM\Exceptions\AuthenticationFailException;
use thiagovictorino\IAM\Exceptions\ValidatorException;
use thiagovictorino\IAM\Repositories\IAMUserRepository;
use thiagovictorino\IAM\Services\IAMAuthService;
use thiagovictorino\MyArch\Factories\DTOFactory;

class IAMAuthController extends IAMBaseController {



    public function auth(Request $request){

        try{



            /**
             * @var $dtoRequest AuthDTORequest
             */
            $dtoRequest = $this->dtoFactory->make($request->all(),AuthDTORequest::class);

            /**
             * @var $authService IAMAuthService
             */
            $authService = resolve(IAMAuthService::class);

            $token = $authService->auth($dtoRequest);

            $response = $this->dtoFactory->make(['token'=>$token], AuthDTOResponse::class);

            return $response->toArray();

        }catch (ValidatorException $validatorException){
            return response($validatorException->getMessage(),400);
        }catch (AuthenticationFailException $exception){
            return response($exception->getMessage(),401);
        }catch (\Exception $exception){
            return response($exception->getMessage(),500);
        }

    }
}