<?php

namespace App\Jobs;

use App\Models\User;
use App\Actions\FetchAndStoreUserWeather;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchUserWeather implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(FetchAndStoreUserWeather $fetchAndStoreUserWeather): void
    {
        $fetchAndStoreUserWeather->execute(User::all());
    }
}
