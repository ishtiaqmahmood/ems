<x-layout>
    <x-page-heading>Register</x-page-heading>

    <x-forms.form method="POST" action="/register" enctype="multipart/form-data">
        <x-forms.input label="Name" name="name" />
        <x-forms.input label="Email" name="email" type="email" />
        <x-forms.input label="Password" name="password" type="password" />
        <x-forms.input label="Password Confirmation" name="password_confirmation" type="password" />

        <x-forms.button>Create Account</x-forms.button>
    </x-forms.form>

    <div class="mt-4 w-full flex justify-center">
        <p class="text-sm text-gray-600 text-center">
            Already have an account?
            <a href="/login" class="text-blue-600 hover:text-blue-800 font-medium">
                Login here
            </a>
        </p>
    </div>
</x-layout>
