@props(['reminder'])

<li class="mb-10 ms-4">
    <div
        class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
    </div>
    <time datetime="{{ $reminder->due_date }}"
        class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ \Carbon\Carbon::parse($reminder->due_date)->toDayDateTimeString() }}</time>
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
        {{ $reminder->animal->name }} <span
            class="ml-2 bg-indigo-100 text-indigo-800 text-xs font-medium me-2 px-2 py-0.5 rounded dark:bg-indigo-900 dark:text-indigo-300">{{ $reminder->reminder_type }}</span>
    </h3>
    <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
        {{ $reminder->description }}</p>
    <a href=""
        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-md text-sm px-2 py-1.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
        Hapus
    </a>
</li>
