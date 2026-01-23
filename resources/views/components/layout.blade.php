<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="px-10 min-h-screen flex flex-col">
        {{-- <nav class="flex justify-between items-center py-4 border-b border-gray-700">
            <!-- Left side -->
            <div class="space-x-6 font-bold">
                <a href="/">EMS</a>
            </div>

            <!-- Right side -->
            @auth
                <div class="space-x-6 font-bold flex items-center">
                    <a href="{{ route('profile.show') }}" class="hover:underline">Profile</a>

                    <form method="POST" action="/logout">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="hover:underline">Log Out</button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="space-x-6 font-bold">
                    <a href="/register">Sign Up</a>
                    <a href="/login">Login</a>
                </div>
            @endguest
        </nav> --}}
        <main class="flex-1 p-8 overflow-y-auto">


            <section>
                {{ $slot }}
            </section>
        </main>
    </div>
</body>

</html>
