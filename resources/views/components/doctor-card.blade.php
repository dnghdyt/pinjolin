@props(['doctor'])

<div
    class="flex flex-col items-center bg-white border border-gray-200 hover:border-gray-400 hover:shadow-lg rounded-lg md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 p-2">
    <div class="h-full w-[100px]">
        <img class="object-cover w-full rounded-md" src="/storage/users-avatar/avatar.png" alt="">
    </div>
    <div class="flex flex-1 gap-1 flex-col px-4 leading-normal h-full">
        <h5 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white text-left">Drh.
            {{ $doctor->name }}</h5>
        <p class="font-normal text-gray-500 dark:text-gray-400 text-left">{{ $doctor->doctor_profil->specialist }}</p>
        <div class="flex gap-2">
            <a href="/chat/{{ $doctor->id }}"
                class="w-max flex-1 focus:outline-none text-white bg-pink-500 hover:bg-pink-600 focus:ring-4 focus:ring-pink-300 font-bold rounded-md text-sm px-4 py-1 dark:bg-pink-600 dark:hover:bg-pink-500 dark:focus:ring-pink-900">Chat</a>
            <button
                class="w-max flex-1 focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-bold rounded-md text-sm px-4 py-1 dark:bg-blue-600 dark:hover:bg-blue-500 dark:focus:ring-blue-900"
                data-modal-target="doctor-modal-{{ $doctor->id }}"
                data-modal-toggle="doctor-modal-{{ $doctor->id }}" type="button">Detail</button>
        </div>

    </div>
</div>
