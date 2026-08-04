@php
    $editorId = $id ?? 'editor-' . uniqid();
@endphp

<div class="space-y-2">
    <label class="block text-sm font-medium mb-1">{{ $label ?? 'Konten' }}</label>

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
        <div class="flex flex-wrap gap-2 border-b bg-slate-50 p-2">
            <button type="button" class="rounded border bg-white px-2 py-1 text-sm font-semibold" data-command="bold"><strong>B</strong></button>
            <button type="button" class="rounded border bg-white px-2 py-1 text-sm italic" data-command="italic">I</button>
            <button type="button" class="rounded border bg-white px-2 py-1 text-sm underline" data-command="underline">U</button>
            <button type="button" class="rounded border bg-white px-2 py-1 text-sm" data-command="insertUnorderedList">• List</button>
            <button type="button" class="rounded border bg-white px-2 py-1 text-sm" data-command="createLink">Link</button>
        </div>

        <div
            id="{{ $editorId }}"
            contenteditable="true"
            class="min-h-[140px] p-3 text-sm leading-6 focus:outline-none"
            data-editor-target="{{ $name }}"
        >{!! $value ?? '' !!}</div>

        <textarea name="{{ $name }}" id="{{ $editorId }}-input" class="hidden">{{ $value ?? '' }}</textarea>
    </div>

    <p class="text-xs text-slate-500">Gunakan tombol format untuk bold, italic, list, dan link.</p>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-editor-target]').forEach(function (editor) {
            const name = editor.getAttribute('data-editor-target');
            const hiddenInput = document.getElementById(editor.id + '-input');

            if (!hiddenInput) {
                return;
            }

            editor.innerHTML = hiddenInput.value || '';

            const syncValue = function () {
                hiddenInput.value = editor.innerHTML;
            };

            editor.addEventListener('input', syncValue);
            editor.addEventListener('blur', syncValue);

            editor.closest('.space-y-2').querySelectorAll('[data-command]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const command = this.getAttribute('data-command');

                    if (command === 'createLink') {
                        const url = prompt('Masukkan URL');
                        if (url) {
                            document.execCommand('createLink', false, url);
                        }
                    } else {
                        document.execCommand(command);
                    }

                    syncValue();
                    editor.focus();
                });
            });
        });
    });
</script>
