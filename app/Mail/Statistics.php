<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Statistics extends Mailable
{
    use Queueable, SerializesModels;

    public $numArtists;
    public $numPlaylists;
    public $totalTime;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($numArtists, $numPlaylists, $totalTime)
    {
        $this->numArtists = $numArtists;
        $this->numPlaylists = $numPlaylists;
        $this->totalTime = $totalTime;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("Statistics") // will be inferred from this class name if not called
            ->view('email.statistics');
    }
}
