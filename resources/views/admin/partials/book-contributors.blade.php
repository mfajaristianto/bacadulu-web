@php
    $contributorBook = $book ?? null;

    $initialAuthors = old('authors');
    if (!is_array($initialAuthors)) {
        $initialAuthors = $contributorBook?->authors() ?? [''];
    }
    $initialAuthors = array_values(array_filter($initialAuthors, fn ($name) => trim((string) $name) !== ''));
    if ($initialAuthors === []) $initialAuthors = [''];

    $initialEditors = old('editors');
    if (!is_array($initialEditors)) {
        $initialEditors = $contributorBook?->editors() ?? [];
    }
    $initialEditors = array_values(array_filter($initialEditors, fn ($name) => trim((string) $name) !== ''));

    $authorMode = old('author_display_mode', $contributorBook?->authorDisplayMode() ?? 'inline');
    $editorMode = old('editor_display_mode', $contributorBook?->editorDisplayMode() ?? 'inline');
    $primaryAuthor = old('primary_author', $contributorBook?->primaryAuthorName());
    $primaryEditor = old('primary_editor', $contributorBook?->primaryEditorName());
@endphp

<div class="md:col-span-2 rounded-2xl border border-slate-200 bg-slate-50 p-4 md:p-5" data-dynamic-contributors>
    <div class="space-y-7">
        <div data-contributor-group="authors">
            <div class="mb-3 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <label class="block text-sm font-bold text-slate-800">Penulis</label>
                    <p class="mt-1 text-xs text-slate-500">Data dari BacaPublisher otomatis dipecah per nama. Tambah, hapus, atau ubah urutannya di sini.</p>
                </div>
                <button type="button" data-add-row class="rounded-lg border border-orange-200 bg-white px-3 py-2 text-xs font-semibold text-orange-700 transition hover:bg-orange-50">+ Tambah Penulis</button>
            </div>

            <div data-row-list class="space-y-2">
                @foreach($initialAuthors as $index => $name)
                    <div data-contributor-row class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white p-2">
                        <span data-order-number class="w-7 shrink-0 text-center text-xs font-bold text-slate-400">{{ $index + 1 }}</span>
                        <input type="text" name="authors[]" value="{{ $name }}" placeholder="Nama penulis" class="min-w-0 flex-1 rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100">
                        <label data-primary-wrap class="{{ $authorMode === 'primary' ? 'flex' : 'hidden' }} shrink-0 items-center gap-1 text-[11px] font-semibold text-slate-600" title="Jadikan penulis utama">
                            <input type="radio" name="primary_author" value="{{ $name }}" {{ $primaryAuthor === $name ? 'checked' : '' }} class="h-4 w-4 border-slate-300 text-orange-600 focus:ring-orange-500">
                            Utama
                        </label>
                        <button type="button" data-move-up class="rounded-lg px-2 py-1.5 text-slate-500 hover:bg-slate-100" title="Naikkan urutan">↑</button>
                        <button type="button" data-move-down class="rounded-lg px-2 py-1.5 text-slate-500 hover:bg-slate-100" title="Turunkan urutan">↓</button>
                        <button type="button" data-remove-row class="rounded-lg px-2 py-1.5 text-red-500 hover:bg-red-50" title="Hapus">×</button>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <div class="mb-2 text-xs font-bold uppercase tracking-wide text-slate-500">Cara tampil penulis</div>
                <div class="grid gap-2 sm:grid-cols-3">
                    @foreach([
                        'inline' => ['label' => 'Satu baris', 'example' => 'Erik, Sawal, Rina'],
                        'stacked' => ['label' => 'Bertingkat', 'example' => "Erik\nSawal\nRina"],
                        'primary' => ['label' => 'Utama + lainnya', 'example' => "Erik (Utama)\nSawal, Rina"],
                    ] as $value => $option)
                        <label class="cursor-pointer rounded-xl border border-slate-200 bg-white p-3 text-sm transition hover:border-orange-300">
                            <span class="flex items-center gap-2 font-semibold text-slate-700">
                                <input type="radio" name="author_display_mode" value="{{ $value }}" {{ $authorMode === $value ? 'checked' : '' }} data-mode-radio class="h-4 w-4 border-slate-300 text-orange-600 focus:ring-orange-500">
                                {{ $option['label'] }}
                            </span>
                            <span class="mt-2 block whitespace-pre-line rounded-lg bg-slate-50 px-2.5 py-2 text-[11px] leading-5 text-slate-500">{{ $option['example'] }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="mt-3 rounded-xl border border-orange-200 bg-orange-50/60 p-3" data-live-preview>
                    <div class="mb-1 text-[10px] font-bold uppercase tracking-[0.14em] text-orange-700">Contoh hasil di halaman buku</div>
                    <div class="text-sm text-slate-700" data-preview-output></div>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-200 pt-6" data-contributor-group="editors">
            <div class="mb-3 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <label class="block text-sm font-bold text-slate-800">Editor <span class="font-normal text-slate-400">(opsional)</span></label>
                    <p class="mt-1 text-xs text-slate-500">Tidak dibatasi 3 orang. Tambahkan sebanyak yang diperlukan.</p>
                </div>
                <button type="button" data-add-row class="rounded-lg border border-indigo-200 bg-white px-3 py-2 text-xs font-semibold text-indigo-700 transition hover:bg-indigo-50">+ Tambah Editor</button>
            </div>

            <div data-row-list class="space-y-2">
                @foreach($initialEditors as $index => $name)
                    <div data-contributor-row class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white p-2">
                        <span data-order-number class="w-7 shrink-0 text-center text-xs font-bold text-slate-400">{{ $index + 1 }}</span>
                        <input type="text" name="editors[]" value="{{ $name }}" placeholder="Nama editor" class="min-w-0 flex-1 rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                        <label data-primary-wrap class="{{ $editorMode === 'primary' ? 'flex' : 'hidden' }} shrink-0 items-center gap-1 text-[11px] font-semibold text-slate-600" title="Jadikan editor utama">
                            <input type="radio" name="primary_editor" value="{{ $name }}" {{ $primaryEditor === $name ? 'checked' : '' }} class="h-4 w-4 border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            Utama
                        </label>
                        <button type="button" data-move-up class="rounded-lg px-2 py-1.5 text-slate-500 hover:bg-slate-100" title="Naikkan urutan">↑</button>
                        <button type="button" data-move-down class="rounded-lg px-2 py-1.5 text-slate-500 hover:bg-slate-100" title="Turunkan urutan">↓</button>
                        <button type="button" data-remove-row class="rounded-lg px-2 py-1.5 text-red-500 hover:bg-red-50" title="Hapus">×</button>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <div class="mb-2 text-xs font-bold uppercase tracking-wide text-slate-500">Cara tampil editor</div>
                <div class="grid gap-2 sm:grid-cols-3">
                    @foreach([
                        'inline' => ['label' => 'Satu baris', 'example' => 'Editor A, Editor B, Editor C'],
                        'stacked' => ['label' => 'Bertingkat', 'example' => "Editor A\nEditor B\nEditor C"],
                        'primary' => ['label' => 'Utama + lainnya', 'example' => "Editor A (Utama)\nEditor B, Editor C"],
                    ] as $value => $option)
                        <label class="cursor-pointer rounded-xl border border-slate-200 bg-white p-3 text-sm transition hover:border-indigo-300">
                            <span class="flex items-center gap-2 font-semibold text-slate-700">
                                <input type="radio" name="editor_display_mode" value="{{ $value }}" {{ $editorMode === $value ? 'checked' : '' }} data-mode-radio class="h-4 w-4 border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                {{ $option['label'] }}
                            </span>
                            <span class="mt-2 block whitespace-pre-line rounded-lg bg-slate-50 px-2.5 py-2 text-[11px] leading-5 text-slate-500">{{ $option['example'] }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="mt-3 rounded-xl border border-indigo-200 bg-indigo-50/60 p-3" data-live-preview>
                    <div class="mb-1 text-[10px] font-bold uppercase tracking-[0.14em] text-indigo-700">Contoh hasil di halaman buku</div>
                    <div class="text-sm text-slate-700" data-preview-output></div>
                </div>
            </div>
        </div>
    </div>

    <template data-row-template>
        <div data-contributor-row class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white p-2">
            <span data-order-number class="w-7 shrink-0 text-center text-xs font-bold text-slate-400"></span>
            <input type="text" value="" class="min-w-0 flex-1 rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2">
            <label data-primary-wrap class="hidden shrink-0 items-center gap-1 text-[11px] font-semibold text-slate-600">
                <input type="radio" class="h-4 w-4 border-slate-300 focus:ring-orange-500">
                Utama
            </label>
            <button type="button" data-move-up class="rounded-lg px-2 py-1.5 text-slate-500 hover:bg-slate-100" title="Naikkan urutan">↑</button>
            <button type="button" data-move-down class="rounded-lg px-2 py-1.5 text-slate-500 hover:bg-slate-100" title="Turunkan urutan">↓</button>
            <button type="button" data-remove-row class="rounded-lg px-2 py-1.5 text-red-500 hover:bg-red-50" title="Hapus">×</button>
        </div>
    </template>
</div>

@once
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-dynamic-contributors]').forEach(function (box) {
        const template = box.querySelector('[data-row-template]');

        box.querySelectorAll('[data-contributor-group]').forEach(function (group) {
            const type = group.dataset.contributorGroup;
            const list = group.querySelector('[data-row-list]');
            const add = group.querySelector('[data-add-row]');
            const modeName = type === 'authors' ? 'author_display_mode' : 'editor_display_mode';
            const inputName = type === 'authors' ? 'authors[]' : 'editors[]';
            const primaryName = type === 'authors' ? 'primary_author' : 'primary_editor';

            const mode = () => group.querySelector(`input[name="${modeName}"]:checked`)?.value || 'inline';

            const renderPreview = () => {
                const output = group.querySelector('[data-preview-output]');
                if (!output) return;

                const rows = [...list.querySelectorAll('[data-contributor-row]')];
                const names = rows
                    .map(row => row.querySelector('input[type="text"]')?.value.trim())
                    .filter(Boolean);

                const fallback = type === 'authors'
                    ? ['Juneman Abraham', 'Yananto Mihadi Putra', 'Lucky Nugroho']
                    : ['Editor A', 'Editor B', 'Editor C'];
                const previewNames = names.length ? names : fallback;

                output.replaceChildren();

                if (mode() === 'stacked') {
                    previewNames.forEach(name => {
                        const line = document.createElement('div');
                        line.textContent = name;
                        line.className = 'leading-6';
                        output.appendChild(line);
                    });
                    return;
                }

                if (mode() === 'primary') {
                    const selected = rows.find(row => row.querySelector('input[type="radio"]')?.checked);
                    let primary = selected?.querySelector('input[type="text"]')?.value.trim();
                    if (!primary || !previewNames.includes(primary)) primary = previewNames[0];

                    const roleLabel = type === 'authors' ? 'Penulis' : 'Editor';

                    const mainLabel = document.createElement('div');
                    mainLabel.className = 'text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400';
                    mainLabel.textContent = roleLabel + ' Utama';
                    output.appendChild(mainLabel);

                    const main = document.createElement('div');
                    main.className = 'font-semibold text-slate-800';
                    main.textContent = primary;
                    output.appendChild(main);

                    const others = previewNames.filter(name => name !== primary);
                    if (others.length) {
                        const secondaryLabel = document.createElement('div');
                        secondaryLabel.className = 'mt-2 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400';
                        secondaryLabel.textContent = roleLabel + ' Lainnya';
                        output.appendChild(secondaryLabel);

                        const secondary = document.createElement('div');
                        secondary.className = 'text-xs text-slate-500';
                        secondary.textContent = others.join(', ');
                        output.appendChild(secondary);
                    }
                    return;
                }

                output.textContent = previewNames.join(', ');
            };

            const sync = () => {
                [...list.querySelectorAll('[data-contributor-row]')].forEach((row, index) => {
                    row.querySelector('[data-order-number]').textContent = index + 1;
                    const text = row.querySelector('input[type="text"]');
                    const radio = row.querySelector('input[type="radio"]');
                    const primaryWrap = row.querySelector('[data-primary-wrap]');
                    text.name = inputName;
                    radio.name = primaryName;
                    radio.value = text.value.trim();
                    primaryWrap.classList.toggle('hidden', mode() !== 'primary');
                    primaryWrap.classList.toggle('flex', mode() === 'primary');
                });
                renderPreview();
            };

            const bindRow = (row) => {
                const text = row.querySelector('input[type="text"]');
                const radio = row.querySelector('input[type="radio"]');
                text.addEventListener('input', () => {
                    radio.value = text.value.trim();
                    renderPreview();
                });
                radio.addEventListener('change', renderPreview);
                row.querySelector('[data-move-up]').addEventListener('click', () => {
                    const prev = row.previousElementSibling;
                    if (prev) list.insertBefore(row, prev);
                    sync();
                });
                row.querySelector('[data-move-down]').addEventListener('click', () => {
                    const next = row.nextElementSibling;
                    if (next) list.insertBefore(next, row);
                    sync();
                });
                row.querySelector('[data-remove-row]').addEventListener('click', () => {
                    if (type === 'authors' && list.querySelectorAll('[data-contributor-row]').length === 1) {
                        text.value = '';
                        radio.checked = false;
                    } else {
                        row.remove();
                    }
                    sync();
                });
            };

            list.querySelectorAll('[data-contributor-row]').forEach(bindRow);
            group.querySelectorAll('[data-mode-radio]').forEach(r => r.addEventListener('change', sync));

            add.addEventListener('click', () => {
                const row = template.content.firstElementChild.cloneNode(true);
                list.appendChild(row);
                bindRow(row);
                sync();
                row.querySelector('input[type="text"]').focus();
            });

            sync();
        });
    });
});
</script>
@endonce
