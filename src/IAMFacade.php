<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 9/26/17
 * Time: 12:59
 */

namespace thiagovictorino\IAM\Facade;

use \Illuminate\Support\Facades\Facade;

class IAMFacade extends Facade {
    protected static function getFacadeAccessor() {
        return 'iam';
    }
}