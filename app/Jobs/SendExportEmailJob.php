<?php

namespace App\Jobs;

use App\Notifications\BeerListEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SendExportEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;

    private $filename;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $filename)
    {
        $this->user = $user;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify(new BeerListEmail($this->filename));
        //dd(Storage::disk('s3')->get($this->filename));
    }
}
