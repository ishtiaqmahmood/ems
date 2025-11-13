<x-admin-layout>
    <div class="max-w-4xl mx-auto py-10 px-6 bg-white shadow-lg rounded-xl">

        {{-- Header --}}
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
            <i class="bi bi-building text-sky-600"></i>
            Add Organization
        </h2>

        {{-- Success / Error Messages --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 border border-green-300 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-800 border border-red-300 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.organizations.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            {{-- Name --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2" for="name">Organization Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400"
                    placeholder="Enter organization name" required>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2" for="description">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400"
                    placeholder="Enter organization description">{{ old('description') }}</textarea>
            </div>

            {{-- Contact Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400"
                        placeholder="Enter email">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400"
                        placeholder="Enter phone number">
                </div>
            </div>

            {{-- Website --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2" for="website">Website</label>
                <input type="url" name="website" id="website" value="{{ old('website') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400"
                    placeholder="https://example.com">
            </div>

            {{-- Logo Upload --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2" for="logo">Logo</label>
                <input type="file" name="logo" id="logo" accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400">
            </div>

            {{-- Multiple Images Upload --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2" for="images">Additional Images</label>
                <input type="file" name="images[]" id="images" multiple accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400">
            </div>

            {{-- Submit Button --}}
            <div>
                <button type="submit"
                    class="bg-sky-600 text-white px-6 py-2 rounded-lg shadow hover:bg-sky-700 transition font-medium">
                    Save Organization
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>
