<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 10/5/17
 * Time: 15:30
 */

namespace thiagovictorino\IAM\Repositories;


use Illuminate\Database\Eloquent\Model;

interface IAMRepositoryInterface {
    function model() : Model;
}

abstract class IAMAbstractRepository implements IAMRepositoryInterface {


    public function find(int $id ): ?Model {
        return $this->model()->find($id);
    }

    /**
     * @return array
     */
    public function all(): array {
        return $this->model()->all();
    }
}