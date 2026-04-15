@extends('layouts.nursery')

@section('title', 'Edit Nursery Profile - Chatla')

@push('styles')
<style>
  /* Toggle switch */
  .toggle-input:checked + .toggle-track { background-color: #2c5926; }
  .toggle-input:checked + .toggle-track .toggle-thumb { transform: translateX(20px); }

  /* Time input styling */
  input[type="time"]::-webkit-calendar-picker-indicator { opacity: 0.4; cursor: pointer; }
</style>
@endpush

@section('header')
<header class="h-14 bg-white border-b border-slate-100 flex items-center justify-between px-6 shrink-0">
  <h1 class="text-base font-bold">Edit Nursery Profile</h1>
  <div class="flex items-center gap-3">
    <button class="text-slate-400 hover:text-primary transition-colors p-1.5 relative">
      <span class="material-symbols-outlined mat text-[22px]">notifications</span>
      <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
    </button>
    <button type="submit" form="nursery-profile-form" class="bg-primary text-white px-5 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition-opacity">
      Save Changes
    </button>
  </div>
</header>
@endsection

@section('content')
      <div class="max-w-3xl mx-auto px-6 py-8 space-y-6">

        @if (session('status') === 'profile-updated')
            <div class="bg-green-50 text-green-700 p-4 rounded-lg text-sm font-semibold border border-green-200">
                Profile successfully updated.
            </div>
        @endif

        <form id="nursery-profile-form" action="{{ route('nursery.profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="mb-6">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Nursery Identity</h2>
            <div class="bg-white rounded-xl border border-slate-100 p-6">
              <div class="flex items-center gap-6 mb-6 pb-6 border-b border-slate-100">
                <div class="relative shrink-0">
                  <div class="w-20 h-20 rounded-xl border-2 border-slate-100 overflow-hidden bg-background-light" id="nursery-logo-wrapper">
                    <img id="nursery-logo-preview" class="w-full h-full object-cover"
                      src="{{ auth()->user()->nursery->profile_img ? asset('storage/' . auth()->user()->nursery->profile_img) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuBsywabFjZ3elNUFFgdRgwJOJrq9hz1adle7vsO2UBxT6EIFZI2Hv2hzjdS_u4WfH_z3yJVssMzrT_a_yzTYJBV7efG9hUpCjuXjYzgnWv4N_zuvKSVZX105SOdIGUnPaIjXv3UYYZ-gKzAyHAKzbhHKai6zBsAoj35bRxaivbmchjRTO3UmNO5v8sAAlf79LNnMHI4LchgLHGtz4V04aA3n4un6P_bvWjLmCoLCEcOqVcKTMet2C3HKy_JO-WUvepVUowzvZyHVmY' }}"
                      alt="Nursery logo"/>
                  </div>
                  <label class="absolute -bottom-2 -right-2 w-7 h-7 bg-primary text-white rounded-full flex items-center justify-center border-2 border-white cursor-pointer shadow">
                    <span class="material-symbols-outlined mat text-[14px]">photo_camera</span>
                    <input type="file" name="profile_img" accept="image/*" class="hidden" id="nursery-logo-input" onchange="previewNurseryLogo(event)"/>
                  </label>
                </div>
                <div>
                  <p class="font-semibold text-sm">Nursery Logo</p>
                  <p class="text-xs text-slate-400 mt-0.5 mb-3">PNG or JPG · Recommended 256×256px</p>
                  <div class="flex gap-2">
                    <label class="cursor-pointer px-3 py-1.5 bg-primary/10 text-primary text-xs font-semibold rounded-lg hover:bg-primary/20 transition-colors">
                      Change Logo
                      <input type="file" name="profile_img" accept="image/*" class="hidden" onchange="previewNurseryLogo(event)"/>
                    </label>
                  </div>
                  @error('profile_img') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1.5">
                  <label class="text-xs font-semibold text-slate-600">Nursery Name</label>
                  <div class="relative">
                    <span class="material-symbols-outlined mat absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">storefront</span>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->nursery->name ?? '') }}"
                      class="w-full pl-10 pr-3 py-2.5 bg-background-light border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/30 outline-none"/>
                  </div>
                  @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                  <label class="text-xs font-semibold text-slate-600">City</label>
                  <div class="relative">
                    <span class="material-symbols-outlined mat absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">location_city</span>
                    <select name="city_id" class="w-full pl-10 pr-3 py-2.5 bg-background-light border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/30 outline-none appearance-none">
                      @foreach($cities ?? [] as $city)
                          <option value="{{ $city->id }}" {{ old('city_id', auth()->user()->nursery->city_id) == $city->id ? 'selected' : '' }}>
                              {{ $city->name }}
                          </option>
                      @endforeach
                    </select>
                  </div>
                  @error('city_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5 col-span-2">
                  <label class="text-xs font-semibold text-slate-600">Street Address</label>
                  <div class="relative">
                    <span class="material-symbols-outlined mat absolute left-3 top-2.5 text-slate-400 text-[18px]">location_on</span>
                    <textarea name="address" rows="2"
                      class="w-full pl-10 pr-3 py-2.5 bg-background-light border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/30 outline-none resize-none">{{ old('address', auth()->user()->nursery->address ?? '') }}</textarea>
                  </div>
                  @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5 col-span-2">
                  <label class="text-xs font-semibold text-slate-600">Website Link (Optional)</label>
                  <div class="relative">
                    <span class="material-symbols-outlined mat absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">language</span>
                    <input type="url" name="website" value="{{ old('website', auth()->user()->nursery->website ?? '') }}" placeholder="https://www.yournursery.com"
                      class="w-full pl-10 pr-3 py-2.5 bg-background-light border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/30 outline-none placeholder:text-slate-400"/>
                  </div>
                  @error('website') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                  <label class="text-xs font-semibold text-slate-600">Phone Number</label>
                  <div class="relative">
                    <span class="material-symbols-outlined mat absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">call</span>
                    <input type="tel" name="phone" value="{{ old('phone', auth()->user()->nursery->phone ?? '') }}"
                      class="w-full pl-10 pr-3 py-2.5 bg-background-light border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/30 outline-none"/>
                  </div>
                  @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                  <label class="text-xs font-semibold text-slate-600">Contact Email Address</label>
                  <div class="relative">
                    <span class="material-symbols-outlined mat absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">mail</span>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                      class="w-full pl-10 pr-3 py-2.5 bg-background-light border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/30 outline-none"/>
                  </div>
                  @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
              </div>
            </div>
          </div>

          <div class="mb-6">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Owner Profile</h2>
            <div class="bg-white rounded-xl border border-slate-100 p-6">
              <div class="flex items-center gap-6 mb-5">
                <!-- Owner avatar -->
                <div class="relative shrink-0">
                  <div class="w-16 h-16 rounded-full border-2 border-slate-100 overflow-hidden bg-background-light" id="owner-avatar-wrapper">
                    @if(auth()->user()->profile_img)
                      <img id="owner-avatar-preview" src="{{ asset('storage/' . auth()->user()->profile_img) }}" alt="Owner Photo" class="w-full h-full object-cover"/>
                    @else
                      <div id="owner-avatar-preview" class="w-full h-full bg-primary/20 bg-cover bg-center flex items-center justify-center">
                        <span class="material-symbols-outlined mat-fill text-primary/60 text-[32px]">person</span>
                      </div>
                    @endif
                  </div>
                  <label class="absolute -bottom-1 -right-1 w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center border-2 border-white cursor-pointer shadow">
                    <span class="material-symbols-outlined mat text-[12px]">photo_camera</span>
                    <input type="file" name="owner_profile_img" accept="image/*" class="hidden" id="owner-photo-input" onchange="previewOwnerPhoto(event)"/>
                  </label>
                </div>
                <div>
                  <p class="font-semibold text-sm">Owner Photo</p>
                  <p class="text-xs text-slate-400 mt-0.5 mb-2">Visible on your public nursery profile</p>
                  <label class="cursor-pointer px-3 py-1.5 bg-primary/10 text-primary text-xs font-semibold rounded-lg hover:bg-primary/20 transition-colors">
                    Upload Photo
                    <input type="file" name="owner_profile_img" accept="image/*" class="hidden" onchange="previewOwnerPhoto(event)"/>
                  </label>
                  @error('owner_profile_img') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1.5 col-span-2">
                  <label class="text-xs font-semibold text-slate-600">Owner Name</label>
                  <div class="relative">
                    <span class="material-symbols-outlined mat absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">person</span>
                    <input type="text" name="owner_name" value="{{ old('owner_name', auth()->user()->name ?? '') }}"
                      class="w-full pl-10 pr-3 py-2.5 bg-background-light border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/30 outline-none"/>
                  </div>
                  @error('owner_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
              </div>
            </div>
          </div>

          <div class="mb-6">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Operating Hours</h2>
            <div class="bg-white rounded-xl border border-slate-100 p-6">
              <p class="text-xs text-slate-400 mb-4">Toggle each day on/off, then set opening and closing times. This is saved as a single formatted string.</p>

              <div class="space-y-2" id="hours-rows">

                <div class="day-row flex items-center gap-3 py-2 px-3 rounded-lg hover:bg-slate-50 transition-colors" data-day="Mon">
                  <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="toggle-input sr-only" onchange="toggleDay(this)"/>
                    <div class="toggle-track w-10 h-5 bg-slate-200 rounded-full transition-colors duration-200 flex items-center px-0.5">
                      <div class="toggle-thumb w-4 h-4 bg-white rounded-full shadow transition-transform duration-200"></div>
                    </div>
                  </label>
                  <span class="w-8 text-sm font-semibold text-slate-400">Mon</span>
                  <div class="time-fields flex items-center gap-2 flex-1 opacity-30 pointer-events-none">
                    <input type="time" value="08:00" disabled class="bg-background-light border-none rounded-lg px-3 py-1.5 text-sm font-medium focus:ring-2 focus:ring-primary/30 outline-none"/>
                    <span class="text-slate-300 text-sm">—</span>
                    <input type="time" value="18:00" disabled class="bg-background-light border-none rounded-lg px-3 py-1.5 text-sm font-medium focus:ring-2 focus:ring-primary/30 outline-none"/>
                  </div>
                  <span class="text-xs text-slate-400 w-28 text-right day-preview">Closed</span>
                </div>

                <div class="day-row flex items-center gap-3 py-2 px-3 rounded-lg hover:bg-slate-50 transition-colors" data-day="Tue">
                  <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="toggle-input sr-only" onchange="toggleDay(this)"/>
                    <div class="toggle-track w-10 h-5 bg-slate-200 rounded-full transition-colors duration-200 flex items-center px-0.5">
                      <div class="toggle-thumb w-4 h-4 bg-white rounded-full shadow transition-transform duration-200"></div>
                    </div>
                  </label>
                  <span class="w-8 text-sm font-semibold text-slate-400">Tue</span>
                  <div class="time-fields flex items-center gap-2 flex-1 opacity-30 pointer-events-none">
                    <input type="time" value="08:00" disabled class="bg-background-light border-none rounded-lg px-3 py-1.5 text-sm font-medium focus:ring-2 focus:ring-primary/30 outline-none"/>
                    <span class="text-slate-300 text-sm">—</span>
                    <input type="time" value="18:00" disabled class="bg-background-light border-none rounded-lg px-3 py-1.5 text-sm font-medium focus:ring-2 focus:ring-primary/30 outline-none"/>
                  </div>
                  <span class="text-xs text-slate-400 w-28 text-right day-preview">Closed</span>
                </div>

                <div class="day-row flex items-center gap-3 py-2 px-3 rounded-lg hover:bg-slate-50 transition-colors" data-day="Wed">
                  <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="toggle-input sr-only" onchange="toggleDay(this)"/>
                    <div class="toggle-track w-10 h-5 bg-slate-200 rounded-full transition-colors duration-200 flex items-center px-0.5">
                      <div class="toggle-thumb w-4 h-4 bg-white rounded-full shadow transition-transform duration-200"></div>
                    </div>
                  </label>
                  <span class="w-8 text-sm font-semibold text-slate-400">Wed</span>
                  <div class="time-fields flex items-center gap-2 flex-1 opacity-30 pointer-events-none">
                    <input type="time" value="08:00" disabled class="bg-background-light border-none rounded-lg px-3 py-1.5 text-sm font-medium focus:ring-2 focus:ring-primary/30 outline-none"/>
                    <span class="text-slate-300 text-sm">—</span>
                    <input type="time" value="18:00" disabled class="bg-background-light border-none rounded-lg px-3 py-1.5 text-sm font-medium focus:ring-2 focus:ring-primary/30 outline-none"/>
                  </div>
                  <span class="text-xs text-slate-400 w-28 text-right day-preview">Closed</span>
                </div>

                <div class="day-row flex items-center gap-3 py-2 px-3 rounded-lg hover:bg-slate-50 transition-colors" data-day="Thu">
                  <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="toggle-input sr-only" onchange="toggleDay(this)"/>
                    <div class="toggle-track w-10 h-5 bg-slate-200 rounded-full transition-colors duration-200 flex items-center px-0.5">
                      <div class="toggle-thumb w-4 h-4 bg-white rounded-full shadow transition-transform duration-200"></div>
                    </div>
                  </label>
                  <span class="w-8 text-sm font-semibold text-slate-400">Thu</span>
                  <div class="time-fields flex items-center gap-2 flex-1 opacity-30 pointer-events-none">
                    <input type="time" value="08:00" disabled class="bg-background-light border-none rounded-lg px-3 py-1.5 text-sm font-medium focus:ring-2 focus:ring-primary/30 outline-none"/>
                    <span class="text-slate-300 text-sm">—</span>
                    <input type="time" value="18:00" disabled class="bg-background-light border-none rounded-lg px-3 py-1.5 text-sm font-medium focus:ring-2 focus:ring-primary/30 outline-none"/>
                  </div>
                  <span class="text-xs text-slate-400 w-28 text-right day-preview">Closed</span>
                </div>

                <div class="day-row flex items-center gap-3 py-2 px-3 rounded-lg hover:bg-slate-50 transition-colors" data-day="Fri">
                  <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="toggle-input sr-only" onchange="toggleDay(this)"/>
                    <div class="toggle-track w-10 h-5 bg-slate-200 rounded-full transition-colors duration-200 flex items-center px-0.5">
                      <div class="toggle-thumb w-4 h-4 bg-white rounded-full shadow transition-transform duration-200"></div>
                    </div>
                  </label>
                  <span class="w-8 text-sm font-semibold text-slate-400">Fri</span>
                  <div class="time-fields flex items-center gap-2 flex-1 opacity-30 pointer-events-none">
                    <input type="time" value="08:00" disabled class="bg-background-light border-none rounded-lg px-3 py-1.5 text-sm font-medium focus:ring-2 focus:ring-primary/30 outline-none"/>
                    <span class="text-slate-300 text-sm">—</span>
                    <input type="time" value="18:00" disabled class="bg-background-light border-none rounded-lg px-3 py-1.5 text-sm font-medium focus:ring-2 focus:ring-primary/30 outline-none"/>
                  </div>
                  <span class="text-xs text-slate-400 w-28 text-right day-preview">Closed</span>
                </div>

                <div class="day-row flex items-center gap-3 py-2 px-3 rounded-lg hover:bg-slate-50 transition-colors" data-day="Sat">
                  <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="toggle-input sr-only" onchange="toggleDay(this)"/>
                    <div class="toggle-track w-10 h-5 bg-slate-200 rounded-full transition-colors duration-200 flex items-center px-0.5">
                      <div class="toggle-thumb w-4 h-4 bg-white rounded-full shadow transition-transform duration-200"></div>
                    </div>
                  </label>
                  <span class="w-8 text-sm font-semibold text-slate-400">Sat</span>
                  <div class="time-fields flex items-center gap-2 flex-1 opacity-30 pointer-events-none">
                    <input type="time" value="08:00" disabled class="bg-background-light border-none rounded-lg px-3 py-1.5 text-sm font-medium focus:ring-2 focus:ring-primary/30 outline-none"/>
                    <span class="text-slate-300 text-sm">—</span>
                    <input type="time" value="18:00" disabled class="bg-background-light border-none rounded-lg px-3 py-1.5 text-sm font-medium focus:ring-2 focus:ring-primary/30 outline-none"/>
                  </div>
                  <span class="text-xs text-slate-400 w-28 text-right day-preview">Closed</span>
                </div>

                <div class="day-row flex items-center gap-3 py-2 px-3 rounded-lg hover:bg-slate-50 transition-colors" data-day="Sun">
                  <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="toggle-input sr-only" onchange="toggleDay(this)"/>
                    <div class="toggle-track w-10 h-5 bg-slate-200 rounded-full transition-colors duration-200 flex items-center px-0.5">
                      <div class="toggle-thumb w-4 h-4 bg-white rounded-full shadow transition-transform duration-200"></div>
                    </div>
                  </label>
                  <span class="w-8 text-sm font-semibold text-slate-400">Sun</span>
                  <div class="time-fields flex items-center gap-2 flex-1 opacity-30 pointer-events-none">
                    <input type="time" value="08:00" disabled class="bg-background-light border-none rounded-lg px-3 py-1.5 text-sm font-medium focus:ring-2 focus:ring-primary/30 outline-none"/>
                    <span class="text-slate-300 text-sm">—</span>
                    <input type="time" value="18:00" disabled class="bg-background-light border-none rounded-lg px-3 py-1.5 text-sm font-medium focus:ring-2 focus:ring-primary/30 outline-none"/>
                  </div>
                  <span class="text-xs text-slate-400 w-28 text-right day-preview">Closed</span>
                </div>

              </div>

              <div class="mt-5 pt-4 border-t border-slate-100">
                <div class="flex items-start gap-3 bg-primary/5 rounded-lg px-4 py-3">
                  <span class="material-symbols-outlined mat-fill text-primary text-[18px] mt-0.5">info</span>
                  <div>
                    <p class="text-xs font-semibold text-slate-600 mb-1">Saved as text</p>
                    <p class="text-xs font-mono text-slate-500 leading-relaxed" id="hours-preview">No hours set</p>
                    
                    <input type="hidden" name="operating_hours" id="hours-value" value="{{ old('operating_hours', auth()->user()->nursery->operating_hours ?? '') }}"/>
                  </div>
                </div>
                @error('operating_hours') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          <!-- ── Location Map Preview ── -->
          <div class="mb-6">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Location Preview</h2>
            <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
              <div class="relative h-44">
                <div class="absolute inset-0 bg-cover bg-center opacity-50"
                  style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCA0oGZsMYjsEEYvMT2e85QC4gyCGr2v6rjybCjK8oDmQKX7jX-3ezwHHaMjHeVEUc4EgPy1_ecArCmrhHmxf-AaQTy_d0SJY7Mp7ZUgaIhsT-HBq52GeidWA1qsXdNVZmP9UmZROM3C1ciDpgQUS18F3NzrpZytpsj3kV8hslowTiC1DmhWPgzKFuv5EKhpzbFabrbCTJEhoJ6Unm4I28MRAK9PLAa-4VaKwcXvmTdHAEmcaR9CEApt3L-fX-FQhz5EBhk4DO80KE')">
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                  <div class="p-3 bg-white rounded-full shadow-lg">
                    <span class="material-symbols-outlined mat-fill text-primary text-[28px]">location_on</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          //  save&cancel buttons
          <div class="flex items-center justify-end gap-3 py-2">
            <a href="{{ route('dashboard') }}" class="text-slate-500 text-sm font-medium px-4 py-2 rounded-lg hover:bg-slate-100 transition-colors">Discard changes</a>
            <button type="submit" class="bg-primary text-white px-8 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition-opacity shadow-sm">Save Profile</button>
          </div>

        </form> </div>
    </main>
  </div>
</div>

@push('scripts')
<script>
/* ── Toggle day on/off ── */
function toggleDay(cb) {
  const row = cb.closest('.day-row');
  const timeFields = row.querySelector('.time-fields');
  const preview = row.querySelector('.day-preview');
  const label = row.querySelector('span.w-8');
  if (cb.checked) {
    timeFields.classList.remove('opacity-30','pointer-events-none');
    timeFields.querySelectorAll('input').forEach(i => i.disabled = false);
    label.classList.remove('text-slate-400');
    label.classList.add('text-slate-700');
    preview.textContent = formatTimeRange(row);
  } else {
    timeFields.classList.add('opacity-30','pointer-events-none');
    timeFields.querySelectorAll('input').forEach(i => i.disabled = true);
    label.classList.remove('text-slate-700');
    label.classList.add('text-slate-400');
    preview.textContent = 'Closed';
  }
  buildPreview();
}

/* ── Format 24h → 12h AM/PM ── */
function to12(val) {
  if (!val) return '';
  const [h, m] = val.split(':').map(Number);
  const ampm = h >= 12 ? 'PM' : 'AM';
  const h12 = h % 12 || 12;
  return `${String(h12).padStart(2,'0')}:${String(m).padStart(2,'0')} ${ampm}`;
}

function formatTimeRange(row) {
  const inputs = row.querySelectorAll('input[type="time"]');
  return `${to12(inputs[0].value)} - ${to12(inputs[1].value)}`;
}

/* ── Convert 12h AM/PM → 24h ── */
function from12(val) {
  if (!val) return '08:00';
  const parts = val.split(' ');
  if (parts.length < 2) return '08:00';
  const time = parts[0];
  const ampm = parts[1];
  let [h, m] = time.split(':').map(Number);
  if (ampm === 'PM' && h < 12) h += 12;
  if (ampm === 'AM' && h === 12) h = 0;
  return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
}

/* ── Live preview listeners ── */
document.querySelectorAll('.day-row input').forEach(input => {
  input.addEventListener('change', function() {
    const row = this.closest('.day-row');
    const cb = row.querySelector('.toggle-input');
    if (cb.checked) {
      row.querySelector('.day-preview').textContent = formatTimeRange(row);
    } else {
      row.querySelector('.day-preview').textContent = 'Closed';
    }
    buildPreview();
  });
});

/* ── Build the compact string saved in DB ── */
function buildPreview() {
  const rows = document.querySelectorAll('.day-row');
  const segments = [];
  let rangeStart = null, rangeDay = null, rangeOpen = null, rangeClose = null;

  function flush() {
    if (!rangeStart) return;
    const range = rangeStart === rangeDay ? rangeDay : `${rangeStart}-${rangeDay}`;
    segments.push(`${range}: ${rangeOpen} - ${rangeClose}`);
    rangeStart = null;
  }

  rows.forEach(row => {
    const cb = row.querySelector('.toggle-input');
    const day = row.dataset.day;
    if (cb.checked) {
      const inputs = row.querySelectorAll('input[type="time"]');
      const open = to12(inputs[0].value), close = to12(inputs[1].value);
      if (rangeStart && open === rangeOpen && close === rangeClose) {
        rangeDay = day;
      } else {
        flush();
        rangeStart = day; rangeDay = day; rangeOpen = open; rangeClose = close;
      }
    } else {
      flush();
    }
  });
  flush();

  const str = segments.join(' · ');
  document.getElementById('hours-preview').textContent = str || 'No hours set';
  document.getElementById('hours-value').value = str;
}

/* ── Parse saved string → UI ── */
function parseHours() {
  const savedVal = document.getElementById('hours-value').value;
  if (!savedVal || savedVal === 'Loading...' || savedVal === 'No hours set') return;

  const rows = document.querySelectorAll('.day-row');
  const dayNames = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

  // Reset UI to all closed first
  rows.forEach(row => {
    const cb = row.querySelector('.toggle-input');
    cb.checked = false;
    const timeFields = row.querySelector('.time-fields');
    timeFields.classList.add('opacity-30','pointer-events-none');
    timeFields.querySelectorAll('input').forEach(i => i.disabled = true);
    row.querySelector('span.w-8').className = 'w-8 text-sm font-semibold text-slate-400';
    row.querySelector('.day-preview').textContent = 'Closed';
  });

  const segments = savedVal.split(' · ');
  segments.forEach(segment => {
    const [daysPart, timesPart] = segment.split(': ');
    if (!timesPart) return;

    // Split times by hyphen
    const times = timesPart.split(' - ');
    if (times.length < 2) return;
    
    const open = times[0], close = times[1];
    const days = [];

    // Split range by hyphen
    if (daysPart.includes('-')) {
        const range = daysPart.split('-');
        const startIndex = dayNames.indexOf(range[0].trim());
        const endIndex = dayNames.indexOf(range[1].trim());
        if (startIndex !== -1 && endIndex !== -1) {
            for (let i = startIndex; i <= endIndex; i++) days.push(dayNames[i]);
        }
    } else {
        days.push(daysPart.trim());
    }

    days.forEach(day => {
        const row = Array.from(rows).find(r => r.dataset.day === day);
        if (row) {
            const cb = row.querySelector('.toggle-input');
            cb.checked = true;
            const inputs = row.querySelectorAll('input[type="time"]');
            inputs[0].value = from12(open);
            inputs[1].value = from12(close);
            
            // Visual update for the row
            const timeFields = row.querySelector('.time-fields');
            timeFields.classList.remove('opacity-30','pointer-events-none');
            timeFields.querySelectorAll('input').forEach(i => i.disabled = false);
            row.querySelector('span.w-8').className = 'w-8 text-sm font-semibold text-slate-700';
            row.querySelector('.day-preview').textContent = formatTimeRange(row);
        }
    });
  });
}

/* init */
parseHours();
buildPreview();

/* ── Owner photo preview ── */
function previewOwnerPhoto(event) {
  const file = event.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = function(e) {
    const wrapper = document.getElementById('owner-avatar-wrapper');
    // Replace whatever is inside the wrapper with a live <img>
    wrapper.innerHTML = `<img id="owner-avatar-preview" src="${e.target.result}" alt="Owner Photo" class="w-full h-full object-cover"/>`;
    // Also sync the hidden file input so the form submits correctly
    const mainInput = document.getElementById('owner-photo-input');
    const dt = new DataTransfer();
    dt.items.add(file);
    mainInput.files = dt.files;
  };
  reader.readAsDataURL(file);
}

/* ── Nursery logo preview ── */
function previewNurseryLogo(event) {
  const file = event.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = function(e) {
    const wrapper = document.getElementById('nursery-logo-wrapper');
    wrapper.innerHTML = `<img id="nursery-logo-preview" src="${e.target.result}" alt="Nursery Logo" class="w-full h-full object-cover"/>`;
    const mainInput = document.getElementById('nursery-logo-input');
    // If event isn't from the main input, sync it
    if(event.target.id !== 'nursery-logo-input') {
        const dt = new DataTransfer();
        dt.items.add(file);
        mainInput.files = dt.files;
    }
  };
  reader.readAsDataURL(file);
}
</script>
@endpush
@endsection
