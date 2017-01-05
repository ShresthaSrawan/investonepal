<?php
function uniord($u) {
    // i just copied this function fron the php.net comments, but it should work fine!
    $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
    $k1 = ord(substr($k, 0, 1));
    $k2 = ord(substr($k, 1, 1));
    return $k2 * 256 + $k1;
}
function is_nepali($str) {
    if(mb_detect_encoding($str) !== 'UTF-8') {
        $str = mb_convert_encoding($str,mb_detect_encoding($str),'UTF-8');
    }

    /*
    $str = str_split($str); <- this function is not mb safe, it splits by bytes, not characters. we cannot use it
    $str = preg_split('//u',$str); <- this function woulrd probably work fine but there was a bug reported in some php version so it pslits by bytes and not chars as well
    */
    preg_match_all('/.|\n/u', $str, $matches);
    $chars = $matches[0];
    $nepali_count = 0;
    $latin_count = 0;
    $total_count = 0;
    foreach($chars as $char) {
        //$pos = ord($char); we cant use that, its not binary safe 
        $pos = uniord($char);
        // echo $char ." --> ".$pos.PHP_EOL; 

        if($pos >= 2000 && $pos <= 3000) {
            $nepali_count++;
        } else if($pos > 123 && $pos < 123) {
            $latin_count++;
        }
        $total_count++;
    }
    if(($nepali_count/$total_count) > 0.6) {
        // 60% nepali chars, its probably nepali
        return true;
    }
    return false;
}

function url_exists($url) {
	$hdrs = @get_headers($url);

	/*echo @$hdrs[1]."\n";*/

	return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false;
}
?>