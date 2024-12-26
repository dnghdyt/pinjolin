@props(['doctor'])

<div id="doctor-modal-{{ $doctor->id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Profil
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="doctor-modal-{{ $doctor->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <img src="{{ $doctor->image }}" alt="" class="rounded-md w-full">
                <div class="flex flex-col pt-4 pb-8">
                    <h5 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white text-left">
                        Drh.
                        {{ $doctor->name }}</h5>
                    <p class="font-normal text-gray-500 dark:text-gray-400 text-left mt-1">Spesialis
                        {{ $doctor->doctor_profil->specialist }}
                    </p>
                    <p class="font-normal text-gray-500 dark:text-gray-400 text-left mt-2">Informasi lainnya</p>
                    <div class="font-normal text-gray-500 dark:text-gray-400 text-left">
                        {!! $doctor->doctor_profil->bio !!}
                    </div>

                </div>
                <a href="/chat/{{ $doctor->id }}"
                    class="text-white inline-flex w-full justify-center bg-pink-500 hover:bg-pink-600 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-pink-600 dark:hover:bg-pink-700 dark:focus:ring-pink-800">
                    Chat
                </a>
            </div>
        </div>
    </div>
</div>
