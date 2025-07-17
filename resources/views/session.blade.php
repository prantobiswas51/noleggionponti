<x-app-layout>

    <div class="max-w-4xl p-4 bg-gray-200 mx-4 mt-6 rounded-lg flex flex-col lg:mx-auto">

        <div class="py-2 text-purple-600 font-semibold text-2xl">
            € {{ Auth::user()->balance }}
        </div>

        <h1 class="my-2">Device: {{ $device->name }}</h1>

        <div class="flex items-center gap-3 w-full">

            @if (Auth::user()->acceptance_ip == null && Auth::user()->acceptance_time == null)
            <form method="POST" class="w-full" action="{{ route('accept_contract') }}">
                @csrf
                <div class="mb-4">
                    <input type="checkbox" name="terms" class="rounded-sm" required>
                    <label for="terms" class="text-sm">I agree to the rental terms and conditions and privacy
                        policy</label>
                </div>
                <div class="mb-4">
                    <!-- Hidden input to send false value if checkbox is not selected -->
                    <input type="hidden" name="marketing" value="false">
                    <input type="checkbox" name="marketing" class="rounded-sm" id="marketing" value="true">
                    <label for="marketing" class="text-sm">Send me marketing emails</label>
                </div>
                <button type="submit" class="p-2 px-5 my-2 bg-sky-600 text-white rounded-md">I agree</button>
            </form>


            @else
            <form method="POST" class="w-full" action="{{ route('start_devices') }}">
                @csrf
                <input type="hidden" name="device" value="{{ $device->identifier }}">
                @if ($isActive)
                <button type="button" disabled class="w-full px-4 py-2 my-2 bg-gray-500 rounded-lg text-white">
                    Start Session
                </button>
                @else
                <button type="submit" class="w-full px-4 py-2 my-2 bg-blue-500 rounded-lg text-white">Start
                    Session</button>
                @endif
            </form>

            <form method="POST" class="w-full" action="{{ route('stop_devices') }}">
                @csrf
                <input type="hidden" name="device" value="{{ $device->identifier }}">
                <button type="submit" class="w-full px-4 py-2 bg-red-500 rounded-lg text-white">Stop Session</button>
            </form>

            @endif

        </div>

        @if (session('success'))
        <p style="color: green">{{ session('success') }}</p>
        @endif

        @if ($started_at)
        <div id="session-timer" class="text-xl font-bold text-gray-800 mt-4">
            Session Time: <span id="timer">00:00</span>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                    const timerElement = document.getElementById('timer');
                    const start = new Date('{{ \Carbon\Carbon::parse($started_at)->toIso8601String() }}');

                    function updateTimer() {
                        const now = new Date();
                        const diff = Math.floor((now - start) / 1000);
                        const mins = String(Math.floor(diff / 60)).padStart(2, '0');
                        const secs = String(diff % 60).padStart(2, '0');
                        timerElement.textContent = `${mins}:${secs}`;
                    }

                    updateTimer();
                    setInterval(updateTimer, 1000);
                });
        </script>
        @endif

    </div>
</x-app-layout>