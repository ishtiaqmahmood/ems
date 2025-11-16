<x-admin-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Create Section</h1>

        <form action="{{ route('admin.sections.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Organization --}}
            <label class="font-semibold">Organization</label>
            <select name="organization_id" id="organization" class="w-full mb-3 p-2 border rounded">
                <option value="">Select Organization</option>
                @foreach ($organizations as $org)
                    <option value="{{ $org->id }}">{{ $org->name }}</option>
                @endforeach
            </select>

            {{-- Department --}}
            <label class="font-semibold">Department</label>
            <select name="department_id" id="department" class="w-full mb-3 p-2 border rounded">
                <option value="">Select Department</option>
            </select>

            {{-- Name --}}
            <label class="font-semibold">Section Name</label>
            <input type="text" name="name" class="w-full mb-3 p-2 border rounded" required>

            {{-- Slug --}}
            <label class="font-semibold">Slug (auto-generated)</label>
            <input type="text" name="slug" id="slug" class="w-full mb-3 p-2 border rounded" readonly>

            {{-- Code --}}
            <label class="font-semibold">Code (auto-generated)</label>
            <input type="text" name="code" class="w-full mb-3 p-2 border rounded"
                value="{{ strtoupper(Str::random(6)) }}" readonly>

            {{-- UUID --}}
            <input type="hidden" name="uuid" value="{{ Str::uuid() }}">

            {{-- Images
            <label class="font-semibold">Images</label>
            <input type="file" name="images[]" multiple class="w-full mb-3 p-2 border rounded"> --}}

            {{-- Description --}}
            <label class="font-semibold">Description</label>
            <textarea name="description" rows="4" class="w-full p-2 border rounded" placeholder="Section description..."></textarea>

            {{-- Status --}}
            <label class="font-semibold">Status</label>
            <select name="status" class="w-full mb-3 p-2 border rounded">
                <option value="active" selected>Active</option>
                <option value="inactive">Inactive</option>
                <option value="archived">Archived</option>
            </select>

            {{-- Sort Order --}}
            <label class="font-semibold">Sort Order</label>
            <input type="number" name="sort_order" class="w-full mb-3 p-2 border rounded" value="0">

            {{-- Hidden Created By --}}
            <input type="hidden" name="created_by" value="{{ Auth::id() }}">

            <button class="mt-4 px-4 py-2 bg-sky-600 text-white rounded-lg">
                Save Section
            </button>
        </form>
    </div>

    <script>
        // Auto load departments based on organization
        document.getElementById('organization').addEventListener('change', function() {
            fetch('/admin/departments/by-organization/' + this.value)
                .then(res => res.json())
                .then(data => {
                    let dep = document.getElementById('department');
                    dep.innerHTML = '<option value="">Select Department</option>';
                    data.forEach(d => dep.innerHTML += `<option value="${d.id}">${d.name}</option>`);
                });
        });

        // Auto-generate slug from name
        document.querySelector('input[name="name"]').addEventListener('input', function() {
            document.getElementById('slug').value =
                this.value.toLowerCase().replace(/ /g, '-').replace(/[^a-z0-9\-]/g, '');
        });
    </script>
</x-admin-layout>
