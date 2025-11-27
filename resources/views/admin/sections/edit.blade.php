<x-admin-layout>

    <div class="max-w-5xl mx-auto p-8">

        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-4xl font-extrabold text-gray-900 drop-shadow-sm flex items-center gap-3">
                <i class="bi bi-layers-half text-sky-600"></i>
                Edit Section
            </h1>
            <p class="text-gray-500 mt-1 text-lg">
                Update all details of this section with enhanced UX controls and live dynamic dropdowns.
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white/80 backdrop-blur-xl border border-gray-200 shadow-2xl rounded-3xl p-10 space-y-10">

            <form action="{{ route('admin.sections.update', $section) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- ---------------------- -->
                <!-- GENERAL INFORMATION    -->
                <!-- ---------------------- -->
                <div class="space-y-6">

                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-info-circle text-sky-600"></i> General Information
                    </h2>

                    <div class="grid md:grid-cols-2 gap-8">

                        <!-- Organization -->
                        <div class="relative">
                            <label class="absolute -top-3 left-3 bg-white px-2 text-sm font-semibold text-gray-700">
                                Organization
                            </label>
                            <select name="organization_id" id="organization"
                                class="w-full p-4 border rounded-xl bg-gray-50 focus:bg-white focus:ring-4 focus:ring-sky-200 transition shadow-sm">
                                <option value="">Select Organization</option>
                                @foreach ($organizations as $org)
                                    <option value="{{ $org->id }}"
                                        {{ old('organization_id', $section->organization_id) == $org->id ? 'selected' : '' }}>
                                        {{ $org->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Department -->
                        <div class="relative">
                            <label class="absolute -top-3 left-3 bg-white px-2 text-sm font-semibold text-gray-700">
                                Department
                            </label>
                            <select name="department_id" id="department"
                                class="w-full p-4 border rounded-xl bg-gray-50 focus:bg-white focus:ring-4 focus:ring-sky-200 transition shadow-sm">
                                @foreach ($departments as $dep)
                                    <option value="{{ $dep->id }}"
                                        {{ old('department_id', $section->department_id) == $dep->id ? 'selected' : '' }}>
                                        {{ $dep->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <!-- Section Name -->
                    <div class="relative">
                        <label class="absolute -top-3 left-3 bg-white px-2 text-sm font-semibold text-gray-700">
                            Section Name
                        </label>
                        <input type="text" name="name" value="{{ old('name', $section->name) }}"
                            class="w-full p-4 border rounded-xl bg-gray-50 focus:bg-white focus:ring-4 focus:ring-sky-200 transition shadow-sm">
                    </div>

                </div>

                <!-- ---------------------- -->
                <!-- DESCRIPTION            -->
                <!-- ---------------------- -->
                <div class="space-y-6 pt-6 border-t">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-file-text text-sky-600"></i> Description
                    </h2>

                    <div class="relative">
                        <label class="absolute -top-3 left-3 bg-white px-2 text-sm font-semibold text-gray-700">
                            Description
                        </label>
                        <textarea name="description" rows="5"
                            class="w-full p-4 border rounded-xl bg-gray-50 focus:bg-white focus:ring-4 focus:ring-sky-200 transition shadow-sm">{{ old('description', $section->description) }}</textarea>
                    </div>
                </div>

                <!-- ---------------------- -->
                <!-- STATUS + SORT ORDER   -->
                <!-- ---------------------- -->
                <div class="space-y-6 pt-6 border-t">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-gear-wide-connected text-sky-600"></i> Status & Sorting
                    </h2>

                    <div class="grid md:grid-cols-2 gap-8">

                        <!-- Status -->
                        <div class="relative">
                            <label class="absolute -top-3 left-3 bg-white px-2 text-sm font-semibold text-gray-700">
                                Status
                            </label>
                            <select name="status"
                                class="w-full p-4 border rounded-xl bg-gray-50 focus:bg-white focus:ring-4 focus:ring-sky-200 transition shadow-sm">
                                @foreach (['active', 'inactive', 'archived'] as $status)
                                    <option value="{{ $status }}"
                                        {{ old('status', $section->status) == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort Order -->
                        <div class="relative">
                            <label class="absolute -top-3 left-3 bg-white px-2 text-sm font-semibold text-gray-700">
                                Sort Order
                            </label>
                            <input type="number" name="sort_order"
                                value="{{ old('sort_order', $section->sort_order) }}"
                                class="w-full p-4 border rounded-xl bg-gray-50 focus:bg-white focus:ring-4 focus:ring-sky-200 transition shadow-sm">
                        </div>

                    </div>
                </div>

                <!-- ---------------------- -->
                <!-- SAVE BUTTON            -->
                <!-- ---------------------- -->
                <div class="pt-8 border-t">
                    <button
                        class="px-8 py-4 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 flex items-center gap-2 text-lg">
                        <i class="bi bi-check2-circle"></i>
                        Save Changes
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- Dynamic Department Loader -->
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
