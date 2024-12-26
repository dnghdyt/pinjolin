<x-app-layout>
    <div class="w-9/12 mx-auto">
    @if ($article->is_approved == false)
    <x-back href="/dashboard" />
    @else
    <x-back href="/artikel" />
    @endif
        <div class="pb-2">
            <h3 class="text-3xl font-semibold">{{ $article->title }}</h3>
            <div class=" text-slate-500 flex gap-4 my-1">
                Dipost oleh
                <img src="{{ $article->user->image }}" alt="avatar" class="w-7 h-7 rounded-full">
                {{ $article->user->name }}
                <span
                    class="bg-indigo-100 text-indigo-800 text-xs font-medium me-2 px-2 py-0.5 rounded dark:bg-indigo-900 dark:text-indigo-300">{{ $article->categories->name }}</span>
                <span>{{ $article->created_at->diffForHumans() }}</span>
            </div>
            <img src="{{ $article->image }}" alt="" class="w-1/2 my-2 rounded-md">
            <div class="my-3">{!! $article->body !!}</div>
        </div>
        @if ($article->is_approved == false)
            <div class="flex gap-4 items-center">
                <form action="/artikel">
                    @csrf
                    <button type="submit"
                        class="w-max focus:outline-none text-white bg-pink-500 hover:bg-pink-600 focus:ring-4 focus:ring-pink-300 font-bold rounded-lg text-base px-5 py-2 dark:bg-pink-600 dark:hover:bg-pink-500 dark:focus:ring-pink-900">Setujui</button>
                    <button type="submit"
                        class="w-max focus:outline-none text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 font-bold rounded-lg text-base px-5 py-2 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-900">Hapus</button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
