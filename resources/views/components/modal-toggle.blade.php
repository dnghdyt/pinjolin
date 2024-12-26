@props(['name'])

<button data-modal-target="{{$name}}-modal" data-modal-toggle="{{$name}}-modal"
    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm py-1 px-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
    type="button">
    <x-feathericon-plus />
</button>
