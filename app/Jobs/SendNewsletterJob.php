<?php

namespace App\Jobs;

use App\Mail\NewsletterMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    public function __construct(
        public string $mailSubject,
        public string $mailBody,
        public string $ctaUrl = '',
        public string $ctaLabel = 'Scopri di piu'
    ) {}

    public function handle(): void
{
    User::where('newsletter', true)
        ->chunkById(100, function ($users) {
            foreach ($users as $user) {
                try {
                    Mail::to($user->email)
                        ->queue(new NewsletterMail(
                            $this->mailSubject,
                            $this->mailBody,
                            $this->ctaUrl,
                            $this->ctaLabel
                        ));

                    \App\Models\EmailLog::create([
                        'type'      => 'newsletter',
                        'recipient' => $user->email,
                        'subject'   => $this->mailSubject,
                        'status'    => 'sent',
                    ]);
                } catch (\Exception $e) {
                    \App\Models\EmailLog::create([
                        'type'      => 'newsletter',
                        'recipient' => $user->email,
                        'subject'   => $this->mailSubject,
                        'status'    => 'failed',
                        'notes'     => $e->getMessage(),
                    ]);
                }
            }
        });
}
}
