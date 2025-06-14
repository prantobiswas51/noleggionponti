<x-app-layout>
    <h1>Device: {{ $device->name }}</h1>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ url('/device-session/start') }}">
        @csrf
        <input type="hidden" name="device" value="{{ $device->identifier }}">
        <button type="submit">Start 30 Minute Session</button>
    </form>
</x-app-layout>
