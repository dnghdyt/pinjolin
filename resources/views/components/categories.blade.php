@props(['name', 'active'])
<div class="my-4 flex gap-2">
    <x-category href="/{{$name}}" active="{{$active}}" name="Semua"/>
    <x-category href="/{{$name}}?category=Hewan Ternak" active="{{$active}}" name="Hewan Ternak"/>
    <x-category href="/{{$name}}?category=Kucing" active="{{$active}}" name="Kucing"/>
    <x-category href="/{{$name}}?category=Anjing" active="{{$active}}" name="Anjing"/>
    <x-category href="/{{$name}}?category=Burung" active="{{$active}}" name="Burung"/>
    <x-category href="/{{$name}}?category=Kelinci" active="{{$active}}" name="Kelinci"/>
</div>
