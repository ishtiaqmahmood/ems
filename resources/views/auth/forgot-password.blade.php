<x-layout>
    <x-page-heading>Forgot Password</x-page-heading>

    @if (session('status'))
        <div class="mb-4 text-green-600 font-medium">{{ session('status') }}</div>
    @endif

    <x-forms.form method="POST" action="/forgot-password">
        @csrf
        <x-forms.input label="Email" name="email" type="email" />

        <x-forms.button>Send Reset Link</x-forms.button>
    </x-forms.form>


    <div class="mt-4 w-full flex justify-center">
        <a href="/login" class="block text-center text-blue-600 hover:text-blue-800 font-medium">
            Back to Login
        </a>
    </div>

</x-layout>
