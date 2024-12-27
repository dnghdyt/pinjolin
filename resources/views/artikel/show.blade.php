<x-app-layout>
    <div class="w-9/12 mx-auto mt-16">
        <div class="pb-2">
            <h3 class="text-3xl font-semibold">{{ $article->title }}</h3>
            <div class="text-slate-500 flex gap-4 my-1">
                Dipost oleh
                {{ $article->user->name }}
                <span
                    class="bg-indigo-100 text-indigo-800 text-xs font-medium me-2 px-2 py-0.5 rounded dark:bg-indigo-900 dark:text-indigo-300">{{ $article->category->category_name }}</span>
                <span>{{ $article->created_at->diffForHumans() }}</span>
            </div>
            <div class="my-8 w-1/2 h-64 rounded-md overflow-hidden">
                <img src="{{ $article->thumbnail }}" alt="Thumbnail" class="w-full h-full object-cover">
            </div>
            <div class="my-3">{!! $article->content !!}</div>
        </div>
    </div>
</x-app-layout>
