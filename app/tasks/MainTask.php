<?php

class MainTask extends \Phalcon\CLI\Task
{
    public function mainAction() {
        echo "===========================\n";
        echo "Kurio Programming Test\n";
        echo "===========================\n";
        echo "RSS Reader\n";
        echo "Usage :\n";
        echo "\t* Add new source of RSS : php app/cli.php main newSource [URL] [RSS_URL]\n";
        echo "\t  Ex: php app/cli.php main newSource www.detik.com http://rss.detik.com/index.php/detikcom\n";
        echo "\t* Fetch All RSS Sources\t: php app/cli.php main fetchRss\n";
        echo "Some RSS Source :\n";
        echo "\t- http://www.antaranews.com/rss/nasional\n";
        echo "\t- http://rss.detik.com/index.php/detikcom\n";
        echo "===========================\n\n";
    }

    public function fetchRssAction() {

        $sources = Sources::find();
        if (count($sources) > 0)
        {
            foreach($sources as $s)
            {
                $rss = $this->getRss($s->rss_url);
                echo "* Fetching " . $s->url . ", " . count($rss) . " Feeds\n";
                foreach($rss as $r)
                {
                    $content = new Articles();
                    $r['source_id'] = $s->id;
                    $content->save($r);
                }
            }
        }
        else
            echo "* No source found, please add new source.\n";
        echo "* Done fetching.\n\n";
    }

    public function newSourceAction() {

        $params = $this->dispatcher->getParams();
        $newUrl = $params[0];
        $newRssUrl = $params[1];
        //Lets check it first, exist ?
        $source = Sources::query()
            ->where("rss_url = :rss_url:")
            ->bind(array("rss_url" => $newRssUrl))
            ->execute();

        if (count($source) == 0)
        {
            $s = new Sources();
            $s->save(array(
                "url" => $newUrl,
                "rss_url" => $newRssUrl,
            ));
            echo "URL Source saved!\n";
        }
        else
            echo "URL Source exist!\n";

    }

    private function getRss($url)
    {
//        $xml = file_get_contents($url, false);
//
//
//        if (!($x = simplexml_load_string($xml)))
//            return;
//
//        $rss = array();
//        foreach ($x->channel->item as $k => $r)
//        {
//            $content = (String)$r->description;
//            $title = (String)$r->title;
//
//            if ($this->isDuplicate($title,$content))
//                continue;
//
//            $rss[] = array(
//                "title" => $title,
//                "content" => $content,
//                "summary" => $this->summarize($content),
//                "publish_time" => date("Y-m-d H:i:s",strtotime((String)$r->pubDate)),
//            );
//        }
//
//        return $rss;

        $rss = array();
        $feed = new SimplePie();
        $feed->set_feed_url($url);
        $feed->enable_cache(false);
        $feed->init();

        foreach($feed->get_items() as $item)
        {
            $content = $item->get_content();
            $title = $item->get_title();
            $rss[] = array(
                "title" => $title,
                "content" => $content,
                "summary" => $this->summarize($content),
                "publish_time" => date("Y-m-d H:i:s",strtotime($item->get_date())),
            );
        }

        return $rss;
    }

    private function summarize($input, $length=150, $ellipses = true, $strip_html = true) {
        //strip tags, if desired
        if ($strip_html) {
            $input = strip_tags($input);
        }

        //no need to trim, already shorter than trim length
        if (strlen($input) <= $length) {
            return $input;
        }

        //find last space within length
        $last_space = strrpos(substr($input, 0, $length), ' ');
        $trimmed_text = substr($input, 0, $last_space);

        //add ellipses (...)
        if ($ellipses) {
            $trimmed_text .= '...';
        }

        return $trimmed_text;
    }

    private function isDuplicate($title,$content)
    {
        $rss = Articles::query()
            ->where("title = :title:")
            ->orWhere("content = :content:")
            ->bind(array("title" => $title,"content" => $content))
            ->execute();

        if (count($rss) > 0)
            return true;

        return false;
    }
}