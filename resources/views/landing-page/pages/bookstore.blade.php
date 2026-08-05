@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Baca Dulu Bookstore</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  :root{
    --navy:#241B52;
    --navy-deep:#170F38;
    --orange:#EF5843;
    --orange-dark:#C6432F;
    --gold:#F7AA35;
    --cream:#FBF9F5;
    --white:#FFFFFF;
    --ink-muted:#6B7280;
    --border:#EAE7DF;
    --brand-gradient:linear-gradient(135deg,var(--orange) 0%,var(--gold) 100%);
  }
  *{box-sizing:border-box;margin:0;padding:0;}
  body{
    font-family:'Inter',sans-serif;
    color:var(--navy);
    background:var(--white);
    -webkit-font-smoothing:antialiased;
  }
  h1,h2,h3,.brand,.nav a,.btn{font-family:'Poppins',sans-serif;}
  a{text-decoration:none;color:inherit;}
  img{display:block;max-width:100%;}
  
  /* Diubah menjadi 100% agar melebar penuh ke kanan dan kiri */
  .wrap{width:100%;max-width:100%;margin:0;padding:0 40px;}

  .cta-btn{
    background:var(--brand-gradient);color:var(--white);font-weight:600;font-size:14px;
    padding:12px 22px;border-radius:8px;border:none;cursor:pointer;
    transition:filter .15s;white-space:nowrap;
  }
  .cta-btn:hover{filter:brightness(0.93);}

  /* ---------- HERO ---------- */
  .hero{
    background:var(--white);
    background-image:radial-gradient(circle at 88% 8%, rgba(239,88,67,0.30), transparent 52%),
                    radial-gradient(circle at 100% 55%, rgba(247,170,53,0.35), transparent 48%),
                    radial-gradient(circle at 6% 100%, rgba(247,170,53,0.20), transparent 42%);
    color:var(--navy);padding:76px 0 56px;position:relative;overflow:hidden;
    width:100%;
  }
  .hero::before{
    content:"";position:absolute;top:0;left:0;right:0;height:4px;
    background:var(--brand-gradient);
  }
  .eyebrow{
    display:inline-flex;align-items:center;gap:8px;
    background:#FFF1E4;color:var(--orange-dark);
    font-size:13px;font-weight:600;padding:6px 14px;border-radius:20px;
    margin-bottom:20px;letter-spacing:.3px;
  }
  .eyebrow .dot{width:7px;height:7px;border-radius:50%;background:var(--brand-gradient);display:inline-block;}
  .hero h1{font-size:42px;font-weight:700;line-height:1.15;margin-bottom:14px;max-width:700px;color:var(--navy);}
  .hero p{font-size:16px;color:var(--ink-muted);max-width:650px;margin-bottom:32px;line-height:1.6;}
  .search-bar{
    display:flex;gap:10px;background:var(--white);padding:8px;border-radius:12px;
    max-width:650px;border:1px solid var(--border);box-shadow:0 12px 30px rgba(36,27,82,0.10);
  }
  .search-bar input{
    flex:1;border:none;outline:none;font-size:15px;padding:10px 14px;color:var(--navy);font-family:'Inter',sans-serif;
  }
  .search-bar button{
    background:var(--brand-gradient);color:var(--white);border:none;border-radius:8px;
    padding:0 22px;font-weight:600;font-size:14px;cursor:pointer;font-family:'Poppins',sans-serif;
  }
  .hero-stats{display:flex;gap:36px;margin-top:36px;}
  .hero-stats div{border-left:2px solid var(--border);padding-left:14px;}
  .hero-stats strong{display:block;font-size:22px;font-weight:700;color:var(--navy);}
  .hero-stats span{font-size:13px;color:var(--ink-muted);}

  /* ---------- SHELF ---------- */
  section{padding:56px 0;width:100%;}
  .section-head{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:26px;}
  .section-head h2{font-size:26px;font-weight:700;color:var(--navy);display:flex;align-items:center;gap:10px;}
  .section-head h2 .tag{width:10px;height:10px;border-radius:3px;background:var(--brand-gradient);display:inline-block;}
  .section-head p{color:var(--ink-muted);font-size:14px;margin-top:4px;margin-left:20px;}
  .see-all{font-size:14px;font-weight:600;color:var(--orange);}
  
  .shelf{
    display:flex;gap:20px;overflow-x:auto;padding-bottom:12px;scroll-snap-type:x mandatory;
    width:100%;
  }
  .shelf::-webkit-scrollbar{height:6px;}
  .shelf::-webkit-scrollbar-thumb{background:var(--brand-gradient);border-radius:10px;}
  .shelf .book-card{min-width:210px;flex:1;scroll-snap-align:start;}

  /* ---------- BOOK CARD ---------- */
  .book-card{
    background:var(--white);border:1px solid var(--border);border-radius:14px;overflow:hidden;
    transition:box-shadow .2s, transform .2s;
  }
  .book-card:hover{box-shadow:0 14px 28px rgba(27,36,83,0.10);transform:translateY(-3px);}
  .cover-3d{
    height:236px;background:linear-gradient(180deg,var(--cream) 0%,#F1EDE4 100%);
    display:flex;align-items:center;justify-content:center;
    perspective:900px;position:relative;
  }
  .cover-3d::after{
    content:"";position:absolute;left:50%;bottom:20px;width:110px;height:14px;
    background:radial-gradient(ellipse at center, rgba(27,36,83,0.18), transparent 70%);
    transform:translateX(-50%);
  }
  .book3d{
    position:relative;width:148px;height:198px;transform-style:preserve-3d;
    transform:rotateY(-26deg);transition:transform .4s ease;
  }
  .book-card:hover .book3d{transform:rotateY(-8deg);}
  .face{position:absolute;top:0;}
  .face.front{
    width:148px;height:198px;left:0;transform:translateZ(9px);
    border-radius:2px 6px 6px 2px;padding:16px;display:flex;flex-direction:column;justify-content:flex-end;
    color:var(--white);box-shadow:8px 14px 26px rgba(18,25,59,0.28);
  }
  .face.pages{
    width:18px;height:194px;right:0;top:2px;
    background:repeating-linear-gradient(to bottom,#fdfcf9 0 2px,#eae5da 2px 3px);
    transform-origin:right;transform:rotateY(90deg);
    box-shadow:inset -2px 0 4px rgba(0,0,0,0.10);
  }
  .face.spine{
    width:18px;height:194px;left:0;top:2px;
    transform-origin:left;transform:rotateY(-90deg);
    filter:brightness(0.72);
  }
  .front .spine-title{font-family:'Poppins',sans-serif;font-weight:700;font-size:15px;line-height:1.25;}
  .front .spine-sub{font-size:11px;opacity:.85;margin-top:4px;}
  .badge{
    position:absolute;top:12px;left:12px;font-size:10px;font-weight:700;
    padding:4px 9px;border-radius:20px;letter-spacing:.3px;z-index:2;
  }
  .badge.baru{background:var(--gold);color:var(--navy-deep);}
  .badge.best{background:var(--brand-gradient);color:var(--white);}
  .badge.ebook{background:rgba(255,255,255,0.9);color:var(--navy);}
  .book-info{padding:14px 16px 18px;}
  .book-info .penerbit{font-size:11px;color:var(--ink-muted);text-transform:uppercase;letter-spacing:.4px;font-weight:600;}
  .book-info .title{font-size:15px;font-weight:600;color:var(--navy);margin:5px 0 6px;line-height:1.3;min-height:39px;}
  .book-info .author{font-size:12.5px;color:var(--ink-muted);margin-bottom:10px;}
  .book-info .row{display:flex;align-items:center;justify-content:space-between;}
  .price{font-weight:700;color:var(--navy);font-size:15px;}
  .price small{font-weight:400;color:var(--ink-muted);font-size:11px;display:block;text-decoration:line-through;}
  .add-btn{
    width:36px;height:36px;border-radius:9px;border:none;background:var(--cream);
    color:var(--orange);font-size:18px;cursor:pointer;font-weight:700;transition:background .15s, transform .15s;
  }
  .add-btn:hover{background:var(--brand-gradient);color:var(--white);}
  .add-btn.added{transform:scale(0.85);}
  .rating{font-size:12px;color:var(--gold);margin-bottom:8px;}
  .rating span{color:var(--ink-muted);}

  /* ---------- CATALOG GRID (Diubah agar menyesuaikan layar penuh) ---------- */
  .catalog-bg{background:var(--cream);width:100%;}
  .filter-row{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:30px;}
  .chip{
    padding:9px 18px;border-radius:20px;font-size:13.5px;font-weight:500;
    background:var(--white);border:1px solid var(--border);cursor:pointer;color:var(--navy);
    transition:all .15s;
  }
  .chip.active{background:var(--navy);border-color:var(--navy);color:var(--white);}
  
  .grid{
    display:grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap:22px;
    width:100%;
  }

  /* ---------- CTA BANNER ---------- */
  .cta-banner{
    width: calc(100% - 80px);
    margin: 0 auto 64px auto;
    background:var(--white);
    background-image:linear-gradient(120deg, #FFF6EC 0%, #FFE9D2 45%, #FFEFD0 100%),
                    radial-gradient(circle at 90% 10%, rgba(239,88,67,0.18), transparent 55%);
    border:1px solid var(--border);
    border-radius:20px;padding:48px 56px;display:flex;align-items:center;justify-content:space-between;
    color:var(--navy);gap:24px;position:relative;overflow:hidden;
  }
  .cta-banner::before{
    content:"";position:absolute;top:0;left:0;bottom:0;width:5px;
    background:var(--brand-gradient);
  }
  .cta-banner h3{font-size:24px;font-weight:700;margin-bottom:8px;}
  .cta-banner p{color:var(--ink-muted);font-size:14px;max-width:500px;}
  .cta-banner .cta-btn{background:var(--brand-gradient);color:var(--navy-deep);}
  .cta-banner .cta-btn:hover{filter:brightness(0.94);}

  /* ---------- CART: floating button ---------- */
  .cart-fab{
    position:fixed;right:26px;bottom:26px;z-index:1200;
    width:58px;height:58px;border-radius:50%;border:none;
    background:var(--navy);color:var(--white);font-size:24px;cursor:pointer;
    box-shadow:0 12px 28px rgba(36,27,82,0.35);
    display:flex;align-items:center;justify-content:center;
    transition:transform .15s;
  }
  .cart-fab:hover{transform:translateY(-2px);}
  .cart-fab .cart-count{
    position:absolute;top:-4px;right:-4px;min-width:22px;height:22px;padding:0 5px;
    background:var(--brand-gradient);color:var(--white);
    font-size:11px;font-weight:700;border-radius:11px;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 0 0 2px var(--white);
  }
  .cart-count.hide{display:none;}
  .cart-count.pop{animation:cartPop .3s ease;}
  @keyframes cartPop{0%{transform:scale(1);}50%{transform:scale(1.35);}100%{transform:scale(1);}}

  /* ---------- CART: overlay + drawer ---------- */
  .cart-overlay{
    position:fixed;inset:0;background:rgba(23,15,56,0.45);
    opacity:0;pointer-events:none;transition:opacity .25s;z-index:1300;
  }
  .cart-overlay.show{opacity:1;pointer-events:auto;}

  .cart-drawer{
    position:fixed;top:0;right:0;height:100vh;width:400px;max-width:92vw;
    background:var(--white);z-index:1400;
    box-shadow:-18px 0 40px rgba(23,15,56,0.18);
    transform:translateX(100%);transition:transform .3s cubic-bezier(.22,1,.36,1);
    display:flex;flex-direction:column;
  }
  .cart-drawer.open{transform:translateX(0);}
  .cart-drawer-head{
    padding:22px 24px;border-bottom:1px solid var(--border);
    display:flex;align-items:center;justify-content:space-between;
  }
  .cart-drawer-head h3{font-size:18px;font-weight:700;}
  .cart-close{background:none;border:none;font-size:20px;cursor:pointer;color:var(--ink-muted);line-height:1;}
  .cart-items{flex:1;overflow-y:auto;padding:16px 24px;}
  .cart-empty{color:var(--ink-muted);font-size:14px;text-align:center;padding:60px 0;}
  .cart-item{
    display:flex;gap:12px;padding:14px 0;border-bottom:1px solid var(--border);
  }
  .cart-item .ci-info{flex:1;min-width:0;}
  .cart-item .ci-title{font-size:14px;font-weight:600;color:var(--navy);margin-bottom:2px;
    overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
  .cart-item .ci-author{font-size:12px;color:var(--ink-muted);margin-bottom:8px;}
  .cart-item .ci-row{display:flex;align-items:center;justify-content:space-between;}
  .qty-ctrl{display:flex;align-items:center;gap:8px;}
  .qty-ctrl button{
    width:26px;height:26px;border-radius:6px;border:1px solid var(--border);
    background:var(--cream);cursor:pointer;font-size:14px;font-weight:700;color:var(--navy);
  }
  .qty-ctrl span{font-size:13px;font-weight:600;min-width:16px;text-align:center;}
  .ci-price{font-size:13.5px;font-weight:700;color:var(--navy);}
  .ci-remove{background:none;border:none;color:var(--orange-dark);font-size:12px;cursor:pointer;text-decoration:underline;}

  .cart-drawer-foot{padding:20px 24px 24px;border-top:1px solid var(--border);}
  .cart-total-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;}
  .cart-total-row span:first-child{font-size:14px;color:var(--ink-muted);}
  .cart-total-row strong{font-size:19px;color:var(--navy);}
  .checkout-wa-btn{
    width:100%;padding:13px;border-radius:10px;border:none;cursor:pointer;
    background:#25D366;color:var(--white);font-weight:700;font-size:14.5px;
    display:flex;align-items:center;justify-content:center;gap:8px;
    font-family:'Poppins',sans-serif;transition:filter .15s;
  }
  .checkout-wa-btn:hover{filter:brightness(0.95);}
  .checkout-wa-btn:disabled{opacity:.5;cursor:not-allowed;}
  .cart-note{font-size:11.5px;color:var(--ink-muted);text-align:center;margin-top:10px;line-height:1.5;}

  @media (max-width:960px){
    .hero h1{font-size:32px;}
    .cta-banner{flex-direction:column;text-align:center;padding:36px 28px;width: calc(100% - 40px);}
    .wrap{padding:0 20px;}
  }
</style>
</head>
<body>

<section class="hero">
  <div class="wrap">
    <span class="eyebrow"><span class="dot"></span> Toko resmi Baca Dulu</span>
    <h1>Temukan buku terbitan penerbit rekan kami</h1>
    <p>Jelajahi ribuan judul e-book dan buku fisik dari para penulis dan penerbit yang telah dipercaya Baca Dulu — langsung dari sumbernya.</p>
    <div class="search-bar">
      <input type="text" placeholder="Cari judul, penulis, atau penerbit...">
      <button>Cari</button>
    </div>
    <div class="hero-stats">
      <div><strong>1.240+</strong><span>Judul tersedia</span></div>
      <div><strong>86</strong><span>Penerbit rekanan</span></div>
      <div><strong>4.8/5</strong><span>Rating pembaca</span></div>
    </div>
  </div>
</section>

<section>
  <div class="wrap">
    <div class="section-head">
      <div>
        <h2><span class="tag"></span>Terbitan terbaru</h2>
        <p>Baru rilis minggu ini dari penerbit-penerbit rekan kami</p>
      </div>
      <a href="#" class="see-all">Lihat semua →</a>
    </div>
    <div class="shelf" id="shelf"></div>
  </div>
</section>

<section class="catalog-bg">
  <div class="wrap">
    <div class="section-head">
      <div>
        <h2><span class="tag"></span>Katalog lengkap</h2>
        <p>Semua buku yang dijual penerbit di Baca Dulu Bookstore</p>
      </div>
    </div>
    <div class="filter-row" id="filters"></div>
    <div class="grid" id="catalogGrid"></div>
  </div>
</section>

<div class="cta-banner">
  <div>
    <h3>Penerbit atau penulis? Jual bukumu di sini.</h3>
    <p>Gabung sebagai mitra penerbit dan pasarkan judul-judulmu langsung ke pembaca Baca Dulu.</p>
  </div>
  <button class="cta-btn">Kirim Naskah</button>
</div>

<!-- ============ KERANJANG ============ -->
<button class="cart-fab" id="cartFab" title="Buka keranjang">
  🛒
  <span class="cart-count hide" id="cartCount">0</span>
</button>

<div class="cart-overlay" id="cartOverlay"></div>

<div class="cart-drawer" id="cartDrawer">
  <div class="cart-drawer-head">
    <h3>Keranjang Anda</h3>
    <button class="cart-close" id="cartClose">✕</button>
  </div>
  <div class="cart-items" id="cartItemsWrap"></div>
  <div class="cart-drawer-foot">
    <div class="cart-total-row">
      <span>Total</span>
      <strong id="cartTotalText">Rp 0</strong>
    </div>
    <button class="checkout-wa-btn" id="checkoutBtn" disabled>
      💬 Checkout via WhatsApp
    </button>
    <p class="cart-note">Pesanan akan diteruskan ke tim kami lewat WhatsApp untuk konfirmasi stok, ongkir, dan pembayaran.</p>
  </div>
</div>

<script>
const books = [
  {title:"Jejak yang Tertinggal", author:"Rani Ardhita", penerbit:"Rekacipta Media", price:"Rp 89.000", priceNum:89000, strike:"Rp 110.000", cat:"Fiksi", color:"#EF5843", badge:"best", rating:"4.9"},
  {title:"Filosofi Secangkir Kopi", author:"Bagas Wirawan", penerbit:"Pena Semesta", price:"Rp 76.500", priceNum:76500, cat:"Non-Fiksi", color:"#241B52", badge:"baru", rating:"4.7"},
  {title:"Menulis untuk Hidup", author:"Sari Kusuma", penerbit:"Aksara Baru", price:"Rp 65.000", priceNum:65000, cat:"Pengembangan Diri", color:"#F7AA35", badge:"ebook", rating:"4.8"},
  {title:"Negeri di Ufuk Senja", author:"Dimas Prakoso", penerbit:"Rekacipta Media", price:"Rp 95.000", priceNum:95000, cat:"Fiksi", color:"#372A6E", rating:"4.6"},
  {title:"Strategi Bisnis Kecil", author:"Yusuf Hakim", penerbit:"Cerdas Finansial", price:"Rp 82.000", priceNum:82000, cat:"Bisnis", color:"#C6432F", badge:"best", rating:"4.9"},
  {title:"Petualangan Kancil Cerdik", author:"Nadia Putri", penerbit:"Pelangi Anak", price:"Rp 45.000", priceNum:45000, cat:"Anak & Remaja", color:"#EF5843", badge:"baru", rating:"5.0"},
  {title:"Ruang Sunyi", author:"Alia Maheswari", penerbit:"Pena Semesta", price:"Rp 70.000", priceNum:70000, cat:"Fiksi", color:"#241B52", rating:"4.5"},
  {title:"Investasi untuk Pemula", author:"Reza Firmansyah", penerbit:"Cerdas Finansial", price:"Rp 88.000", priceNum:88000, cat:"Bisnis", color:"#F7AA35", badge:"ebook", rating:"4.7"},
];

const categories = ["Semua","Fiksi","Non-Fiksi","Bisnis","Pengembangan Diri","Anak & Remaja"];

function initials(title){
  return title.split(" ").slice(0,3).join(" ");
}

function bookCard(b){
  const badgeMap = {baru:"Baru", best:"Bestseller", ebook:"E-book"};
  const badgeHtml = b.badge ? `<span class="badge ${b.badge}">${badgeMap[b.badge]}</span>` : "";
  const strikeHtml = b.strike ? `<small>${b.strike}</small>` : "";
  const coverBg = b.badge === "best" ? "var(--brand-gradient)" : b.color;
  return `
  <div class="book-card" data-cat="${b.cat}">
    <div class="cover-3d">
      <div class="book3d">
        <div class="face spine" style="background:${coverBg}"></div>
        <div class="face pages"></div>
        <div class="face front" style="background:${coverBg}">
          ${badgeHtml}
          <div>
            <div class="spine-title">${initials(b.title)}</div>
            <div class="spine-sub">${b.author}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="book-info">
      <div class="penerbit">${b.penerbit}</div>
      <div class="title">${b.title}</div>
      <div class="author">${b.author}</div>
      <div class="rating">★★★★★ <span>${b.rating}</span></div>
      <div class="row">
        <div class="price">${b.price}${strikeHtml}</div>
        <button class="add-btn" title="Tambah ke keranjang" data-title="${b.title}">+</button>
      </div>
    </div>
  </div>`;
}

document.getElementById('shelf').innerHTML = books.slice(0,5).map(bookCard).join("");
document.getElementById('catalogGrid').innerHTML = books.map(bookCard).join("");

document.getElementById('filters').innerHTML = categories.map((c,i)=>
  `<div class="chip ${i===0?'active':''}" data-cat="${c}">${c}</div>`
).join("");

document.querySelectorAll('.chip').forEach(chip=>{
  chip.addEventListener('click', ()=>{
    document.querySelectorAll('.chip').forEach(c=>c.classList.remove('active'));
    chip.classList.add('active');
    const cat = chip.dataset.cat;
    document.querySelectorAll('#catalogGrid .book-card').forEach(card=>{
      card.style.display = (cat==="Semua" || card.dataset.cat===cat) ? "" : "none";
    });
  });
});

const STORE_WA_NUMBER = "6281315717719";
const CART_KEY = "bacadulu_cart";
let cart = [];
try {
  cart = JSON.parse(localStorage.getItem(CART_KEY) || "[]");
} catch (e) {
  cart = [];
}

function formatRupiah(n){
  return "Rp " + n.toLocaleString("id-ID");
}

function saveCart(){
  localStorage.setItem(CART_KEY, JSON.stringify(cart));
  updateCartBadge();
  renderCartItems();
}

function addToCart(title){
  const book = books.find(b => b.title === title);
  if (!book) return;
  const existing = cart.find(i => i.title === title);
  if (existing) {
    existing.qty += 1;
  } else {
    cart.push({ title: book.title, author: book.author, priceNum: book.priceNum, qty: 1 });
  }
  saveCart();
  bumpCartCount();
}

function changeQty(title, delta){
  const item = cart.find(i => i.title === title);
  if (!item) return;
  item.qty += delta;
  if (item.qty <= 0) {
    cart = cart.filter(i => i.title !== title);
  }
  saveCart();
}

function removeFromCart(title){
  cart = cart.filter(i => i.title !== title);
  saveCart();
}

function cartTotal(){
  return cart.reduce((sum, i) => sum + (i.priceNum * i.qty), 0);
}

function cartItemCount(){
  return cart.reduce((sum, i) => sum + i.qty, 0);
}

function updateCartBadge(){
  const countEl = document.getElementById('cartCount');
  const count = cartItemCount();
  countEl.textContent = count;
  countEl.classList.toggle('hide', count === 0);
  document.getElementById('checkoutBtn').disabled = count === 0;
}

function bumpCartCount(){
  const countEl = document.getElementById('cartCount');
  countEl.classList.remove('pop');
  void countEl.offsetWidth;
  countEl.classList.add('pop');
}

function renderCartItems(){
  const wrap = document.getElementById('cartItemsWrap');
  const totalText = document.getElementById('cartTotalText');

  if (cart.length === 0) {
    wrap.innerHTML = `<p class="cart-empty">Keranjang masih kosong.<br>Yuk pilih buku dari katalog di atas.</p>`;
  } else {
    wrap.innerHTML = cart.map(item => `
      <div class="cart-item">
        <div class="ci-info">
          <div class="ci-title">${item.title}</div>
          <div class="ci-author">${item.author}</div>
          <div class="ci-row">
            <div class="qty-ctrl">
              <button data-action="dec" data-title="${item.title}">−</button>
              <span>${item.qty}</span>
              <button data-action="inc" data-title="${item.title}">+</button>
            </div>
            <div class="ci-price">${formatRupiah(item.priceNum * item.qty)}</div>
          </div>
          <button class="ci-remove" data-action="remove" data-title="${item.title}">Hapus</button>
        </div>
      </div>
    `).join("");
  }

  totalText.textContent = formatRupiah(cartTotal());

  wrap.querySelectorAll('[data-action]').forEach(btn => {
    btn.addEventListener('click', () => {
      const title = btn.dataset.title;
      const action = btn.dataset.action;
      if (action === 'inc') changeQty(title, 1);
      if (action === 'dec') changeQty(title, -1);
      if (action === 'remove') removeFromCart(title);
    });
  });
}

function openCart(){
  document.getElementById('cartDrawer').classList.add('open');
  document.getElementById('cartOverlay').classList.add('show');
}

function closeCart(){
  document.getElementById('cartDrawer').classList.remove('open');
  document.getElementById('cartOverlay').classList.remove('show');
}

function checkoutViaWhatsApp(){
  if (cart.length === 0) return;

  const lines = cart.map((item, idx) =>
    `${idx + 1}. ${item.title} (${item.qty}x) - ${formatRupiah(item.priceNum * item.qty)}`
  ).join("\n");

  const message =
    `Halo, saya ingin pesan buku berikut dari Baca Dulu Bookstore:\n\n` +
    `${lines}\n\n` +
    `Total: ${formatRupiah(cartTotal())}\n\n` +
    `Mohon info ongkir dan cara pembayarannya. Terima kasih.`;

  const url = `https://wa.me/${STORE_WA_NUMBER}?text=${encodeURIComponent(message)}`;
  window.open(url, '_blank');
}

document.querySelectorAll('.add-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    addToCart(btn.dataset.title);
    btn.classList.add('added');
    setTimeout(() => btn.classList.remove('added'), 150);
  });
});

document.getElementById('cartFab').addEventListener('click', openCart);
document.getElementById('cartClose').addEventListener('click', closeCart);
document.getElementById('cartOverlay').addEventListener('click', closeCart);
document.getElementById('checkoutBtn').addEventListener('click', checkoutViaWhatsApp);

updateCartBadge();
renderCartItems();
</script>

</body>
</html>
@endsection