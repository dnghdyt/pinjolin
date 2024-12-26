@props(['href' => '#'])
<a href="{{ $href }}"
    class="w-max focus:outline-none text-white bg-pink-500 hover:bg-pink-600 focus:ring-4 focus:ring-pink-300 font-bold rounded-lg text-base px-5 py-2 dark:bg-pink-600 dark:hover:bg-pink-500 dark:focus:ring-pink-900">{{ $slot }}</a>
