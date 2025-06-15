<x-app-layout>

    <div class="max-w-4xl p-4 bg-gray-200 mx-4 mt-6 rounded-lg flex flex-col lg:mx-auto">
        <h1>Device: {{ $device->name }}</h1>

        <form method="POST" action="{{ route('start_devices') }}">
            @csrf
            <input type="hidden" name="device" value="{{ $device->identifier }}">
            <button type="submit" class="px-4 py-2 bg-blue-400 rounded-lg text-white">Start 30 Minute Session</button>
        </form>

        @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
        @endif
    </div>

</x-app-layout>