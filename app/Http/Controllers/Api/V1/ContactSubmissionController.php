<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Http\Requests\Api\V1\StoreContactSubmissionRequest;
use App\Traits\ApiResponse;

class ContactSubmissionController extends Controller
{
    use ApiResponse;

    /**
     * Store a newly created contact submission in storage.
     */
    public function store(StoreContactSubmissionRequest $request)
    {
        $submission = ContactSubmission::create($request->validated());

        return $this->successResponse($submission, 'Contact submission received successfully.', 201);
    }
}
