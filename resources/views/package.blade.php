<x-documental::layout page-header="{{ $package->name }}">

    <div class="text-lg">
        {!! $package->description !!}
    </div>

    <div class="relative mt-2 flex items-center gap-6">
        <x-documental::github :link="$package->github_url" label="View on Github" />
        <x-documental::stars :label="$package->stars" />
        <x-documental::downloads :label="$package->downloads" />
        <x-documental::latest :label="$package->latest_release" />
    </div>

    <div class="grid grid-cols-1 gap-x-8 gap-y-16 mt-4 lg:grid-cols-3">
        @foreach ($package->versions as $version)
            <div class="flex flex-col items-start justify-between">
                <div class="group relative">
                    <h3 class="mt-3 text-lg/6 font-semibold text-gray-900 group-hover:text-gray-600">
                        <a href="{{ route('docs.version.show', ['package' => $package->slug, 'version' => $version->name]) }}">
                            <span class="absolute inset-0"></span>
                            Version {{ $version->name }} Docs
                        </a>
                    </h3>
                </div>
            </div>
        @endforeach
    </div>
</x-documental::layout>
