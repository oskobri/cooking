<?php

namespace App\Console\Commands;

use App\Jobs\ImportRecipeFromUrl;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportRecipe extends Command
{
    protected $signature = 'app:import-recipe {url}';

    protected $description = 'Import recipe from url';

    public function handle(): void
    {
        ImportRecipeFromUrl::dispatchSync($this->argument('url'));
    }
}
