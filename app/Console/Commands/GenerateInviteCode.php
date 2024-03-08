<?php

namespace App\Console\Commands;

use App\Models\Invite;
use Illuminate\Console\Command;

class GenerateInviteCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-invite-code {--count=1 : The number of invite codes to generate} {--expires=7 : The number of days the invite code is valid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an invite code';

    public function handle(): void
    {
        $count = $this->option('count');
        $expires = $this->option('expires');

        $invites = Invite::factory()->count($count)->create(['expires_at' => now()->addDays($expires)]);

        $this->info("Invite Codes:");
        foreach ($invites as $invite) {
            $this->info("{$invite->code}");
        }
    }
}
