@props(['href' => '#', 'active', 'name'])

<a href="{{$href}}" class="border-slate-300 hover:border-teal-500 border px-3 py-1 rounded-md text-slate-500 hover:text-teal-500 {{($active === $name) ? 'border-teal-500 text-teal-500': ''}}">
    {{$name}}
</a>