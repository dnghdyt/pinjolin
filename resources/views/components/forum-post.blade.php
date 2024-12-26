@props(['post'])

<div class="border-b border-slate-300 pb-2">
    <a href="/forum/{{ $post->id }}" class="text-3xl hover:text-blue-400">{{ $post->title }}</a>
    <div class=" text-slate-500 flex gap-4 my-1">
        Dipost oleh
        <img src="{{ $post->user->image }}" alt="avatar" class="w-7 h-7 rounded-full">
        {{ $post->user->name }}
        <a href="/artikel?category={{ $post->categories->name }}"
            class="bg-indigo-100 text-indigo-800 text-xs font-medium me-2 px-2 py-0.5 rounded dark:bg-indigo-900 dark:text-indigo-300">{{ $post->categories->name }}</a>

        <span>{{ $post->created_at->diffForHumans() }}</span>
        <span>{{ $post->comments->count() }} Balasan</span>
    </div>
    <div class="line-clamp-1 ">{!! $post->body !!}</div>
</div>
