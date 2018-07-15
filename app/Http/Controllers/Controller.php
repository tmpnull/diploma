<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Swagger\Annotations as OAS;

/**
 * @OAS\Info(
 *     description="This is laravel project",
 *     version="1.0.0",
 *     title="Swagger laravel",
 *     @OAS\Contact(
 *         email="kornevdima@gmail.com"
 *     )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
