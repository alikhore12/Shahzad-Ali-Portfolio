<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::table('portfolio_projects')->whereIn('slug', [
            'portfolio-os',
            'local-growth-lab',
            'commerce-studio',
        ])->delete();
    }

    public function down(): void
    {
        // Placeholder projects are intentionally not restored.
    }
};
