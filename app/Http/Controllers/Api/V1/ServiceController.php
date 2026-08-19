<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Http\Resources\V1\ServiceResource;
use App\Traits\ApiResponse;

class ServiceController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::active()->get();
        return $this->successResponse(ServiceResource::collection($services), 'Services retrieved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        if ($service->status !== 'active') {
            return $this->errorResponse('Service not found.', 404);
        }
        
        return $this->successResponse(new ServiceResource($service), 'Service retrieved successfully.');
    }
}
