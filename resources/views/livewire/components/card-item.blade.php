<!-- Card Item -->
<div x-data="{
        expanded: false,
        getIbuColor(ibu) {
            return ibu >0 ? (ibu <= 50 ? 'bg-success-600' : ibu > 50 && ibu <=120 ? 'bg-warning-600' : 'bg-danger-600') : '';
        }
    }"
    class="my-8 duration-300 bg-gray-100 rounded-lg shadow-lg shadow-gray-200 dark:shadow-gray-900 dark:bg-gray-800 hover:-translate-y-1">

    <!-- Clickable Area -->
    <a @click="expanded = ! expanded" class="cursor-pointer">

        <figure>

            <!-- IBU -->
            <span
                class="absolute p-2 mt-0 ml-2 text-xs font-bold leading-none text-white transform rounded-full notification-badge"
                :class="getIbuColor({{ $beer['ibu']; }})">
                {{ $beer['ibu'] }}
            </span>

            <!-- Image -->
            <img src="{{ $beer['image_url'] ?? 'https://frazerpromo.com/thumbnail_Images/no_image.png' }}"
                class="object-cover mx-auto mt-2 rounded-t" style="height:200px" />

            <figcaption class="p-4">

                <!-- Title -->
                <p class="mb-4 text-lg font-bold text-center text-gray-800 dark:text-gray-300">
                    {{ $beer['name'] }}
                </p>

                <!-- Description -->
                <p x-show="expanded" x-collapse class="italic text-center text-gray-500 dark:text-gray-400"
                    style="display:none">
                    {{ $beer['description'] }}
                </p>

            </figcaption>

        </figure>
    </a>
</div>
