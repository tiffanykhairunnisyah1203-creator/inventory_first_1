<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informasi Profil & Keamanan') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Perbarui informasi profil dan password akun Anda.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        @php
            $previousUrl = url()->previous();
            if ($previousUrl == route('profile.edit') || $previousUrl == url()->current()) {
                $previousUrl = route('dashboard');
            }
        @endphp
        <input type="hidden" name="redirect_to" value="{{ old('redirect_to', $previousUrl) }}">

        {{-- Input Foto Profil --}}
        <div>
            <x-input-label for="avatar" :value="__('Foto Profil')" />
            
            <div class="mt-2 flex items-center gap-x-4">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="h-16 w-16 rounded-full object-cover ring-2 ring-gray-100">
                @else
                    <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xl ring-2 ring-gray-100">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif

                <label for="avatar" class="cursor-pointer">
                    <span class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        Pilih Foto Baru
                    </span>
                    <input id="avatar" name="avatar" type="file" class="hidden" accept="image/*" onchange="previewImage(this)">
                </label>
                
                <span id="file-chosen" class="text-sm text-gray-500 italic">Tidak ada file dipilih</span>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="no_telepon" :value="__('Nomor WhatsApp / Telepon')" />
            <x-text-input id="no_telepon" name="no_telepon" type="text" class="mt-1 block w-full" :value="old('no_telepon', $user->no_telepon)" placeholder="Contoh: 081234567890" />
            <x-input-error class="mt-2" :messages="$errors->get('no_telepon')" />
        </div>
        
        <hr class="my-8 border-gray-200 dark:border-gray-700"> 

        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Ubah Password') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Biarkan kosong jika Anda tidak ingin mengubah password saat ini.') }}
            </p>
        </header>

        <div>
            <x-input-label for="current_password" :value="__('Password Saat Ini')" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="password" :value="__('Password Baru')" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                <x-input-error class="mt-2" :messages="$errors->get('password')" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
            </div>
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Disimpan.') }}</p>
            @endif
        </div>
    </form>

    <script>
        function previewImage(input) {
            const fileChosen = document.getElementById('file-chosen');
            if(input.files && input.files[0]) {
                fileChosen.textContent = input.files[0].name;
            }
        }
    </script>
</section>