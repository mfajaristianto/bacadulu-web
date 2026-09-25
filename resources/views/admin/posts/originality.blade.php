@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Originality Review</h1>
            <p class="text-slate-600 mt-1">Pemeriksaan berlaku sama untuk seluruh penulis. Badge terverifikasi hanya menunjukkan verifikasi identitas/afiliasi.</p>
        </div>
        <a href="{{ route('admin.posts.index', ['status' => $post->status]) }}" class="px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-sm font-semibold text-slate-700 hover:bg-slate-50">← Kembali</a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-100 text-green-700 border border-green-200 px-4 py-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-100 text-red-700 border border-red-200 px-4 py-3">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 text-red-700 border border-red-200 px-4 py-3">
            <ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl shadow-sm p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <div class="text-xs uppercase tracking-wide text-slate-500">Naskah yang diperiksa</div>
                    <h2 class="text-xl font-bold text-slate-900 mt-1">{{ $post->title }}</h2>
                    <p class="text-sm text-slate-600 mt-2">{{ $post->author ?: $post->user?->name ?: '-' }}</p>
                </div>
                @if($post->user?->isVerifiedAuthor())
                    <span class="shrink-0 rounded-full bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1.5">✓ PENULIS TERVERIFIKASI</span>
                @else
                    <span class="shrink-0 rounded-full bg-slate-100 text-slate-600 text-xs font-bold px-3 py-1.5">PENULIS BIASA</span>
                @endif
            </div>
            <div class="mt-4 rounded-lg bg-amber-50 border border-amber-200 px-4 py-3 text-sm text-amber-800">
                <strong>Status verifikasi tidak memengaruhi hasil pemeriksaan originalitas.</strong> Sistem menilai naskah, timestamp, dan kecocokan sumber—bukan badge akun.
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
            <div class="text-xs uppercase tracking-wide text-slate-500">Multi-source coverage</div>
            <div class="mt-2 text-4xl font-black {{ $result['status'] === 'high' ? 'text-red-600' : ($result['status'] === 'warning' ? 'text-amber-600' : 'text-green-600') }}">
                {{ number_format((float)$result['coverage'], 1, ',', '.') }}%
            </div>
            <div class="mt-2 text-sm text-slate-600">Batas review manual: <strong>{{ number_format((float)$result['limit'], 1, ',', '.') }}%</strong></div>
            <div class="text-sm text-slate-600">Jumlah sumber cocok: <strong>{{ $result['source_count'] }}</strong></div>
            @if($result['exact'])
                <div class="mt-3 rounded-lg bg-red-50 text-red-700 px-3 py-2 text-sm font-semibold">Exact/near-identical copy terdeteksi.</div>
            @endif
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
            <h2 class="text-lg font-bold text-slate-900">Top 5 Sumber</h2>
            <p class="text-sm text-slate-500 mt-1">Coverage sumber dihitung terhadap bagian naskah yang sedang diperiksa. Angka utama di atas menggunakan unique coverage agar bagian yang sama tidak dihitung dua kali.</p>
        </div>
        <div class="divide-y divide-slate-200">
            @forelse($result['sources'] as $index => $source)
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                        <div>
                            <div class="text-xs text-slate-500">Sumber {{ $index + 1 }}</div>
                            <div class="font-bold text-slate-900 mt-1">{{ $source['title'] }}</div>
                            <div class="text-sm text-slate-600 mt-1">Penulis: {{ $source['author'] }}</div>
                            <div class="text-xs text-slate-500 mt-1">
                                Tersimpan: {{ optional($source['created_at'])->format('d M Y H:i') ?: '-' }} · Status: {{ strtoupper($source['status']) }}
                            </div>
                        </div>
                        <div class="md:text-right">
                            <div class="text-2xl font-black text-slate-900">{{ number_format((float)$source['coverage'], 1, ',', '.') }}%</div>
                            @if($source['exact'])<div class="text-xs font-bold text-red-600">IDENTIK</div>@endif
                            @if($source['status'] === 'approved')
                                <a href="{{ route('blog.show', $source['post']->slug) }}" target="_blank" rel="noopener" class="inline-flex mt-2 text-sm font-semibold text-blue-600 hover:text-blue-800">Bandingkan sumber →</a>
                            @else
                                <a href="{{ route('admin.posts.edit', $source['post']) }}" class="inline-flex mt-2 text-sm font-semibold text-blue-600 hover:text-blue-800">Bandingkan di CMS →</a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-slate-500">Tidak ditemukan sumber dengan overlap signifikan.</div>
            @endforelse
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-bold text-slate-900">Keputusan Review Manual</h2>
            <p class="text-sm text-slate-500 mt-1">Untuk coverage di atas batas, approve tetap terkunci sampai keputusan manual dibuat untuk hash naskah saat ini.</p>

            @if($review->decision)
                <div class="mt-4 rounded-lg bg-slate-50 border border-slate-200 px-4 py-3 text-sm">
                    <div><strong>Keputusan saat ini:</strong> {{ str_replace('_', ' ', strtoupper($review->decision)) }}</div>
                    <div class="mt-1 text-slate-600">{{ $review->decision_note }}</div>
                    <div class="mt-1 text-xs text-slate-400">{{ optional($review->reviewed_at)->format('d M Y H:i') }}</div>
                </div>
            @endif

            <form action="{{ route('admin.posts.originality.review', $post) }}" method="POST" class="mt-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Keputusan</label>
                    <select name="decision" class="w-full rounded-lg border border-slate-300 px-4 py-3" required>
                        <option value="">Pilih keputusan</option>
                        <option value="legitimate_overlap">Overlap sah karena kutipan / atribusi</option>
                        <option value="revision_required">Revisi diperlukan</option>
                        <option value="reject_substantial_copy">Tolak karena penyalinan substansial</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan keputusan</label>
                    <textarea name="decision_note" rows="4" class="w-full rounded-lg border border-slate-300 px-4 py-3" required placeholder="Tuliskan dasar keputusan admin, misalnya bagian yang merupakan kutipan sah, metode standar, atau penyalinan tanpa atribusi."></textarea>
                </div>
                <button type="submit" class="px-4 py-2.5 rounded-lg bg-orange-500 text-white text-sm font-bold hover:bg-orange-600">Simpan Keputusan</button>
            </form>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-bold text-slate-900">Status Approve</h2>
            @php
                $canApprove = !$result['blocked'] || $review->decision === 'legitimate_overlap';
                $decisionBlocks = in_array($review->decision, ['revision_required','reject_substantial_copy'], true);
                $canApprove = $canApprove && !$decisionBlocks;
            @endphp
            @if($canApprove)
                <div class="mt-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-green-700">✓ Naskah dapat masuk proses approve.</div>
                @if($post->status === 'pending')
                    <form action="{{ route('admin.posts.approve', $post) }}" method="POST" class="mt-4">@csrf
                        <button type="submit" onclick="return confirm('Setujui artikel ini?')" class="px-4 py-2.5 rounded-lg bg-green-600 text-white text-sm font-bold hover:bg-green-700">Approve Artikel</button>
                    </form>
                @endif
            @else
                <div class="mt-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-red-700">🔒 Approve terkunci. Selesaikan review manual atau minta penulis merevisi naskah.</div>
            @endif
            <div class="mt-5 text-xs text-slate-500 break-all"><strong>Hash naskah:</strong><br>{{ $result['manuscript_hash'] }}</div>
            <div class="mt-2 text-xs text-slate-500"><strong>Pertama dikirim:</strong> {{ $post->created_at?->format('d M Y H:i:s') }}</div>
            <div class="mt-1 text-xs text-slate-500"><strong>Terakhir diperbarui:</strong> {{ $post->updated_at?->format('d M Y H:i:s') }}</div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
            <h2 class="text-lg font-bold text-slate-900">Audit Trail</h2>
            <p class="text-sm text-slate-500 mt-1">Jejak submit, revisi, keputusan originality, approve, dan reject.</p>
        </div>
        <div class="divide-y divide-slate-200">
            @forelse($auditEvents as $event)
                <div class="px-6 py-4">
                    <div class="flex flex-col md:flex-row md:justify-between gap-2">
                        <div>
                            <div class="font-semibold text-slate-900">{{ str_replace('_', ' ', strtoupper($event->event)) }}</div>
                            <div class="text-xs text-slate-500 mt-1">Actor: {{ $event->actor?->name ?: 'System/User tidak tersedia' }}</div>
                            @if($event->metadata)
                                <div class="text-xs text-slate-500 mt-1">{{ json_encode($event->metadata, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</div>
                            @endif
                        </div>
                        <div class="text-xs text-slate-400 md:text-right">{{ $event->created_at?->format('d M Y H:i:s') }}</div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-5 text-slate-500">Belum ada event audit.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
