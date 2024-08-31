<?php

namespace App\Http\Resources;

use App\Models\ScrapedArticle;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ScrapedArticle */
class ScrapedDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'source' => $this->source,
            'score' => $this->additional_data['score'] ?? 0,
            'scrape' => $this->scrape_source->name,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'act_delete' => $this->deleted_at? '' : route('delete', $this->getKey()),
        ];
    }
}
