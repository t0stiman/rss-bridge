<?php

class GBAtempBridge extends FeedExpander
{
    const MAINTAINER = 't0stiman';
    const NAME = 'GBAtemp';
    const URI = 'https://gbatemp.net/';
    const DESCRIPTION = 'GBAtemp is a user friendly underground video game community.';

    public function collectData()
    {
        $this->collectExpandableDatas(static::URI . 'forums/gbatemp-scene-news.101.rss', 10);
    }
}
