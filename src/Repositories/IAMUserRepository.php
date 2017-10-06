<?php namespace thiagovictorino\IAM\Repositories;
use Illuminate\Database\Eloquent\Model;
use thiagovictorino\IAM\Models\IAMUser;

/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 10/5/17
 * Time: 15:28
 */


class IAMUserRepository extends IAMAbstractRepository {

    function model() : Model {
       return  new IAMUser();
    }


}






