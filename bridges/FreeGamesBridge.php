<?php
class FreeGamesBridge extends BridgeAbstract
{
	const NAME = 'Free EGS Games Bridge';
	const URI = 'https://ep.reddit.com/r/FreeGameFindings/new';
	const DESCRIPTION = 'Free Epic Game Store games';
	const MAINTAINER = 't0stiman';

	public function collectData()
	{
		$page = getSimpleHTMLDOMCached(self::URI, self::CACHE_TIMEOUT)
		or returnServerError('could not retrieve page');

		//for each post
		foreach($page->find('div.link a.title') as $post) {
			$item = array();

			$uri = $post->getAttribute('href');
			//filter out the ads and stuff
			if($uri == '' || !stripos($uri, 'epicgames.com')) {
				continue;
			}
			$title = $post->innertext;
			//only games pls
			if(!stripos($title, '(game)')) {
				continue;
			}

			$item['uri'] = $uri;
			$item['title'] = $title;
			$item['content'] = '<p><a href="' . $uri . '"> Go to giveaway.</a></p>';
			$item['author'] = 'Epic Games Store';

			//add the item to the list
			$this->items[] = $item;
		}
	}
}
