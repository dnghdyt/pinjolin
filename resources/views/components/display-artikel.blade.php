@props(['latest'])

<div class="flex p-2 gap-2">
    <img src="{{ $latest->image }}" alt="" class="w-24 h-16 rounded-md">
    <div class="flex-1 flex flex-col justify-between">
        <a href="/artikel/{{ $latest->id }}"
            class="hover:text-blue-500 text-xs line-clamp-2 font-semibold">{{ $latest->title }}</a>
        <div class="flex gap-2">
            <a href="/artikel?category={{ $latest->categories->name }}"
                class="bg-indigo-100 text-indigo-800 text-xs font-medium me-2 px-2 py-0.5 rounded dark:bg-indigo-900 dark:text-indigo-300">{{ $latest->categories->name }}</a>
            <small class="text-slate-500 text-xs">{{ $latest->created_at->diffForHumans() }}</small>
        </div>
    </div>
</div>
