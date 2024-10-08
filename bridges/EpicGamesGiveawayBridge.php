<?php

class EpicGamesGiveawayBridge extends BridgeAbstract
{
    const NAME = 'Epic Games Store giveaways';
    const URI = 'https://ep.reddit.com/r/FreeGameFindings/new';
    const DESCRIPTION = 'Latest free games from the Epic Game Store';
    const MAINTAINER = 't0stiman';
    const DONATION_URI = 'https://ko-fi.com/tostiman';

    public function collectData()
    {
        $this->items[] = [];

        $page = null;
        try {
            $page = getSimpleHTMLDOMCached(self::URI);
        } catch (HttpException $ex) {
            // Reddit throws a 403 forbidden sometimes
            return;
        }

        //for each post
        foreach ($page->find('div.link a.title') as $post) {
            $item = [];

            $uri = $post->getAttribute('href');
            //filter out everything that doesn't link to epic games
            if ($uri == '' || !stripos($uri, 'epicgames.com')) {
                continue;
            }
            $title = $post->innertext;
            //only games pls
            if (!stripos($title, '(game)')) {
                continue;
            }

            $item['uri'] = $uri;
            $item['title'] = $title;
            $item['content'] = '<p><a href="' . $uri . '"> Go to giveaway.</a></p>';
            $item['author'] = 'Epic Games Store';

            //add the item to the list
            array_push($this->items, $item);
        }
    }
}
