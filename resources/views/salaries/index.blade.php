<x-viewer-layout>
    <div class="max-w-7xl mx-auto py-10 px-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-8 gap-4">
            <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-cash-coin text-sky-600"></i>
                Salary Records
            </h2>

            @if (in_array(Auth::user()->role, ['Admin', 'HR']))
                <a href="{{ route('salaries.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-2xl shadow-md transition transform hover:scale-[1.02]">
                    <i class="bi bi-plus-circle"></i> Add Salary
                </a>
            @endif
        </div>

        {{-- Table Container --}}
        <div class="overflow-x-auto bg-white rounded-2xl shadow-lg border border-gray-100">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-sky-600 text-white text-left">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Employee</th>
                        <th class="px-6 py-3 font-semibold">Amount</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold">Payment Date</th>
                        <th class="px-6 py-3 font-semibold">Effective</th>
                        @if (in_array(Auth::user()->role, ['Admin', 'HR']))
                            <th class="px-6 py-3 font-semibold text-center">Actions</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @forelse($salaries as $salary)
                        <tr
                            class="border-t border-gray-100 hover:bg-sky-50 transition-colors duration-200 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                            <td class="px-6 py-3 font-medium text-gray-800">{{ $salary->user->name }}</td>
                            <td class="px-6 py-3">{{ $salary->amount }} <span
                                    class="text-gray-500">{{ $salary->currency }}</span></td>

                            <td class="px-6 py-3">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if ($salary->status == 'paid') bg-green-100 text-green-700
                                    @elseif ($salary->status == 'pending') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($salary->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-3">{{ \Carbon\Carbon::parse($salary->payment_date)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-3">
                                {{ \Carbon\Carbon::parse($salary->effective_from)->format('M d, Y') }}
                                →
                                {{ $salary->effective_to ? \Carbon\Carbon::parse($salary->effective_to)->format('M d, Y') : 'Present' }}
                            </td>

                            @if (in_array(Auth::user()->role, ['Admin', 'HR']))
                                <td class="px-6 py-3 text-center">
                                    <div class="flex justify-center items-center gap-3">
                                        <a href="{{ route('salaries.edit', $salary) }}"
                                            class="text-sky-600 hover:text-sky-800 transition">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('salaries.destroy', $salary) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this salary record?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500 italic">
                                No salary records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $salaries->links() }}
        </div>
    </div>
</x-viewer-layout>
