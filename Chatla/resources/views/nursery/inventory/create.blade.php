@extends('layouts.nursery')

@section('title', 'Add New Plant – Chatla')

@push('styles')
<style>
  /* ── Field focus ring & Padding Fix ── */
  .field-input{
    width:100%; border:1.5px solid #e8ede9; border-radius:10px;
    padding:10px 14px; font-size:13.5px; font-family:inherit;
    color:#1a2e22; background:#fafcfb; outline:none;
    transition:border-color .18s, box-shadow .18s;
  }
  .field-input:focus{ border-color:#2c5926; box-shadow:0 0 0 3px rgba(44,89,38,.1); background:#fff; }
  .field-input::placeholder{ color:#b0c4ba; }
  .field-input:disabled{ background:#f0f4f1; color:#9ab4a0; cursor:not-allowed; }

  /* Fixed Overlap Issue Here */
  .field-input-icon{ padding-left: 42px !important; }

  .ico-left{
    position:absolute; left:14px; top:50%; transform:translateY(-50%);
    width:18px; height:18px; color:#9ab4a0; pointer-events:none;
  }

  /* ── Growth stage cards ── */
  .stage-card{ cursor:pointer; transition:all .18s; }
  .stage-card input[type=radio]{ display:none; }
  .stage-card input[type=radio]:checked ~ .stage-inner{
    border-color:#2c5926; background:#eaf3e8;
  }
  .stage-card input[type=radio]:checked ~ .stage-inner .stage-icon{
    background:#2c5926; color:white;
  }
  .stage-card input[type=radio]:checked ~ .stage-inner .stage-label{ color:#2c5926; }
  .stage-inner{
    border:1.5px solid #e8ede9; border-radius:12px;
    padding:14px 8px; text-align:center;
    background:#fafcfb; transition:all .18s;
  }
  .stage-inner:hover{ border-color:#2c5926; }
  .stage-icon{
    width:38px; height:38px; border-radius:10px;
    background:#f0f4f1; display:flex; align-items:center; justify-content:center;
    margin:0 auto 7px; transition:all .18s;
  }
  .stage-label{ font-size:12px; font-weight:600; color:#6b8578; }

  /* ── Stock status pills ── */
  .status-pill input[type=radio]{ display:none; }
  .status-pill input[type=radio]:checked ~ .pill-inner{ border-width:2px; font-weight:700; }
  .pill-inner{ border:1.5px solid #e8ede9; border-radius:999px; padding:7px 16px; font-size:12.5px; font-weight:500; cursor:pointer; transition:all .16s; display:flex; align-items:center; gap:6px; }

  .status-pill.available input:checked ~ .pill-inner{ border-color:#16a34a; background:#f0fdf4; color:#15803d; }
  .status-pill.low input:checked ~ .pill-inner{ border-color:#ea580c; background:#fff7ed; color:#c2410c; }
  .status-pill.out input:checked ~ .pill-inner{ border-color:#dc2626; background:#fef2f2; color:#b91c1c; }

  /* ── Photo drop zone ── */
  #drop-zone{ transition:border-color .18s, background .18s; }
  #drop-zone.drag-over{ border-color:#2c5926; background:#eaf3e8; }

  /* ── Section divider ── */
  .section-head{
    display:flex; align-items:center; gap:10px;
    margin-bottom:18px;
  }
  .section-head-line{ flex:1; height:1px; background:#f0f4f1; }
  .section-num{
    width:22px; height:22px; border-radius:50%;
    background:#2c5926; color:white;
    font-size:11px; font-weight:700;
    display:flex; align-items:center; justify-content:center;
    flex-shrink:0;
  }
  .section-title{ font-size:13px; font-weight:700; color:#1a2e22; letter-spacing:.01em; }

  /* ── Searchable dropdown ── */
  .fam-dropdown{ display:none; }
  .fam-dropdown.open{ display:block; }

  /* ── Slide-in animation ── */
  @keyframes slide-up{
    from{ opacity:0; transform:translateY(12px); }
    to{ opacity:1; transform:translateY(0); }
  }
  .slide-up{ animation:slide-up .3s ease both; }

  /* ── Toast ── */
  #toast-custom{
    position:fixed; bottom:28px; left:50%; transform:translateX(-50%) translateY(20px);
    background:#2c5926; color:white; padding:12px 24px; border-radius:999px;
    font-size:13.5px; font-weight:600; display:flex; align-items:center; gap:8px;
    opacity:0; pointer-events:none; transition:opacity .25s, transform .25s; z-index:999;
  }
  #toast-custom.show{ opacity:1; transform:translateX(-50%) translateY(0); }
</style>
@endpush

@section('header')
<header class="h-14 bg-white border-b border-slate-100 flex items-center justify-between px-6 shrink-0">
  <div class="flex items-center gap-3">
    <a href="{{ route('nursery.inventory.index') }}" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
      <span class="material-symbols-outlined mat text-[20px]">arrow_back</span>
    </a>
    <div>
      <p class="text-[11px] text-slate-400 font-medium leading-none mb-0.5">My Plants</p>
      <h1 class="text-sm font-bold leading-none">Add New Plant</h1>
    </div>
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
        <div class="w-9 h-9 rounded-full bg-cover bg-center border border-slate-200" style="background-image: url('{{ auth()->user()->profile_img }}')"></div>
      @else
        <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200 text-primary font-bold">
            {{ substr(auth()->user()->name, 0, 1) }}
        </div>
      @endif
    </div>
  </div>
</header>
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-6 py-8">
  <form id="plant-form" onsubmit="handleSubmit(event)" novalidate>
    @csrf
    <div class="space-y-6">

      <div class="bg-white rounded-2xl border border-slate-100 p-6 slide-up relative z-20" style="animation-delay:.05s">
        <div class="section-head">
          <div class="section-num">1</div>
          <span class="section-title">Plant Identity</span>
          <div class="section-head-line"></div>
        </div>

        <div class="grid grid-cols-2 gap-4 max-w-xl">
          <div class="flex flex-col gap-1.5" id="family-wrap">
            <label class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Plant Family <span class="text-red-400">*</span></label>
            <div class="relative">
              <svg class="ico-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22V12M12 12C8 12 4 9 4 4a8 8 0 0116 0c0 5-4 8-8 8z"/></svg>
              <input id="family-input" type="text" placeholder="Search family…" autocomplete="off"
                class="field-input field-input-icon"
                onfocus="openFamDrop(true)" oninput="filterFam()" required/>
              <span class="material-symbols-outlined mat absolute right-3 top-1/2 -translate-y-1/2 text-[16px] text-slate-300 pointer-events-none">expand_more</span>
            </div>
            <div id="fam-drop" class="fam-dropdown absolute w-full mt-1 z-30 bg-white border border-slate-100 rounded-xl shadow-xl overflow-hidden">
              <div class="max-h-48 overflow-y-auto py-1" id="fam-list"></div>
            </div>
            <input type="hidden" id="family-value" name="family_id"/>
            <p class="err-msg text-[11px] text-red-500 hidden">Please select a family</p>
          </div>

          <div class="flex flex-col gap-1.5" id="name-wrap">
            <label class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Plant Name <span class="text-red-400">*</span></label>
            <div class="relative">
              <svg class="ico-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M7 20h10M12 4v16M4 8l8-4 8 4"/></svg>
              <input id="name-input" type="text" placeholder="Select plant name…" autocomplete="off"
                class="field-input field-input-icon"
                onfocus="openNameDrop(true)" oninput="filterName()" required/>
              <span class="material-symbols-outlined mat absolute right-3 top-1/2 -translate-y-1/2 text-[16px] text-slate-300 pointer-events-none">expand_more</span>
            </div>
            <div id="name-drop" class="fam-dropdown absolute w-full mt-1 z-30 bg-white border border-slate-100 rounded-xl shadow-xl overflow-hidden">
              <div class="max-h-48 overflow-y-auto py-1" id="name-list"></div>
            </div>
            <input type="hidden" id="name-value" name="plant_id"/>
            <p class="err-msg text-[11px] text-red-500 hidden">Please select a plant name</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-2xl border border-slate-100 p-6 slide-up relative z-10" style="animation-delay:.10s">
        <div class="section-head">
          <div class="section-num">2</div>
          <span class="section-title">Growth Stage</span>
          <div class="section-head-line"></div>
        </div>
        <p class="text-xs text-slate-400 mb-4">Select the current growth stage of the plants you're listing.</p>

        <div class="grid grid-cols-4 gap-3" id="stage-grid">
          <label class="stage-card">
            <input type="radio" name="growth_stage" value="seed"/>
            <div class="stage-inner">
              <div class="stage-icon">
                <span class="material-symbols-outlined matf text-[20px]" style="color:#9ab4a0">grain</span>
              </div>
              <div class="stage-label">Seed</div>
            </div>
          </label>
          <label class="stage-card">
            <input type="radio" name="growth_stage" value="seedling"/>
            <div class="stage-inner">
              <div class="stage-icon">
                <span class="material-symbols-outlined matf text-[20px]" style="color:#9ab4a0">sprout</span>
              </div>
              <div class="stage-label">Seedling</div>
            </div>
          </label>
          <label class="stage-card">
            <input type="radio" name="growth_stage" value="vegetative" checked/>
            <div class="stage-inner">
              <div class="stage-icon">
                <span class="material-symbols-outlined matf text-[20px]" style="color:#9ab4a0">potted_plant</span>
              </div>
              <div class="stage-label">Vegetative</div>
            </div>
          </label>
          <label class="stage-card">
            <input type="radio" name="growth_stage" value="mature"/>
            <div class="stage-inner">
              <div class="stage-icon">
                <span class="material-symbols-outlined matf text-[20px]" style="color:#9ab4a0">park</span>
              </div>
              <div class="stage-label">Mature</div>
            </div>
          </label>
        </div>
      </div>

      <div class="bg-white rounded-2xl border border-slate-100 p-6 slide-up" style="animation-delay:.15s">
        <div class="section-head">
          <div class="section-num">3</div>
          <span class="section-title">Stock & Pricing</span>
          <div class="section-head-line"></div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-5">
          <div class="flex flex-col gap-1.5">
            <label class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Units in Stock <span class="text-red-400">*</span></label>
            <div class="relative">
              <svg class="ico-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-4 0v2M8 7V5a2 2 0 00-4 0v2"/></svg>
              <input id="units" type="number" name="stock_units" min="0" placeholder="e.g. 42"
                class="field-input field-input-icon" required oninput="autoStatus()"/>
            </div>
            <p class="err-msg text-[11px] text-red-500 hidden">Please enter units in stock</p>
          </div>
          <div class="flex flex-col gap-1.5">
            <label class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Price <span class="ml-1 text-slate-300 font-normal normal-case tracking-normal">(optional)</span></label>
            <div class="relative flex items-center">
              <svg class="ico-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><path d="M15 8.5a4 4 0 00-6 0c-1.5 2-.5 4 1 5l2 1c1.5 1 2.5 3 1 5a4 4 0 01-6 0"/><line x1="12" y1="6" x2="12" y2="7"/><line x1="12" y1="17" x2="12" y2="18"/></svg>
              <input id="price" type="number" name="price" min="0" step="0.01" placeholder="250"
                class="field-input field-input-icon pr-14"/>
              <span class="absolute right-4 text-xs font-semibold text-slate-400 pointer-events-none">MAD</span>
            </div>
          </div>
        </div>

        <div class="flex flex-col gap-2">
          <label class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Stock Status <span class="text-red-400">*</span></label>
          <div class="flex gap-2 flex-wrap" id="status-pills">
            <label class="status-pill available">
              <input type="radio" name="stock_status" value="available" checked/>
              <div class="pill-inner">
                <span class="w-2 h-2 rounded-full bg-green-500 shrink-0"></span> Available
              </div>
            </label>
            <label class="status-pill low">
              <input type="radio" name="stock_status" value="low"/>
              <div class="pill-inner">
                <span class="w-2 h-2 rounded-full bg-orange-400 shrink-0"></span> Low Stock
              </div>
            </label>
            <label class="status-pill out">
              <input type="radio" name="stock_status" value="out"/>
              <div class="pill-inner">
                <span class="w-2 h-2 rounded-full bg-red-500 shrink-0"></span> Out of Stock
              </div>
            </label>
          </div>
          <p id="status-hint" class="text-[11px] text-slate-400 hidden flex items-center gap-1">
            <span class="material-symbols-outlined mat text-[13px]">tips_and_updates</span>
            <span id="status-hint-text"></span>
          </p>
        </div>
      </div>

      <div class="bg-white rounded-2xl border border-slate-100 p-6 slide-up" style="animation-delay:.20s">
        <div class="section-head">
          <div class="section-num">4</div>
          <span class="section-title">Plant Photo</span>
          <div class="section-head-line"></div>
        </div>
        <div id="drop-zone"
          class="border-2 border-dashed border-slate-200 rounded-xl relative overflow-hidden cursor-pointer"
          onclick="document.getElementById('photo-input').click()"
          ondragover="e=>{e.preventDefault();this.classList.add('drag-over')}"
          ondragleave="this.classList.remove('drag-over')"
          ondrop="handleDrop(event)">
          <div id="drop-empty" class="flex flex-col items-center justify-center py-10 gap-3">
            <div class="w-14 h-14 rounded-2xl bg-bg-page flex items-center justify-center">
              <span class="material-symbols-outlined mat text-[28px] text-slate-300">add_photo_alternate</span>
            </div>
            <div class="text-center">
              <p class="text-sm font-semibold text-slate-600">Drop your photo here</p>
              <p class="text-xs text-slate-400 mt-0.5">or <span class="text-primary font-semibold">click to browse</span> · PNG, JPG, WEBP up to 10MB</p>
            </div>
          </div>
          <div id="drop-preview" class="hidden relative">
            <img id="preview-img" src="" alt="preview" class="w-full h-56 object-cover"/>
            <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
              <p class="text-white text-sm font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined mat text-[18px]">edit</span>Change photo
              </p>
            </div>
            <button type="button" onclick="removePhoto(event)"
              class="absolute top-3 right-3 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow text-slate-500 hover:text-red-500 transition-colors">
              <span class="material-symbols-outlined mat text-[17px]">close</span>
            </button>
          </div>
        </div>
        <input type="file" id="photo-input" name="plant_photo" accept="image/*" class="hidden" onchange="handlePhoto(event)"/>
      </div>

      <div class="bg-white rounded-2xl border border-slate-100 p-6 slide-up" style="animation-delay:.25s">
        <div class="section-head">
          <div class="section-num">5</div>
          <span class="section-title">Description</span>
          <div class="section-head-line"></div>
          <span class="text-[11px] text-slate-300 font-medium ml-1">optional</span>
        </div>
        <div class="relative mt-2">
          <textarea id="description" name="description" rows="5"
            placeholder="Describe what makes this plant special...at your nursery"
            class="field-input resize-none pr-16" oninput="updateCharCount()"></textarea>
          <span class="absolute bottom-3 right-3 text-[11px] text-slate-300 font-medium" id="char-count">0/500</span>
        </div>
      </div>

      <div class="flex items-center justify-between pb-4 slide-up" style="animation-delay:.30s">
        <button type="button" onclick="resetForm()" class="text-slate-500 text-sm font-medium px-5 py-2.5 rounded-xl hover:bg-white hover:border hover:border-slate-200 transition-all flex items-center gap-2">
          <span class="material-symbols-outlined mat text-[17px]">refresh</span>Reset form
        </button>
        <div class="flex items-center gap-3">
          <button type="submit" id="submit-btn"
            class="bg-primary text-white text-sm font-semibold px-8 py-2.5 rounded-xl hover:bg-primary-hover transition-colors flex items-center gap-2 shadow-sm shadow-primary/20">
            <span class="material-symbols-outlined mat text-[18px]">check_circle</span> Publish Plant
          </button>
        </div>
      </div>
    </div>
  </form>
</div>

<div id="toast-custom">
  <span class="material-symbols-outlined matf text-[18px]">check_circle</span>
  Plant published successfully!
</div>
@endsection

@push('scripts')
<script>
/* ── DATA — from database ── */
const families = @json($families);
const plants = @json($plants);

/* ── FAMILY SEARCHABLE DROPDOWN ── */
let selectedFamId = null;

function buildFamList(query = "") {
  const list = document.getElementById('fam-list');
  const q = query.toLowerCase();
  const matches = families.filter(f => f.name.toLowerCase().includes(q));
  list.innerHTML = matches.length
    ? matches.map(f => `<div class="fam-opt px-3 py-2 text-sm text-slate-600 hover:bg-primary-light hover:text-primary cursor-pointer rounded-lg mx-1" onclick="pickFam(${f.id}, '${f.name.replace(/'/g, "\\'")}')">${f.name}</div>`).join('')
    : `<div class="px-3 py-2 text-sm text-slate-400">No results</div>`;
}

function openFamDrop(isClick = false) {
  document.getElementById('fam-drop').classList.add('open');
  const query = isClick ? "" : document.getElementById('family-input').value;
  buildFamList(query);
}

function filterFam() {
  buildFamList(document.getElementById('family-input').value);
  selectedFamId = null;
  document.getElementById('family-value').value = "";
}

function pickFam(id, name, isAuto = false) {
  selectedFamId = id;
  document.getElementById('family-input').value = name;
  document.getElementById('family-value').value = id;
  document.getElementById('fam-drop').classList.remove('open');
  clearErr(document.getElementById('family-input'));
  
  // If picked manually, ALWAYS clear the plant name
  if(!isAuto) {
    document.getElementById('name-input').value = '';
    document.getElementById('name-value').value = '';
  }
}

/* ── PLANT NAME SEARCHABLE DROPDOWN ── */
function buildNameList(query = "") {
  const list = document.getElementById('name-list');
  const q = query.toLowerCase();
  
  // Filter by family if selected, then by query
  let matches = plants;
  if (selectedFamId) {
    matches = matches.filter(p => p.family_id == selectedFamId);
  }
  matches = matches.filter(p => p.name.toLowerCase().includes(q));

  list.innerHTML = matches.length
    ? matches.map(p => `<div class="fam-opt px-3 py-2 text-sm text-slate-600 hover:bg-primary-light hover:text-primary cursor-pointer rounded-lg mx-1" onclick="pickName(${p.id}, '${p.name.replace(/'/g, "\\'")}', ${p.family_id}, '${p.family.name.replace(/'/g, "\\'")}')">${p.name}</div>`).join('')
    : `<div class="px-3 py-2 text-sm text-slate-400">No results</div>`;
}

function openNameDrop(isClick = false) {
  document.getElementById('name-drop').classList.add('open');
  const query = isClick ? "" : document.getElementById('name-input').value;
  buildNameList(query);
}

function filterName() {
  buildNameList(document.getElementById('name-input').value);
  document.getElementById('name-value').value = "";
}

function pickName(id, name, famId, famName) {
  document.getElementById('name-input').value = name;
  document.getElementById('name-value').value = id;
  document.getElementById('name-drop').classList.remove('open');
  clearErr(document.getElementById('name-input'));

  // Logic: Auto-select family if not already correct (pass isAuto = true)
  if (selectedFamId != famId) {
    pickFam(famId, famName, true);
  }
}

document.addEventListener('click', e => {
  if (!document.getElementById('family-wrap').contains(e.target))
    document.getElementById('fam-drop').classList.remove('open');
  if (!document.getElementById('name-wrap').contains(e.target))
    document.getElementById('name-drop').classList.remove('open');
});

/* ── AUTO STATUS FROM UNITS ── */
function autoStatus() {
  const val = parseInt(document.getElementById('units').value);
  const hint = document.getElementById('status-hint');
  const hintText = document.getElementById('status-hint-text');
  if (isNaN(val)) { hint.classList.add('hidden'); return; }
  hint.classList.remove('hidden');
  if (val === 0) {
    pickStatus('out');
    hintText.textContent = 'Auto-set to Out of Stock (0 units)';
  } else if (val <= 5) {
    pickStatus('low');
    hintText.textContent = `Auto-set to Low Stock (≤5 units)`;
  } else {
    pickStatus('available');
    hintText.textContent = `Auto-set to Available (${val} units)`;
  }
}

function pickStatus(val) {
  document.querySelectorAll('[name="stock_status"]').forEach(r => r.checked = r.value === val);
}

/* ── PHOTO HANDLING ── */
function handlePhoto(e) {
  const file = e.target.files[0];
  if (file) showPreview(file);
}

function handleDrop(e) {
  e.preventDefault();
  document.getElementById('drop-zone').classList.remove('drag-over');
  const file = e.dataTransfer.files[0];
  if (file && file.type.startsWith('image/')) showPreview(file);
}

function showPreview(file) {
  const url = URL.createObjectURL(file);
  document.getElementById('preview-img').src = url;
  document.getElementById('drop-empty').classList.add('hidden');
  document.getElementById('drop-preview').classList.remove('hidden');
}

function removePhoto(e) {
  e.stopPropagation();
  document.getElementById('preview-img').src = '';
  document.getElementById('drop-empty').classList.remove('hidden');
  document.getElementById('drop-preview').classList.add('hidden');
  document.getElementById('photo-input').value = '';
}

/* ── DESCRIPTION CHAR COUNT ── */
function updateCharCount() {
  const ta = document.getElementById('description');
  const len = ta.value.length;
  if (len > 500) ta.value = ta.value.slice(0, 500);
  document.getElementById('char-count').textContent = `${Math.min(len,500)}/500`;
}

/* ── VALIDATION & SUBMIT ── */
function showErr(el, msg) {
  el.style.borderColor = '#ef4444';
  el.style.boxShadow = '0 0 0 3px rgba(239,68,68,.1)';
  const errEl = el.closest('.flex') ? el.closest('.flex').nextElementSibling : null;
  if (errEl && errEl.classList.contains('err-msg')) errEl.classList.remove('hidden');
}
function clearErr(el) {
  el.style.borderColor = '';
  el.style.boxShadow = '';
  const errEl = el.closest('.flex') ? el.closest('.flex').nextElementSibling : null;
  if (errEl && errEl.classList.contains('err-msg')) errEl.classList.add('hidden');
}

function handleSubmit(e) {
  e.preventDefault();
  let valid = true;

  const famVal = document.getElementById('family-value').value;
  const famInput = document.getElementById('family-input');
  if (!famVal) { showErr(famInput, 'required'); valid = false; }

  const nameVal = document.getElementById('name-value').value;
  const nameInput = document.getElementById('name-input');
  if (!nameVal) { showErr(nameInput, 'required'); valid = false; }

  const units = document.getElementById('units').value;
  const unitsInput = document.getElementById('units');
  if (units === '' || units < 0) { showErr(unitsInput, 'required'); valid = false; }

  if (!valid) return;

  const btn = document.getElementById('submit-btn');
  btn.innerHTML = `<span class="material-symbols-outlined mat text-[18px]">hourglass_top</span> Publishing…`;
  btn.disabled = true;

  setTimeout(() => {
    btn.innerHTML = `<span class="material-symbols-outlined matf text-[18px]">check_circle</span> Published!`;
    showToast();
    setTimeout(() => {
      btn.innerHTML = `<span class="material-symbols-outlined mat text-[18px]">check_circle</span> Publish Plant`;
      btn.disabled = false;
      resetForm();
    }, 3000);
  }, 1200);
}

function showToast() {
  const t = document.getElementById('toast-custom');
  if(t) {
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3500);
  }
}

function resetForm() {
  document.getElementById('plant-form').reset();
  document.getElementById('family-input').value = '';
  document.getElementById('family-value').value = '';
  selectedFamId = null;
  document.getElementById('name-input').value = '';
  document.getElementById('name-value').value = '';
  removePhoto({stopPropagation:()=>{}});
  document.getElementById('char-count').textContent = '0/500';
  document.getElementById('status-hint').classList.add('hidden');
}

/* init */
setTimeout(() => buildFamList(), 100);
</script>
@endpush
