<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="User Member API Documentation",
     *      description="User Member API description",
     *      @OA\Contact(
     *          email="jkachiro@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="User Member API Server"
     * )
     *
     * @OA\Tag(
     *     name="User",
     *     description="API Endpoints of User Accounts"
     * )

     *
     * @OA\Tag(
     *     name="Membership",
     *     description="API Endpoints of User Members"
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
