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
use thiagovictorino\IAM\Exceptions\ValidatorException;
use thiagovictorino\MyArch\Factories\DTOFactory;

class IAMAuthController extends IAMBaseController {

    public function auth(Request $request){

        try{

            $dtoRequest = (new DTOFactory())->make($request->all(),AuthDTORequest::class);
            return ['created' =>true];
        }catch (ValidatorException $validatorException){
            response($validatorException->getMessage(),400);

        }

    }
}