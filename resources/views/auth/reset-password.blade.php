<x-layout>
    <x-page-heading>Reset Password</x-page-heading>

    <x-forms.form method="POST" action="/reset-password">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <x-forms.input label="Email" name="email" type="email" />
        <x-forms.input label="New Password" name="password" type="password" />
        <x-forms.input label="Confirm Password" name="password_confirmation" type="password" />

        <x-forms.button>Reset Password</x-forms.button>
    </x-forms.form>

    <div class="mt-4 w-full flex justify-center">
        <a href="/login" class="block text-center text-blue-600 hover:text-blue-800 font-medium">
            Back to Login
        </a>
    </div>
</x-layout>
