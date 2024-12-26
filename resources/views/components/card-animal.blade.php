@props(['animal'])

<div
    class="max-w-sm bg-white border border-gray-200 hover:border-gray-400 rounded-lg hover:shadow-lg dark:bg-gray-800 dark:border-gray-700">
    <a href="/animal/{{ $animal->id }}">
        <img class="rounded-t-lg " src="{{$animal->image }}" alt="" />
    </a>
    <div class="px-3 py-2">
        <a href="/animal/{{ $animal->id }}" class="mb-1 text-lg line-clamp-2 font-bold tracking-tight text-gray-900 dark:text-white">
            {{ $animal->name }}</a>
        <p class="font-normal text-base text-gray-700 dark:text-gray-400">Spesies {{ $animal->species }}</p>
        <p class="mb-2 font-normal text-base text-gray-700 dark:text-gray-400">Umur {{ $animal->age }}</p>
    </div>
</div>
