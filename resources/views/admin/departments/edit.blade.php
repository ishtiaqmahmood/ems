<x-admin-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            {{ isset($department) ? 'Edit' : 'Create' }} Department
        </h1>

        <form
            action="{{ isset($department) ? route('admin.departments.update', $department) : route('admin.departments.store') }}"
            method="POST" class="bg-white shadow rounded-lg p-6 space-y-4">
            @csrf
            @if (isset($department))
                @method('PUT')
            @endif

            {{-- UUID --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">UUID</label>
                <input type="text" name="uuid"
                    value="{{ old('uuid', $department->uuid ?? \Illuminate\Support\Str::uuid()) }}"
                    class="w-full px-4 py-2 border rounded-lg bg-gray-100 focus:outline-none" readonly>
                <p class="text-gray-500 text-sm mt-1">Unique identifier (auto-generated)</p>
            </div>

            {{-- Organization --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Organization</label>
                <select name="organization_id"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none"
                    required>
                    <option value="">Select Organization</option>
                    @foreach ($organizations as $org)
                        <option value="{{ $org->id }}"
                            {{ old('organization_id', $department->organization_id ?? '') == $org->id ? 'selected' : '' }}>
                            {{ $org->name }}
                        </option>
                    @endforeach
                </select>
                @error('organization_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Name --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Name</label>
                <input type="text" name="name" id="name"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none"
                    value="{{ old('name', $department->name ?? '') }}" required>
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Slug</label>
                <input type="text" name="slug" id="slug"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none"
                    value="{{ old('slug', $department->slug ?? '') }}">
                <p class="text-gray-500 text-sm mt-1">Auto-generated from name, editable if needed.</p>
                @error('slug')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Code --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Code</label>
                <div class="flex gap-2">
                    <input type="text" name="code" id="code"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none"
                        value="{{ old('code', $department->code ?? '') }}">
                    <button type="button" id="generateCode"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Generate
                    </button>
                </div>
                @error('code')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Description</label>
                <textarea name="description" rows="4"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none"
                    placeholder="Enter department description">{{ old('description', $department->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Status</label>
                <select name="status"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    <option value="active"
                        {{ old('status', $department->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive"
                        {{ old('status', $department->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive
                    </option>
                    <option value="archived"
                        {{ old('status', $department->status ?? '') == 'archived' ? 'selected' : '' }}>Archived
                    </option>
                </select>
                @error('status')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div>
                <button type="submit"
                    class="px-6 py-2 bg-sky-600 text-white font-semibold rounded-lg shadow hover:bg-sky-700 transition">
                    {{ isset($department) ? 'Update' : 'Create' }}
                </button>
            </div>
        </form>
    </div>

    <script>
        // Auto-generate slug from name
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        nameInput.addEventListener('input', () => {
            slugInput.value = nameInput.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');
        });

        // Auto-generate random code
        document.getElementById('generateCode').addEventListener('click', () => {
            const code = Math.random().toString(36).substring(2, 8).toUpperCase();
            document.getElementById('code').value = code;
        });
    </script>
</x-admin-layout>
