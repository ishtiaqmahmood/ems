<x-viewer-layout>
    <div class="max-w-2xl mx-auto py-10 px-6">
        <div class="bg-white p-8 rounded-2xl shadow border border-gray-100">
            <h2 class="text-2xl font-semibold mb-6 text-gray-700">Edit Salary</h2>

            <form action="{{ route('salaries.update', $salary) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Employee --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Employee</label>
                    <select name="user_id"
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('user_id') border-red-500 @enderror">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $salary->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Amount & Currency --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Amount</label>
                        <input type="number" step="0.01" name="amount" value="{{ old('amount', $salary->amount) }}"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('amount') border-red-500 @enderror"
                            required>
                        @error('amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Currency</label>
                        <input type="text" name="currency" value="{{ old('currency', $salary->currency) }}"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('currency') border-red-500 @enderror">
                        @error('currency')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Payment Date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Payment Date</label>
                    <input type="date" name="payment_date" value="{{ old('payment_date', $salary->payment_date) }}"
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('payment_date') border-red-500 @enderror"
                        required>
                    @error('payment_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Payment Method --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Payment Method</label>
                    <input type="text" name="payment_method"
                        value="{{ old('payment_method', $salary->payment_method) }}"
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('payment_method') border-red-500 @enderror">
                    @error('payment_method')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                    <select name="status"
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('status') border-red-500 @enderror">
                        <option value="paid" {{ $salary->status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ $salary->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ $salary->status == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Effective Dates --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Effective From</label>
                        <input type="date" name="effective_from"
                            value="{{ old('effective_from', $salary->effective_from) }}"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('effective_from') border-red-500 @enderror"
                            required>
                        @error('effective_from')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Effective To</label>
                        <input type="date" name="effective_to"
                            value="{{ old('effective_to', $salary->effective_to) }}"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('effective_to') border-red-500 @enderror">
                        @error('effective_to')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Submit --}}
                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="px-5 py-2.5 bg-sky-600 text-white font-medium rounded-2xl shadow hover:bg-sky-700 focus:ring-2 focus:ring-sky-500 focus:outline-none transition">
                        Update Salary
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-viewer-layout>
