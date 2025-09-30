<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BaseApiController extends Controller
{
    use ApiResponse, AuthorizesRequests; // tambahkan AuthorizesRequests
}
