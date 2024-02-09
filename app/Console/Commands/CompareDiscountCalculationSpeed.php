<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\CartService;
use Illuminate\Console\Command;

class CompareDiscountCalculationSpeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:compare-discount-calculation-speed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'checks the time difference between discount calculation solutions';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        /** @var User $user */
        $user = User::query()->first();
        $cartService = new CartService($user);

        // slow version
        $startSlow = microtime(true);
        $cartService->calculateDiscountSlow();
        $endSlow = microtime(true);

        $startFast = microtime(true);
        $cartService->calculateDiscountFast();
        $endFast = microtime(true);

        print("slow - " . ($endSlow - $startSlow) . " seconds" .  PHP_EOL);
        print("fast - " . $endFast - $startFast . " seconds" . PHP_EOL);
    }
}
