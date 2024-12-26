<x-app-layout>
    <div class="w-9/12 mx-auto">
        <div class="flex gap-2">
            <div class=" w-8/12">
                <h2 class="text-2xl font-semibold mb-2">Artikel Terbaru</h2>
                <div class="relative">
                    <img src="{{$latests[0]->image}}" alt="" class="w-full h-[412px] rounded-md">
                    <a href="/artikel/{{ $latests[0]->id }}"
                        class="absolute bottom-0 rounded-b-md left-0 px-4 py-8 w-full bg-gradient-to-t from-gray-950 hover:from-gray-700 to-transparent text-white">
                        <h3 class="text-3xl font-semibold line-clamp-2">{{ $latests[0]->title }}</h3>
                        <p class="text-slate-400">{{ $latests[0]->created_at->diffForHumans() }}</p>
                    </a>
                </div>
            </div>
            <div class="overflow-y-scroll h-[452px] rounded-md w-4/12">
                @foreach ($latests->skip(1) as $latest)
                <x-display-artikel :latest="$latest"/>
                @endforeach
            </div>
        </div>
        <div class="mt-16" >
            <x-search name="artikel" href="artikel" />
            <x-categories name="artikel" active="{{$active}}"/>
        </div>
        <div class="grid grid-cols-4 gap-4 items-start justify-center mb-4">
        @foreach ($articles as $article)
            <x-artikel-item :article="$article"/>
        @endforeach
        </div>
        {{ $articles->links() }}
    </div>
</x-app-layout>
