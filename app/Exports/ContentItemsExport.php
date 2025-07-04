<?php

namespace App\Exports;

use App\Models\ContentItem;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContentItemsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Get all items with relations
        return ContentItem::with('contentType')->whereHas('contentType', function ($q) {
            $q->where('user_id', auth()->id());
        })->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Description',
            'Status',
            'Content Type',
            'Created At',
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->title,
            $item->description,
            ucfirst($item->status->value),
            optional($item->contentType)->name,
            $item->created_at->format('Y-m-d H:i'),
        ];
    }
}
