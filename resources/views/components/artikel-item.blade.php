@props(['article'])

<div class="max-w-sm bg-white border border-gray-200 hover:border-gray-400 rounded-lg hover:shadow-lg dark:bg-gray-800 dark:border-gray-700">
    <a href="/blog/{{ $article->id }}">
        <img class="rounded-t-lg w-full h-48 object-cover" src="{{$article->thumbnail}}" alt="" />
    </a>
    <div class="px-3 py-2">
        <a href="/blog/{{ $article->id }}"
           class="mb-1 line-clamp-2 font-bold tracking-tight text-gray-900 dark:text-white">
            {{ $article->title }}
        </a>
        <a href="#" class="bg-indigo-100 text-indigo-800 text-xs font-medium me-2 px-2 py-0.5 rounded dark:bg-indigo-900 dark:text-indigo-300">
            {{$article->category->category_name}}
        </a>
        <div class="mb-2 font-normal text-xs text-gray-700 dark:text-gray-400 line-clamp-2">
            {!! $article->content !!}
        </div>
        <p class="mb-1 font-normal text-xs text-gray-700 dark:text-gray-400">
            {{ $article->created_at->diffForHumans() }}
        </p>
    </div>
</div>
