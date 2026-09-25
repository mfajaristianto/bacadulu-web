@extends('layouts.admin')

@section('content')

<div class="mx-auto max-w-7xl">

    <div class="mb-7 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2">
                <span class="h-[3px] w-7 rounded-full bg-orange-500"></span>
                <span class="text-[10px] font-extrabold uppercase tracking-[.16em] text-orange-600">
                    Moderasi Pengguna
                </span>
            </div>

            <h1 class="text-2xl font-extrabold text-slate-900 sm:text-3xl">
                Verifikasi Penulis
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-500">
                Periksa identitas publik, afiliasi, tautan akademik, dan bukti kepenulisan
                sebelum memberikan badge Penulis Terverifikasi.
            </p>
        </div>

        <div class="rounded-2xl border border-orange-100 bg-white px-5 py-3 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-[.12em] text-slate-400">
                Menunggu Review
            </p>
            <p class="mt-1 text-2xl font-extrabold text-orange-600">
                {{ $counts['pending'] }}
            </p>
        </div>
    </div>

    @if(session('admin_verification_success'))
        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
            {{ session('admin_verification_success') }}
        </div>
    @endif

    @if(session('admin_verification_error'))
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
            {{ session('admin_verification_error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
            <ul class="list-disc space-y-1 pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-6 grid grid-cols-2 gap-3 lg:grid-cols-4">
        @php
            $tabs = [
                'pending' => ['Pending', 'text-orange-600', 'border-orange-300 bg-orange-50'],
                'approved' => ['Disetujui', 'text-emerald-600', 'border-emerald-300 bg-emerald-50'],
                'rejected' => ['Ditolak', 'text-red-600', 'border-red-300 bg-red-50'],
                'all' => ['Semua', 'text-slate-800', 'border-slate-400 bg-slate-100'],
            ];
        @endphp

        @foreach($tabs as $tabKey => [$tabLabel, $numberClass, $activeClass])
            <a
                href="{{ route('admin.author-verifications.index', ['status' => $tabKey]) }}"
                class="rounded-2xl border p-4 transition
                       {{ $status === $tabKey
                            ? $activeClass . ' shadow-sm'
                            : 'border-slate-200 bg-white hover:border-orange-200'
                       }}"
            >
                <p class="text-xs font-bold text-slate-500">{{ $tabLabel }}</p>
                <p class="mt-2 text-2xl font-extrabold {{ $numberClass }}">
                    {{ $counts[$tabKey] }}
                </p>
            </a>
        @endforeach
    </div>

    <div class="space-y-5">
        @forelse($verifications as $verification)

            @php
                $user = $verification->user;

                $statusText = match($verification->status) {
                    'approved' => 'Terverifikasi',
                    'rejected' => 'Ditolak',
                    default => 'Menunggu Review',
                };

                $statusClass = match($verification->status) {
                    'approved' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                    'rejected' => 'border-red-200 bg-red-50 text-red-700',
                    default => 'border-amber-200 bg-amber-50 text-amber-700',
                };
            @endphp

            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="flex flex-col gap-4 border-b border-slate-100 p-5 lg:flex-row lg:items-center lg:justify-between">

                    <div class="flex min-w-0 items-center gap-4">
                        @if($user)
                            <x-user-avatar :user="$user" :size="52" />
                        @else
                            <div class="grid h-[52px] w-[52px] place-items-center rounded-full bg-slate-100 font-bold text-slate-400">
                                U
                            </div>
                        @endif

                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="truncate font-extrabold text-slate-900">
                                    {{ $user?->name ?? 'User tidak tersedia' }}
                                </h2>

                                <span class="inline-flex rounded-full border px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wide {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </div>

                            <p class="mt-1 truncate text-sm text-slate-500">
                                {{ $user?->email ?? '-' }}
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                Dikirim {{ $verification->created_at?->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @if($user)
                            <a
                                href="{{ route('profile.public', $user) }}"
                                target="_blank"
                                rel="noopener"
                                class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 transition hover:border-orange-200 hover:text-orange-600"
                            >
                                Profil Publik
                            </a>
                        @endif

                        @if($verification->evidence_path)
                            <a
                                href="{{ route('admin.author-verifications.evidence', $verification) }}"
                                target="_blank"
                                rel="noopener"
                                class="inline-flex items-center justify-center rounded-xl bg-[#241B52] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#31256e]"
                            >
                                Lihat Bukti Private
                            </a>
                        @endif
                    </div>
                </div>

                <div class="grid gap-4 p-5 md:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            Institusi / Afiliasi
                        </p>
                        <p class="mt-2 text-sm font-bold text-slate-800">
                            {{ $verification->institution ?: '-' }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            ORCID
                        </p>
                        @if($verification->orcid_url)
                            <a
                                href="{{ $verification->orcid_url }}"
                                target="_blank"
                                rel="noopener"
                                class="mt-2 block break-all text-sm font-semibold text-orange-600 hover:underline"
                            >
                                {{ $verification->orcid_url }}
                            </a>
                        @else
                            <p class="mt-2 text-sm text-slate-400">-</p>
                        @endif
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            Google Scholar
                        </p>
                        @if($verification->google_scholar_url)
                            <a
                                href="{{ $verification->google_scholar_url }}"
                                target="_blank"
                                rel="noopener"
                                class="mt-2 inline-block text-sm font-semibold text-orange-600 hover:underline"
                            >
                                Buka Profil
                            </a>
                        @else
                            <p class="mt-2 text-sm text-slate-400">-</p>
                        @endif
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            Publikasi / DOI
                        </p>
                        @if($verification->publication_url)
                            <a
                                href="{{ $verification->publication_url }}"
                                target="_blank"
                                rel="noopener"
                                class="mt-2 inline-block text-sm font-semibold text-orange-600 hover:underline"
                            >
                                Lihat Publikasi
                            </a>
                        @else
                            <p class="mt-2 text-sm text-slate-400">-</p>
                        @endif
                    </div>
                </div>

                @if($verification->evidence_original_name)
                    <div class="mx-5 mb-5 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs text-slate-500">
                            <span class="font-bold text-slate-700">File bukti:</span>
                            {{ $verification->evidence_original_name }}
                        </p>
                    </div>
                @endif

                @if($verification->status === 'pending')
                    <div class="grid gap-5 border-t border-slate-100 bg-slate-50/70 p-5 lg:grid-cols-2">

                        <form
                            action="{{ route('admin.author-verifications.approve', $verification) }}"
                            method="POST"
                            class="rounded-xl border border-emerald-200 bg-white p-4"
                        >
                            @csrf
                            @method('PATCH')

                            <h3 class="text-sm font-extrabold text-emerald-700">
                                Setujui Penulis
                            </h3>

                            <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                Pastikan nama, afiliasi, tautan publik, dan bukti kepenulisan sesuai.
                            </p>

                            <textarea
                                name="admin_note"
                                rows="3"
                                maxlength="1500"
                                placeholder="Catatan admin (opsional)"
                                class="mt-4 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-50"
                            ></textarea>

                            <button
                                type="submit"
                                onclick="return confirm('Setujui pengguna ini sebagai Penulis Terverifikasi?')"
                                class="mt-3 w-full rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-emerald-700"
                            >
                                ✓ Approve Penulis
                            </button>
                        </form>

                        <form
                            action="{{ route('admin.author-verifications.reject', $verification) }}"
                            method="POST"
                            class="rounded-xl border border-red-200 bg-white p-4"
                        >
                            @csrf
                            @method('PATCH')

                            <h3 class="text-sm font-extrabold text-red-700">
                                Tolak Pengajuan
                            </h3>

                            <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                Alasan penolakan akan terlihat oleh pengguna agar bisa diperbaiki.
                            </p>

                            <textarea
                                name="admin_note"
                                rows="3"
                                maxlength="1500"
                                required
                                placeholder="Contoh: nama pada bukti tidak sesuai..."
                                class="mt-4 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-red-400 focus:ring-4 focus:ring-red-50"
                            ></textarea>

                            <button
                                type="submit"
                                onclick="return confirm('Tolak pengajuan verifikasi ini?')"
                                class="mt-3 w-full rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-red-700"
                            >
                                Tolak Pengajuan
                            </button>
                        </form>

                    </div>
                @else
                    <div class="border-t border-slate-100 bg-slate-50 p-5 text-sm text-slate-500">
                        @if($verification->reviewer)
                            <p>
                                <span class="font-bold text-slate-700">Diproses oleh:</span>
                                {{ $verification->reviewer->name }}
                            </p>
                        @endif

                        @if($verification->reviewed_at)
                            <p class="mt-1">
                                <span class="font-bold text-slate-700">Tanggal review:</span>
                                {{ $verification->reviewed_at->format('d M Y H:i') }}
                            </p>
                        @endif

                        @if($verification->admin_note)
                            <div class="mt-3 rounded-xl border border-slate-200 bg-white p-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Catatan Admin
                                </p>
                                <p class="mt-2 whitespace-pre-line leading-relaxed text-slate-700">
                                    {{ $verification->admin_note }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

            </section>

        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center">
                <div class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-slate-100 text-2xl">
                    ✓
                </div>

                <h2 class="mt-4 font-extrabold text-slate-800">
                    Tidak ada pengajuan
                </h2>

                <p class="mt-2 text-sm text-slate-500">
                    Belum ada data untuk status ini.
                </p>
            </div>
        @endforelse
    </div>

    @if($verifications->hasPages())
        <div class="mt-7">
            {{ $verifications->links() }}
        </div>
    @endif

</div>

@endsection
