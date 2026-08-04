<!-- HERO SECTION UTAMA -->
<section id="home" class="relative w-full h-[600px] flex items-center justify-start overflow-hidden">
    
    <!-- Gambar Background Slideshow -->
    <div class="absolute inset-0 z-0">
        <img id="img1" src="{{ asset('img/home.jpg') }}" class="hero-slide absolute inset-0 w-full h-full object-cover transition-opacity duration-1500 opacity-100">
        <img id="img2" src="{{ asset('img/transisi-1.jpg') }}" class="hero-slide absolute inset-0 w-full h-full object-cover transition-opacity duration-1500 opacity-0">
        <img id="img3" src="{{ asset('img/transisi-2.jpg') }}" class="hero-slide absolute inset-0 w-full h-full object-cover transition-opacity duration-1500 opacity-0">
        
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/60 z-[1]"></div>
    </div>

    <!-- Konten Utama -->
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 w-full grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        
        <!-- SISI KIRI: Teks -->
        <div class="lg:col-span-7 text-white">
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-bold leading-tight mb-6 animate-slide-in-left">
                Wujudkan Karya Ilmiah Berkualitas dan Berdampak
            </h1>
            
            <p class="text-lg text-gray-200 mb-8 leading-relaxed max-w-xl">
                Kami telah menerbitkan ribuan naskah Buku Ajar, Buku Referensi, Buku Monograf, Book Chapter, Jurnal Penelitian Ilmiah hingga Proceeding dalam bentuk buku cetak maupun E-Book.
            </p>

            <a href="https://wa.me/6281315717719" target="_blank" 
               class="inline-flex items-center gap-3 bg-[#FFC145] hover:bg-[#e0a838] text-slate-900 px-6 py-3 rounded-full font-bold transition-all shadow-md">
                <img src="{{ asset('img/waa.jpg') }}" alt="WhatsApp" class="w-6 h-6 rounded-full object-cover">
                <span class="text-sm">Hubungi via WhatsApp</span>
            </a>
        </div>
    </div>
</section>

<script>
    (function () {
        const images = [
            document.getElementById('img1'),
            document.getElementById('img2'),
            document.getElementById('img3')
        ].filter(Boolean);

        if (images.length < 2) {
            return;
        }

        let currentIndex = 0;
        let intervalId = null;

        const showSlide = (index) => {
            images.forEach((img, idx) => {
                img.classList.remove('opacity-100');
                img.classList.add('opacity-0');
                img.style.zIndex = idx === index ? '2' : '1';
                img.style.filter = 'brightness(0.6)';
            });
            images[index].classList.remove('opacity-0');
            images[index].classList.add('opacity-100');
            images[index].style.opacity = '1';
            images[index].style.filter = 'brightness(0.6)';
        };

        const startSlideshow = () => {
            if (intervalId !== null) {
                return;
            }
            showSlide(currentIndex);
            intervalId = setInterval(() => {
                currentIndex = (currentIndex + 1) % images.length;
                showSlide(currentIndex);
            }, 7000);
        };

        const stopSlideshow = () => {
            if (intervalId !== null) {
                clearInterval(intervalId);
                intervalId = null;
            }
        };

        const init = () => {
            images.forEach((img) => {
                img.style.transition = 'opacity 1.8s ease-in-out, filter 1.8s ease-in-out';
                img.style.zIndex = '1';
                img.style.filter = 'brightness(0.6)';
                img.classList.add('opacity-0');
                img.classList.remove('opacity-100');
            });
            showSlide(currentIndex);
            startSlideshow();
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }

        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
                startSlideshow();
            } else {
                stopSlideshow();
            }
        });
    })();
</script>