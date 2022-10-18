<?php

namespace Modules\Core\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SeedFreshSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate settings table and fresh update config settings';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('settings')->truncate();

        $settings = config('settings.defaults');

        foreach ($settings as $key => $value) {
            setting([$key => $value]);
            setting()->save();
        }

        echo "Fresh settings updated successfully." . "\n";
    }

}
