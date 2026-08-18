<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class ActivityLogObserver
{
    /**
     * Handle the Model "created" event.
     */
    public function created(Model $model): void
    {
        $this->logActivity('create', $model, $model->getAttributes());
    }

    /**
     * Handle the Model "updated" event.
     */
    public function updated(Model $model): void
    {
        // Detect publish/unpublish logic if the model has a status field
        if ($model->isDirty('status')) {
            $oldStatus = $model->getOriginal('status');
            $newStatus = $model->getAttribute('status');
            
            if ($oldStatus !== 'published' && $newStatus === 'published') {
                $this->logActivity('publish', $model);
                return; // We logged a publish, no need for generic update
            } elseif ($oldStatus === 'published' && $newStatus !== 'published') {
                $this->logActivity('unpublish', $model);
                return;
            }
        }

        $changes = $model->getChanges();
        
        // Remove 'updated_at' from the logged changes so it's not noise
        unset($changes['updated_at']);
        
        if (!empty($changes)) {
            $this->logActivity('update', $model, ['changes' => $changes]);
        }
    }

    /**
     * Handle the Model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        $this->logActivity('delete', $model);
    }

    /**
     * Handle the Model "restored" event.
     */
    public function restored(Model $model): void
    {
        $this->logActivity('restore', $model);
    }

    /**
     * Handle the Model "force deleted" event.
     */
    public function forceDeleted(Model $model): void
    {
        $this->logActivity('force_delete', $model);
    }

    protected function logActivity(string $action, Model $model, array $metadata = []): void
    {
        // Prevent logging activities while testing or seeding to avoid noise
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            return;
        }

        // Add a title descriptor if available for easier reading
        $description = $model->title ?? $model->name ?? null;

        log_activity($action, $model, $metadata, $description);
    }
}
