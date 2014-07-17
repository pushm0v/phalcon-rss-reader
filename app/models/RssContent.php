<?php

class RssContent extends \Phalcon\Mvc\Model {

    protected $id;
    protected $url;

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }
}