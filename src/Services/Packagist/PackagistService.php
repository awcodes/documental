<?php

namespace Awcodes\Documental\Services\Packagist;

use Awcodes\Documental\DataObjects\PackagistData;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class PackagistService
{
    public function __construct(
        private ?PendingRequest $client = null,
    ) {
        $this->client = Http::acceptJson();
    }

    /** @throws ConnectionException */
    public function getRepo(string $repo): PackagistData | RequestException
    {
        try {
            $repoData = $this->client
                ->get("https://packagist.org/packages/{$repo}.json")
                ->throw();

            return PackagistData::fromArray($repoData->json('package'));
        } catch (RequestException $e) {
            return $e;
        }
    }
}
