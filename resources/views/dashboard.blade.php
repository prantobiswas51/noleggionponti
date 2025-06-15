<x-app-layout>

    <div class="max-w-4xl p-4 bg-gray-200 mx-4 mt-6 rounded-lg flex items-center justify-between lg:mx-auto">
        <div class="">
            <p class=" font-medium">Your Balance</p>
            <p class="text-2xl font-bold text-green-500">€ {{ Auth::user()->balance }}</p>
        </div>
        <div class="">
            <button class="px-6 py-2 bg-blue-600 text-white rounded-lg"><a href="{{ route('deposit') }}">+ Deposit</a></button>
        </div>
    </div>

    <div class="max-w-4xl p-4 bg-gray-200 mx-4 mt-6 rounded-lg flex items-center lg:mx-auto">
        <a class="bg-sky-400 px-4 p-2 text-white rounded-md mx-2" href="/device-session?device=ABC123">Device 1</a>
        <a class="bg-sky-400 px-4 p-2 text-white rounded-md mx-2" href="/device-session?device=JKL223">Device 2</a>
        <a class="bg-sky-400 px-4 p-2 text-white rounded-md mx-2" href="/device-session?device=XYZ333">Device 3</a>
    </div>

    <div class="max-w-4xl mx-4 lg:mx-auto p-6 lg:p-10 bg-gray-100 border-2 border-black shadow-xl rounded-2xl my-10 space-y-10">

        <!-- QR Scanner Section -->
        <section class="text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Scanner QR Ponte</h2>

            <div class="relative w-full max-w-md mx-auto border-4 border-dashed border-gray-300 rounded-xl bg-gray-100 overflow-hidden aspect-video flex items-center justify-center">
               <div id="video_reader" class="relative w-full max-w-md mx-auto aspect-video border-4 border-dashed border-gray-300 rounded-xl bg-gray-100 overflow-hidden"></div>
                <canvas id="reader" class="absolute top-0 left-0 w-full h-full "></canvas>
            </div>

            <div id="scanner-message" class="text-gray-500 mt-4">Scanner QR non attivo</div>

            <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-4">
                <button id="open-camera" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-camera mr-2"></i> Scansiona QR con Fotocamera
                </button>
                <button id="stop-camera" class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition hidden">
                    <i class="fas fa-stop mr-2"></i> Stop Camera
                </button>
            </div>
        </section>

        <!-- Session Info -->
        <section id="sessionInfo" class="hidden bg-blue-50 border border-blue-200 rounded-xl p-6 text-center shadow">
            <h3 class="text-2xl font-semibold text-blue-800 mb-4">Informazioni Sessione</h3>
            <div class="text-lg text-gray-700 space-y-2 mb-6">
                <p>Ponte: <span id="ponteId" class="font-bold text-blue-700">-</span></p>
                <p>Tempo rimanente: <span id="tempoRimanente" class="font-bold text-blue-800 text-3xl">30:00</span></p>
            </div>
            <button id="stopSessionBtn" class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-stop mr-2"></i> Termina Sessione
            </button>
        </section>

        <!-- Instructions -->
        <section class="bg-gray-50 border border-gray-200 rounded-xl p-6">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Come utilizzare il servizio</h3>
            <ol class="list-decimal list-inside space-y-2 text-gray-700 text-left max-w-prose mx-auto">
                <li>Clicca su <strong>"Scansiona QR con Fotocamera"</strong></li>
                <li>Inquadra il codice QR sul ponte</li>
                <li>Attendi la conferma di inizio sessione</li>
                <li>La sessione terminerà automaticamente dopo 30 minuti o quando clicchi su <strong>"Termina Sessione"</strong></li>
            </ol>
        </section>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let html5QrCode;

        document.getElementById('open-camera').addEventListener('click', function () {
            html5QrCode = new Html5Qrcode("video_reader");
            const config = { fps: 10, qrbox: 250 };

            html5QrCode.start(
                { facingMode: "environment" },
                config,
                qrCodeMessage => {
                    console.log(`QR Code: ${qrCodeMessage}`);
                    if (qrCodeMessage.startsWith('http')) {
                        window.location.href = qrCodeMessage;
                    } else {
                        alert("Command: " + qrCodeMessage);
                    }

                    html5QrCode.stop();
                    document.getElementById('stop-camera').classList.add('hidden');
                },
                errorMessage => {
                    // Ignored
                }
            ).then(() => {
                document.getElementById('stop-camera').classList.remove('hidden');
            });
        });

        document.getElementById('stop-camera').addEventListener('click', function () {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear();
                    document.getElementById('stop-camera').classList.add('hidden');
                });
            }
        });
    </script>

</x-app-layout>
