<?php

namespace App\Console\Commands;

use App\Jobs\SendNewsletterJob;
use Illuminate\Console\Command;

class SendNewsletter extends Command
{
    protected $signature = 'newsletter:send
                            {subject : Oggetto della newsletter}
                            {body : Testo della newsletter}
                            {--cta-url= : URL del pulsante}
                            {--cta-label=Scopri di piu : Testo del pulsante}';

    protected $description = 'Invia la newsletter a tutti gli utenti iscritti';

    public function handle(): void
    {
        $iscritti = \App\Models\User::where('newsletter', true)->count();

        if ($iscritti === 0) {
            $this->warn('Nessun utente iscritto alla newsletter!');
            return;
        }

        $this->info("Invio newsletter a {$iscritti} utenti...");

        SendNewsletterJob::dispatch(
            $this->argument('subject'),
            $this->argument('body'),
            $this->option('cta-url') ?? '',
            $this->option('cta-label')
        );

        $this->info('Job newsletter aggiunto alla coda!');
    }
}
