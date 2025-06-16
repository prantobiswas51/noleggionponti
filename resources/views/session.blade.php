<x-app-layout>

    <div class="max-w-4xl p-4 bg-gray-200 mx-4 mt-6 rounded-lg flex flex-col lg:mx-auto">

        <div class="py-2 text-purple-600 font-semibold text-2xl">
            € {{ Auth::user()->balance }}
        </div>

        <h1 class="my-2">Device: {{ $device->name }}</h1>

        <form method="POST" action="{{ route('start_devices') }}">
            @csrf
            <input type="hidden" name="device" value="{{ $device->identifier }}">
            <button type="submit" class="px-4 py-2 my-2 bg-blue-400 rounded-lg text-white">Start Session</button>
        </form>

        <form method="POST" action="{{ route('stop_devices') }}">
            @csrf
            <input type="hidden" name="device" value="{{ $device->identifier }}">
            <button type="submit" class="px-4 py-2 bg-blue-400 rounded-lg text-white">Stop Session</button>
        </form>

        @if(session('success'))
            <p style="color: green">{{ session('success') }}</p>
        @endif
    </div>

</x-app-layout>