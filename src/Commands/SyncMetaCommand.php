<?php

namespace Awcodes\Documental\Commands;

use Awcodes\Documental\Models\Package;
use Awcodes\Documental\Services\Packagist\PackagistService;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Laravel\Prompts\Progress;

use function Laravel\Prompts\progress;

class SyncMetaCommand extends Command
{
    protected $signature = 'documental:sync-meta {project?}';

    protected $description = 'Syncs the meta data for all packages';

    public function handle(): int
    {
        if ($this->argument('project')) {
            $projects = Package::query()->where('slug', $this->argument('project'))->get();
        } else {
            $projects = Package::all();
        }

        progress(
            label: 'Syncing projects',
            steps: $projects,
            callback: function (Package $package, Progress $progress): null {
                $progress->label("Syncing {$package->name}");

                return $this->performTask($package);
            }
        );

        return self::SUCCESS;
    }

    /** @throws ConnectionException */
    private function performTask(Package $package): null
    {
        $data = (new PackagistService)->getRepo(repo: $package->github_url);

        if ($data instanceof RequestException) {
            return null;
        }

        $package->update([
            'description' => $data->description,
            'latest_release' => $data->version,
            'stars' => $data->stars,
            'downloads' => $data->total_downloads,
            'monthly_downloads' => $data->monthly_downloads,
            'daily_downloads' => $data->daily_downloads,
        ]);

        return null;
    }
}
