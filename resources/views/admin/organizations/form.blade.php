<x-admin-layout>
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $organization->name ?? '') }}"
            required>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                value="{{ old('email', $organization->email ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control"
                value="{{ old('phone', $organization->phone ?? '') }}">
        </div>
    </div>

    <div class="mb-3">
        <label>Website</label>
        <input type="url" name="website" class="form-control"
            value="{{ old('website', $organization->website ?? '') }}">
    </div>

    <div class="mb-3">
        <label>Address</label>
        <textarea name="address" class="form-control">{{ old('address', $organization->address ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ old('description', $organization->description ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label>Logo</label><br>
        @if (!empty($organization->logo_url))
            <img src="{{ $organization->logo_url }}" width="100" class="rounded mb-2 border">
        @endif
        <input type="file" name="logo" class="form-control">
    </div>

    <div class="mb-3">
        <label>Other Images</label>
        <input type="file" name="images[]" class="form-control" multiple>
    </div>

</x-admin-layout>
