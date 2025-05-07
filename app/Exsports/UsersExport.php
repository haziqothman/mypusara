<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;
    protected $startDate;
    protected $endDate;

    public function __construct($data, $startDate = null, $endDate = null)
    {
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return collect($this->data['users']);
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'No. Telefon',
            'Alamat',
            'Jumlah Tempahan',
            'Tarikh Daftar',
            'Status'
        ];
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->phone ?? 'N/A',
            $user->address ?? 'N/A',
            $user->total_bookings,
            $user->created_at->format('d/m/Y'),
            $user->email_verified_at ? 'Aktif' : 'Belum Sah'
        ];
    }
}