<?php

class MainTask extends \Phalcon\CLI\Task
{
    public function mainAction() {
        echo "===========================\n";
        echo "Kurio Programming Test\n";
        echo "===========================\n\n";
        echo "RSS Reader\n\n";
        echo "Usage :\n";
        echo "\t* Add new source of RSS : php app/cli.php main newSource [RSS_URL]\n";
        echo "\t* Fetch All RSS \t: php app/cli.php main fetchRss\n";
        echo "\n\n";
        echo "Some RSS Source :\n";
        echo "\t- http://www.antaranews.com/rss/nasional\n";
        echo "\t- http://rss.detik.com/index.php/detikcom\n";
        echo "===========================\n\n";
    }

    public function fetchRssAction() {

        $sources = RssSource::find();
        foreach($sources as $s)
        {
            $rss = $this->getRss($s->getUrl());
            var_dump($rss);
        }
    }

    public function newSourceAction() {

        $params = $this->dispatcher->getParams();
        $newUrl = $params[0];
        //Lets check it first, exist ?
        $source = RssSource::findFirst(array(
            "url" => $newUrl
        ));

        if (false == $source)
        {
            $s = new RssSource();
            $channel = $this->parseChannel($newUrl);

            $s->save($channel);
            echo "URL Source saved!\n";
        }
        else
            echo "URL Source exist!\n";

    }

    private function getRss($url)
    {
        if (!($x = simplexml_load_file($url)))
            return;

        return $x;
    }

    private function parseChannel($url)
    {
        $rss = $this->getRss($url);
        if ($rss->channel)
        {
            return array(
                "url" => $url,
                "title" => (String)$rss->channel->title,
                "description" => (String)$rss->channel->description,
                "lang" => (String)$rss->channel->language,
                "last_build_date" => ($rss->channel->lastBuildDate) ? date("Y-m-d H:i:s",strtotime((String)$rss->channel->lastBuildDate)) : date(now) ,
                "pub_date" => ($rss->channel->pubDate) ? date("Y-m-d H:i:s",strtotime((String)$rss->channel->pubDate)) : date(now) ,
            );
        }

        return array(
            "url" => $url
        );
    }
}