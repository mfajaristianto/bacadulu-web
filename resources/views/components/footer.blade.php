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
        
        <!-- Grid Utama (3 Kolom Seimbang) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 pb-16">
            
            <!-- KOLOM 1: Brand & Logo -->
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

            <!-- KOLOM 2: Alamat Kantor & Google Maps -->
            <div class="flex flex-col gap-6">
                <h4 class="text-white font-bold text-lg tracking-wide">{{ __('Lokasi Kantor') }}</h4>
                <div class="space-y-4">
                    <div>
                        <h5 class="text-white font-semibold text-sm mb-1 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#ffaa00]"></span> The Manhattan Square
                        </h5>
                        <p class="text-xs text-gray-400 leading-relaxed">
                            Jl. TB Simatupang, Lt 12, RT.3/RW.3, Cilandak Tim., Ps. Minggu, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta.
                        </p>
                    </div>

                    <!-- Google Maps Interaktif (Ukuran Diperbesar h-64 agar tombol Zoom & Buka di Maps Tampil Sempurna) -->
                    <div class="w-full h-64 rounded-xl overflow-hidden border border-white/10 shadow-xl relative bg-slate-900">
                        <iframe 
                            src="https://maps.google.com/maps?q=The%20Manhattan%20Square%2C%20Jl.%20TB%20Simatupang%2C%20Jakarta%20Selatan&t=&z=16&ie=UTF8&iwloc=&output=embed" 
                            width="100%" 
                            height="100%" 
                            style="border:0; width:100%; height:100%;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

            <!-- KOLOM 3: Kontak (Gmail, WhatsApp, & Sosial Media) -->
            <div class="flex flex-col gap-6">
                <h4 class="text-white font-bold text-lg tracking-wide">{{ __('Hubungi Kami') }}</h4>
                
                <div class="space-y-3 text-sm">
                    <!-- Gmail -->
                    <a href="mailto:info@bacadulu.com" class="flex items-center gap-3 text-gray-300 hover:text-[#ffaa00] transition-colors duration-200 group">
                        <div class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center group-hover:border-[#ffaa00] transition-colors flex-shrink-0">
                            <svg class="w-4 h-4 fill-current text-gray-300 group-hover:text-[#ffaa00]" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium">info@bacadulu.com</span>
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/6281315717719" target="_blank" class="flex items-center gap-3 text-gray-300 hover:text-[#ffaa00] transition-colors duration-200 group">
                        <div class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center group-hover:border-[#ffaa00] transition-colors flex-shrink-0">
                            <img src="{{ asset('img/waa.jpg') }}" alt="WhatsApp" class="w-4 h-4 object-contain rounded-full">
                        </div>
                        <span class="text-xs font-medium">+62 813-1571-7719</span>
                    </a>
                </div>

                <!-- Stay Connected (Sosial Media) -->
                <div class="pt-2">
                    <h5 class="text-white font-semibold text-xs tracking-wide mb-3 uppercase text-gray-400">{{ __('Ikuti Kami') }}</h5>
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

        </div>

        <!-- SUB-FOOTER -->
        <div class="border-t border-white/5 pt-6 mt-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="relative inline-block text-left">
                <select onchange="window.location.href = this.value;" class="bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-xs font-semibold text-white focus:outline-none focus:ring-1 focus:ring-[#ffaa00] cursor-pointer appearance-none pr-8" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23a0aec0%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 10px top 50%; background-size: 8px auto;">
                    @php $currentLocale = app()->getLocale(); @endphp
                    <option value="{{ url('lang/id') }}" {{ $currentLocale == 'id' ? 'selected' : '' }} class="bg-[#1a1a30] text-white">Bahasa Indonesia (ID)</option>
                    <option value="{{ url('lang/en') }}" {{ $currentLocale == 'en' ? 'selected' : '' }} class="bg-[#1a1a30] text-white">English (EN)</option>
                </select>
            </div>
            <p class="text-xs text-gray-500">Copyright © {{ now()->year }} BacaDulu. All rights reserved.</p>
            <div class="hidden sm:block w-16"></div>
        </div>
    </div>
</footer>