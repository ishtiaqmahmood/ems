<x-admin-layout>
    <div class="p-6 space-y-10">

        <!-- Heading -->
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">
                Leave Application Details
            </h1>
        </div>

        <!-- Details Card -->
        <div class="bg-white rounded-xl shadow-md p-8 space-y-6 border border-gray-100">

            <!-- User + Type + Duration -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <p class="text-sm text-gray-500">User</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $leave->user->name }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Leave Type</p>
                    <span
                        class="inline-block mt-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                        {{ ucfirst($leave->type) }}
                    </span>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Duration</p>
                    <p class="text-lg font-medium text-gray-900">
                        {{ $leave->start_date->format('d M Y') }}
                        <span class="mx-1 text-gray-400">→</span>
                        {{ $leave->end_date->format('d M Y') }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">({{ $leave->total_days }} days)</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Status</p>

                    @php
                        $color = [
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'approved' => 'bg-green-100 text-green-700',
                            'rejected' => 'bg-red-100 text-red-700',
                        ][$leave->status];
                    @endphp

                    <span class="inline-block mt-1 px-3 py-1 rounded-full text-sm font-semibold {{ $color }}">
                        {{ ucfirst($leave->status) }}
                    </span>
                </div>

            </div>

            <!-- Reason -->
            <div>
                <p class="text-sm text-gray-500">Reason</p>
                <p class="mt-1 text-gray-800 leading-relaxed">
                    {{ $leave->reason }}
                </p>
            </div>

            <!-- Description -->
            <div>
                <p class="text-sm text-gray-500">Description</p>
                <p class="mt-1 text-gray-800 leading-relaxed">
                    {{ $leave->description }}
                </p>
            </div>

            <!-- PDF Letter -->
            @if ($leave->letter_pdf)
                <div>
                    <p class="text-sm text-gray-500">Attached Letter</p>

                    <a href="{{ $leave->letter_pdf_url }}" target="_blank"
                        class="inline-flex items-center mt-2 px-5 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg shadow transition">
                        View PDF
                        <i class="bi bi-file-earmark-pdf text-white ml-2"></i>
                    </a>
                </div>
            @endif
        </div>

        <!-- Update Status Section -->
        <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Update Status</h2>

            <form action="{{ route('admin.leaves.update', $leave->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-2 text-gray-700 font-medium">Status</label>
                    <select name="status"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500 p-3">
                        <option value="pending" {{ $leave->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $leave->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $leave->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <button
                    class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow transition">
                    Update Status
                </button>
            </form>
        </div>

    </div>
</x-admin-layout>
