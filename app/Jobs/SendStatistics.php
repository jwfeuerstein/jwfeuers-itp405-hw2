<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Album;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewAlbum;
use App\Models\User;
use App\Mail\Statistics;

class SendStatistics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //protected $album;

    protected $numArtists;
    protected $numPlaylists;
    protected $totalTime;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($numArtists, $numPlaylists, $totalTime)
    {
        //$this->album = $album;
        $this->numArtists = $numArtists;
        $this->numPlaylists = $numPlaylists;
        $this->totalTime = $totalTime;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            //Mail::to($user->email)->send(new NewAlbum($this->album));
            Mail::to($user->email)->send(new Statistics($this->numArtists, $this->numPlaylists, $this->totalTime));
        }
    }
}
