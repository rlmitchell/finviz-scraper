<?php

class Scraper
{
    protected $symbol;
    protected $webpage_data;
    protected $annual_dividend;
    protected $price;

  public function __construct($symbol) {
    $this->symbol = $symbol;
    $this->webpage_data = $this->get_current_finviz_page($this->symbol);
    $this->annual_dividend = $this->parse('[Dividend (annual)]');
    $this->price = $this->parse('>Price</td>');
  }

  public function get_annual_dividend() { 
    return $this->annual_dividend;
  }

  public function get_price() { 
    return $this->price;
  }

  private function parse($find_str){
    $find_str_loc = strpos($this->webpage_data, $find_str);
    $bold_start_loc = strpos($this->webpage_data, '<b>', $find_str_loc);
    $bold_end_loc = strpos($this->webpage_data, '</b>', $bold_start_loc);
    $text = substr($this->webpage_data, $bold_start_loc, ($bold_end_loc - $bold_start_loc));
    $text = str_replace("<b>","",$text);
    return strval($text);
  }

  private function get_current_finviz_page($symbol) {
    $url='https://finviz.com/quote.ashx?t=' . $symbol . '&p=d';
    $tries = 3;
    while($tries > 0){
      try {
        $tries = $tries - 1;
        $c=curl_init();
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 4);
        curl_setopt($c, CURLOPT_TIMEOUT, 6);
        curl_setopt($c, CURLOPT_HTTPHEADER, array('User-Agent: Mozilla'));
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_URL, $url);
        $response = curl_exec($c);
        curl_close($c);

        if( is_int(strpos($response, '[Dividend (annual)]')) ){
          $tries = 0;
        }
      } catch(Exception $e) {
          $tries = $tries;
      }
    }

    if( is_int(strpos($response, '[Dividend (annual)]')) ){
      return $response;
    }
    throw new Exception('Dividend not found in page data.');
  }
}


$results_array = array('uri'=>$_SERVER['REQUEST_URI'], 'symbol'=> strtoupper(explode("/",$_SERVER['REQUEST_URI'])[3]));
$scraper = new Scraper($results_array['symbol']);
$results_array['price'] = $scraper->get_price();
$results_array['annual_dividend'] = $scraper->get_annual_dividend();

print(json_encode($results_array));

