<?php

namespace App\Mail;

use App\Models\Wishlist;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WishlistEmail extends Mailable
{
    use Queueable, SerializesModels;

    public Wishlist $wishlist;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Wishlist $wishlist)
    {
        $this->wishlist = $wishlist;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view("view.name");
    }
}
