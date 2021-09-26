<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParcelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'item_name' => $this->item_name,
            'weight' => $this->weight,
            'volume' => $this->volume,
            'declared_value' => $this->declared_value,
            'chosen_model' => $this->chosen_model,
            'quote' => $this->quote,
        ];
        if (!empty($this->id)) {
            $result['id'] = $this->id;
        }
        return $result;
    }
}
