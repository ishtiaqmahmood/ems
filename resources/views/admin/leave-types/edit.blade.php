<x-admin-layout>
    <div class="max-w-3xl mx-auto mt-12 px-6 py-10 bg-white shadow-2xl rounded-3xl border border-sky-300">
        <!-- Header -->
        <h1 class="text-3xl font-bold text-sky-700 mb-8 text-center">Edit Leave Type</h1>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.leave-types.update', $leaveType) }}" class="space-y-6">
            @csrf
            @method('PUT')

            @include('admin.leave-types._form')


        </form>
    </div>
</x-admin-layout>
