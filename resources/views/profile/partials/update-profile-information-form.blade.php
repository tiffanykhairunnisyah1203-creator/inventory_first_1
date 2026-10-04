<section>
    <header class="mb-8 border-b border-gray-100 pb-5">
        <h2 class="text-2xl font-semibold text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-2 text-sm text-gray-500">
            {{ __("Perbarui informasi profil, username, dan foto akun Anda di bawah ini.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('patch')

        @php
            $previousUrl = url()->previous();
            if ($previousUrl == route('profile.edit') || $previousUrl == url()->current()) {
                $previousUrl = route('dashboard');
            }
        @endphp
        <input type="hidden" name="redirect_to" value="{{ old('redirect_to', $previousUrl) }}">

        {{-- 1. FOTO PROFIL (Dengan Preview & Tombol Hapus) --}}
        <div x-data="{ 
                photoPreview: null,
                hasPhoto: {{ (isset($user) && $user->avatar) ? 'true' : 'false' }},
                removeAvatar: false,
                updatePreview(event) {
                    const file = event.target.files[0];
                    if(!file) return;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.photoPreview = e.target.result;
                        this.hasPhoto = true;
                        this.removeAvatar = false;
                    };
                    reader.readAsDataURL(file);
                },
                deletePhoto() {
                    this.photoPreview = null;
                    this.hasPhoto = false;
                    this.removeAvatar = true;
                    document.getElementById('avatar').value = null; 
                }
            }" 
            class="bg-gray-50 p-6 rounded-lg border border-gray-200 flex items-center gap-x-6">
            
            {{-- Input tersembunyi untuk mengirim sinyal hapus ke backend --}}
            <input type="hidden" name="remove_avatar" x-bind:value="removeAvatar ? '1' : '0'">

            <div class="relative h-20 w-20 flex-shrink-0">
                <img x-show="hasPhoto" 
                     x-bind:src="photoPreview ? photoPreview : '{{ isset($user) && $user->avatar ? asset('storage/' . $user->avatar) : '' }}'" 
                     alt="Avatar" 
                     class="h-20 w-20 rounded-full object-cover ring-4 ring-white shadow-md"
                     style="display: none;">
                     
                <div x-show="!hasPhoto" 
                     class="h-20 w-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-2xl ring-4 ring-white shadow-md"
                     style="display: none;">
                    {{ substr($user->name ?? 'A', 0, 1) }}
                </div>
            </div>

            <div>
                <x-input-label for="avatar" :value="__('Foto Profil')" class="mb-2 block font-medium" />
                <div class="flex items-center gap-3">
                    <label for="avatar" class="cursor-pointer">
                        <span class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Pilih Foto
                        </span>
                        <input id="avatar" name="avatar" type="file" class="hidden" accept="image/*" x-on:change="updatePreview($event)">
                    </label>
                    
                    <button type="button" x-show="hasPhoto" x-on:click="deletePhoto()" class="text-sm text-red-500 hover:text-red-700 font-medium transition-colors" style="display: none;">
                        Hapus Foto
                    </button>
                </div>
                <p class="mt-2 text-xs text-gray-500">Maksimal ukuran file: 2MB. Format: JPG, PNG.</p>
                <x-input-error class="mt-2 text-red-500 text-sm" :messages="$errors->get('avatar')" />
            </div>
        </div>

        {{-- 2. INFORMASI DASAR --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" :value="old('name', $user->name ?? '')" required />
                <x-input-error class="mt-2 text-red-500 text-sm" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" :value="old('username', $user->username ?? '')" required />
                <x-input-error class="mt-2 text-red-500 text-sm" :messages="$errors->get('username')" />
            </div>
        </div>

        {{-- 3. KONTAK --}}
        <div>
            <x-input-label for="no_telepon" :value="__('Nomor WhatsApp / Telepon')" />
            <x-text-input id="no_telepon" name="no_telepon" type="text" class="mt-1 block w-full md:w-1/2 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" :value="old('no_telepon', $user->no_telepon ?? '')" placeholder="Contoh: 081234567890" />
            <x-input-error class="mt-2 text-red-500 text-sm" :messages="$errors->get('no_telepon')" />
        </div>
        
        <div class="pt-6 mt-6 border-t border-gray-200 flex items-center justify-end gap-4">
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm font-medium text-emerald-600">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Perubahan Disimpan.
                </p>
            @endif
            
            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-800 focus:bg-gray-800 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                {{ __('Simpan Perubahan') }}
            </button>
        </div>
    </form>
</section>