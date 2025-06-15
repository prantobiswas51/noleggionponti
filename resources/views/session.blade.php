<x-app-layout>
    <h1>Device: {{ $device->name }}</h1>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('start_devices') }}">
        @csrf
        <input type="hidden" name="device" value="{{ $device->identifier }}">
        <button type="submit" class="px-4 py-2 bg-blue-400 rounded-lg text-white">Start 30 Minute Session</button>
    </form>
</x-app-layout>
