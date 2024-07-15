<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use KhmerDateTime\KhmerDateTime;

class InvoiceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id' => $item->id,
                'is_paid' => $item->is_paid,
                'is_screenshot' => $item->is_screenshot,
                'invoice_no' => $item->invoice_no,
                'invoice_date' => $item->invoice_date,
                'created_at' => $item->created_at,
                'room_name' => $item->room->name,
                'telegram_message' => $item->telegram_message == 'done' ? 'ផ្ញើរួច' : 'នៅទេ',
                'total_amount' => $item->sub_total_amount .' ឬ '. $item->total_amount,
                'telegram_message_at' => $item->telegram_message_at == '' ? '' : $item->telegram_message_at,
            ];
        });
    }
}
