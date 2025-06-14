<x-app-layout>
    {{-- Main Content --}}
    <div class="flex-1 p-4 md:p-6 pb-20 md:pb-6 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900">Deposit Funds</h1>
                <p class="text-gray-600 mt-2 text-lg">Add money to your account effortlessly.</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-6 border border-gray-200">
            
                <form action="{{ route('paypal_deposit') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Amount to Deposit</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" name="amount" id="amount" class="block w-full pr-12 p-3 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-lg" placeholder="20.00" min="1" step="0.01" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm text-lg">€</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 ease-in-out text-lg">
                        Deposit Now
                    </button>
                </form>
            </div>

            <div class="mt-8 text-center text-gray-500 text-sm">
                <p>Your transactions are secured with advanced encryption technology.</p>
            </div>
        </div>
    </div>
</x-app-layout>