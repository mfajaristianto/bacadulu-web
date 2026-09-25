@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">
                Kelola Artikel
            </h1>

            <p class="text-slate-600">
                Kelola, setujui, tolak, edit, atau hapus artikel yang dikirim oleh user atau penulis.
            </p>

            <p class="text-xs text-slate-500 mt-2">
                Batas maksimal similarity internal BacaDulu:
                <strong>{{ number_format((float) config('bacadulu.originality.max_similarity', 20), 1, ',', '.') }}%</strong>.
                Pemeriksaan ini membandingkan dengan naskah di database BacaDulu dan bukan pengganti Turnitin/iThenticate.
            </p>
        </div>
    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="rounded-lg bg-green-100 text-green-700 px-4 py-3 mb-6">
            {{ session('success') }}
        </div>
    @endif


    {{-- Error Message --}}
    @if(session('error'))
        <div class="rounded-lg bg-red-100 text-red-700 px-4 py-3 mb-6">
            {{ session('error') }}
        </div>
    @endif


    {{-- Tab Filter Status --}}
    <div class="flex gap-2 mb-6 flex-wrap">

        @foreach([
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'all' => 'Semua'
        ] as $key => $label)

            <a
                href="{{ route('admin.posts.index', ['status' => $key]) }}"
                class="px-4 py-2 rounded-lg text-sm font-semibold
                {{ $status == $key
                    ? 'bg-orange-500 text-white'
                    : 'bg-slate-100 text-slate-600 hover:bg-slate-200'
                }}"
            >
                {{ $label }}
            </a>

        @endforeach

    </div>


    {{-- Table --}}
    <div class="rounded-xl border bg-white shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                {{-- Header Table --}}
                <thead class="bg-slate-50 text-slate-600 border-b">

                    <tr>

                        <th class="px-4 py-3">
                            Judul Artikel
                        </th>

                        <th class="px-4 py-3">
                            Penulis
                        </th>

                        <th class="px-4 py-3">
                            Kategori
                        </th>

                        <th class="px-4 py-3">
                            Similarity Internal
                        </th>

                        <th class="px-4 py-3">
                            Status
                        </th>

                        <th class="px-4 py-3">
                            Tanggal
                        </th>

                        <th class="px-4 py-3">
                            Aksi
                        </th>

                    </tr>

                </thead>


                {{-- Body Table --}}
                <tbody>

                    @forelse($posts as $post)

                        <tr class="border-t hover:bg-slate-50">


                            {{-- Judul Artikel --}}
                            <td class="px-4 py-3">

                                <div class="font-medium text-slate-900">
                                    {{ $post->title }}
                                </div>

                                <div class="text-xs text-slate-400 mt-1">
                                    ID Artikel: #{{ $post->id }}
                                </div>

                            </td>


                            {{-- Penulis --}}
                            <td class="px-4 py-3">

                                <div class="text-slate-700 font-medium">
                                    {{ $post->author ?: '-' }}
                                </div>

                                @if($post->user?->isVerifiedAuthor())
                                    <div class="mt-1 inline-flex text-[11px] font-bold bg-blue-100 text-blue-700 rounded-full px-2 py-0.5">✓ Penulis Terverifikasi</div>
                                    <div class="text-[10px] text-slate-400 mt-1">Tidak memengaruhi originality check</div>
                                @endif

                                @if($post->user_id)

                                    <div class="text-xs text-slate-400 mt-1">
                                        User ID: {{ $post->user_id }}
                                    </div>

                                @endif

                            </td>


                            {{-- Kategori --}}
                            <td class="px-4 py-3">

                                <span
                                    class="text-xs font-semibold
                                           bg-blue-100
                                           text-blue-700
                                           px-2 py-1
                                           rounded-full"
                                >
                                    {{ $post->category }}
                                </span>

                            </td>



                            {{-- Similarity Internal --}}
                            <td class="px-4 py-3 min-w-[260px]">
                                @php
                                    $originality = $post->getAttribute('originality_result') ?? [];
                                    $review = $post->getAttribute('originality_review');
                                    $similarityScore = (float) ($originality['coverage'] ?? $originality['score'] ?? 0);
                                    $similarityLimit = (float) ($originality['limit'] ?? config('bacadulu.originality.max_similarity', 20));
                                    $similarityStatus = $originality['status'] ?? 'safe';
                                    $sourceCount = (int) ($originality['source_count'] ?? 0);
                                    $topSources = $originality['sources'] ?? [];
                                @endphp

                                <div class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-bold
                                    {{ $similarityStatus === 'high' ? 'bg-red-100 text-red-700' : ($similarityStatus === 'warning' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700') }}">
                                    {{ $similarityStatus === 'high' ? '⚠' : '✓' }} {{ number_format($similarityScore, 1, ',', '.') }}%
                                </div>

                                <div class="mt-1 text-xs {{ $similarityStatus === 'high' ? 'text-red-600 font-semibold' : 'text-slate-500' }}">
                                    Multi-source coverage · {{ $sourceCount }} sumber cocok
                                </div>

                                @if($topSources)
                                    <div class="mt-2 space-y-1">
                                        @foreach(array_slice($topSources, 0, 3) as $source)
                                            <div class="text-xs text-slate-600">
                                                <strong>{{ number_format((float)$source['coverage'], 1, ',', '.') }}%</strong>
                                                · {{ \Illuminate\Support\Str::limit($source['title'], 40) }}
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="mt-2 text-xs text-slate-400">Tidak ada overlap signifikan.</div>
                                @endif

                                @if($review?->decision)
                                    <div class="mt-2 text-xs font-semibold text-blue-700">
                                        Review: {{ str_replace('_', ' ', strtoupper($review->decision)) }}
                                    </div>
                                @endif

                                <a href="{{ route('admin.posts.originality', $post) }}" class="mt-2 inline-flex text-xs font-bold text-blue-600 hover:text-blue-800">
                                    Buka Originality Review →
                                </a>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-3">

                                @if($post->status == 'pending')

                                    <span
                                        class="text-xs font-semibold
                                               bg-yellow-100
                                               text-yellow-700
                                               px-2 py-1
                                               rounded-full"
                                    >
                                        Menunggu
                                    </span>


                                @elseif($post->status == 'approved')

                                    <span
                                        class="text-xs font-semibold
                                               bg-green-100
                                               text-green-700
                                               px-2 py-1
                                               rounded-full"
                                    >
                                        Disetujui
                                    </span>


                                @else

                                    <span
                                        class="text-xs font-semibold
                                               bg-red-100
                                               text-red-700
                                               px-2 py-1
                                               rounded-full"
                                    >
                                        Ditolak
                                    </span>

                                @endif

                            </td>


                            {{-- Tanggal --}}
                            <td class="px-4 py-3 text-slate-600">

                                {{ $post->created_at->format('d M Y') }}

                                <div class="text-xs text-slate-400 mt-1">
                                    {{ $post->created_at->format('H:i') }}
                                </div>

                            </td>


                            {{-- Aksi --}}
                            <td class="px-4 py-3">

                                <div class="flex gap-2 flex-wrap">


                                    {{-- Lihat Artikel --}}
                                    <a
                                        href="{{ route('blog.show', $post->slug) }}"
                                        target="_blank"
                                        class="px-3 py-1
                                               text-xs
                                               font-semibold
                                               bg-slate-100
                                               text-slate-700
                                               rounded
                                               hover:bg-slate-200
                                               transition"
                                    >
                                        Lihat
                                    </a>


                                    {{-- Approve --}}
                                    @if($post->status == 'pending')
                                        @php
                                            $rowOriginality = $post->getAttribute('originality_result') ?? [];
                                            $rowReview = $post->getAttribute('originality_review');
                                            $rowBlocked = (bool) ($rowOriginality['blocked'] ?? false);
                                            $manualAllows = $rowReview?->decision === 'legitimate_overlap';
                                            $manualBlocks = in_array($rowReview?->decision, ['revision_required', 'reject_substantial_copy'], true);
                                            $rowCanApprove = (!$rowBlocked || $manualAllows) && !$manualBlocks;
                                        @endphp

                                        @if($rowCanApprove)
                                            <form action="{{ route('admin.posts.approve', $post) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Setujui artikel ini?')" class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded hover:bg-green-200 transition">Setujui</button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.posts.originality', $post) }}" title="Originality Review wajib diselesaikan" class="px-3 py-1 text-xs font-semibold bg-slate-100 text-slate-500 rounded hover:bg-slate-200 transition">🔒 Review dulu</a>
                                        @endif
                                    @endif

                                    {{-- Reject --}}
                                    @if($post->status == 'pending')

                                        <form
                                            action="{{ route('admin.posts.reject', $post) }}"
                                            method="POST"
                                            class="inline"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                onclick="return confirm('Tolak artikel ini?');"
                                                class="px-3 py-1
                                                       text-xs
                                                       font-semibold
                                                       bg-red-100
                                                       text-red-700
                                                       rounded
                                                       hover:bg-red-200
                                                       transition"
                                            >
                                                {{ ($post->getAttribute('originality_result')['blocked'] ?? false)
                                                    ? 'Tolak karena Similarity'
                                                    : 'Tolak'
                                                }}
                                            </button>

                                        </form>

                                    @endif


                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('admin.posts.edit', $post) }}"
                                        class="px-3 py-1
                                               text-xs
                                               font-semibold
                                               bg-blue-100
                                               text-blue-700
                                               rounded
                                               hover:bg-blue-200
                                               transition"
                                    >
                                        Edit
                                    </a>


                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('admin.posts.destroy', $post) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus artikel ini? Artikel yang sudah dihapus tidak dapat dikembalikan.');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-3 py-1
                                                   text-xs
                                                   font-semibold
                                                   bg-red-100
                                                   text-red-700
                                                   rounded
                                                   hover:bg-red-200
                                                   transition"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-4 py-6 text-center text-slate-500"
                            >

                                Tidak ada artikel
                                {{ $status == 'all'
                                    ? ''
                                    : 'dengan status ' . $status
                                }}

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- Pagination --}}
    <div class="mt-6">

        {{ $posts->withQueryString()->links() }}

    </div>

</div>
@endsection