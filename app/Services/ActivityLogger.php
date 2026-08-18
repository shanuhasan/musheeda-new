<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ActivityLogger
{
    /**
     * Keys that should be stripped from logged metadata to prevent exposing secrets.
     */
    protected array $sensitiveKeys = [
        'password',
        'password_confirmation',
        'token',
        'remember_token',
        'secret',
        'api_key',
    ];

    /**
     * Log an activity.
     *
     * @param string $action The action performed (e.g., 'created', 'updated', 'login')
     * @param Model|string|null $subject The subject of the action
     * @param array $metadata Additional metadata
     * @param string|null $description Human-readable description
     * @return ActivityLog
     */
    public function log(string $action, $subject = null, array $metadata = [], ?string $description = null): ActivityLog
    {
        $logData = [
            'user_id' => Auth::id(),
            'action' => $action,
            'ip_address' => request()->ip(),
            'description' => $description,
        ];

        if ($subject instanceof Model) {
            $logData['model_type'] = get_class($subject);
            $logData['model_id'] = $subject->getKey();
        } elseif (is_string($subject)) {
            $logData['model_type'] = $subject;
        }

        if (!empty($metadata)) {
            $logData['metadata'] = $this->scrubSensitiveData($metadata);
        }

        return ActivityLog::create($logData);
    }

    /**
     * Recursively remove sensitive information from an array.
     */
    protected function scrubSensitiveData(array $data): array
    {
        foreach ($data as $key => $value) {
            if (in_array(strtolower($key), $this->sensitiveKeys, true)) {
                $data[$key] = '********';
            } elseif (is_array($value)) {
                $data[$key] = $this->scrubSensitiveData($value);
            }
        }

        return $data;
    }
}
