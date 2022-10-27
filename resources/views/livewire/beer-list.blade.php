<div>

    <!-- Search Form -->
    @include('livewire.components.search-form')

    <!-- Card List Section -->
    <section wire:loading.class="opacity-50" class="p-4 mb-4 bg-white rounded-xl dark:bg-gray-900">

        <!-- Items Count -->
        @if (count($beerList) >0)
            <h2 class="px-2 py-2 font-bold dark:text-white">
                Showing {{ count($beerList) }} result(s).
            </h2>
        @endif

        <!-- Card Grid -->
        <div
            class="grid grid-flow-row gap-8 text-neutral-600 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

            @forelse ($beerList as $beer)

                <!-- Card Item -->
                @include('livewire.components.card-item')

                <!-- Empty -->
                @empty
                    <h2 class="px-2 py-2 text-xl font-bold dark:text-white">
                        No beers found.
                    </h2>

            @endforelse
        </div>

    </section>
</div>
