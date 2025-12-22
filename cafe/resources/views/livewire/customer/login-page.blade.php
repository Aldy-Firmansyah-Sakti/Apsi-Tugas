<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4">
    <div class="bg-white rounded-3xl shadow-lg p-8 w-full max-w-md">
        <h1 class="text-4xl font-bold text-center mb-8">Cafe X</h1>
        
        <form wire:submit.prevent="submit" class="space-y-6">
            <!-- Nama Pemesan -->
            <div>
                <input 
                    type="text" 
                    wire:model="nama_pemesan"
                    placeholder="Nama Pemesan"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                >
                @error('nama_pemesan') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            <!-- No Meja -->
            <div>
                <select 
                    wire:model="nomor_meja"
                    class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                >
                    <option value="">Pilih No Meja</option>
                    @forelse($tables as $table)
                        <option value="{{ $table->nomor_meja }}">
                            Meja {{ $table->nomor_meja }}
                        </option>
                    @empty
                        <option value="" disabled>Tidak ada meja tersedia</option>
                    @endforelse
                </select>
                @error('nomor_meja') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            <p class="text-sm text-gray-500 text-center">
                *Masukkan Nama dan No Meja dengan benar
            </p>

            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full bg-green-700 hover:bg-green-800 text-white font-semibold py-3 rounded-lg transition duration-200"
            >
                Submit
            </button>
        </form>

        <!-- Debug Info (Hapus setelah berhasil) -->
        <div class="mt-4 text-xs text-gray-400 text-center">
            Total Meja: {{ $tables->count() }}
        </div>
    </div>
</div>