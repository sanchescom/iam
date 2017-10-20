<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 10/6/17
 * Time: 16:40
 */
namespace thiagovictorino\IAM\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use thiagovictorino\MyArch\Factories\DTOFactory;

class IAMBaseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var DTOFactory
     */
    protected $dtoFactory;

    public function __construct(DTOFactory $DTOFactory) {

        $this->dtoFactory = $DTOFactory;
    }
}