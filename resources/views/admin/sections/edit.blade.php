<x-admin-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Section</h1>

        <form action="{{ route('admin.sections.update', $section) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Organization --}}
            <label class="font-semibold">Organization</label>
            <select name="organization_id" id="organization" class="w-full mb-4 p-2 border rounded">
                <option value="">Select Organization</option>
                @foreach ($organizations as $org)
                    <option value="{{ $org->id }}"
                        {{ old('organization_id', $section->organization_id) == $org->id ? 'selected' : '' }}>
                        {{ $org->name }}
                    </option>
                @endforeach
            </select>

            {{-- Department --}}
            <label class="font-semibold">Department</label>
            <select name="department_id" id="department" class="w-full mb-4 p-2 border rounded">
                @foreach ($departments as $dep)
                    <option value="{{ $dep->id }}"
                        {{ old('department_id', $section->department_id) == $dep->id ? 'selected' : '' }}>
                        {{ $dep->name }}
                    </option>
                @endforeach
            </select>

            {{-- Name --}}
            <label class="font-semibold">Section Name</label>
            <input type="text" name="name" value="{{ old('name', $section->name) }}"
                class="w-full mb-4 p-2 border rounded">

            {{-- Existing Images --}}
            {{-- @if ($section->images)
                <div class="mb-4">
                    <label class="font-semibold">Current Images</label>
                    <div class="grid grid-cols-3 gap-3 mt-2">
                        @foreach ($section->images as $index => $img)
                            <div class="relative border rounded p-1 bg-white shadow">
                                <img src="{{ asset('storage/' . $img) }}" class="h-24 w-full object-cover rounded">

                                <label class="text-red-600 text-sm flex items-center gap-1 mt-1">
                                    <input type="checkbox" name="remove_images[]" value="{{ $index }}">
                                    Remove
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif --}}

            {{-- Upload New Images
            <label class="font-semibold">Add Images</label>
            <input type="file" name="images[]" multiple class="w-full mb-4 p-2 border rounded"> --}}

            {{-- Description --}}
            <label class="font-semibold">Description</label>
            <textarea name="description" rows="4" class="w-full mb-4 p-2 border rounded">{{ old('description', $section->description) }}</textarea>

            {{-- Status --}}
            <label class="font-semibold">Status</label>
            <select name="status" class="w-full mb-4 p-2 border rounded">
                @foreach (['active', 'inactive', 'archived'] as $status)
                    <option value="{{ $status }}"
                        {{ old('status', $section->status) == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>

            {{-- Sort --}}
            <label class="font-semibold">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $section->sort_order) }}"
                class="w-full mb-4 p-2 border rounded">

            <button class="px-4 py-2 bg-sky-600 text-white rounded-lg">Update Section</button>
        </form>
    </div>

    <script>
        document.getElementById('organization').addEventListener('change', function() {
            let orgId = this.value;
            let selectedDepartment = "{{ $section->department_id }}";

            fetch('/admin/departments/by-organization/' + orgId)
                .then(res => res.json())
                .then(data => {
                    let depDropdown = document.getElementById('department');
                    depDropdown.innerHTML = '';

                    data.forEach(dep => {
                        let selected = dep.id == selectedDepartment ? 'selected' : '';
                        depDropdown.innerHTML +=
                            `<option value="${dep.id}" ${selected}>${dep.name}</option>`;
                    });
                });
        });
    </script>
</x-admin-layout>
