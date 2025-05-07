<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class BookingsExport implements FromCollection, WithHeadings, WithMapping
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
        return collect($this->data['bookings']);
    }

    public function headings(): array
    {
        return [
            'ID Tempahan',
            'No. Pusara',
            'Kawasan',
            'Nama Si Mati',
            'No. KP Si Mati',
            'Nama Waris',
            'No. Telefon',
            'Tarikh Tempahan',
            'Tarikh Pengebumian',
            'Status',
            'Catatan'
        ];
    }

    public function map($booking): array
    {
        return [
            $booking->id,
            $booking->package->pusaraNo ?? 'N/A',
            $this->getSectionName($booking->package->section ?? ''),
            $booking->nama_simati,
            $booking->no_mykad_simati,
            $booking->customerName,
            $booking->contactNumber,
            $booking->created_at->format('d/m/Y H:i'),
            Carbon::parse($booking->eventDate)->format('d/m/Y'),
            $this->getStatusText($booking->status),
            $booking->notes
        ];
    }

    private function getSectionName($section)
    {
        $sections = [
            'section_A' => 'Pintu Masuk',
            'section_B' => 'Tandas & Stor',
            'section_C' => 'Pintu Belakang'
        ];
        
        return $sections[$section] ?? $section;
    }

    private function getStatusText($status)
    {
        $statuses = [
            'confirmed' => 'Disahkan',
            'pending' => 'Dalam Proses',
            'cancelled' => 'Dibatalkan'
        ];
        
        return $statuses[$status] ?? $status;
    }
}