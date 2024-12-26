@props(['animal', 'species', 'user'])

<div
    class="max-w-sm bg-white border border-gray-200 hover:border-gray-400 rounded-lg hover:shadow-lg dark:bg-gray-800 dark:border-gray-700">
    <div>
        <img class="rounded-t-lg " src="{{ $animal->image }}" alt="" />
    </div>
    <div class="px-3 py-2">
        <div
            class="mb-1 text-lg line-clamp-2 font-bold tracking-tight text-gray-900 dark:text-white">
            {{ $animal->name }}</div>
        <p class="font-normal text-base text-gray-700 dark:text-gray-400">Spesies {{ $animal->species }}</p>
        <p class="mb-2 font-normal text-base text-gray-700 dark:text-gray-400">Umur {{ $animal->age }} tahun</p>
        <div class="flex gap-2">
            <form action="/animal/{{$animal->id}}" method="post">
                @method('delete')
                @csrf
                <button type="submit"
                class="w-max flex-1 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-bold rounded-md text-sm px-4 py-1 dark:bg-red-600 dark:hover:bg-red-500 dark:focus:ring-red-900">Hapus</button>
            </form>
            <button
                class="w-max flex-1 focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-bold rounded-md text-sm px-4 py-1 dark:bg-blue-600 dark:hover:bg-blue-500 dark:focus:ring-blue-900"
                data-modal-target="addpet-modal" data-modal-toggle="addpet-modal" type="button">Edit</button>

                <x-editpet-modal :animal="$animal" :species="$species" :user="$user">Edit</x-editpet-modal>

        </div>
    </div>
</div>
