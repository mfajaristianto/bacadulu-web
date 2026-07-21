<footer class="relative bg-[#111122] text-gray-300 pt-20 pb-6 w-full overflow-hidden">
    
    <!-- AKSEN LENGKUNGAN -->
    <div class="absolute inset-0 pointer-events-none opacity-10">
        <svg class="absolute right-0 top-0 h-full w-auto" viewBox="0 0 1000 1000" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1000 0C850 300 600 200 400 500C200 800 100 900 0 1000H1000V0Z" fill="url(#paint0_linear)"/>
            <defs>
                <linearGradient id="paint0_linear" x1="500" y1="0" x2="500" y2="1000" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#ffaa00" />
                    <stop offset="1" stop-color="#1e1e38" />
                </linearGradient>
            </defs>
        </svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8 z-10">
        
        <!-- Grid Utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 pb-16">
            
            <!-- KOLOM 1: Brand -->
            <div class="flex flex-col gap-6">
                <div>
                    <h3 class="text-3xl font-extrabold text-white tracking-tight leading-tight">
                        {{ __('Baca Dulu,') }}<br>
                        <span class="text-[#ffaa00]">{{ __('Pahami Kemudian.') }}</span>
                    </h3>
                    <p class="mt-4 text-sm text-gray-400 leading-relaxed max-w-sm">
                        {{ __('Platform edukasi dan pelatihan berbasis informasi yang berkualitas untuk mendukung pembelajaran berkelanjutan.') }}
                    </p>
                </div>
                <div class="max-w-[200px]">
                    <img src="{{ asset('img/Bina.jpg') }}" alt="PT. Bina Cendikia Academy" class="w-full h-auto rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                </div>
            </div>

            <!-- KOLOM 2: Alamat Kantor -->
            <div class="flex flex-col gap-6">
                <h4 class="text-white font-bold text-lg tracking-wide">{{ __('Lokasi Kantor') }}</h4>
                <div class="space-y-6">
                    <div>
                        <h5 class="text-white font-semibold text-sm mb-2 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#ffaa00]"></span> Palma Tower
                        </h5>
                        <p class="text-xs text-gray-400 leading-relaxed">TB Simatupang, JL. RA Kartini II-S Kav. 6, RT.6/RW.14, Pd. Pinang, Kec. Kebayoran Lama, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12310</p>
                    </div>
                    <div>
                        <h5 class="text-white font-semibold text-sm mb-2 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#ffaa00]"></span> The Manhattan Square
                        </h5>
                        <p class="text-xs text-gray-400 leading-relaxed">Jl. TB Simatupang, RT.3/RW.3, Cilandak Tim., Ps. Minggu, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12560</p>
                    </div>
                </div>
            </div>

            <!-- KOLOM 3: Stay Connected -->
            <div class="flex flex-col gap-8">
                <div>
                    <h4 class="text-white font-bold text-lg tracking-wide mb-4">{{ __('Stay Connected') }}</h4>
                    <div class="flex items-center gap-3">
                        <a href="https://www.youtube.com/@Bacaduluofficial" target="_blank" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-gray-300 hover:bg-[#ffaa00] hover:text-[#111122] hover:border-[#ffaa00] transition-all duration-300 transform hover:-translate-y-1">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.163a3.003 3.003 0 0 0-2.11-2.11C19.517 3.545 12 3.545 12 3.545s-7.516 0-9.387.507a3.003 3.003 0 0 0-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 0 0 2.11 2.11c1.871.507 9.387.507 9.387.507s7.517 0 9.387-.507a3.003 3.003 0 0 0 2.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        <a href="https://www.instagram.com/bacaduluofficial/" target="_blank" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-gray-300 hover:bg-[#ffaa00] hover:text-[#111122] hover:border-[#ffaa00] transition-all duration-300 transform hover:-translate-y-1">
                            <svg class="w-5 h-5 fill-none stroke-current stroke-2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                        </a> 
                        <a href="https://www.tiktok.com/@mpl.id.official" target="_blank" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-gray-300 hover:bg-[#ffaa00] hover:text-[#111122] hover:border-[#ffaa00] transition-all duration-300 transform hover:-translate-y-1">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.77 0 2.89 2.89 0 0 1 2.89-2.89h.54V9.66h-.54a6.33 6.33 0 1 0 6.33 6.33V8.89a8.16 8.16 0 0 0 4.25 1.15V6.69z"/>
                            </svg>
                        </a>

                    </div>
                </div>
            </div>

            <!-- KOLOM 4: CS -->
            <div>
                <div class="relative bg-gradient-to-br from-[#1e1e38] to-[#111122] p-6 rounded-2xl border border-white/5 shadow-2xl overflow-hidden">
                    <h4 class="text-lg font-bold text-white mb-2">{{ __('Customer Service') }}</h4>
                    <p class="text-xs text-gray-400 leading-relaxed mb-4">{{ __('Punya pertanyaan mengenai program kami atau butuh bantuan pendaftaran? Hubungi tim kami sekarang.') }}</p>
                    <a href="https://wa.me/6281315717719" target="_blank" class="w-full bg-[#ffaa00] text-[#111122] font-extrabold text-xs py-3 rounded-xl hover:bg-[#ffbb22] transition-colors duration-300 flex items-center justify-center gap-2">
                        <img src="{{ asset('img/waa.jpg') }}" alt="WhatsApp" class="w-5 h-5 object-contain rounded-full">
                        {{ __('Hubungi via WhatsApp') }}
                    </a>
                </div>
            </div>

        </div>

        <!-- SUB-FOOTER -->
        <div class="border-t border-white/5 pt-6 mt-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="relative inline-block text-left">
                <select onchange="window.location.href = this.value;" class="bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-xs font-semibold text-white focus:outline-none focus:ring-1 focus:ring-[#ffaa00] cursor-pointer appearance-none pr-8" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23a0aec0%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 10px top 50%; background-size: 8px auto;">
                    @php $currentLocale = app()->getLocale(); @endphp
                    <option value="{{ url('lang/id') }}" {{ $currentLocale == 'id' ? 'selected' : '' }} class="bg-[#1a1a30] text-white">Bahasa Indonesia (ID)</option>
                    <option value="{{ url('lang/en') }}" {{ $currentLocale == 'en' ? 'selected' : '' }} class="bg-[#1a1a30] text-white">English (EN)</option>
                    <option value="{{ url('lang/zh') }}" {{ $currentLocale == 'zh' ? 'selected' : '' }} class="bg-[#1a1a30] text-white">China (ZH)</option>
                    <option value="{{ url('lang/ja') }}" {{ $currentLocale == 'ja' ? 'selected' : '' }} class="bg-[#1a1a30] text-white">Japan (JA)</option>
                    <option value="{{ url('lang/ko') }}" {{ $currentLocale == 'ko' ? 'selected' : '' }} class="bg-[#1a1a30] text-white">South Korea (KO)</option>
                </select>
            </div>
            <p class="text-xs text-gray-500">Copyright © {{ now()->year }} BacaDulu. All rights reserved.</p>
            <div class="hidden sm:block w-16"></div>
        </div>
    </div>

    <!-- FLOATING SPEED DIAL -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-center gap-4">
        <div id="contactMenu" class="flex flex-col items-center gap-4 opacity-0 pointer-events-none translate-y-5 transition-all duration-300 ease-out">
            <a href="tel:6281315717719" class="w-12 h-12 bg-[#10e383] text-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform duration-200 overflow-hidden aspect-square"><svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M21.384 17.791c-1.207-1.207-2.766-1.207-3.973 0l-1.127 1.127c-.23.23-.585.281-.873.124-2.128-1.155-4.512-3.539-5.667-5.667-.156-.288-.106-.643.124-.873l1.127-1.127c1.207-1.207 1.207-2.766 0-3.973l-2.254-2.254c-1.207-1.207-2.766-1.207-3.973 0L3.513 6.304c-1.207 1.207-1.42 2.973-.564 4.54 1.701 3.111 4.75 6.16 7.861 7.861 1.567.856 3.333.643 4.54-.564l1.127-1.127c1.207-1.207 1.207-2.766 0-3.973l-2.254-2.254z"/></svg></a>
            <a href="https://wa.me/6281315717719" target="_blank" class="w-12 h-12 bg-[#25D366] rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform duration-200 overflow-hidden aspect-square"><img src="{{ asset('img/waa.jpg') }}" alt="WhatsApp" class="w-full h-full object-cover"></a>
            <a href="https://www.instagram.com/bacaduluofficial/" target="_blank" class="w-12 h-12 bg-gradient-to-tr from-[#f9ce34] via-[#ee2a7b] to-[#6228d7] text-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform duration-200 overflow-hidden aspect-square"><svg class="w-6 h-6 fill-none stroke-current stroke-2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
            <a href="mailto:support@bacadulu.com" class="w-12 h-12 bg-[#ff4b5c] text-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform duration-200 overflow-hidden aspect-square"><svg class="w-5 h-5 fill-none stroke-current stroke-2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></a>
        </div>
        <button id="fabToggle" onclick="toggleContactMenu()" class="bg-[#ffaa00] text-[#111122] flex items-center justify-center shadow-2xl transition-all duration-300 focus:outline-none" style="width: 56px !important; height: 56px !important; border-radius: 9999px !important; overflow: hidden !important; aspect-ratio: 1/1 !important;" title="Hubungi Kami">
            <svg id="chatIcon" class="w-6 h-6 fill-current transition-all duration-300" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z"/></svg>
            <svg id="closeIcon" class="w-6 h-6 fill-none stroke-current stroke-2 transition-all duration-300 transform scale-0 absolute" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        function toggleContactMenu() {
            const menu = document.getElementById('contactMenu');
            const toggleBtn = document.getElementById('fabToggle');
            const chatIcon = document.getElementById('chatIcon');
            const closeIcon = document.getElementById('closeIcon');
            const isOpen = !menu.classList.contains('opacity-0');
            if (isOpen) {
                menu.classList.add('opacity-0', 'pointer-events-none', 'translate-y-5');
                menu.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
                toggleBtn.classList.remove('bg-[#ff5d5d]', 'text-white');
                toggleBtn.classList.add('bg-[#ffaa00]', 'text-[#111122]');
                chatIcon.classList.remove('scale-0', 'rotate-90'); chatIcon.classList.add('scale-100', 'rotate-0');
                closeIcon.classList.remove('scale-100', 'rotate-0'); closeIcon.classList.add('scale-0', '-rotate-90');
            } else {
                menu.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-5');
                menu.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
                toggleBtn.classList.remove('bg-[#ffaa00]', 'text-[#111122]');
                toggleBtn.classList.add('bg-[#ff5d5d]', 'text-white');
                chatIcon.classList.remove('scale-100', 'rotate-0'); chatIcon.classList.add('scale-0', 'rotate-90');
                closeIcon.classList.remove('scale-0', '-rotate-90'); closeIcon.classList.add('scale-100', 'rotate-0');
            }
        }
    </script>
</footer>