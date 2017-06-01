<?php
if (isset($_GET['url'])) {
    $url    = "https://api.blogit.vn/getlink.php?link=" . trim($_GET['url']);
    $str    = curl2($url);
    $entry  = json_decode($str, true);
    $data   = $entry['result']['data']['link'];
    $artist = $entry['result']['data']['artist'];
    $tittle = $entry['result']['data']['title'];
    foreach ($data as $ten) {
        $data = $ten['file'];
        $link = curl($ten['file'], "", "", 1);
        if (preg_match('/ocation: (.*)/i', $link, $matches)) {
            $link = trim($matches[1]);
            $link = curl($link, "", "", 1);
            if (preg_match('/ocation: (.*)/i', $link, $matches)) {
                $link = trim($matches[1]);
            }
        }
        echo json_encode(array(
            'link' => $link,
            'title' => $tittle,
            'artist' => $artist
        ));
    }
}
if (isset($_GET['hit'])) {
$url = $_GET['hit'];

   var_dump(zing($url));
    
}
if (isset($_GET['s'])) {
    $post     = trim(strtolower($_GET['s']));
    $data     = curl2("http://mp3.zing.vn/tim-kiem/bai-hat.html?q=" . urlencode($post));
    $matches  = explode('class="title-song">', $data);
    $mess     = $matches[1];
    $matches2 = explode("<h3>", $mess);
    $mess2    = $matches2[1];
    preg_match('%a href="/nghe-si/(.*)" title="(.*)">(.*)</a%U', $mess, $artist);
    $artist = $artist[3];
    preg_match('%a href="(.*)" class="txt-primary%U', $mess2, $url);
    $url = $url[1];
    preg_match('%data-highlight="(.*)" title="(.*)" order="0">%U', $mess2, $title);
    $title = $title[2];
    $title = str_replace(" - " . $artist, "", $title);
    $link1 = 'http://mp3.zing.vn' . $url;
	    $url    = "https://api.blogit.vn/getlink.php?link=" . trim($link1);
    $str    = curl2($url);
    $entry  = json_decode($str, true);
    $data   = $entry['result']['data']['link'];
    $artist = $entry['result']['data']['artist'];
    $tittle = $entry['result']['data']['title'];
	if(!empty($data)){
    foreach ($data as $ten) {
        $data = $ten['file'];
        $link = curl($ten['file'], "", "", 1);
        if (preg_match('/ocation: (.*)/i', $link, $matches)) {
            $link = trim($matches[1]);
            $link = curl($link, "", "", 1);
            if (preg_match('/ocation: (.*)/i', $link, $matches)) {
                $link1 = trim($matches[1]);
				$link = explode("?filename",$link1);
				$link = $link[0];
            }
			echo json_encode(array(
            'link' => $link,
            'title' => $tittle,
            'artist' => $artist,
            'link_tai' => $link1
        ));
        }
        
    }
    }else echo "notfound";
    
} else
    echo "Fail";
function curl($url, $cookies, $post, $header = 1)
{
    $ch = @curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    if ($cookies)
        curl_setopt($ch, CURLOPT_COOKIE, $cookies);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:5.0) Gecko/20100101 Firefox/5.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    $page = curl_exec($ch);
    curl_close($ch);
    return $page;
}
function curl2($url)
{
    $ch = @curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    $head[] = "Connection: keep-alive";
    $head[] = "Keep-Alive: 300";
    $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $head[] = "Accept-Language: en-us,en;q=0.5";
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    $page = curl_exec($ch);
    curl_close($ch);
    return $page;
}
function zing($url) {

    $link = str_replace('mp3.zing.vn','m.mp3.zing.vn',$url);
    $content = file_get_contents($link);

    $xml = explode('xml="', $content);
    $xml = explode('"', $xml[1]);

    $data = file_get_contents($xml[0]);

    preg_match('/"source":"(.*)=?"/U', $data, $link);
    $url = str_replace('\/', '/', $link[1]);

    return $url;
}
?>