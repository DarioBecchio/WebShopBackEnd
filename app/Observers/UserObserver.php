<?php

namespace App\Observers;

use App\Mail\WelcomeNewUser;
use App\Mail\AccountDeleted;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    /**
     * Scatta quando un nuovo utente viene creato.
     * Breeze/Jetstream creano l'utente PRIMA della verifica email,
     * quindi aspettiamo che l'email sia verificata.
     */
    public function created(User $user): void
    {
        // Non inviamo qui: l'utente non ha ancora verificato l'email
        // Usiamo verified() sotto
    }

    /**
     * Scatta quando l'utente verifica la sua email.
     * È il momento giusto per il benvenuto!
     */
    public function verified(User $user): void
    {
        Mail::to($user->email)
            ->queue(new WelcomeNewUser($user));
    }

    /**
     * Scatta quando l'utente cancella il proprio account.
     */
    public function deleted(User $user): void
    {
        Mail::to($user->email)
            ->queue(new AccountDeleted($user));
    }

    /**
     * Scatta sui soft delete (se hai SoftDeletes nel model User).
     * Se non usi SoftDeletes, puoi rimuovere questo metodo.
     */
    public function forceDeleted(User $user): void
    {
        // Già gestito da deleted() se non usi SoftDeletes
    }
}