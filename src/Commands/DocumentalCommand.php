<?php

namespace Awcodes\Documental\Commands;

use Illuminate\Console\Command;

class DocumentalCommand extends Command
{
    public $signature = 'documental';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
