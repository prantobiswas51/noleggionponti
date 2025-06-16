<x-app-layout>
    <div class="flex mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8 max-w-md w-full text-center">
            <div class="flex justify-center mb-6">
                <div class="bg-green-100 rounded-full p-4">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">Payment Successful</h2>
            <p class="text-gray-600 mb-6">Thank you for your payment. Your transaction has been completed successfully.
            </p>

            <div class=" shadow-lg rounded-lg overflow-hidden w-full my-4">
                <table class="min-w-full">
                    <!-- Table Body -->
                    <tbody>
                        <!-- Row 1: Payment ID -->
                        <tr class="border-b border-gray-700">
                            <td class="px-6 py-4 text-sm font-medium text-gray-400">
                                Payment ID
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-300 text-right">
                                {{ $result->id }}
                            </td>
                        </tr>
                        <tr class="border-b border-gray-700">
                            <td class="px-6 py-4 text-sm font-medium text-gray-400">
                                Payer Email
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-300 text-right">
                                {{ $result->payer->payer_info->email }}
                            </td>
                        </tr>
                        <!-- Row 2: Amount -->
                        <tr class="border-b border-gray-700">
                            <td class="px-6 py-4 text-sm font-medium text-gray-400">
                                Payment Status
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-300 text-right">
                                @if ($result->state == 'approved')
                                <button class="text-green-600 bg-green-300/20 p-2 rounded-lg">Approved</button>
                                @else
                                <button class="text-red-600 bg-red-300/20 p-2 rounded-lg">Rejected</button>
                                @endif
                            </td>
                        </tr>
                        <tr class="border-b border-gray-700">
                            <td class="px-6 py-4 text-sm font-medium text-gray-400">
                                Amount
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-300 text-right">
                                ${{ $result->transactions[0]->amount->total }}
                            </td>
                        </tr>
                        <!-- Row 3: Date -->
                        <tr class="border-b border-gray-700">
                            <td class="px-6 py-4 text-sm font-medium text-gray-400">
                                Date
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-300 text-right">
                                {{ $result->create_time }}
                            </td>
                        </tr>
                        <!-- Row 4: Status -->
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-400">
                                Currency
                            </td>
                            <td class="px-6 py-4 text-right">
                                {{ $result->transactions[0]->amount->currency }}
                            </td>
                        </tr>
                    </tbody>
                </table>


            </div>

            <a href="{{ route('dashboard') }}"
                class="inline-block bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded transition-all duration-200">
                Go to Dashboard
            </a>
        </div>
    </div>
</x-app-layout>