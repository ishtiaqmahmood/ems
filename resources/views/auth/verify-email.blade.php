<x-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="max-w-md w-full bg-white shadow-lg rounded-xl p-8">
            <!-- Heading -->
            <h1 class="text-3xl md:text-4xl font-extrabold text-center text-gray-900 mb-6 tracking-tight">
                Verify Your Email
            </h1>

            <!-- Description -->
            <p class="text-gray-700 text-center mb-6">
                Thanks for registering! Before proceeding, please check your email for a verification link.
                If you didn't receive the email, you can request another below.
            </p>

            <!-- Resend Form -->
            @if (session('status'))
                <div class="mb-4 text-green-600 text-center font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}" class="flex flex-col items-center">
                @csrf
                <x-forms.button class="w-full mb-4">Resend Verification Email</x-forms.button>
            </form>

            <!-- Back to Login -->
            <div class="text-center mt-4">
                <a href="/login" class="text-blue-600 hover:text-blue-800 font-medium">
                    Back to Login
                </a>
            </div>
        </div>
    </div>
</x-layout>
