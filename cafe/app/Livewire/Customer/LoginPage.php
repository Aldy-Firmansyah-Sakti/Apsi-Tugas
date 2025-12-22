<?php

namespace App\Livewire\Customer;

use App\Models\Table;
use Livewire\Component;

class LoginPage extends Component
{
    public $nama_pemesan = '';
    public $nomor_meja = '';

    public function rules()
    {
        return [
            'nama_pemesan' => 'required|min:3|max:100',
            'nomor_meja' => 'required|exists:tables,nomor_meja',
        ];
    }

    public function messages()
    {
        return [
            'nama_pemesan.required' => 'Nama pemesan harus diisi',
            'nama_pemesan.min' => 'Nama minimal 3 karakter',
            'nomor_meja.required' => 'Pilih nomor meja',
            'nomor_meja.exists' => 'Nomor meja tidak valid',
        ];
    }

    public function mount()
    {
        // Jika dari QR code
        if (request()->has('table')) {
            $this->nomor_meja = request('table');
        }
    }

    public function submit()
    {
        $validated = $this->validate();

        // Simpan ke session
        session([
            'customer_name' => $this->nama_pemesan,
            'table_number' => $this->nomor_meja,
        ]);

        // Redirect ke homepage
        return redirect()->route('customer.home');
    }

    public function render()
    {
        // Load tables yang available
        $tables = Table::where('status', 'available')
            ->orderByRaw('CAST(nomor_meja AS UNSIGNED)')
            ->get();

        return view('livewire.customer.login-page', [
            'tables' => $tables
        ])->layout('layouts.customer');
    }
}