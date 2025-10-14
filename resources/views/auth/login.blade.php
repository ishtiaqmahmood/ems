<x-layout>
    <x-page-heading>Login</x-page-heading>

    <x-forms.form method="POST" action="/login">

        <x-forms.input label="Email" name="email" type="email" />
        <x-forms.input label="Password" name="password" type="password" />

        <div class="mb-4 text-right">
            <a href="/forgot-password" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                Forgot Password?
            </a>
        </div>

        <div class="mb-4 flex items-center">
            <input type="checkbox" name="remember" id="remember"
                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <label for="remember" class="ml-2 block text-sm text-gray-700">
                Remember Me
            </label>
        </div>

        <x-forms.button>Log in</x-forms.button>
    </x-forms.form>

    <div class="mt-4 w-full flex justify-center">
        <p class="text-sm text-gray-600 text-center">
            Already have an account?
            <a href="/register" class="text-blue-600 hover:text-blue-800 font-medium">
                Register here
            </a>
        </p>
    </div>
</x-layout>
