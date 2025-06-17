<x-app-layout>

    <div class="max-w-4xl p-4 bg-gray-200 mx-4 mt-6 rounded-lg flex flex-col lg:mx-auto">

        <div class="py-2 text-purple-600 font-semibold text-2xl">
            € {{ Auth::user()->balance }}
        </div>

        <h1 class="my-2">Device: {{ $device->name }}</h1>

        <div class="flex items-center gap-3 w-full">
            <form method="POST" class="w-full" action="{{ route('start_devices') }}">
                @csrf
                <input type="hidden" name="device" value="{{ $device->identifier }}">
                <button type="submit" class="w-full px-4 py-2 my-2 bg-blue-500 rounded-lg text-white">Start
                    Session</button>
            </form>

            <form method="POST" class="w-full" action="{{ route('stop_devices') }}">
                @csrf
                <input type="hidden" name="device" value="{{ $device->identifier }}">
                <button type="submit" class="w-full px-4 py-2 bg-red-500 rounded-lg text-white">Stop Session</button>
            </form>
        </div>

        @if(session('success'))
            <p style="color: green">{{ session('success') }}</p>
        @endif

        @if(session('started_at'))
            <div id="session-timer" class="text-xl font-bold text-gray-800 mt-4">
                Session Time: <span id="timer">00:00</span>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const timerElement = document.getElementById('timer');
                    const start = new Date('{{ session('started_at') }}');

                    function updateTimer() {
                        const now = new Date();
                        const diff = Math.floor((now - start) / 1000); // in seconds
                        const mins = String(Math.floor(diff / 60)).padStart(2, '0');
                        const secs = String(diff % 60).padStart(2, '0');
                        timerElement.textContent = `${mins}:${secs}`;
                    }

                    updateTimer(); // initial run
                    setInterval(updateTimer, 1000); // update every second
                });
            </script>
        @endif

    </div>

</x-app-layout>
