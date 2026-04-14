<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Plant Catalogue – Chatla</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.tailwindcss.com?plugins=forms"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          primary: "#2c5926",
          "primary-light": "#eaf3e8",
          "bg-page": "#f6f7f6",
        },
        fontFamily: { sans: ["Inter", "sans-serif"] },
      },
    },
  };
</script>
<style>
  * { box-sizing: border-box; }
  body { font-family: 'Inter', sans-serif; }
  .mat  { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
  .matf { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }

  /* Toggle switch */
  .tog-input:checked + .tog-track { background:#2c5926; }
  .tog-input:checked + .tog-track .tog-thumb { transform:translateX(18px); }

  /* Card hover overlay */
  .plant-card .card-overlay { opacity:0; transition:opacity .18s; }
  .plant-card:hover .card-overlay { opacity:1; }

  /* Custom scrollbar */
  ::-webkit-scrollbar { width:5px; height:5px; }
  ::-webkit-scrollbar-thumb { background:#d1d5db; border-radius:9999px; }

  /* Family dropdown */
  .family-dropdown { display:none; }
  .family-dropdown.open { display:block; }

  /* Line clamp */
  .line-clamp-2 {
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
  }

  /* Modal backdrop */
  #edit-modal { display:none; }
  #edit-modal.open { display:flex; }
</style>
</head>
<body class="bg-bg-page text-slate-900 font-sans">
<div class="flex h-screen overflow-hidden">

  <!-- ═══════════════ SIDEBAR ═══════════════ -->
  <aside class="w-52 flex flex-col bg-white border-r border-slate-100 shrink-0">
    <!-- Logo -->
    <div class="flex items-center gap-3 px-5 py-5 border-b border-slate-100">
      <div class="w-9 h-9 bg-primary rounded-full flex items-center justify-center text-white shrink-0">
        <span class="material-symbols-outlined matf text-[20px]">psychiatry</span>
      </div>
      <div class="leading-tight">
        <p class="font-bold text-[15px] text-primary">Chatla</p>
        <p class="text-[10px] text-slate-400 font-medium">Nursery Admin</p>
      </div>
    </div>
    <!-- Nav -->
    <nav class="flex-1 px-3 py-5 space-y-0.5">
      <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-primary/8 hover:text-primary rounded-lg text-sm font-medium transition-colors">
        <span class="material-symbols-outlined mat text-[20px]">grid_view</span>Overview
      </a>
      <a href="{{ route('nursery.inventory.index') }}" class="flex items-center gap-3 px-3 py-2.5 bg-primary text-white rounded-lg text-sm font-semibold">
        <span class="material-symbols-outlined matf text-[20px]">potted_plant</span>My Plants
      </a>
      <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-primary/8 hover:text-primary rounded-lg text-sm font-medium transition-colors">
        <span class="material-symbols-outlined mat text-[20px]">add_circle</span>Add New Plant
      </a>
      <a href="{{ route('nursery.profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-primary/8 hover:text-primary rounded-lg text-sm font-medium transition-colors">
        <span class="material-symbols-outlined mat text-[20px]">storefront</span>Nursery Info
      </a>
    </nav>
    <!-- Logout / Bottom -->
    <div class="px-3 py-4 border-t border-slate-100">
      <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-red-50 hover:text-red-600 rounded-lg text-sm font-medium transition-colors cursor-pointer text-left">
              <span class="material-symbols-outlined mat text-[20px]">logout</span>Log Out
          </button>
      </form>
    </div>
  </aside>

  <!-- ═══════════════ MAIN ═══════════════ -->
  <div class="flex flex-col flex-1 overflow-hidden">

    <!-- HEADER -->
    <header class="h-14 bg-white border-b border-slate-100 flex items-center justify-between px-6 shrink-0">
      <div class="relative w-72">
        <span class="material-symbols-outlined mat absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">search</span>
        <input id="search-input" type="text" placeholder="Search plants, orders, or leads..."
          class="w-full bg-bg-page border-none rounded-full py-2 pl-10 pr-4 text-sm placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 outline-none"
          oninput="applyFilters()"/>
      </div>
      <div class="flex items-center gap-4">
        <button class="text-slate-400 hover:text-primary transition-colors p-1.5 relative">
          <span class="material-symbols-outlined mat text-[22px]">notifications</span>
          <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
        </button>
        <div class="h-6 w-px bg-slate-200"></div>
        <div class="flex items-center gap-2.5">
          <div class="text-right">
            <p class="text-sm font-semibold leading-tight">{{ auth()->user()->name }}</p>
            <p class="text-[11px] text-slate-400">Owner</p>
          </div>
          @if(auth()->user()->profile_img)
            <div class="w-9 h-9 rounded-full bg-cover bg-center border border-slate-200" style="background-image:url('{{ auth()->user()->profile_img }}')"></div>
          @else
            <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200 text-primary font-bold">
              {{ substr(auth()->user()->name, 0, 1) }}
            </div>
          @endif
        </div>
      </div>
    </header>

    <!-- PAGE BODY -->
    <main class="flex-1 overflow-y-auto bg-bg-page">
      <div class="px-8 py-7">

        <!-- ─── Page title row ─── -->
        <div class="flex items-center justify-between mb-5">
          <div>
            <h2 class="text-xl font-bold tracking-tight">Catalogue <span class="text-slate-400 font-normal text-base" id="count-label">(0 plants)</span></h2>
          </div>
          <button onclick="openEdit(null)"
            class="bg-primary text-white px-4 py-2.5 rounded-lg flex items-center gap-2 font-semibold text-sm hover:opacity-90 transition-opacity">
            <span class="material-symbols-outlined mat text-[18px]">add</span>Add New Plant
          </button>
        </div>

        <!-- ─── FILTER BAR ─── -->
        <div class="bg-white border border-slate-100 rounded-xl px-5 py-4 mb-6 flex flex-wrap items-end gap-4">

          <!-- Sort by -->
          <div class="flex flex-col gap-1.5 min-w-[130px]">
            <label class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Sort by</label>
            <div class="relative">
              <select id="sort-select" onchange="applyFilters()"
                class="w-full bg-bg-page border-none rounded-lg pl-3 pr-8 py-2 text-sm text-slate-700 font-medium focus:ring-2 focus:ring-primary/20 outline-none appearance-none cursor-pointer">
                <option value="name">Name A–Z</option>
                <option value="price-asc">Price ↑</option>
                <option value="price-desc">Price ↓</option>
                <option value="stock-desc">Most Stock</option>
              </select>
              <span class="material-symbols-outlined mat absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 text-[16px] pointer-events-none">expand_more</span>
            </div>
          </div>

          <!-- Stock status -->
          <div class="flex flex-col gap-1.5 min-w-[140px]">
            <label class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Stock status</label>
            <div class="relative">
              <span class="material-symbols-outlined mat absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-[16px] pointer-events-none">inventory_2</span>
              <select id="status-select" onchange="applyFilters()"
                class="w-full bg-bg-page border-none rounded-lg pl-9 pr-8 py-2 text-sm text-slate-700 font-medium focus:ring-2 focus:ring-primary/20 outline-none appearance-none cursor-pointer">
                <option value="">All statuses</option>
                <option value="available">Available</option>
                <option value="low">Low Stock</option>
                <option value="out">Out of Stock</option>
              </select>
              <span class="material-symbols-outlined mat absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 text-[16px] pointer-events-none">expand_more</span>
            </div>
          </div>

          <!-- Plant family (searchable) -->
          <div class="flex flex-col gap-1.5 min-w-[180px] relative" id="family-wrap">
            <label class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Plant family</label>
            <div class="relative">
              <span class="material-symbols-outlined mat absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-[16px] pointer-events-none">eco</span>
              <input id="family-search" type="text" placeholder="All families"
                autocomplete="off"
                class="w-full bg-bg-page border-none rounded-lg pl-9 pr-8 py-2 text-sm text-slate-700 font-medium focus:ring-2 focus:ring-primary/20 outline-none cursor-pointer"
                onfocus="openFamilyDrop()" oninput="filterFamilyOptions()"/>
              <span class="material-symbols-outlined mat absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 text-[16px] pointer-events-none">expand_more</span>
            </div>
            <!-- Dropdown -->
            <div id="family-dropdown"
              class="family-dropdown absolute top-full left-0 mt-1 w-full bg-white border border-slate-100 rounded-xl shadow-lg z-30 overflow-hidden">
              <div class="max-h-44 overflow-y-auto py-1" id="family-list">
                <div class="family-opt px-3 py-2 text-sm text-slate-600 hover:bg-primary/5 hover:text-primary cursor-pointer rounded-lg mx-1" data-val="" onclick="pickFamily(this)">All families</div>
                @foreach($families as $fam)
                  <div class="family-opt px-3 py-2 text-sm text-slate-600 hover:bg-primary/5 hover:text-primary cursor-pointer rounded-lg mx-1" data-val="{{ $fam->name }}" onclick="pickFamily(this)">{{ $fam->name }}</div>
                @endforeach
              </div>
            </div>
          </div>

          <!-- Active filters chips -->
          <div id="active-chips" class="flex flex-wrap gap-2 items-center ml-auto self-end pb-0.5"></div>

          <!-- Clear all -->
          <button id="clear-btn" onclick="clearFilters()" class="hidden self-end pb-1 text-xs text-slate-400 hover:text-red-500 font-medium transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined mat text-[14px]">close</span>Clear all
          </button>
        </div>

        <!-- ─── CATALOGUE GRID ─── -->
        <div id="catalogue-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5"></div>

        <!-- Empty state -->
        <div id="empty-state" class="hidden flex-col items-center justify-center py-24 text-slate-400">
          <span class="material-symbols-outlined mat text-[48px] mb-3">search_off</span>
          <p class="text-base font-medium">No plants match your filters</p>
          <p class="text-sm mt-1">Try adjusting or clearing the filters above</p>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-7">
          <p class="text-xs text-slate-400" id="page-info">Showing 0–0 of 0</p>
          <div class="flex items-center gap-1.5" id="pagination"></div>
        </div>

      </div>
    </main>
  </div>
</div>

<!-- ═══════════════ EDIT MODAL ═══════════════ -->
<div id="edit-modal" class="fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-sm p-4">
  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">

    <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
      <h3 class="text-base font-bold" id="modal-title">Edit Plant</h3>
      <button onclick="closeEdit()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
        <span class="material-symbols-outlined mat text-[20px]">close</span>
      </button>
    </div>

    <form class="px-6 py-5 space-y-4" onsubmit="submitEdit(event)">

      <!-- Image upload -->
      <div class="flex flex-col gap-1.5">
        <label class="text-xs font-semibold text-slate-600">Plant Photo</label>
        <div class="relative group cursor-pointer" onclick="document.getElementById('photo-input').click()">
          <div id="photo-preview" class="w-full h-36 rounded-xl bg-bg-page border-2 border-dashed border-slate-200 flex flex-col items-center justify-center gap-2 overflow-hidden group-hover:border-primary/40 transition-colors">
            <span class="material-symbols-outlined mat text-[32px] text-slate-300">add_photo_alternate</span>
            <p class="text-xs text-slate-400">Click to upload image</p>
          </div>
          <input type="file" id="photo-input" accept="image/*" class="hidden" onchange="previewPhoto(event)"/>
        </div>
      </div>

      <!-- Name + Family row -->
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col gap-1.5">
          <label class="text-xs font-semibold text-slate-600">Plant Name</label>
          <input id="f-name" type="text" placeholder="Plant name"
            class="bg-slate-50 text-slate-500 border border-slate-200 rounded-lg px-3 py-2.5 text-sm cursor-not-allowed outline-none" readonly/>
        </div>
        <div class="flex flex-col gap-1.5">
          <label class="text-xs font-semibold text-slate-600">Family</label>
          <input id="f-family" type="text" placeholder="Plant family"
            class="bg-slate-50 text-slate-500 border border-slate-200 rounded-lg px-3 py-2.5 text-sm cursor-not-allowed outline-none" readonly/>
        </div>
      </div>

      <div class="grid grid-cols-3 gap-4">
        <div class="flex flex-col gap-1.5">
          <label class="text-xs font-semibold text-slate-600">Price (MAD)</label>
          <input id="f-price" type="number" min="0" placeholder="250"
            class="bg-bg-page border-none rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none"/>
        </div>
        <div class="flex flex-col gap-1.5">
          <label class="text-xs font-semibold text-slate-600">Units in Stock</label>
          <input id="f-stock" type="number" min="0" placeholder="42"
            class="bg-bg-page border-none rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none"/>
        </div>
        <div class="flex flex-col gap-1.5">
          <label class="text-xs font-semibold text-slate-600">Status</label>
          <div class="relative">
            <select id="f-status"
              class="w-full bg-bg-page border-none rounded-lg pl-3 pr-8 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none appearance-none">
              <option value="available">Available</option>
              <option value="low">Low Stock</option>
              <option value="out">Out of Stock</option>
            </select>
            <span class="material-symbols-outlined mat absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 text-[16px] pointer-events-none">expand_more</span>
          </div>
        </div>
      </div>

      <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
        <button type="button" onclick="closeEdit()" class="text-slate-500 text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-slate-100 transition-colors">Cancel</button>
        <button type="submit" class="bg-primary text-white text-sm font-semibold px-6 py-2.5 rounded-lg hover:opacity-90 transition-opacity">Save Plant</button>
      </div>
    </form>
  </div>
</div>

<script>
/* ═══════════════════════════════════
   DATA (Populated from Laravel)
═══════════════════════════════════ */
let plants = @json($plants);

let editingId = null;
let selectedFamily = "";
const PER_PAGE = 8;
let currentPage = 1;

/* ═══════════════════════════════════
   STATUS HELPERS
═══════════════════════════════════ */
const statusBadge = {
  available: `<span class="inline-flex items-center gap-1 text-[11px] font-semibold text-green-700 bg-green-100 px-2.5 py-1 rounded-full"><span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>In Stock</span>`,
  low:       `<span class="inline-flex items-center gap-1 text-[11px] font-semibold text-orange-700 bg-orange-100 px-2.5 py-1 rounded-full"><span class="w-1.5 h-1.5 rounded-full bg-orange-500 inline-block"></span>Low Stock</span>`,
  out:       `<span class="inline-flex items-center gap-1 text-[11px] font-semibold text-red-700 bg-red-100 px-2.5 py-1 rounded-full"><span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span>Out of Stock</span>`,
};

/* ═══════════════════════════════════
   RENDER GRID
═══════════════════════════════════ */
function renderGrid(list) {
  const grid = document.getElementById('catalogue-grid');
  const empty = document.getElementById('empty-state');
  const countLabel = document.getElementById('count-label');
  const pageInfo = document.getElementById('page-info');

  const total = list.length;
  const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
  if (currentPage > totalPages) currentPage = totalPages;

  const start = (currentPage - 1) * PER_PAGE;
  const page = list.slice(start, start + PER_PAGE);

  countLabel.textContent = `(${total} plant${total !== 1 ? 's' : ''})`;
  pageInfo.textContent = total
    ? `Showing ${start+1}–${Math.min(start+PER_PAGE, total)} of ${total}`
    : 'No results';

  if (!page.length) {
    grid.innerHTML = '';
    grid.classList.add('hidden');
    empty.classList.remove('hidden');
    empty.classList.add('flex');
    renderPagination(0, 0);
    return;
  }

  grid.classList.remove('hidden');
  empty.classList.add('hidden');
  empty.classList.remove('flex');

  grid.innerHTML = page.map(p => `
    <div class="plant-card group bg-white rounded-2xl border border-slate-100 overflow-hidden cursor-pointer relative" data-id="${p.id}">
      <!-- Image -->
      <div class="relative h-44 overflow-hidden bg-bg-page">
        <img src="${p.img}" alt="${p.name}" 
          class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
          onerror="this.src='https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&q=80'"/>
        <!-- Status badge top-right -->
        <div class="absolute top-3 right-3">${statusBadge[p.status]}</div>
        <!-- Hover overlay with actions -->
        <div class="card-overlay absolute inset-0 bg-black/40 flex items-center justify-center gap-3">
          <button onclick="openEdit(${p.id})" class="flex items-center gap-1.5 bg-white text-slate-800 text-xs font-semibold px-4 py-2 rounded-full hover:bg-primary hover:text-white transition-colors shadow-lg">
            <span class="material-symbols-outlined mat text-[15px]">edit</span>Edit
          </button>
          <button onclick="deletePlant(event,${p.id})" class="flex items-center gap-1.5 bg-white text-red-600 text-xs font-semibold px-4 py-2 rounded-full hover:bg-red-600 hover:text-white transition-colors shadow-lg">
            <span class="material-symbols-outlined mat text-[15px]">delete</span>Delete
          </button>
        </div>
      </div>
      <!-- Card body -->
      <div class="p-4">
        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">${p.family}</p>
        <h3 class="font-bold text-sm text-slate-900 mb-0.5 leading-snug">${p.name}</h3>
        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-3">${p.desc}</p>
        <div class="flex items-center justify-between">
          <p class="text-sm font-bold text-primary">${p.price.toLocaleString()} MAD</p>
          <p class="text-sm font-medium text-slate-500">${p.stock} units</p>
        </div>
      </div>
    </div>
  `).join('');

  renderPagination(totalPages, currentPage);
}

/* ═══════════════════════════════════
   PAGINATION
═══════════════════════════════════ */
function renderPagination(total, current) {
  const wrap = document.getElementById('pagination');
  if (total <= 1) { wrap.innerHTML = ''; return; }

  let html = `<button onclick="goPage(${current-1})" ${current===1?'disabled':''} class="w-7 h-7 flex items-center justify-center rounded border border-slate-200 hover:bg-slate-50 text-slate-400 disabled:opacity-40">
    <span class="material-symbols-outlined mat text-[16px]">chevron_left</span></button>`;

  for (let i=1; i<=total; i++) {
    if (total > 6 && i > 3 && i < total-1) {
      if (i === 4) html += `<span class="text-slate-400 text-xs px-1">…</span>`;
      if (i !== current) continue;
    }
    html += `<button onclick="goPage(${i})" class="w-7 h-7 flex items-center justify-center rounded ${i===current ? 'bg-primary text-white font-bold' : 'border border-slate-200 hover:bg-slate-50 text-slate-500 font-medium'} text-xs">${i}</button>`;
  }

  html += `<button onclick="goPage(${current+1})" ${current===total?'disabled':''} class="w-7 h-7 flex items-center justify-center rounded border border-slate-200 hover:bg-slate-50 text-slate-400 disabled:opacity-40">
    <span class="material-symbols-outlined mat text-[16px]">chevron_right</span></button>`;

  wrap.innerHTML = html;
}

function goPage(p) {
  const q = document.getElementById('search-input').value.toLowerCase();
  const st = document.getElementById('status-select').value;
  const filtered = getFiltered(q, st, selectedFamily);
  const total = Math.ceil(filtered.length / PER_PAGE);
  if (p < 1 || p > total) return;
  currentPage = p;
  renderGrid(filtered);
}

/* ═══════════════════════════════════
   FILTERS
═══════════════════════════════════ */
function getFiltered(q, status, family) {
  const sort = document.getElementById('sort-select').value;
  let list = plants.filter(p => {
    const matchQ = !q || p.name.toLowerCase().includes(q) || p.common.toLowerCase().includes(q) || p.family.toLowerCase().includes(q);
    const matchS = !status || p.status === status;
    const matchF = !family || p.family === family;
    return matchQ && matchS && matchF;
  });
  list.sort((a,b) => {
    if (sort==='name') return a.name.localeCompare(b.name);
    if (sort==='price-asc') return a.price - b.price;
    if (sort==='price-desc') return b.price - a.price;
    if (sort==='stock-desc') return b.stock - a.stock;
    return 0;
  });
  return list;
}

function applyFilters() {
  const q = document.getElementById('search-input').value.toLowerCase();
  const st = document.getElementById('status-select').value;
  currentPage = 1;
  renderGrid(getFiltered(q, st, selectedFamily));
  updateChips(q, st, selectedFamily);
}

function updateChips(q, st, fam) {
  const wrap = document.getElementById('active-chips');
  const clearBtn = document.getElementById('clear-btn');
  const chips = [];
  if (st) {
    const labels = { available:'In Stock', low:'Low Stock', out:'Out of Stock' };
    chips.push(`<span class="flex items-center gap-1 text-xs font-medium text-primary bg-primary-light px-2.5 py-1 rounded-full">
      ${labels[st]}
      <button onclick="document.getElementById('status-select').value='';applyFilters()" class="text-primary/60 hover:text-red-500 ml-0.5">
        <span class="material-symbols-outlined mat text-[13px]">close</span></button></span>`);
  }
  if (fam) {
    chips.push(`<span class="flex items-center gap-1 text-xs font-medium text-primary bg-primary-light px-2.5 py-1 rounded-full">
      ${fam}
      <button onclick="selectedFamily='';document.getElementById('family-search').value='';applyFilters()" class="text-primary/60 hover:text-red-500 ml-0.5">
        <span class="material-symbols-outlined mat text-[13px]">close</span></button></span>`);
  }
  wrap.innerHTML = chips.join('');
  if (chips.length || q) { clearBtn.classList.remove('hidden'); clearBtn.classList.add('flex'); }
  else { clearBtn.classList.add('hidden'); clearBtn.classList.remove('flex'); }
}

function clearFilters() {
  document.getElementById('search-input').value = '';
  document.getElementById('status-select').value = '';
  document.getElementById('family-search').value = '';
  selectedFamily = '';
  currentPage = 1;
  applyFilters();
}

/* ═══════════════════════════════════
   FAMILY DROPDOWN
═══════════════════════════════════ */
function openFamilyDrop() {
  document.getElementById('family-dropdown').classList.add('open');
  filterFamilyOptions();
}
function filterFamilyOptions() {
  const q = document.getElementById('family-search').value.toLowerCase();
  document.querySelectorAll('.family-opt').forEach(el => {
    el.style.display = el.dataset.val.toLowerCase().includes(q) || el.dataset.val === '' ? '' : 'none';
  });
}
function pickFamily(el) {
  selectedFamily = el.dataset.val;
  document.getElementById('family-search').value = el.dataset.val || '';
  document.getElementById('family-dropdown').classList.remove('open');
  applyFilters();
}
document.addEventListener('click', e => {
  if (!document.getElementById('family-wrap').contains(e.target)) {
    document.getElementById('family-dropdown').classList.remove('open');
  }
});

/* ═══════════════════════════════════
   EDIT MODAL
═══════════════════════════════════ */
function openEdit(id) {
  editingId = id;
  const modal = document.getElementById('edit-modal');
  const title = document.getElementById('modal-title');
  // reset photo preview
  document.getElementById('photo-preview').innerHTML = `
    <span class="material-symbols-outlined mat text-[32px] text-slate-300">add_photo_alternate</span>
    <p class="text-xs text-slate-400">Click to upload image</p>`;

  if (id) {
    const p = plants.find(x => x.id === id);
    title.textContent = 'Edit Plant';
    document.getElementById('f-name').value   = p.name;
    document.getElementById('f-family').value = p.family;
    document.getElementById('f-price').value  = p.price;
    document.getElementById('f-stock').value  = p.stock;
    document.getElementById('f-status').value = p.status;
    document.getElementById('photo-preview').innerHTML = `
      <img src="${p.img}" class="w-full h-full object-cover rounded-xl" onerror=""/>`;
  } else {
    // For now Add New Plant button handles some default UI, but the backend integration will come later.
    title.textContent = 'Add New Plant';
    ['f-name','f-family','f-price','f-stock'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('f-status').value = 'available';
  }
  modal.classList.add('open');
}

function closeEdit() {
  document.getElementById('edit-modal').classList.remove('open');
}

function submitEdit(e) {
  e.preventDefault();
  const price  = parseInt(document.getElementById('f-price').value) || 0;
  const stock  = parseInt(document.getElementById('f-stock').value) || 0;
  const status = document.getElementById('f-status').value;
  const photoInput = document.getElementById('photo-input');

  if (editingId) {
    const p = plants.find(x => x.id === editingId);
    
    // Create FormData for backend
    const formData = new FormData();
    formData.append('_method', 'PUT'); // Spoof PUT request for Laravel with file
    formData.append('price', price);
    formData.append('quantity', stock);
    formData.append('stock_status', status);
    
    if (photoInput.files.length > 0) {
      formData.append('image', photoInput.files[0]);
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Send the fetch request
    const btn = e.target.querySelector('button[type="submit"]');
    const oldText = btn.innerHTML;
    btn.innerHTML = 'Saving...';
    btn.disabled = true;

    fetch(`/nursery/plants/${editingId}`, {
      method: 'POST', // using POST with _method=PUT
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      },
      body: formData
    })
    .then(response => {
      if (!response.ok) throw new Error('Validation or server error');
      return response.json();
    })
    .then(data => {
      if(data.success) {
        // Update local state to reflect UI changes smoothly
        Object.assign(p, { price, stock, status });
        if (data.image_url) {
           p.img = data.image_url;
        }
        closeEdit();
        applyFilters();
      } else {
        alert('Could not update plant.');
      }
    })
    .catch(error => alert('Error saving plant.'))
    .finally(() => {
      btn.innerHTML = oldText;
      btn.disabled = false;
    });
  }
}

function previewPhoto(e) {
  const file = e.target.files[0];
  if (!file) return;
  const url = URL.createObjectURL(file);
  document.getElementById('photo-preview').innerHTML = `
    <img src="${url}" class="w-full h-full object-cover rounded-xl"/>`;
}

/* ═══════════════════════════════════
   DELETE
═══════════════════════════════════ */
function deletePlant(e, id) {
  e.stopPropagation();
  if (!confirm('Delete this plant?')) return;
  
  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
  
  fetch(`/nursery/plants/${id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      }
  })
  .then(response => {
      if (!response.ok) throw new Error('Could not delete plant');
      return response.json();
  })
  .then(data => {
      if (data.success) {
          plants = plants.filter(p => p.id !== id);
          applyFilters();
      }
  })
  .catch(error => alert(error.message));
}

/* ═══════════════════════════════════
   INIT
═══════════════════════════════════ */
applyFilters();
</script>
</body>
</html>
