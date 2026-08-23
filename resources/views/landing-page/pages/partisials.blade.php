<article class="book-card">

    {{-- COVER --}}
    <div class="cover-area">
        <div class="book-3d">

            <div
                class="book-face book-spine"
                style="background:linear-gradient(135deg,#EF5843,#F7AA35);"
            ></div>

            <div class="book-face book-pages"></div>

            @if($book->cover)

                <div
                    class="book-face book-front"
                    style="background-image:url('{{ asset('storage/'.$book->cover) }}');"
                ></div>

            @else

                <div
                    class="book-face book-front"
                    style="background:linear-gradient(135deg,#EF5843,#F7AA35);"
                >
                    <div>
                        <div class="cover-title">
                            {{ \Illuminate\Support\Str::limit($book->title,45) }}
                        </div>

                        <div class="cover-author">
                            {{ $book->author }}
                        </div>
                    </div>
                </div>

            @endif

        </div>
    </div>

    {{-- INFO --}}
    <div class="book-info">

        <div class="book-publisher">
            {{ $book->publisher ?: 'Baca Dulu' }}
        </div>

        <div class="book-title">
            {{ $book->title }}
        </div>

        <div class="book-author">
            {{ $book->author }}
        </div>

        {{-- FORMAT --}}
        <div class="book-format-list">

            {{-- BUKU CETAK --}}
            @if($book->has_print && $book->print_price !== null)

                <div class="format-box print-format">

                    <div class="format-content">

                        <span class="format-label print-label">
                            <svg class="format-icon" viewBox="0 0 24 24">
                                <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                            </svg>
                            Buku Cetak
                        </span>

                        @if($book->has_active_print_discount)

                            <div class="format-old-price">
                                Rp {{ number_format((float)$book->print_price,0,',','.') }}
                            </div>

                        @else

                            <div
                                class="format-old-price"
                                style="text-decoration:none"
                            >
                                &nbsp;
                            </div>

                        @endif

                        <div class="format-price">
                            Rp {{ number_format((float)$book->effective_print_price,0,',','.') }}
                        </div>

                        @if($book->has_active_print_discount)

                            <span class="format-discount">
                                -{{ number_format((float)$book->print_discount_percent,0) }}%
                            </span>

                        @else

                            <span class="format-discount-placeholder">
                                &nbsp;
                            </span>

                        @endif

                    </div>

                    <button
                        type="button"
                        class="format-add print-add"
                        data-cart-add="1"
                        data-key="book-{{ $book->id }}-print"
                        data-book-id="{{ $book->id }}"
                        data-format="Buku Cetak"
                        data-title="{{ $book->title }}"
                        data-author="{{ $book->author }}"
                        data-publisher="{{ $book->publisher }}"
                        data-price="{{ (float)$book->effective_print_price }}"
                        data-cover="{{ $book->cover ? asset('storage/'.$book->cover) : '' }}"
                    >
                        + Cetak
                    </button>

                </div>

            @else

                <div class="format-box print-format format-unavailable">

                    <div class="format-content">

                        <span class="format-label print-label">
                            <svg class="format-icon" viewBox="0 0 24 24">
                                <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                            </svg>
                            Buku Cetak
                        </span>

                        <div class="format-unavailable-text">
                            Tidak tersedia
                        </div>

                        <span class="format-discount-placeholder">
                            &nbsp;
                        </span>

                    </div>

                    <button
                        type="button"
                        class="format-add unavailable-add"
                        data-unavailable-message="Buku Cetak tidak tersedia untuk judul {{ $book->title }}."
                    >
                        + Cetak
                    </button>

                </div>

            @endif

            {{-- E-BOOK --}}
            @if($book->has_ebook && $book->ebook_price !== null)

                <div class="format-box ebook-format">

                    <div class="format-content">

                        <span class="format-label ebook-label">
                            <svg class="format-icon" viewBox="0 0 24 24">
                                <rect x="5" y="3" width="14" height="18" rx="2"/>
                                <path d="M9 7h6M9 11h6"/>
                            </svg>
                            E-book
                        </span>

                        @if($book->has_active_ebook_discount)

                            <div class="format-old-price">
                                Rp {{ number_format((float)$book->ebook_price,0,',','.') }}
                            </div>

                        @else

                            <div
                                class="format-old-price"
                                style="text-decoration:none"
                            >
                                &nbsp;
                            </div>

                        @endif

                        <div class="format-price">
                            Rp {{ number_format((float)$book->effective_ebook_price,0,',','.') }}
                        </div>

                        @if($book->has_active_ebook_discount)

                            <span class="format-discount">
                                -{{ number_format((float)$book->ebook_discount_percent,0) }}%
                            </span>

                        @else

                            <span class="format-discount-placeholder">
                                &nbsp;
                            </span>

                        @endif

                    </div>

                    <button
                        type="button"
                        class="format-add ebook-add"
                        data-cart-add="1"
                        data-key="book-{{ $book->id }}-ebook"
                        data-book-id="{{ $book->id }}"
                        data-format="E-book"
                        data-title="{{ $book->title }}"
                        data-author="{{ $book->author }}"
                        data-publisher="{{ $book->publisher }}"
                        data-price="{{ (float)$book->effective_ebook_price }}"
                        data-cover="{{ $book->cover ? asset('storage/'.$book->cover) : '' }}"
                    >
                        + E-book
                    </button>

                </div>

            @else

                <div class="format-box ebook-format format-unavailable">

                    <div class="format-content">

                        <span class="format-label ebook-label">
                            <svg class="format-icon" viewBox="0 0 24 24">
                                <rect x="5" y="3" width="14" height="18" rx="2"/>
                                <path d="M9 7h6M9 11h6"/>
                            </svg>
                            E-book
                        </span>

                        <div class="format-unavailable-text">
                            Tidak tersedia
                        </div>

                        <span class="format-discount-placeholder">
                            &nbsp;
                        </span>

                    </div>

                    <button
                        type="button"
                        class="format-add unavailable-add"
                        data-unavailable-message="E-book tidak tersedia untuk judul {{ $book->title }}."
                    >
                        + E-book
                    </button>

                </div>

            @endif

        </div>

        <a
            href="{{ route('portofolio.bookstore.show',['book'=>$book->slug]) }}"
            class="detail-btn"
        >
            Lihat Deskripsi
        </a>

    </div>

</article>