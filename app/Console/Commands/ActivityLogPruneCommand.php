<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ActivityLogPruneCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:prune {--days=30 : The number of days to retain logs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune old activity logs from the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $date = \Carbon\Carbon::now()->subDays($days);
        
        $count = \App\Models\ActivityLog::where('created_at', '<=', $date)->delete();
        
        $this->info("Pruned {$count} activity logs older than {$days} days.");
    }
}
