<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ExportAllSeeders extends Command
{
    protected $signature = 'export:allseeders';
    protected $description = 'Export all tables into a single seeder file';

    public function handle()
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = env('DB_DATABASE');

        $seederContent = "<?php\n\nuse Illuminate\\Database\\Seeder;\nuse Illuminate\\Support\\Facades\\DB;\n\nclass AllTablesSeeder extends Seeder\n{\n    public function run()\n    {\n";

        foreach ($tables as $tableObj) {
            $table = array_values((array) $tableObj)[0];

            if (in_array($table, ['migrations'])) continue; // bỏ qua bảng migrations

            $rows = DB::table($table)->get();

            foreach ($rows as $row) {
                $data = var_export((array) $row, true);
                $seederContent .= "        DB::table('$table')->insert($data);\n";
            }
        }

        $seederContent .= "    }\n}\n";

        $filePath = database_path("seeders/AllTablesSeeder.php");
        File::put($filePath, $seederContent);

        $this->info("All tables exported to a single seeder: AllTablesSeeder.php");
    }
}
