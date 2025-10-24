<x-viewer-layout>
    <div class="max-w-3xl mx-auto py-10 px-6">
        <div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">

            {{-- Header Section --}}
            <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white p-6 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-semibold flex items-center gap-2">
                        <i class="bi bi-cash-coin"></i>
                        Salary Details
                    </h2>
                    <p class="text-sm text-sky-100">Salary record for {{ $salary->user->name }}</p>
                </div>

                <a href="{{ route('salaries.index') }}"
                    class="text-white hover:text-sky-100 text-sm font-medium underline transition">
                    ← Back to List
                </a>
            </div>

            {{-- Details Section --}}
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Employee Name</p>
                        <p class="text-lg font-medium text-gray-800">{{ $salary->user->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Amount</p>
                        <p class="text-lg font-medium text-gray-800">
                            {{ number_format($salary->amount, 2) }} {{ $salary->currency }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Payment Status</p>
                        <span
                            class="inline-block px-3 py-1 rounded-full text-xs font-semibold mt-1
                            @if ($salary->status === 'paid') bg-green-100 text-green-700
                            @elseif ($salary->status === 'pending') bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($salary->status) }}
                        </span>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Payment Date</p>
                        <p class="text-lg font-medium text-gray-800">
                            {{ \Carbon\Carbon::parse($salary->payment_date)->format('M d, Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Effective From</p>
                        <p class="text-lg font-medium text-gray-800">
                            {{ \Carbon\Carbon::parse($salary->effective_from)->format('M d, Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Effective To</p>
                        <p class="text-lg font-medium text-gray-800">
                            {{ $salary->effective_to ? \Carbon\Carbon::parse($salary->effective_to)->format('M d, Y') : 'Present' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Payment Method</p>
                        <p class="text-lg font-medium text-gray-800">
                            {{ $salary->payment_method ?? 'Not specified' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Currency</p>
                        <p class="text-lg font-medium text-gray-800">{{ $salary->currency }}</p>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-200 flex justify-end gap-3">
                    @if (in_array(Auth::user()->role, ['Admin', 'HR']))
                        <a href="{{ route('salaries.edit', $salary) }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-2xl shadow transition">
                            <i class="bi bi-pencil"></i> Edit
                        </a>

                        <form action="{{ route('salaries.destroy', $salary) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this salary record?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-2xl shadow transition">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-viewer-layout>
