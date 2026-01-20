<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ShortUrl;
use Carbon\Carbon;

class CleanExpiredShortUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shorturls:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete short URLs not used for more than 3 months';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threshold = Carbon::now()->subMonths(3);

        $deleted = ShortUrl::where(function ($query) use ($threshold) {
                $query->whereNull('last_used_at')
                      ->where('created_at', '<', $threshold);
            })
            ->orWhere('last_used_at', '<', $threshold)
            ->delete();

        $this->info("{$deleted} expired short URLs deleted.");
    }
}
