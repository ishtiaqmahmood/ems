<x-admin-layout>
    <div class="max-w-4xl mx-auto p-6">

        {{-- Page Header --}}
        <div class="flex justify-between items-center mb-8">
            <h1
                class="text-3xl font-extrabold bg-clip-text text-transparent
                bg-gradient-to-r from-sky-600 to-blue-400 drop-shadow">
                Create Section
            </h1>
        </div>

        {{-- Form Card --}}
        <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
            <form action="{{ route('admin.sections.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                {{-- Organization --}}
                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Organization</label>
                    <select name="organization_id" id="organization"
                        class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2
                               focus:ring-sky-500 transition">
                        <option value="">Select Organization</option>
                        @foreach ($organizations as $org)
                            <option value="{{ $org->id }}">{{ $org->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Department --}}
                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Department</label>
                    <select name="department_id" id="department"
                        class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2
                               focus:ring-sky-500 transition">
                        <option value="">Select Department</option>
                    </select>
                </div>

                {{-- Name --}}
                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Section Name</label>
                    <input type="text" name="name" required
                        class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2
                               focus:ring-sky-500 transition"
                        placeholder="Enter section name...">
                </div>

                {{-- Slug --}}
                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Slug (auto-generated)</label>
                    <input type="text" id="slug" name="slug" readonly
                        class="w-full p-3 rounded-xl bg-gray-100 border-gray-200 shadow-inner text-gray-600">
                </div>

                {{-- Code --}}
                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Code (auto-generated)</label>
                    <input type="text" name="code" readonly
                        class="w-full p-3 rounded-xl bg-gray-100 border-gray-200 shadow-inner text-gray-600"
                        value="{{ strtoupper(Str::random(6)) }}">
                </div>

                {{-- UUID --}}
                <input type="hidden" name="uuid" value="{{ Str::uuid() }}">

                {{-- Description --}}
                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2
                               focus:ring-sky-500 transition"
                        placeholder="Write section description..."></textarea>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Status</label>
                    <select name="status"
                        class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2
                               focus:ring-sky-500 transition">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>

                {{-- Sort Order --}}
                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Sort Order</label>
                    <input type="number" name="sort_order" value="0"
                        class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2
                               focus:ring-sky-500 transition">
                </div>

                {{-- Created by --}}
                <input type="hidden" name="created_by" value="{{ Auth::id() }}">

                {{-- Submit Button --}}
                <div class="pt-4">
                    <button
                        class="px-6 py-3 bg-gradient-to-r from-sky-600 to-blue-500 text-white font-semibold
                               rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition">
                        Save Section
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        // Load departments dynamically
        document.getElementById('organization').addEventListener('change', function() {
            fetch('/admin/departments/by-organization/' + this.value)
                .then(res => res.json())
                .then(data => {
                    let dep = document.getElementById('department');
                    dep.innerHTML = '<option value="">Select Department</option>';
                    data.forEach(d => dep.innerHTML += `<option value="${d.id}">${d.name}</option>`);
                });
        });

        // Auto slug generator
        document.querySelector('input[name="name"]').addEventListener('input', function() {
            document.getElementById('slug').value =
                this.value.toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^a-z0-9\-]/g, '');
        });
    </script>
</x-admin-layout>
