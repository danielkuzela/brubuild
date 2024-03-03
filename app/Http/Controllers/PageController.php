<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function show(Page $page): Response
    {
        $page->media = $page->getMedia('*');
        $page->rendered_content = $this->processContents($page, $page->content);

        unset($page->content);
        unset($page->media);

        return Inertia::render('Page/Index', [
            'page' => $page
        ]);
    }


    public function processContents(Page $page, $content){

        $processed_content = $content;
        $page_media = $page->media;

        foreach ($processed_content as &$contents) {
            // procces image objects - retrieve data from Spatie
            if (isset($contents['data']['images_hash'])) {

                // Retrieve spatie image gallery data
                // $media = $page->getMedia($contents['data']['images_hash']);
                $media = $page_media->filter(function ($item) use ($contents) {
                    return $item->collection_name == $contents['data']['images_hash'];
                });

                if ($media->count()) {
                    foreach ($media as $medium) {
                        $contents['data']['images'][] = $medium;
                    }
                }
            }

            if(isset($contents['data']['content'])){
                $contents['data']['rendered_content'] = [];
                $contents['data']['rendered_content'] = $this->processContents($page, $contents['data']['content']);
                unset($contents['data']['content']);
            }
        }

        return $processed_content;
    }
}
