<?php

class RssSource extends \Phalcon\Mvc\Model {

    protected $id;
    protected $url;
    protected $title;
    protected $description;
    protected $lang;
    protected $last_build_date;
    protected $pub_date;

    public function getId()
    {
        return $this->id;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($value)
    {
        $this->url = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function setLang($value)
    {
        $this->lang = $value;
    }

    public function getLastPubDate()
    {
        return $this->last_pub_date;
    }

    public function setLastPubDate($value)
    {
        $this->last_pub_date = date("Y-m-d H:i:s",strtotime($value));
    }

    public function getPubDate()
    {
        return $this->pub_date;
    }

    public function setPubDate($value)
    {
        $this->pub_date = date("Y-m-d H:i:s",strtotime($value));
    }
}