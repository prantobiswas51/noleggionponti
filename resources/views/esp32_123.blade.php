<x-app-layout>
    <div class="max-w-md mx-auto p-6 my-8 bg-white shadow-lg rounded-lg border border-gray-200">

        <div class="mb-6 text-2xl font-bold text-gray-800 border-b pb-3">
            Control Bridge 1
        </div>

        <div class="flex items-center justify-between">
            <span class="text-xl font-semibold text-gray-700">
                Bridge Status
            </span>

            @if (Auth::user()->balance < 7) <div> Seems like you don't have enough balance to activate the bridge
        </div>
        @else
        <div x-data="{ isOn: false }" class="flex items-center">
            <label for="toggle-bridge-1" class="sr-only">Toggle Bridge 1</label>

            <input type="checkbox" id="toggle-bridge-1" class="hidden" x-model="isOn" @change="
                        console.log('Bridge 1 Switch is now:', isOn ? 'ON' : 'OFF');
                    ">

            <div @click="isOn = !isOn" :class="isOn ? 'bg-indigo-600' : 'bg-gray-300'"
                class="relative w-16 h-9 flex items-center rounded-full p-1 cursor-pointer transition-colors duration-300 ease-in-out shadow-inner">
                <div :class="isOn ? 'translate-x-7' : 'translate-x-0'"
                    class="bg-white w-7 h-7 rounded-full shadow-md transform transition-transform duration-300 ease-in-out">
                </div>
            </div>

            <span class="ml-4 text-xl font-semibold" :class="isOn ? 'text-indigo-700' : 'text-gray-500'">
                <span x-text="isOn ? 'Active' : 'Inactive'"></span>
            </span>
        </div>
        @endif

       

    </div>

     <div class="mt-4">
            Please be advised that each activation would cost you 7 EURO!
        </div>
    
</x-app-layout>