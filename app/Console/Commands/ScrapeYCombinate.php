<?php

namespace App\Console\Commands;

use App\Enums\ScrapeNewsSource;
use App\Models\ScrapedArticle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Masterminds\HTML5;

class ScrapeYCombinate extends Command
{
    private const SCRAPE_URL = 'https://news.ycombinator.com/';
    private const SCRAPE_TABLE_INDEX = 2;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:y-combi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Scrapes news information from website '" . self::SCRAPE_URL . "'";

    public function __construct(
        private readonly HTML5 $DOMInitiator,
        private readonly ScrapedArticle $model,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $data = $this->getWebsiteContentObject();
        $data = $data->getElementsByTagName('table');
        /** @var \DOMElement $table */
        foreach ($data as $index => $table) {
            if ($index == self::SCRAPE_TABLE_INDEX) {
                break;
            }
        }

        $article = null;
        /** @var \DOMElement $domTRow */
        foreach ($table->getElementsByTagName('tr') as $domTRow) {
            if (str_contains($domTRow->className, 'athing') && !empty($domTRow->id)) {
                $article = $this->findModel($domTRow->id);
                if ($article->exists) {
                    if($article->deleted_at) {
                        $article = null;
                    }
                    continue;
                }
                /** @var \DOMElement $spanElement */
                foreach ($domTRow->getElementsByTagName('span') as $spanElement) {
                    if ($spanElement->className === 'titleline') {
                        break;
                    }
                }
                $article->title = $spanElement->firstElementChild->nodeValue;
                $source = $spanElement->firstElementChild->getAttribute('href');
                $article->source = \Str::isUrl($source)? $source : self::SCRAPE_URL . $source;
            } elseif ($domTRow->className === '' && $article) {
                /** @var \DOMElement $spanElement */
                foreach ($domTRow->getElementsByTagName('span') as $spanElement) {
                    if ($spanElement->id === 'score_' . $article->scrape_source_id) {
                        $article->addAdditionalData('score', (int)$spanElement->nodeValue);
                        if ($article->exists) {
                            break;
                        }
                    } elseif ($spanElement->className === 'age') {
                        $article->setCreatedAt($spanElement->getAttribute('title'));
                    }
                }
                $article->save();
                $article = null;
            }
        }
        return 0;
    }

    private function getWebsiteContentObject(): \DOMDocument
    {
        return $this->DOMInitiator->loadHTML(Http::get(self::SCRAPE_URL));
    }

    private function findModel($id): ScrapedArticle
    {
        return $this->model::withTrashed()
            ->firstOrNew(['scrape_source' => ScrapeNewsSource::YCombinator, 'scrape_source_id' => $id]);
    }
}
