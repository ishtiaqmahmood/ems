@csrf

<div class="bg-white rounded-2xl shadow-lg p-8 space-y-8">

    {{-- Header --}}
    <div class="border-b pb-4">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ isset($leaveType) ? 'Edit Leave Type' : 'Create Leave Type' }}
        </h2>
        <p class="text-sm text-gray-500">
            Define leave rules, duration, and payment policy
        </p>
    </div>

    {{-- Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Code --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Leave Code <span class="text-red-500">*</span>
            </label>
            <input type="text" name="code" value="{{ old('code', $leaveType->code ?? '') }}"
                class="w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500"
                placeholder="earned_full_pay" required>
            @error('code')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Max Duration --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Max Duration
            </label>
            <input type="number" name="max_duration" value="{{ old('max_duration', $leaveType->max_duration ?? '') }}"
                class="w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500" placeholder="e.g. 30">
            @error('max_duration')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Name BN --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Name (Bangla) <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name_bn" value="{{ old('name_bn', $leaveType->name_bn ?? '') }}"
                class="w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500"
                placeholder="গড় বেতনে অর্জিত ছুটি" required>
            @error('name_bn')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Name EN --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Name (English) <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name_en" value="{{ old('name_en', $leaveType->name_en ?? '') }}"
                class="w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500"
                placeholder="Earned Leave (Full Pay)" required>
            @error('name_en')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Duration Unit --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Duration Unit
            </label>
            <select name="duration_unit"
                class="w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                @foreach (['day', 'month', 'year'] as $unit)
                    <option value="{{ $unit }}" @selected(old('duration_unit', $leaveType->duration_unit ?? 'day') === $unit)>
                        {{ ucfirst($unit) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Options --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4">

        <label class="flex items-center gap-3 bg-gray-50 p-4 rounded-xl border cursor-pointer">
            <input type="checkbox" name="requires_medical" value="1" @checked(old('requires_medical', $leaveType->requires_medical ?? false))
                class="rounded text-sky-600 focus:ring-sky-500">
            <span class="text-sm text-gray-700 font-medium">
                Requires Medical Certificate
            </span>
        </label>

        <label class="flex items-center gap-3 bg-gray-50 p-4 rounded-xl border cursor-pointer">
            <input type="checkbox" name="paid" value="1" @checked(old('paid', $leaveType->paid ?? true))
                class="rounded text-green-600 focus:ring-green-500">
            <span class="text-sm text-gray-700 font-medium">
                Paid Leave
            </span>
        </label>

        <label class="flex items-center gap-3 bg-gray-50 p-4 rounded-xl border cursor-pointer">
            <input type="checkbox" name="lifetime_limit" value="1" @checked(old('lifetime_limit', $leaveType->lifetime_limit ?? false))
                class="rounded text-purple-600 focus:ring-purple-500">
            <span class="text-sm text-gray-700 font-medium">
                Lifetime Limit
            </span>
        </label>

    </div>

    {{-- Description --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Description
        </label>
        <textarea name="description" rows="4"
            class="w-full rounded-xl border-gray-300 focus:ring-sky-500 focus:border-sky-500"
            placeholder="Optional notes or rules...">{{ old('description', $leaveType->description ?? '') }}</textarea>
    </div>

    {{-- Actions --}}
    <div class="flex justify-end gap-4 pt-6 border-t">
        <a href="{{ route('admin.leave-types.index') }}"
            class="px-6 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
            Cancel
        </a>

        <button type="submit"
            class="px-8 py-2 rounded-xl bg-gradient-to-r from-sky-600 to-sky-700 text-white font-semibold shadow hover:scale-105 transition">
            Save Leave Type
        </button>
    </div>

</div>
