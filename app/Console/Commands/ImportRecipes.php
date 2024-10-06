<?php

namespace App\Console\Commands;

use App\Jobs\ImportRecipeFromUrl;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportRecipes extends Command
{
    protected $signature = 'app:import-recipes';

    protected $description = 'Import recipes from config/import-recipes';

    public function handle()
    {
        $recipes = config('import-recipes');

        foreach ($recipes as $recipe) {
            try {
                ImportRecipeFromUrl::dispatch($recipe['url']);
            }
            catch(\Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }
}
