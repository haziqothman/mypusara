<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GravesExport implements FromCollection, WithHeadings, WithMapping
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
        return collect($this->data['graves']);
    }

    public function headings(): array
    {
        return [
            'No. Pusara',
            'Kawasan',
            'Status',
            'Jumlah Tempahan',
            'Kedudukan GPS',
            'Tarikh Dicipta',
            'Tarikh Kemaskini'
        ];
    }

    public function map($grave): array
    {
        return [
            $grave->pusaraNo,
            $this->getSectionName($grave->section),
            $this->getStatusText($grave->status),
            $grave->total_bookings,
            $grave->latitude && $grave->longitude ? $grave->latitude.', '.$grave->longitude : 'N/A',
            $grave->created_at->format('d/m/Y'),
            $grave->updated_at->format('d/m/Y')
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
            'tersedia' => 'Tersedia',
            'tidak_tersedia' => 'Tidak Tersedia',
            'dalam_penyelanggaraan' => 'Dalam Penyelenggaraan'
        ];
        
        return $statuses[$status] ?? $status;
    }
}