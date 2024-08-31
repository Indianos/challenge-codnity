<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScrapedArticle extends Model
{
    use SoftDeletes;

    protected $casts = [
        'scrape_source' => 'App\Enums\ScrapeNewsSource',
        'additional_data' => 'json',
    ];
    protected $guarded = ['id'];

    protected $attributes = [
        'additional_data' => '[]',
    ];

    public function addAdditionalData(string|int $key, mixed $value): void
    {
        $this->setAdditionalData($value, $key);
    }

    public function setAdditionalData(mixed $data, string|int $key = null): void
    {
        if ($key) {
            $data = [$key => $data] + ($this->additional_data ?? []);
        } elseif (!is_array($data)) {
            throw new \InvalidArgumentException("AdditionalData must be keyed array.");
        }
        $this->additional_data = $data;
    }
}
