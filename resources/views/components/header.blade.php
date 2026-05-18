<header class="flex justify-between items-center px-4 md:px-10 py-5 bg-white/80 backdrop-blur-md sticky top-0 z-40 border-b border-gray-100/50 shadow-sm">
    <!-- Page Title & Mobile Menu Toggle -->
    <div class="flex items-center gap-4">
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-gray-600 hover:bg-slate-50 rounded-xl transition-all">
            <i class="bi bi-list text-2xl"></i>
        </button>

        <div class="hidden md:block w-1 h-8 bg-sky-600 rounded-full"></div>
        <h1 class="text-lg md:text-xl font-black text-gray-900 tracking-tight truncate max-w-[150px] sm:max-w-none">{{ $pageTitle ?? 'Dashboard' }}</h1>
    </div>

    <!-- User & Actions -->
    <div class="flex items-center gap-6" x-data="{
        notificationsOpen: false,
        notifications: [],
        unreadCount: 0,
        async fetchNotifications() {
            try {
                const response = await fetch('/api/notifications/unread');
                const data = await response.json();
                this.notifications = data.notifications;
                this.unreadCount = data.unreadCount;
            } catch (error) {
                console.error('Error fetching notifications:', error);
            }
        },
        async markAsRead(id) {
            await fetch(`/api/notifications/${id}/read`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
            await this.fetchNotifications();
        }
    }" x-init="fetchNotifications(); setInterval(() => fetchNotifications(), 30000)">

        {{-- Notification Bell & Dropdown --}}
        <div class="relative">
            <button @click="notificationsOpen = !notificationsOpen" class="relative p-2 text-gray-400 hover:text-sky-600 hover:bg-sky-50 rounded-xl transition-all group">
                <i class="bi bi-bell text-xl"></i>
                <template x-if="unreadCount > 0">
                    <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white animate-pulse"></span>
                </template>
            </button>

            {{-- Dropdown Panel --}}
            <div x-show="notificationsOpen"
                 @click.away="notificationsOpen = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl shadow-sky-200/50 border border-gray-100 overflow-hidden z-50">

                <div class="p-4 border-b border-gray-50 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-xs font-black uppercase tracking-wider text-gray-400">Notifications</h3>
                    <span x-show="unreadCount > 0" class="px-2 py-0.5 bg-sky-100 text-sky-600 text-[10px] font-bold rounded-full" x-text="unreadCount + ' New'"></span>
                </div>

                <div class="max-h-[350px] overflow-y-auto custom-scrollbar">
                    <template x-if="notifications.length === 0">
                        <div class="p-8 text-center">
                            <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="bi bi-bell-slash text-gray-300 text-xl"></i>
                            </div>
                            <p class="text-sm text-gray-400 font-medium">All caught up!</p>
                        </div>
                    </template>

                    <template x-for="notification in notifications" :key="notification.id">
                        <div class="p-4 border-b border-gray-50 hover:bg-slate-50 transition-colors cursor-pointer group" @click="markAsRead(notification.id)">
                            <div class="flex gap-3">
                                <div class="w-8 h-8 rounded-lg flex-shrink-0 flex items-center justify-center"
                                     :class="notification.data.type === 'new_leave' ? 'bg-amber-50 text-amber-500' : 'bg-sky-50 text-sky-500'">
                                    <i class="bi" :class="notification.data.type === 'new_leave' ? 'bi-person-plus' : 'bi-check2-circle'"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 leading-snug group-hover:text-sky-600 transition-colors" x-text="notification.data.message"></p>
                                    <p class="text-[10px] text-gray-400 mt-1 font-medium" x-text="notification.created_at_human"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="p-3 bg-slate-50/50 text-center border-t border-gray-50">
                    <button class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-sky-600 transition-colors">View All Activities</button>
                </div>
            </div>
        </div>

        @auth
            <div class="h-8 w-px bg-gray-100"></div>

            <a href="{{ route('profile.show') }}"
                class="flex items-center gap-3 pl-2 pr-4 py-2 rounded-2xl hover:bg-slate-50 transition-all group">

                {{-- Avatar Circle --}}
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-500 to-indigo-600 flex items-center justify-center text-white font-black shadow-lg shadow-sky-100 group-hover:scale-105 transition-transform">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>

                <div class="hidden md:block">
                    <p class="text-sm font-black text-gray-900 leading-none mb-1 group-hover:text-sky-600 transition-colors">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none">{{ Auth::user()->role }}</p>
                </div>
            </a>
        @endauth
    </div>
</header>
