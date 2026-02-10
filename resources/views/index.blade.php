<x-documental::layout page-header="Packages">
     <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 py-8 lg:py-12">
        @foreach ($packages as $package)
             <div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow flex flex-col dark:bg-gray-800 dark:divide-gray-900">
                 <div class="px-4 py-5 sm:p-6 flex-1">
                     <div class="group relative">
                         <h3 class="mt-0 text-lg/6 font-semibold text-gray-900 group-hover:text-gray-600">
                             <a href="{{ route('docs.version.show', ['package' => $package->slug, 'version' => $package->versions->first()]) }}" class="no-underline">
                                 <span class="absolute inset-0"></span>
                                 <span class="flex items-center gap-2">
                                    {{ $package->name }} <span class="relative z-10 rounded-full bg-gray-50 px-3 py-1 font-medium text-xs text-gray-600 dark:bg-gray-900/50 dark:text-gray-100">{{ $package->latest_release }}</span>
                                 </span>
                             </a>
                         </h3>
                         <p class="mt-5 line-clamp-3 text-sm/6 text-gray-600 dark:text-gray-400">
                             {!! $package->description !!}
                         </p>
                     </div>
                 </div>
                 <div class="divide-x divide-gray-200 grid grid-cols-2 dark:divide-gray-900">
                     <div class="px-4 py-4 sm:px-6">
                         <x-documental::stars :label="$package->stars" />
                     </div>
                     <div class="px-4 py-4 sm:px-6">
                         <x-documental::downloads :label="$package->downloads" />
                     </div>
                 </div>
             </div>
        @endforeach
    </div>
</x-documental::layout>
