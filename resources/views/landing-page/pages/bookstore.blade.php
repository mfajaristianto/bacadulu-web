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
  .wrap{max-width:1200px;margin:0 auto;padding:0 32px;}

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
  .hero h1{font-size:42px;font-weight:700;line-height:1.15;margin-bottom:14px;max-width:640px;color:var(--navy);}
  .hero p{font-size:16px;color:var(--ink-muted);max-width:560px;margin-bottom:32px;line-height:1.6;}
  .search-bar{
    display:flex;gap:10px;background:var(--white);padding:8px;border-radius:12px;
    max-width:600px;border:1px solid var(--border);box-shadow:0 12px 30px rgba(36,27,82,0.10);
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

  /* ---------- SHELF (featured, horizontal scroll) ---------- */
  section{padding:56px 0;}
  .section-head{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:26px;}
  .section-head h2{font-size:26px;font-weight:700;color:var(--navy);display:flex;align-items:center;gap:10px;}
  .section-head h2 .tag{width:10px;height:10px;border-radius:3px;background:var(--brand-gradient);display:inline-block;}
  .section-head p{color:var(--ink-muted);font-size:14px;margin-top:4px;margin-left:20px;}
  .see-all{font-size:14px;font-weight:600;color:var(--orange);}
  .shelf{
    display:flex;gap:20px;overflow-x:auto;padding-bottom:12px;scroll-snap-type:x mandatory;
  }
  .shelf::-webkit-scrollbar{height:6px;}
  .shelf::-webkit-scrollbar-thumb{background:var(--brand-gradient);border-radius:10px;}
  .shelf .book-card{min-width:190px;scroll-snap-align:start;}

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
    color:var(--orange);font-size:18px;cursor:pointer;font-weight:700;transition:background .15s;
  }
  .add-btn:hover{background:var(--brand-gradient);color:var(--white);}
  .rating{font-size:12px;color:var(--gold);margin-bottom:8px;}
  .rating span{color:var(--ink-muted);}

  /* ---------- CATALOG (filters + grid) ---------- */
  .catalog-bg{background:var(--cream);}
  .filter-row{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:30px;}
  .chip{
    padding:9px 18px;border-radius:20px;font-size:13.5px;font-weight:500;
    background:var(--white);border:1px solid var(--border);cursor:pointer;color:var(--navy);
    transition:all .15s;
  }
  .chip.active{background:var(--navy);border-color:var(--navy);color:var(--white);}
  .grid{display:grid;grid-template-columns:repeat(4,1fr);gap:22px;}

  /* ---------- CTA BANNER ---------- */
  .cta-banner{
    margin:0 32px 64px;max-width:1136px;margin-left:auto;margin-right:auto;
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
  .cta-banner p{color:var(--ink-muted);font-size:14px;max-width:420px;}
  .cta-banner .cta-btn{background:var(--brand-gradient);color:var(--navy-deep);}
  .cta-banner .cta-btn:hover{filter:brightness(0.94);}

  @media (max-width:960px){
    .grid{grid-template-columns:repeat(2,1fr);}
    .hero h1{font-size:32px;}
    .cta-banner{flex-direction:column;text-align:center;padding:36px 28px;}
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

<script>
const books = [
  {title:"Jejak yang Tertinggal", author:"Rani Ardhita", penerbit:"Rekacipta Media", price:"Rp 89.000", strike:"Rp 110.000", cat:"Fiksi", color:"#EF5843", badge:"best", rating:"4.9"},
  {title:"Filosofi Secangkir Kopi", author:"Bagas Wirawan", penerbit:"Pena Semesta", price:"Rp 76.500", cat:"Non-Fiksi", color:"#241B52", badge:"baru", rating:"4.7"},
  {title:"Menulis untuk Hidup", author:"Sari Kusuma", penerbit:"Aksara Baru", price:"Rp 65.000", cat:"Pengembangan Diri", color:"#F7AA35", badge:"ebook", rating:"4.8"},
  {title:"Negeri di Ufuk Senja", author:"Dimas Prakoso", penerbit:"Rekacipta Media", price:"Rp 95.000", cat:"Fiksi", color:"#372A6E", rating:"4.6"},
  {title:"Strategi Bisnis Kecil", author:"Yusuf Hakim", penerbit:"Cerdas Finansial", price:"Rp 82.000", cat:"Bisnis", color:"#C6432F", badge:"best", rating:"4.9"},
  {title:"Petualangan Kancil Cerdik", author:"Nadia Putri", penerbit:"Pelangi Anak", price:"Rp 45.000", cat:"Anak & Remaja", color:"#EF5843", badge:"baru", rating:"5.0"},
  {title:"Ruang Sunyi", author:"Alia Maheswari", penerbit:"Pena Semesta", price:"Rp 70.000", cat:"Fiksi", color:"#241B52", rating:"4.5"},
  {title:"Investasi untuk Pemula", author:"Reza Firmansyah", penerbit:"Cerdas Finansial", price:"Rp 88.000", cat:"Bisnis", color:"#F7AA35", badge:"ebook", rating:"4.7"},
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
        <button class="add-btn" title="Tambah ke keranjang">+</button>
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
</script>

</body>
</html>
@endsection