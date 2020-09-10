<?php


namespace App\Model;

use Nette;
use Nette\Utils\Json;
use GuzzleHttp;

class DataLoader
{

    private $session;

    public function __construct(Nette\Http\Session $session)
    {
        $this->session=$session;
    }

    /**
     * Load data from URL to JSON array in session.
     * @param $url
     * @return mixed
     * @throws GuzzleHttp\Exception\GuzzleException
     * @throws Nette\Utils\JsonException
     */
    function loadJsonFromUrlToSession($url):void
    {

        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $url);

        $section=$this->session->getSection("datagrid");

        $section->dataSource=Json::decode((string)$res->getBody(), Json::FORCE_ARRAY);


    }
}