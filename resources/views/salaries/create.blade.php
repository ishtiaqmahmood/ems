<x-viewer-layout>
    <div class="max-w-3xl mx-auto py-12 px-6">
        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-sky-600 to-sky-500 px-8 py-6 text-white flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-semibold flex items-center gap-2">
                        <i class="bi bi-cash-stack text-xl"></i>
                        Add Salary Record
                    </h2>
                    <p class="text-sm text-sky-100">Manage employee payroll information with accuracy</p>
                </div>
                <a href="{{ route('salaries.index') }}"
                    class="text-sky-100 hover:text-white text-sm font-medium transition underline">
                    ← Back
                </a>
            </div>

            {{-- Form --}}
            <form action="{{ route('salaries.store') }}" method="POST" class="p-8 space-y-8">
                @csrf

                {{-- Employee --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Employee</label>
                    <select name="user_id"
                        class="w-full rounded-xl border-gray-300 focus:border-sky-500 focus:ring focus:ring-sky-200 text-gray-700 transition py-2.5">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Amount & Currency --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Amount</label>
                        <input type="number" step="0.01" name="amount"
                            class="w-full rounded-xl border-gray-300 focus:border-sky-500 focus:ring focus:ring-sky-200 text-gray-700 transition py-2.5 px-3"
                            placeholder="Enter salary amount" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                        <input type="text" name="currency" value="BDT"
                            class="w-full rounded-xl border-gray-300 focus:border-sky-500 focus:ring focus:ring-sky-200 text-gray-700 transition py-2.5 px-3">
                    </div>
                </div>

                {{-- Payment Info --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Date</label>
                        <input type="date" name="payment_date"
                            class="w-full rounded-xl border-gray-300 focus:border-sky-500 focus:ring focus:ring-sky-200 text-gray-700 transition py-2.5 px-3"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                        <input type="text" name="payment_method"
                            class="w-full rounded-xl border-gray-300 focus:border-sky-500 focus:ring focus:ring-sky-200 text-gray-700 transition py-2.5 px-3"
                            placeholder="e.g., Bank Transfer, Cash">
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                    <select name="status"
                        class="w-full rounded-xl border-gray-300 focus:border-sky-500 focus:ring focus:ring-sky-200 text-gray-700 transition py-2.5">
                        <option value="paid" class="text-green-700">Paid</option>
                        <option value="pending" class="text-yellow-700">Pending</option>
                        <option value="failed" class="text-red-700">Failed</option>
                    </select>
                </div>

                {{-- Effective Dates --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Effective From</label>
                        <input type="date" name="effective_from"
                            class="w-full rounded-xl border-gray-300 focus:border-sky-500 focus:ring focus:ring-sky-200 text-gray-700 transition py-2.5 px-3"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Effective To</label>
                        <input type="date" name="effective_to"
                            class="w-full rounded-xl border-gray-300 focus:border-sky-500 focus:ring focus:ring-sky-200 text-gray-700 transition py-2.5 px-3">
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-6">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-2xl shadow-md transition transform hover:scale-[1.03]">
                        <i class="bi bi-check-circle"></i>
                        <span>Save Salary</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-viewer-layout>
