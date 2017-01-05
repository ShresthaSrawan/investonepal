<?php

namespace App\Http\Controllers;

use App\Models\TodaysFloorSheet;
use App\URLCrawler;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

class FloorSheetCrawler extends URLCrawler
{
    const HEADER_ROW_INDEX=1;

    private $sn_index;
    private $contract_no_index;
    private $stock_symbol_index;
    private $buyer_broker_index;
    private $seller_broker_index;
    private $quantity_index;
    private $rate_index;
    private $amount_index;

    private $headers;
    private $date;
    private $floorsheet;

    public function __construct()
    {
        parent::__construct();

        ini_set("memory_limit","1G");
        DB::connection()->disableQueryLog();
        set_time_limit(0);
        
        $this->sn_index = 0;
        $this->contract_no_index = 1;
        $this->stock_symbol_index = 2;
        $this->buyer_broker_index = 3;
        $this->seller_broker_index = 4;
        $this->quantity_index = 5;
        $this->rate_index = 6;
        $this->amount_index = 7;
        $this->floorsheet = [];
    }

    public function fetch($limit = 1)
    {
        $url = "http://nepalstock.com.np/floorsheet";
        $output = $this->httpPost($url,['_limit'=>$limit]);
        $crawler = new Crawler($output);
        $unique = $crawler->filter('.my-table')->filter('.unique');
        $header = $unique->filter('td')->each(function(Crawler $node,$i){
            return $node->text();
        });

        $result = $unique->nextAll()->each(function(Crawler $node, $i){
            return $node->filter('td')->each(function(Crawler $node, $i) {
                return $node->text();
            });
        });


        $this->floorsheet = array_splice($result,0,-3);
        $this->headers = $header;

        //get the date
        $transaction_no = $this->floorsheet[0][$this->contract_no_index];
        $this->date = substr($transaction_no,0,4).'-'.substr($transaction_no,4,2).'-'.substr($transaction_no,6,2);

        //clear the memory
        $crawler->clear();
        unset($crawler);

    }

    public function floorsheetDump()
    {
        if(is_null($this->floorsheet))
            return false;
        TodaysFloorSheet::truncate();

        $sql = "INSERT INTO todays_floorsheet(`transaction_no`,`stock_symbol`,`buyer_broker`,`seller_broker`,`quantity`,`rate`,`amount`) values";
        foreach($this->floorsheet as $floorsheet)
        {
             
            $fs_transaction_no = $floorsheet[$this->contract_no_index];
            $fs_stock_symbol = $floorsheet[$this->stock_symbol_index];
            $fs_buyer_broker = $floorsheet[$this->buyer_broker_index];
            $fs_seller_broker = $floorsheet[$this->seller_broker_index];
            $fs_quantity = $floorsheet[$this->quantity_index];
            $fs_rate = $floorsheet[$this->rate_index];
            $fs_amount = $floorsheet[$this->amount_index];
            
            $sql .= "(
                '{$fs_transaction_no}',
                '{$fs_stock_symbol}',
                '{$fs_buyer_broker}',
                '{$fs_seller_broker}',
                '{$fs_quantity}',
                '{$fs_rate}',
                '{$fs_amount}'
            ),";
        }
        $sql = substr($sql, 0,-1).';';
        return DB::statement($sql);
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getSnIndex()
    {
        return $this->sn_index;
    }

    public function setSnIndex($index)
    {
        $this->sn_index = $index;
    }

    public function getContractNoIndex()
    {
        return $this->contract_no_index;
    }

    public function setContractNoIndex($index)
    {
        $this->contract_no_index = $index;
    }
    public function getStockSymbolIndex()
    {
        return $this->stock_symbol_index;
    }

    public function setStockSymbolIndex($index)
    {
        $this->stock_symbol_index = $index;
    }
    public function getBuyerBrokerIndex()
    {
        return $this->buyer_broker_index;
    }

    public function setBuyerBrokerIndex($index)
    {
        $this->buyer_broker_index = $index;
    }

    public function getSellerBrokerIndex()
    {
        return $this->seller_broker_index;
    }

    public function setSellerBrokerIndex($index)
    {
        $this->seller_broker_index = $index;
    }
    public function getQuantityIndex()
    {
        return $this->quantity_index;
    }

    public function setQuantityIndex($index)
    {
        $this->quantity_index = $index;
    }
    public function getRateIndex()
    {
        return $this->rate_index;
    }

    public function setRateIndex($index)
    {
        $this->rate_index = $index;
    }
    public function getAmountIndex()
    {
        return $this->amount_index;
    }

    public function setAmountIndex($index)
    {
        $this->amount_index = $index;
    }

    public function getDate()
    {
        return $this->date;
    }
}
