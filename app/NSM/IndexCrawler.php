<?php
namespace App\NSM;
use App\URLCrawler;
use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Created by PhpStorm.
 * User: Roshan
 * Date: 8/26/2015
 * Time: 12:57 PM
 */
class IndexCrawler extends URLCrawler
{
    private $url =  'http://www.nepalstock.com.np/';
    //private $url =  'test/test.html';
    private $output;
    public $result = [];

    public function setURL($url)
    {
        $this->url = $url;
        return $this;
    }

    public function fetch($limit = null)
    {
        $this->output = $this->httpGet($this->url);
        //$this->output = file_get_contents($this->url);
        return ($this->output === false) ? false : $this->get();

    }

    public function get()
    {
        $crawler = new Crawler($this->output);
        $crawler->filter('.panel')->each(function(Crawler $node, $i){
            $heading = $node->filter('.panel-heading');
            if($heading->count() > 0):
                $title =  strtolower($heading->text());
                if(strpos($title,'market information') !== false):
                    $this->getMarketInfo($node);
                endif;
            endif;
        });

        $crawler->filter('.panel')->each(function(Crawler $node, $i){
            $heading = $node->filter('.panel-heading');
            if($heading->count() > 0):
                $title =  strtolower($heading->text());
                if(strpos($title,'as of') !== false):
                    $this->result['date'] = Carbon::parse(str_replace('as of ','',$title))->format('Y-m-d');
                    $this->getMarketCap($node);
                endif;
            endif;
        });

        return $this->result;
    }

    public function getMarketInfo(Crawler $crawler)
    {
        $header = $crawler->filter('table thead tr')->first()->filter('td')->each(function(Crawler $node, $i){
            return $node->text();
        });

        $header = array_splice($header,0,-1);

        $body = $crawler->filter('table tbody tr')->each(function(Crawler $node, $i){
            $row = $node->filter('td')->each(function(Crawler $node,$i){
                return $this->filterValue($node);
            });

            return array_splice($row,0,-1);
        });

        $indexNo = 0;
        $valueNo = 2;
        $newHeader = [];
        foreach($header as $key=>$head):
            if(strtolower($head) == 'index'):
                $indexNo = $key;
                $newHeader[0] = 'Index';
            elseif(strtolower($head) == 'current'):
                $valueNo = $key;
                $newHeader[1] = 'Value';
            endif;
        endforeach;

        $body = $this->removeEmptyArray($body);
        $newBody = [];
        foreach($body as $row):
            $bodyRow = [];
            foreach($row as $k=>$column):
                if($k == $indexNo):
                    $bodyRow[0] = $column;
                elseif($k == $valueNo):
                    $bodyRow[1] = $column;
                endif;
            endforeach;
            $newBody[] = $bodyRow;
        endforeach;

        $this->result['header'] = $newHeader;
        $this->result['body'] = $this->removeEmptyArray($newBody);
    }

    public function getMarketCap(Crawler $crawler)
    {
        $count = count($this->result['header']);
        $data = $crawler->filter('table tbody tr')->each(function(Crawler $node, $i) use($count){
            $row = $node->filter('td')->each(function(Crawler $node, $i){
                return str_replace('Millions','',$this->filterValue($node, true));
            });

            $result = [];
            if(($a = stripos($row[0],'total market capitalization') !== false) || (stripos($row[0],'floated market capitalization') !== false)):
                $liv = end($row);
                $row[0] = ($a) ? 'Market Capitalization' : 'Float Market Cap.';
                while(count($row) < $count){ $row[] = $liv; }
                $result = $row;
            endif;

            return $result;
        });

        $this->result['body'] = array_merge($this->result['body'],$this->removeEmptyArray($data));
    }

    private function removeEmptyArray(array $body)
    {
        $output = [];
        foreach($body as $v):
            if(!empty($v)) $output[] = $v;
        endforeach;

        return $output;
    }

    private function filterValue(Crawler $node, $keepSpace = false)
    {
        $regex = ($keepSpace == true) ? '/[^A-Za-z0-9\-. ]/' : '/[^A-Za-z0-9\-.]/';
        return preg_replace($regex, '', $node->text());
    }
}