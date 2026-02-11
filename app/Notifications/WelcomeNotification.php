<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $name = $this->user->name ?: 'Pelanggan';
        return (new MailMessage)
            ->subject('Selamat datang di Toko Mas Sumatra')
            ->greeting("Halo {$name},")
            ->line('Terima kasih telah mendaftar di Toko Mas Sumatra.')
            ->action('Lihat Produk', route('catalog.index'))
            ->line('Salam hangat,')
            ->line('Tim Toko Mas Sumatra');
    }
}