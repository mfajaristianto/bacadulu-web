<section class="py-20 w-full bg-slate-50">
    <div class="max-w-5xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-slate-900 mb-12">Dewan Redaksi</h2>
        
        <!-- Grid Dipaksa 2 Kolom di Desktop -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            @php
            $data = [
                ['nama' => 'Ferdinand Pardede', 'jabatan' => 'Senior Partner (Valuation Firm)', 'img' => 'img/pak Ferdinand.jpg'],
                ['nama' => 'Lie Sia Widjaja', 'jabatan' => 'Certified Public Business Valuer', 'img' => 'img/lie sia.jpg'],
                ['nama' => 'Erik Nugraha', 'jabatan' => 'Associate Partner (BacaDulu)', 'img' => 'img/erik.jpg'],
                ['nama' => 'Dr. Audita Setiawan', 'jabatan' => 'Kepala Biro SDM, USB YPKP', 'img' => 'img/audita.jpg'],
            ];
            @endphp

            @foreach($data as $item)
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-orange-100 flex items-center hover:shadow-lg transition-all">
                <div class="w-20 h-20 flex-shrink-0 mr-4">
                    <img src="{{ asset($item['img']) }}" class="w-full h-full object-cover rounded-full border-2 border-orange-500 p-0.5">
                </div>
                <div>
                    <h3 class="font-bold text-slate-900">{{ $item['nama'] }}</h3>
                    <p class="text-orange-600 text-xs font-semibold uppercase">{{ $item['jabatan'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>