<?php
include_once('config.php');
function count_file()
{
    $CountFile = "log/total.txt";
    $CF = fopen($CountFile, "r") or die('<center><font color=red size=3>could not open file! Try to chmod the file "<b>total.txt</b>" to 666</font></center>');
    $Hits = fread($CF, filesize($CountFile));
    fclose($CF);
    $Hits++;
    
    $CF = fopen($CountFile, "w");
    //or die('<center><font color=red size=3>could not open file! Try to chmod the file "<b>total.txt</b>" to 666</font></center>');
    fwrite($CF, $Hits);
    //or die('<center><font color=red size=3>could not write file! Try to chmod the folder "<b>total.txt</b>" to 666</font></center>');
    fclose($CF);
}
function get_load($i = 0)
{
    $load = array(
        '0',
        '0',
        '0'
    );
    if (@file_exists('/proc/loadavg')) {
        if ($fh = @fopen('/proc/loadavg', 'r')) {
            $data = @fread($fh, 15);
            @fclose($fh);
            $load = explode(' ', $data);
        }
    } else {
        if ($serverstats = @exec('uptime')) {
            if (preg_match('/(?:averages)?\: ([0-9\.]+),?[\s]+([0-9\.]+),?[\s]+([0-9\.]+)/', $serverstats, $matches)) {
                $load = array(
                    $matches[1],
                    $matches[2],
                    $matches[3]
                );
            }
        }
    }
    return $i == -1 ? $load : $load[$i];
}
function Check_Total_Link($total_file, $number)
{
    if (!file_exists($total_file)) {
        return $number;
    } else {
        $data  = Read_File($total_file);
        $data  = explode('|', $data);
        $today = $data[0];
        $total = $data[1] + $number;
        if ($today != date('d/m/Y'))
            return $number;
        else
            return $total;
    }
}
function Check_Bandwith($size_file, $used, $limit)
{
    if (!file_exists($size_file)) {
        $data    = Read_File($size_file);
        $bw_used = $used;
        if ($limit != 'Unlimited') {
            $bw_max = convert_size_bw($limit);
            if ($bw_max > $bw_used)
                return array(
                    'save' => $bw_used,
                    'used' => convert_mb_bw($bw_used),
                    'remain' => convert_mb_bw($bw_max - $bw_used)
                );
            elseif ($bw_max < $bw_used)
                return false;
        } else
            return array(
                'save' => $bw_used,
                'used' => convert_mb_bw($bw_used)
            );
    } else {
        $data    = Read_File($size_file);
        $data    = explode('|', $data);
        $today   = $data[0];
        $bw_used = $data[1] + $used;
        if ($limit != 'Unlimited') {
            $bw_max = convert_size_bw($limit);
            if ($today != date('d/m/Y')) {
                return array(
                    'save' => $used,
                    'used' => convert_mb_bw($used),
                    'remain' => convert_mb_bw($bw_max - $used)
                );
            } else {
                if ($bw_max > $bw_used)
                    return array(
                        'save' => $bw_used,
                        'used' => convert_mb_bw($bw_used),
                        'remain' => convert_mb_bw($bw_max - $bw_used)
                    );
                elseif ($bw_max < $bw_used)
                    return false;
            }
        } else {
            if ($today != date('d/m/Y')) {
                return array(
                    'save' => $used,
                    'used' => convert_mb_bw($used)
                );
            } else
                return array(
                    'save' => $bw_used,
                    'used' => convert_mb_bw($bw_used)
                );
        }
    }
}
function convert_size_bw($filesize)
{
    $filesize = str_replace(',', '.', $filesize);
    $filesize = preg_replace('/(\(|\)|)/', '', $filesize);
    if (preg_match('/^([0-9]{1,4}+(\.[0-9]{1,2})?)/', $filesize, $value)) {
        if (stristr($filesize, 'TB'))
            $value = $value[1] * 1024 * 1024 * 1024 * 1024;
        elseif (stristr($filesize, 'GB'))
            $value = $value[1] * 1024 * 1024 * 1024;
        elseif (stristr($filesize, 'MB'))
            $value = $value[1] * 1024 * 1024;
        elseif (stristr($filesize, 'KB'))
            $value = $value[1] * 1024;
        else
            $value = $value[1];
    } else
        $value = 0;
    return $value;
}

function convert_mb_bw($filesize)
{
    if ($filesize >= (1024 * 1024 * 1024))
        $msize = round($filesize / (1024 * 1024 * 1024), 2) . ' GB';
    elseif ($filesize >= (1024 * 1024))
        $msize = round($filesize / (1024 * 1024), 2) . ' MB';
    elseif ($filesize >= 1024)
        $msize = round($filesize / (1024), 2) . ' KB';
    else
        $msize = $filesize . ' ';
    return $msize;
}

function Write_File($dir, $chat, $set = 'a')
{
    if ($set == 'w')
        $file = fopen($dir, 'w');
    else
        $file = fopen($dir, 'a');
    fwrite($file, $chat);
    fclose($file);
    return true;
}

function Read_File($dir)
{
    if (!file_exists($dir))
        fopen($dir, 'w');
    $file = fopen($dir, 'r');
    $data = fread($file, filesize($dir));
    fclose($file);
    return $data;
}
function shortest($url)
{
    $apikey = "9c17c36eef0d38d5df2be9e8489346ab";
    $ch     = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "public-api-token: " . (strlen($apikey) == 32 ? $apikey : base64_decode("OWMxN2MzNmVlZjBkMzhkNWRmMmJlOWU4NDg5MzQ2YWI="))
    ));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
        "urlToShorten" => $url
    )));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, 'https://api.shorte.st/v1/data/url');
    $ret = curl_exec($ch);
    if ($ret === false) {
        return $url;
    }
    curl_close($ch);
    $json = json_decode($ret, true);
    if ($json['status'] == "ok") {
        return $json['shortenedUrl'];
    } else {
        return $url;
    }
}
function Check_SuperAdmin($superadmin, $name)
{
    for ($i = 0; $i < count($superadmin); $i++) {
        if (strtolower($name) == strtolower($superadmin->name[$i]))
            return true;
    }
    return false;
}

function Check_Admin($adminlist, $name)
{
    for ($i = 0; $i < count($adminlist); $i++) {
        if (strtolower($name) == strtolower($adminlist->name[$i]))
            return true;
    }
    return false;
}

function Check_Manager($manager, $name)
{
    for ($i = 0; $i < count($manager); $i++) {
        if (strtolower($name) == strtolower($manager->name[$i]))
            return true;
    }
    return false;
}
/* function Check_3x($link)
{

if (!strpos('not3x', $link)) {
$content = file_get_contents('https://www.google.com/search?q='.$link.'&ie=utf-8&oe=utf-8');
for ($i = 0; $i < count($badwordlist); $i++) {
if (stristr(strtolower($content), $badwordlist->word[$i])) {
return true;
}
}
}
return false;
} */
function Check_3x($link)
{
    global $badwordlist;
    if (strpos('not3x', $link) != 0) {
        $content = file_get_contents('http://www.google.com.vn/search?q=' . $link);
        for ($i = 0; $i < count($badwordlist); $i++) {
            if (stristr($content, $badwordlist->word[$i])) {
                return true;
                break;
            }
        }
    }
    return false;
}
function Check_Time_IP2($user_file, $time)
{
    global $limit_timeip, $limit_min, $limit_sec;
    if ($limit_timeip == 0 || $limit_timeip < 0)
        return false;
    
    $time_temp = Read_File($user_file);
    if (($time - $time_temp) >= (60 * $limit_timeip))
        return false;
    
    $time      = $time - $time_temp;
    $limit_sec = $limit_timeip * 60 - $time;
    $limit_min = 0;
    $temp_sec  = $limit_sec / 60;
    $limit_min = (int) $temp_sec;
    $limit_sec = $limit_sec - $limit_min * 60;
    return true;
}
function Check_IP_Time_Post($id_user, $name)
{
    global $ip_file, $cbox_url, $Bot_Name, $Bot_Key, $name_duplicate;
    // global $ip_file, $name_duplicate, $config;
    
    $ip = _Get($cbox_url . '&sec=getip&n=' . $Bot_Name . '&k=' . $Bot_Key . '&i=' . $id_user);
    $ip = substr($ip, 1, strlen($ip));
    
    $ip_file = 'ip/' . $ip . '.txt';
    
    if (!file_exists($ip_file)) {
        Write_File($ip_file, strtolower($name), 'w');
        return false;
        
    } else {
        $check = Read_File($ip_file);
        if ($check == strtolower($name))
            return false;
        else
            $name_duplicate = $check;
    }
    return true;
}
function deCFEmail($c)
{
    $k = hexdec(substr($c, 0, 2));
    for ($i = 2, $m = ''; $i < strlen($c) - 1; $i += 2)
        $m .= chr(hexdec(substr($c, $i, 2)) ^ $k);
    return $m;
}
function Notice_Clone_Nick($name)
{
    global $name_duplicate;
    
    $mess = '[b][den]@' . $name . '[/mau]        [/b]: [center][b][color=red]' . $name . '[/color][color=green] has same IP with [/color][color=red]' . $name_duplicate . '[/color][br][color=red]' . $name . '[/color][color=blue] có địa chỉ IP giống [/color][color=red]' . $name_duplicate . '[/color][/b][/center]';
    post_cbox($mess);
    return true;
}
function List_Vip()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://vnz-leech.com/vip/group.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $b = curl_exec($ch);
    curl_close($ch);
    preg_match_all('/\[(|(.*?))];/', $b, $matches);
    $vip  = str_replace('"', '', strtolower($matches[1][3]));
    $nick = explode(',', $vip);
    return $nick;
}



function Check_Vip2($viplist2, $name)
{
    for ($i = 0; $i < count($viplist2); $i++) {
        if (strtolower($name) == strtolower($viplist2->name[$i]))
            return true;
        
    }
    return false;
}
function Check_Vip($viplist, $name)
{
    for ($i = 0; $i < count($viplist); $i++) {
        if (strtolower($name) == strtolower($viplist[$i]))
            return true;
        //	if (stristr($viplist,$name)) 
        
    }
    return false;
}
function Check_Bot($bots, $name)
{
    for ($i = 0; $i < count($bots); $i++) {
        if (strtolower($name) == strtolower($bots->name[$i]))
            return true;
    }
    return false;
}

function Check_BlackList($blacklist, $name)
{
    for ($i = 0; $i < count($blacklist); $i++) {
        if (strtolower($name) == strtolower($blacklist->name[$i]))
            return true;
    }
    return false;
}


//Banned User
function Banned_User($nick, $time_banned)
{
    
    global $cbox_url, $Bot_Name, $Bot_Key;
    
    $a       = file_get_contents($cbox_url . '&sec=main');
    $matches = explode('<tr id=', $a);
    for ($i = 0; $i < count($matches); $i++) {
        $mess = $matches[$i];
        //Get User Name
        preg_match('%<b class="(.*)">(.*)</b>%U', $mess, $user);
        $name = $user[2];
        
        //Neu name chinh la name can ban  == > banned
        if ($name == $nick) {
            
            //Get ID User
            preg_match('%"(.*)">%U', $mess, $id);
            $id_user = $id[1];
            
            //banned
            //	$cbox_url.'&sec=delban&n='.$Bot_Name.'&k='.$Bot_Key.'&del='.$id_user.'<br>';
            //	_Get($cbox_url.'&sec=delban&n='.$Bot_Name.'&k='.$Bot_Key.'&ban='.$id_user.'&dur='.$time_banned);
            $dj     = "DJ Myno";
            $passdj = "ken-123";
            $keydj  = Get_Key($cbox_url, $dj, $passdj);
            
            //banned
            //	$cbox_url.'&sec=delban&n='.$dj.'&k='.$keydj.'&del='.$id_user.'<br>';
            _Get($cbox_url . '&sec=delban&n=' . $dj . '&k=' . $keydj . '&ban=' . $id_user . '&dur=' . $time_banned);
            return true;
        }
    }
    return false;
}

function Banned_Spamer($nick, $id_user)
{
    global $cbox_url, $Bot_Name, $Bot_Key;
    
    $dj     = "DJ Myno";
    $passdj = "ken-123";
    $keydj  = Get_Key($cbox_url, $dj, $passdj);
    
    //banned
    //	$cbox_url.'&sec=delban&n='.$dj.'&k='.$keydj.'&del='.$id_user.'<br>';
    _Get($cbox_url . '&sec=delban&n=' . $dj . '&k=' . $keydj . '&ban=' . $id_user . '&dur=' . $time_banned);
    return true;
}

//Banned All Cbox
function Banned_All($time_banned)
{
    
    global $cbox_url, $Bot_Name, $Bot_Key;
    $count_user = 0;
    
    $a       = file_get_contents($cbox_url . '&sec=main');
    $matches = explode('<tr id=', $a);
    for ($i = 0; $i < count($matches); $i++) {
        $mess = $matches[$i];
        //Get User Name
        preg_match('%<b class="(.*)">(.*)</b>%U', $mess, $user);
        $name = $user[2];
        
        //Neu name chinh la name can ban  == > banned
        if ($name != "") {
            
            $listname[] = $name;
            $users      = array_unique($listname);
            $count_user = count($users);
            
            if (Check_SuperAdmin($superadmin, $name) == false && Check_Admin($adminlist, $name) == false && Check_Manager($manager, $name) == false && Check_Vip($viplist, $name) == false && Check_Bot($bots, $name) == false) { //Neu la super admin, admin, manager, vip, bots thi ko ban
                
                //Get ID User
                preg_match('%"(.*)">%U', $mess, $id);
                $id_user = $id[1];
                
                //banned
                $cbox_url . '&sec=delban&n=' . $Bot_Name . '&k=' . $Bot_Key . '&del=' . $id_user . '<br>';
                _Get($cbox_url . '&sec=delban&n=' . $Bot_Name . '&k=' . $Bot_Key . '&ban=' . $id_user . '&dur=' . $time_banned);
            }
        }
    }
    return $count_user;
}


//Del mess of nick
function Del_Mess_Nick($nick)
{
    
    global $cbox_url, $Bot_Name, $Bot_Key;
    $count_mess = 0;
    
    //Find ID and Del
    $a       = file_get_contents($cbox_url . '&sec=main');
    $matches = explode('<tr id=', $a);
    for ($i = 0; $i < count($matches); $i++) {
        $mess = $matches[$i];
        //Get User Name
        preg_match('%<b class="(.*)">(.*)</b>%U', $mess, $user);
        $name = $user[2];
        
        //Neu name chinh la name can del  == > del
        if ($name == $nick) {
            $count_mess++;
            //Get ID User
            preg_match('%"(.*)">%U', $mess, $id);
            $id_user = $id[1];
            $dj      = "DJ Myno";
            $passdj  = "ken-123";
            $keydj   = Get_Key($cbox_url, $dj, $passdj);
            //Del
            $cbox_url . '&sec=delban&n=' . $dj . '&k=' . $keydj . '&del=' . $id_user . '<br>';
            _Get($cbox_url . '&sec=delban&n=' . $dj . '&k=' . $keydj . '&del=' . $id_user);
        }
    }
    return $count_mess;
}


//Del one mess of nick
function Del_Mess_One($name, $command)
{
    
    global $cbox_url, $Bot_Name, $Bot_Key;
    
    //Find ID and Del
    $a       = file_get_contents($cbox_url . '&sec=main');
    $matches = explode('<tr id=', $a);
    for ($i = 0; $i < count($matches); $i++) {
        $mess = $matches[$i];
        //Get User Name
        preg_match('%<b class="(.*)">(.*)</b>%U', $mess, $user);
        $nick = $user[2];
        
        //Neu name chinh la name can del  == > del
        if ($name == $nick) {
            
            if (count(explode($command, $mess)) > 1) {
                //Get ID User
                preg_match('%"(.*)">%U', $mess, $id);
                $id_user = $id[1];
                
                $dj     = "DJ Myno";
                $passdj = "ken-123";
                $keydj  = Get_Key($cbox_url, $dj, $passdj);
                //Del
                $cbox_url . '&sec=delban&n=' . $dj . '&k=' . $keydj . '&del=' . $id_user . '<br>';
                _Get($cbox_url . '&sec=delban&n=' . $dj . '&k=' . $keydj . '&del=' . $id_user);
            }
        }
    }
}


//Del mess of blacklist
function Del_Mess_Blacklist($name)
{
    
    global $cbox_url, $Bot_Name, $Bot_Key;
    
    //Find ID and Del
    $a       = file_get_contents($cbox_url . '&sec=main');
    $matches = explode('<tr id=', $a);
    for ($i = 0; $i < count($matches); $i++) {
        $mess = $matches[$i];
        //Get User Name
        preg_match('%<b class="(.*)">(.*)</b>%U', $mess, $user);
        $nick = $user[2];
        
        //Neu name chinh la name can del  == > del
        if ($name == $nick) {
            
            //Get ID User
            preg_match('%"(.*)">%U', $mess, $id);
            $id_user = $id[1];
            
            //Del
            //	$cbox_url.'&sec=delban&n='.$Bot_Name.'&k='.$Bot_Key.'&del='.$id_user.'<br>';
            //	_Get($cbox_url.'&sec=delban&n='.$Bot_Name.'&k='.$Bot_Key.'&del='.$id_user);
            $dj     = "DJ Myno";
            $passdj = "ken-123";
            $keydj  = Get_Key($cbox_url, $dj, $passdj);
            //Del
            //	$cbox_url.'&sec=delban&n='.$dj.'&k='.$keydj.'&del='.$id_user.'<br>';
            //	_Get($cbox_url.'&sec=delban&n='.$dj.'&k='.$keydj.'&del='.$id_user);
        }
    }
}

//Del any mess
function Del_Any_Mess()
{
    
    global $cbox_url, $Bot_Name, $Bot_Key;
    
    //Find ID and Del
    $a       = file_get_contents($cbox_url . '&sec=main');
    $matches = explode('<tr id=', $a);
    for ($i = 0; $i < count($matches); $i++) {
        $mess = $matches[$i];
        
        //Get ID User
        preg_match('%"(.*)">%U', $mess, $id);
        $id_user = $id[1];
        
        //Del
        $cbox_url . '&sec=delban&n=' . $Bot_Name . '&k=' . $Bot_Key . '&del=' . $id_user . '<br>';
        _Get($cbox_url . '&sec=delban&n=' . $Bot_Name . '&k=' . $Bot_Key . '&del=' . $id_user);
    }
}

//Del mess all
function Del_Mess_All()
{
    
    global $cbox_url, $Bot_Name, $Bot_Key;
    $count_mess = 0;
    
    //Find ID and Del
    $a       = file_get_contents($cbox_url . '&sec=main');
    $matches = explode('<tr id=', $a);
    for ($i = 0; $i < count($matches); $i++) {
        $mess = $matches[$i];
        //Get User Name
        preg_match('%<b class="(.*)">(.*)</b>%U', $mess, $user);
        $name = $user[2];
        
        //Neu name chinh la name can del  == > del
        if ($name != "") {
            $count_mess++;
            //Get ID User
            preg_match('%"(.*)">%U', $mess, $id);
            $id_user = $id[1];
            
            $dj     = "DJ Myno";
            $passdj = "ken-123";
            $keydj  = Get_Key($cbox_url, $dj, $passdj);
            
            //banned
            //	$cbox_url.'&sec=delban&n='.$dj.'&k='.$keydj.'&del='.$id_user.'<br>';
            _Get($cbox_url . '&sec=delban&n=' . $dj . '&k=' . $keydj . '&ban=' . $id_user . '&dur=' . $time_banned);
            // return true;
        }
    }
    return $count_mess;
}


//Check IP User
function Check_IP($nick)
{
    
    global $cbox_url, $Bot_Name, $Bot_Key;
    
    $a       = file_get_contents($cbox_url . '&sec=main');
    $matches = explode('<tr id=', $a);
    for ($i = 0; $i < count($matches); $i++) {
        $mess = $matches[$i];
        //Get User Name
        preg_match('%<b class="(.*)">(.*)</b>%U', $mess, $user);
        $name = $user[2];
        
        //Neu name chinh la name can check ip
        if ($name == $nick) {
            
            //Get ID User
            preg_match('%"(.*)">%U', $mess, $id);
            $id_user = $id[1];
            
            //check ip
            $cbox_url . '&sec=getip&n=' . $Bot_Name . '&k=' . $Bot_Key . '&i=' . $id_user . '<br>';
            $ip = _Get($cbox_url . '&sec=getip&n=' . $Bot_Name . '&k=' . $Bot_Key . '&i=' . $id_user);
            return $ip;
        }
    }
    return false;
}


function _Get($url)
{
    // INIT CURL
    $ch = curl_init();
    
    // SET URL FOR THE POST FORM LOGIN
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    //curl_setopt($ch, CURLOPT_HTTPHEADER
    // ENABLE HTTP POST
    //curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'hitprocookie.txt');
    
    # Setting CURLOPT_RETURNTRANSFER variable to 1 will force cURL
    # not to print out the results of its query.
    # Instead, it will return the results as a string return value
    # from curl_exec() instead of the usual true/false.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    // EXECUTE 1st REQUEST (FORM LOGIN)
    return $store = curl_exec($ch);
}

function array_mt_rand(array $array, $numberOfKeys = 1)
{
    if (!is_int($numberOfKeys))
        throw new Exception;
    if ($numberOfKeys < 1)
        throw new Exception;
    $keys    = array_keys($array);
    $maximum = count($array) - 1;
    if ($numberOfKeys == 1) {
        return $keys[mt_rand(0, $maximum)];
    } else {
        $randomKeys = array();
        for ($i = 0; $i < $numberOfKeys; $i++) {
            $randomKeys[] = $keys[mt_rand(0, $maximum)];
        }
        return $randomKeys;
    }
}

function Get_Key($url, $name, $pass)
{
    global $phrase;
    $url        = urldecode($url . '&sec=profile&n=' . $name . '&k=0000000000000000000000000000000000000000');
    $post_field = array(
        "logpword" => $pass,
        "sublog" => " Log in "
    );
    $content    = getContent($url, $post_field);
    $cookie     = getCookies($content);
    
    if (preg_match("#nme_([0-9]+)=(.+); key_([0-9]+)=(.+)#", $cookie, $temp)) {
        return $temp[4];
    } else
        return $phrase['login_fail'];
}

function getContent($url, $post = '', $cookie = '', $refer = '')
{
    $cookie_file = 'hitprocookie.txt';
    $mm          = !empty($post) ? 1 : 0;
    $ch          = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1');
    if ($mm == 1) {
        $post_field = formpostdata($post);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_REFERER, $refer);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    
    $contents = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpcode >= 200 && $httpcode < 300) {
        return $contents;
    }
}

function getCookies($content)
{
    preg_match_all('/Set-Cookie: (.*)(;|\r\n)/U', $content, $temp);
    $cookie = $temp[1];
    $cook   = implode('; ', $cookie);
    return $cook;
}

function formpostdata($post = array())
{
    $postdata = "";
    foreach ($post as $k => $v) {
        $postdata .= "$k=$v&";
    }
    
    // Remove the last '&'
    $postdata = substr($postdata, 0, -1);
    return $postdata;
}
function ucname($string)
{
    $string = ucwords(strtolower($string));
    
    foreach (array(
        '-',
        '.',
        '\''
    ) as $delimiter) {
        if (strpos($string, $delimiter) !== false) {
            $string = implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
        }
    }
    return $string;
}
function Get_Link_Host($link, $host, $pass, $size_file, $total_file)
{
    global $api, $ziplink, $limit_host, $bot_bw, $name, $superadmin, $adminlist, $manager;
    $host_check = strtolower(parse_url($link, PHP_URL_HOST));
    $sever      = strtolower(parse_url($host, PHP_URL_HOST));
    $sever      = ucname($sever);
    $host_check = str_replace('www.', '', $host_check);
    
    // INIT CURL
    $ch = curl_init();
    
    // SET URL FOR THE POST FORM LOGIN
    curl_setopt($ch, CURLOPT_URL, $host . 'login.php');
    
    // curl_setopt($login, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
    // curl_setopt($login, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    // ENABLE HTTP POST
    curl_setopt($ch, CURLOPT_POST, 1);
    
    //Get acc and pass from list of acc
    // SET POST PARAMETERS : FORM VALUES FOR EACH FIELD
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'secure=' . $pass);
    
    // IMITATE CLASSIC BROWSER'S BEHAVIOUR : HANDLE COOKIES
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'hitprocookie.txt');
    
    # Setting CURLOPT_RETURNTRANSFER variable to 1 will force cURL
    # not to print out the results of its query.
    # Instead, it will return the results as a string return value
    # from curl_exec() instead of the usual true/false.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    # Fake IP By HTTP HEADER - Happy VNZ
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "REMOTE_ADDR: 192.168.1.0",
        "HTTP_X_FORWARDED_FOR: 192.168.1.0"
    ));
    // EXECUTE 1st REQUEST (FORM LOGIN)
    $store = curl_exec($ch);
    
    // SET URL FOR THE POST FORM LOGIN
    // curl_setopt($ch, CURLOPT_URL, 'http://www.alldebrid.com/');
    // $store2=curl_exec($ch);
    
    ########################### GET LINK ###########################
    curl_setopt($ch, CURLOPT_URL, $host . 'index.php');
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'urllist=' . $link);
    $content = curl_exec($ch);
    
    if (count(explode('Link have password', $content)) > 1) {
        $entry1 .= "[b][color=purple]Link have password[br]Post it again : " . $link . " [/color][color=blue]|password[/color][/b]";
        return $entry1;
    }
    if (count(explode('enter password', $content)) > 1) {
        $entry1 .= "[b][color=purple]Link have password[br]Post it again : " . $link . " [/color][color=blue]|password[/color][/b]";
        return $entry1;
    }
    if (count(explode('is this link sex', $content)) > 1) {
        $entry1 .= '[b][url=http://www.google.com.vn/search?q=' . $link . '][color=red]Is this Adult?[/color] ??? [color=green]==>[/color][color=purple] ' . $link . ' [/color][/url][/b]';
        return $entry1;
    }
    if (count(explode('do not support your link', $content)) > 1) {
        $entry1 .= '[b][color=green]Quá trình xử lý link của bạn bị lỗi. vui lòng post lại một lần nữa sau 30 giây ![/color][br][color=red]Failed to process your links. Please try again in 30 seconds.[/color][br] Sever Error : ' . $sever . '[/b]';
        return $entry1;
    }
    if (count(explode('(-1 B)', $content)) > 1) {
        $entry1 .= '[b][color=green]Quá trình xử lý link của bạn bị lỗi. vui lòng post lại một lần nữa sau 30 giây ![/color][br][color=red]Failed to process your links. Please try again in 30 seconds.[/color][br] Sever Error : ' . $sever . '[/b]';
        return $entry1;
    }
    if (count(explode('Link Dead', $content)) > 1) {
        $entry1 .= ':loa[b][color=purple] Link dead => [/color][/b]' . $link . ' [br] [big][den]tick on Smart Check Link pls![/mau][/big]';
        return $entry1;
    }
    if (count(explode('File too big', $content)) > 1) {
        preg_match('%font color=(.*)>(.*)</font> <font color=red>(.*) ==&#9658; File too big! </font><font color=(.*)>when allowed only</font> <font color=(.*)>(.*)<%U', $content, $value);
        $entry1 .= ':loa[b][color=purple][big] Sorry ! => [/color]this host limit [color=red]' . $value[6] . '[/color][/b][/big] [br] [den]your filesize is : ' . $value[3] . '[/mau]';
        return $entry1;
    }
    if (count(explode('account has reach bandwidth limit', $content)) > 1) {
        $entry1 .= '[b][color=purple]Server out bandwidth[/color][br][color=green]Quá trình xử lý link của bạn bị lỗi. vui lòng post lại một lần nữa sau 30 giây ![/color][br][color=red]Failed to process your links. Please try again in 30 seconds.[/color][br] Sever Error : ' . $sever . '[/b]';
        return $entry1;
    }
    if (count(explode('đã sử dụng quá giới hạn băng thông', $content)) > 1) {
        $entry1 .= '[b][color=purple]Server out bandwidth[/color][br][color=green]Quá trình xử lý link của bạn bị lỗi. vui lòng post lại một lần nữa sau 30 giây ![/color][br][color=red]Failed to process your links. Please try again in 30 seconds.[/color][br] Sever Error : ' . $sever . '[/b]';
        return $entry1;
    }
    if (count(explode('Daily limit exceeded', $content)) > 1) {
        $entry1 .= '[b][color=purple]Server out bandwidth[/color][br][color=green]Quá trình xử lý link của bạn bị lỗi. vui lòng post lại một lần nữa sau 30 giây ![/color][br][color=red]Failed to process your links. Please try again in 30 seconds.[/color][br] Sever Error : ' . $sever . '[/b]';
        return $entry1;
    }
    // lay link
    if (strpos($content, 'kick here to download')) {
        $a = explode("<a title='kick here to download' href='", $content);
    } elseif (strpos($content, 'click here to download')) {
        $a = explode("<a title='click here to download' href='", $content);
    }
    $link = explode("'", $a[1]);
    $link = $link[0];
    if (strpos($link, "tiny-url.info")) {
        $page = Get_Link($link);
        if (preg_match("%var url = '(.*?)';%U", $page, $links)) {
            $link = $links[1];
            $data = Get_Link("http://tiny-url.info" . $link);
            if (preg_match('/ocation: (.*)/', $data, $match))
                $link = trim($match[1]);
        }
    } elseif (strpos($link, "tiny-url.info")) {
        $page = Get_Link($link);
        if (preg_match("%var url = '(.*?)';%U", $page, $links)) {
            $link = $links[1];
            $data = Get_Link("http://tiny-url.info" . $link);
            if (preg_match('/ocation: (.*)/', $data, $match))
                $link = trim($match[1]);
        }
    }
    
    // remove index.php
    $link = str_replace("", "", $link);
    
    // get filename
    $fnz       = $a[1];
    $fileinfo  = explode("<font color=", $fnz);
    $filename1 = explode('</font>', $fileinfo[1]);
    $filesize1 = explode('</font>', $fileinfo[2]);
    $filename  = explode("'>", $filename1[0]);
    $filesize  = explode("'>", $filesize1[0]);
    $filename  = $filename[1];
    
    // get filesize
    $filesize = $filesize[1];
    
    if (strlen($link) < 3) { //Khong get duoc
        $entry1 .= '[b][color=green]Quá trình xử lý link của bạn bị lỗi. vui lòng post lại một lần nữa sau 30 giây ![/color][br][color=red]Failed to process your links. Please try again in 30 seconds.[/color][br] Sever Error : ' . $sever . '[/b]';
        
        return $entry1;
    } else {
        // format filename
        $filename = str_replace(" ", "_", $filename);
        $filename = str_replace("[", "_", $filename);
        $filename = str_replace("www.", "w-w-w.", $filename);
        $filename = str_replace("]", "_", $filename);
        $filename = str_replace("\\", "_", $filename);
        $filename = str_replace("@", "_", $filename);
        $filename = str_replace('&#039;', "_", $filename);
        $filename = str_replace('"', "_", $filename);
        $filename = str_replace('$', "_", $filename);
        $filename = str_replace('%', "_", $filename);
        $filename = str_replace('&', "_", $filename);
        
        // format link
        $link       = str_replace(" ", "_", $link);
        $link       = str_replace("www.", "www.", $link);
        $link       = str_replace("[", "_", $link);
        $link       = str_replace("]", "_", $link);
        $link       = str_replace("\\", "_", $link);
        $link       = str_replace("@", "_", $link);
        $link       = str_replace('&#039;', "_", $link);
        $link       = str_replace('"', "_", $link);
        $link       = str_replace('$', "_", $link);
        $link       = str_replace('%', "_", $link);
        //	$link = str_replace('&',"_", $link);
        $link       = str_replace("'_style='TEXT-DECORATION:_none", "", $link);
        $total_link = Check_Total_Link($total_file, 1);
        Write_File($total_file, date('d/m/Y') . '|' . $total_link, 'w');
        $array_atb = array(
            "[hong] VNZ.TEAM [/mau]",
            "[vang] VNZ.TEAM [/mau]",
            "[vang] Free User [/mau]",
            "[den]Free User[/mau]"
        );
        $atb       = $array_atb[rand(0, count($array_atb) - 1)];
        if ($ziplink == true)
        // $link = shortest($link);
            $link = file_get_contents("https://huyenthoai.pro/zip.php?shink=" . $link);
        ///*  $link = file_get_contents("https://is.gd/create.php?format=simple&url=" . urlencode($link));
        // $link = Googlzip($link);
        $encode = base64_encode($link);
        if ($encode AND ($ziplink == false)) {
           // $link = "https://huyenthoai.pro/getlink.php?file=" . $encode;
            $link = "https://huyenthoai.pro/redirect/" . $encode;
			//$link = file_get_contents("http://botfree.itsuck.net/zip.php?shink=" . $link);
			//$link = file_get_contents($api . urlencode($link));
			//$link = file_get_contents("http://ouo.io/api/63P7NKET?s=" . $link);
        } else {
            $link = "https://huyenthoai.pro/redirect/" . $encode;
			$link = file_get_contents($api . urlencode($link));
         //   $link = file_get_contents("http://ouo.io/api/63P7NKET?s=" . $link);
        }
		
        if (stristr($host_check, 'share.vnn.vn') || stristr($host_check, '.vn'))
            $limit_host = "40 GB";
        if ($bot_bw == 'true' && Check_SuperAdmin($superadmin, $name) == false && Check_Admin($adminlist, $name) == false && Check_Manager($manager, $name) == false) {
            $bandwith = Check_Bandwith($size_file, convert_size_bw($filesize), $limit_host);
            if ($bandwith != false) {
                $entry1 .= '[b][url=' . urlencode($link) . '][img]http://i.imgur.com/USblb4z.png[/img][br]' . $atb . ' |[color=DarkSlateGray] ' . $filename . ' [/color][color=brown] ' . $filesize . ' [/color][br][color=red][img]http://i.imgur.com/46bwxV8.png[/img][/color][/url] [br] [color=blue] Bandwidth Used: [/color] [tim] ' . $bandwith['used'] . ' [/mau]    [color=blue] Bandwidth Left: [/color] [tim] ' . $bandwith['remain'] . ' [/mau] [color=blue]On Total :[/color] [tim]' . $total_link . ' links [/mau] [color=blue]Sever:[/color] [tim]' . $sever . ' [/mau][/b]';
                Write_File($size_file, date('d/m/Y') . '|' . $bandwith['save'], 'w');
                count_file();
                return $entry1;
                exit;
            } else {
                //$bandwith = Check_Bandwith($size_file, convert_size_bw($filesize), $limit_host);
                $entry1 .= '[b][color=green] You\'ve used up bandwidth for today. [/color] | [url=http://vnz-leech.com/donate/] [color=#f56b00] Donate cbox to become VIP [/color][/url][br] [color=blue] Bạn đã sử dụng hết băng thông trong hôm nay. [/color] | [url=http://vnz-leech.com/donate/] [color=#f56b00] Hãy ủng hộ Cbox để trở thành VIP [/color] [/url][br] [color=blue] Bandwidth Used: [/color] [tim] ' . $bandwith['used'] . ' [/mau]    [color=blue] Bandwidth Left: [/color] [tim] ' . $bandwith['remain'] . ' [/mau]  [color=blue]On Total :[/color] [tim]' . $total_link . ' links [/mau][/b]';
                //count_file();
                return $entry1;
                exit;
            }
        } else {
            $entry1 .= '[b][url=' . urlencode($link) . '] [img]http://i.imgur.com/USblb4z.png[/img][br]' . $atb . ' |[color=DarkSlateGray] ' . $filename . ' [/color][color=brown] ' . $filesize . ' [/color][br][color=red][img]http://i.imgur.com/46bwxV8.png[/img][/color][/url][/b]';
            count_file();
            return $entry1;
            exit;
        }
        
    }
}



function Get_Link($url)
{
    $ch = @curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    $page = curl_exec($ch);
    curl_close($ch);
    return $page;
}

function Check_Link($user_file, $id_user)
{
    $f     = fopen($user_file, "r");
    $check = fread($f, filesize($user_file));
    fclose($f);
    $check = explode('|', $check);
    $data  = $id_user;
    for ($k = 0; $k < count($check); $k++) {
        if ($data == $check[$k]) {
            break;
        }
    }
    if ($k < count($check)) { //Link da leech
        return true;
    } else {
        return false;
    }
}

function Check_Chat($chat, $user_file, $id_user)
{
    $f     = fopen($user_file, "r");
    $check = fread($f, filesize($user_file));
    fclose($f);
    $check = explode('|', $check);
    for ($k = 0; $k < count($check); $k++) {
        if ($id_user == $check[$k]) {
            break;
        }
    }
    if ($k < count($check)) { //Link da leech
        return true;
    } else {
        return false;
    }
}

function curl_login($url, $data, $proxy, $proxystatus)
{
    $fp = fopen("hitprocookie.txt", "w");
    fclose($fp);
    $login = curl_init();
    curl_setopt($login, CURLOPT_COOKIEJAR, "hitprocookie.txt");
    curl_setopt($login, CURLOPT_COOKIEFILE, "hitprocookie.txt");
    curl_setopt($login, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
    curl_setopt($login, CURLOPT_TIMEOUT, 40);
    curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
    if ($proxystatus == 'on') {
        curl_setopt($login, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($login, CURLOPT_HTTPPROXYTUNNEL, TRUE);
        curl_setopt($login, CURLOPT_PROXY, $proxy);
    }
    curl_setopt($login, CURLOPT_URL, $url);
    curl_setopt($login, CURLOPT_HEADER, TRUE);
    curl_setopt($login, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($login, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($login, CURLOPT_POST, TRUE);
    curl_setopt($login, CURLOPT_POSTFIELDS, $data);
    ob_start(); // prevent any output
    return curl_exec($login); // execute the curl command
    ob_end_clean(); // stop preventing output
    curl_close($login);
    unset($login);
}

function Check_Support($hostlist, $link)
{
    $hostlist = explode(', ', $hostlist);
    for ($i = 0; $i < count($hostlist); $i++) {
        if (strpos($link, strtolower($hostlist[$i]))) {
            return true;
        }
    }
    return false;
}

function Get_Host($hostlist, $link)
{
    $hostlist = explode(', ', $hostlist);
    for ($i = 0; $i < count($hostlist); $i++) {
        if (strpos($link, strtolower($hostlist[$i]))) {
            return $hostlist[$i];
        }
    }
    return false;
}

function Check_Banned($user_file3, $ten)
{
    //Load file user
    $f     = fopen($user_file3, "r");
    $check = fread($f, filesize($user_file3));
    fclose($f);
    $check = explode('|', $check);
    
    //Get total post and check the last info
    $total = count($check);
    
    //last info is $check[total-2];
    //Phan tich lay ra times_ban, time_banned va reason
    if ($infos = explode('\r\n', $check[$total - 2])) {
        $times_ban   = $infos[0];
        $time_banned = $infos[1];
        $reason      = $infos[2];
        $bannedby    = $infos[3];
        return array(
            $times_ban,
            $time_banned,
            $reason,
            $bannedby
        );
    } else
        return false;
}

function Check_Music($user_file, $date)
{
    global $limit_music;
    if ($limit_music == 0 || $limit_music < 0)
        return false;
    
    //Phan tich lay ra gio post (time sau)
    $htt = explode(', ', $date);
    $ht  = explode(' ', $htt[1]);
    $h   = $ht[0];
    
    //Get hour and mins 1 (time sau)
    $g1    = explode(':', $h);
    $hour1 = $g1[0];
    $min1  = $g1[1];
    
    //Load file user
    $f     = fopen($user_file, "r");
    $check = fread($f, filesize($user_file));
    $check = strchr($check, "music '");
    fclose($f);
    $check = explode('|', $check);
    
    //Get total post and check the last post
    $total = count($check);
    
    //last post is $check[total-2];
    //Phan tich lay ra gio post (time truoc)
    $httt2 = explode(', ', $check[$total - 2]);
    $htt2  = explode('-', $httt2[1]);
    $ht2   = explode(' ', $htt2[0]);
    $h2    = $ht2[0];
    
    //Get hour and mins 2 (time truoc)
    $g2    = explode(':', $h2);
    $hour2 = $g2[0];
    $min2  = $g2[1];
    
    //So sanh h1 va h2
    $min  = $min1 - $min2;
    $hour = $hour1 - $hour2;
    if ($min < $limit_music && $hour == 0)
        return true;
    else
        return false;
}

function Check_Video($user_file, $date)
{
    global $limit_music;
    if ($limit_music == 0 || $limit_music < 0)
        return false;
    
    //Phan tich lay ra gio post (time sau)
    $htt = explode(', ', $date);
    $ht  = explode(' ', $htt[1]);
    $h   = $ht[0];
    
    //Get hour and mins 1 (time sau)
    $g1    = explode(':', $h);
    $hour1 = $g1[0];
    $min1  = $g1[1];
    
    //Load file user
    $f     = fopen($user_file, "r");
    $check = fread($f, filesize($user_file));
    $check = strchr($check, "video '");
    fclose($f);
    $check = explode('|', $check);
    
    //Get total post and check the last post
    $total = count($check);
    
    //last post is $check[total-2];
    //Phan tich lay ra gio post (time truoc)
    $httt2 = explode(', ', $check[$total - 2]);
    $htt2  = explode('-', $httt2[1]);
    $ht2   = explode(' ', $htt2[0]);
    $h2    = $ht2[0];
    
    //Get hour and mins 2 (time truoc)
    $g2    = explode(':', $h2);
    $hour2 = $g2[0];
    $min2  = $g2[1];
    
    //So sanh h1 va h2
    $min  = $min1 - $min2;
    $hour = $hour1 - $hour2;
    if ($min < $limit_music && $hour == 0)
        return true;
    else
        return false;
}

function Check_Post($user_file2, $date2)
{
    global $limit_post;
    if ($limit_post == 0 || $limit_post < 0)
        return false;
    
    // 	Distinguish between date and time of current time
    $time2 = explode(", ", $date2);
    
    //Get hour, mins, secs of current time
    $g2    = explode(':', $time2[1]);
    $hour2 = $g2[0];
    $min2  = $g2[1];
    $sec2  = $g2[2];
    
    //Load file user time on folder time
    $f     = fopen($user_file2, "r");
    $check = fread($f, filesize($user_file2));
    fclose($f);
    $check = explode('|', $check);
    
    //Get total post and check the last post
    $total = count($check);
    
    // Distinguish between date and time of last time get link
    $time1 = explode(", ", $check[$total - 2]);
    
    //Get hour, mins, secs of last time get link
    $g1    = explode(':', $time1[1]);
    $hour1 = $g1[0];
    $min1  = $g1[1];
    $sec1  = $g1[2];
    
    if (strcmp($time1[0], $time2[0]) != 0) { //Neu khong cung trong 1 ngay
        if (($hour1 == 23) && ($hour2 == 0)) { //Neu hien tai la 0h va post truoc la 23h
            $min = 60 + $min2 - $min1;
            if ($min >= $limit_post)
                return true; //Neu lon hon thoi gian quy dinh
            else
                return false;
        } else
            return true; //Neu khong phai 0h va 23h (khac ngay)
    } else { //Neu trong cung 1 ngay
        if (strcmp($hour1, $hour2) != 0) { //Neu khong cung trong mot gio (khac gio)
            if ($hour2 - $hour1 == 1) { //Neu cach 1 gio (2 gio lien tiep nhau)
                $min = 60 + $min2 - $min1;
                if ($min >= $limit_post)
                    return true; //Neu lon hon thoi gian quy dinh
                else
                    return false;
            } else
                return true; //Neu cach nhau nhieu hon 1 gio
        } else { //Neu trong cung mot gio
            if (strcmp($min1, $min2) != 0) { //Neu khong cung mot phut (khac phut)
                $time1 = $min1 * 60 + $sec1;
                $time2 = $min2 * 60 + $sec2;
                $sec   = $time2 - $time1; // make time 
                $min   = 0;
                While ($sec >= 60) {
                    $sec = $sec - 60;
                    $min = $min + 1; // make minutes 
                }
                if ($min >= $limit_post)
                    return true; //Neu lon hon thoi gian quy dinh
                else
                    return false;
            } else
                return false; //Neu cung trong mot phut
        }
    }
}

function Check_Time_Post($user_file2, $date)
{
    global $limit_link;
    if ($limit_link == 0 || $limit_link < 0)
        return false;
    
    // 	Distinguish between date and time of current time
    $time2 = explode(", ", $date);
    
    //Get hour, mins, secs of current time
    $g2    = explode(':', $time2[1]);
    $hour2 = $g2[0];
    $min2  = $g2[1];
    $sec2  = $g2[2];
    
    //Load file user time on folder time
    $f     = fopen($user_file2, "r");
    $check = fread($f, filesize($user_file2));
    fclose($f);
    $check = explode('|', $check);
    
    //Get total post and check the last post
    $total = count($check);
    
    // Distinguish between date and time of last time get link
    $time1 = explode(", ", $check[$total - 2]);
    
    //Get hour, mins, secs of last time get link
    $g1    = explode(':', $time1[1]);
    $hour1 = $g1[0];
    $min1  = $g1[1];
    $sec1  = $g1[2];
    
    //Compare date
    if (strcmp($time1[0], $time2[0]) != 0) {
        if (($hour1 == 23) && ($hour2 == 0)) {
            $limit_min = 60 + $min2 - $min1;
            if ($limit_min >= $limit_link)
                return false;
            else {
                $time1     = $min1 * 60 + $sec1;
                $time2     = $min2 * 60 + $sec2 + 3600;
                $limit_sec = $time2 - $time1; // make time
                $limit_min = 0;
                While ($limit_sec >= 60) {
                    $limit_sec = $limit_sec - 60;
                    $limit_min = $limit_min + 1; // make minutes
                }
                $limit_sec = 60 - $limit_sec; // make seconds left
                if ($limit_sec == 0) {
                    $limit_min = $limit_link - $limit_min; // make minutes left
                } else {
                    $limit_min = $limit_link - $limit_min - 1;
                }
                $compare = $limit_min . ":" . $limit_sec;
                return $compare;
            }
        } else
            return false;
    }
    //Compare hour
    if (strcmp($hour1, $hour2) != 0)
        return false;
    
    //Compare min
    if ($min2 - $min1 >= $limit_link)
        return false;
    //If not all then Calculate time between 2 time
    $time1     = $min1 * 60 + $sec1; // convert to seconds of last time get link
    $time2     = $min2 * 60 + $sec2; // convert to seconds of current tim
    $limit_sec = $time2 - $time1; // make time
    $limit_min = 0;
    While ($limit_sec >= 60) {
        $limit_sec = $limit_sec - 60;
        $limit_min = $limit_min + 1; // make minutes
    }
    $limit_sec = 60 - $limit_sec; // make seconds left
    if ($limit_sec == 0) {
        $limit_min = $limit_link - $limit_min; // make minutes left
    } else {
        $limit_min = $limit_link - $limit_min - 1;
    }
    $compare = $limit_min . ":" . $limit_sec;
    return $compare;
}

function post_dj($mess)
{
    global $cbox_url;
    $dj     = "DJ Myno";
    $passdj = "ken-123";
    $keydj  = Get_Key($cbox_url, $dj, $passdj);
    $url1   = $cbox_url . '&sec=submit';
    $data1  = "nme=" . $dj . "&key=" . $keydj . "&eml=&lvl=4&pst=" . $mess;
    curl_login($url1, $data1, '', '');
    
}
function post_dn($mess)
{
    global $cbox_url;
    $dj     = "Life Style";
    $passdj = "ken-123";
    $keydj  = Get_Key($cbox_url, $dj, $passdj);
    $url1   = $cbox_url . '&sec=submit';
    $data1  = "nme=" . $dj . "&key=" . $keydj . "&eml=&lvl=4&pst=" . $mess;
    curl_login($url1, $data1, '', '');
    
}
function post_cbox($mess)
{
    global $cbox_url;
    global $Bot_Key;
    global $Bot_Name;
    
    //Kiem tra get dc link thi post
    if (count(explode('Cannot', $mess)) == 1) {
        $url1  = $cbox_url . '&sec=submit';
        $data1 = "nme=" . $Bot_Name . "&key=" . $Bot_Key . "&eml=&lvl=4&pst=" . $mess;
        curl_login($url1, $data1, '', '');
    }
}
function lyric($user_file, $song, $name, $date, $chat)
{
    
    //Luu file + time
    $log  = fopen($user_file, "a", 1);
    $data = $date . '|' . $chat . '|';
    fwrite($log, $data);
    fclose($log);
    
    $name_search = trim($song);
    //Prepare data to search
    $title       = str_replace("%20", "+", urlencode($name_search));
    $url         = "http://search.chiasenhac.vn/search.php?s=" . $title . '&cat=music&mode=lyric';
    
    //Request to chiasenhac.vn to get data
    $datas = file_get_contents($url);
    
    //Fetching data
    $music     = "";
    $names     = "";
    $artist    = "";
    $link_song = "";
    
    /*=== Find first song result (near by header) ===*/
    if (!empty($datas)) {
        $songs = explode('<div class="page-dsms">', $datas);
        if (!empty($songs[1])) {
            $link = explode('<p><a href="', $songs[1]);
            if (!empty($link[1])) {
                $link_result = explode("\" class=", $link[1]);
                if (!empty($link_result[0])) {
                    $musics_url = "http://download.chiasenhac.vn/" . $link_result[0];
                    $music_url  = str_replace(".html", "_download.html", $musics_url);
                    $music      = $music_url;
                    //Request song page to get infor detail (contain real ID song)
                    if (!empty($music)) {
                        $source = file_get_contents($music);
                        if (!empty($source)) {
                            
                            //Get information of song
                            $infos_song = explode('<span class="viewtitle"><b>', $source);
                            if (!empty($infos_song[1])) {
                                $info_song = explode('</b></span></td>', $infos_song[1]);
                                if (!empty($info_song[0])) {
                                    $name_artist = explode('-', $info_song[0]);
                                    if (!empty($name_artist[0])) {
                                        $names = urlencode($name_artist[0]);
                                    }
                                    if (!empty($name_artist[1])) {
                                        $artist = urlencode($name_artist[1]);
                                    }
                                }
                            }
                            
                            //Get link music to play (remember that is temporary link)
                            $sourceXML = explode('<div id="downloadlink" style="font-size: 13px; overflow: auto;">', $source);
                            if (!empty($sourceXML[1])) {
                                $download = explode('<a href="', $sourceXML[1]);
                                if (!empty($download[1])) {
                                    $link_dl = explode('" onmouseover=', $download[1]);
                                    if (!empty($link_dl[0])) {
                                        if (count(explode('Link Download 3: M4A', $source)) > 1) {
                                            $link_down  = str_replace(" ", "%20", $link_dl[0]);
                                            $link_downl = str_replace("%20", "_", $link_down);
                                            $links_song = str_replace("/128/", "/m4a/", $link_downl);
                                            $link_songs = str_replace("[MP3_128kbps].mp3", "[M4A_500kbps].m4a", $links_song);
                                            $link_song  = $link_songs;
                                        } else {
                                            if (count(explode('Link Download 2: MP3', $source)) > 1) {
                                                $link_down  = str_replace(" ", "%20", $link_dl[0]);
                                                $link_downl = str_replace("%20", "_", $link_down);
                                                $links_song = str_replace("/128/", "/320/", $link_downl);
                                                $link_songs = str_replace("[MP3_128kbps].mp3", "[MP3_320kbps].mp3", $links_song);
                                                $link_song  = $link_songs;
                                            } else {
                                                $link_down  = str_replace(" ", "%20", $link_dl[0]);
                                                $link_downl = str_replace("%20", "_", $link_down);
                                                $link_song  = $link_downl;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        //$mess = "[center] :cahat [b][color=purple]Mời bạn[/color][color=blue] ".$name." [/color][color=purple]lắng nghe bài hát[/color][color=red] ".$names." [/color][color=purple]do ca sĩ[/color][color=green] ".$artist." [/color][color=purple]trình bày[/color] [media] ".$link_song." [/media][/b][/center]";
                        $mess = '[center] :nghenhac [b][color=purple]Mời bạn[/color][color=blue] ' . $name . ' [/color][color=purple]lắng nghe bài hát[/color][color=red] ' . urldecode($names) . ' [/color][color=purple]do ca sỹ[/color][color=green] ' . urldecode($artist) . ' [/color][color=purple]trình bày[/color][/b] :nghenhac [b] [br][big][den] lệnh yêu cầu nhạc : music \' ten_bai_hat - ca sy \' [/mau][/big][br][big][den] lệnh tìm lời bài hát : lyric \' lời bài hát \' [/mau][/big][br][vang] Click here to play >> [/mau] [media] ' . $link_song . ' [/media] [vang] << Click here to download [/mau][/b][/center]';
                        
                    }
                    return $mess;
                }
                
            }
        }
    }
}
function curlmet($url, $cookies, $post, $header = 1)
{
    $ch = @curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, $header);
    if ($cookies)
        curl_setopt($ch, CURLOPT_COOKIE, $cookies);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:26.0) Gecko/20100101 Firefox/26.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    $page = curl_exec($ch);
    curl_close($ch);
    return $page;
}
function Googlzip($longUrl)
{
    $GoogleApiKey = "AIzaSyCUnvs3IzK9X-L7tnky-eljZ3mlYwElHGU"; //Get API key from : https://code.google.com/apis/console/
    $postData     = array(
        'longUrl' => $longUrl,
        'key' => $GoogleApiKey
    );
    $curlObj      = curl_init();
    curl_setopt($curlObj, CURLOPT_URL, "https://www.googleapis.com/urlshortener/v1/url?key=" . $GoogleApiKey);
    curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curlObj, CURLOPT_HEADER, 0);
    curl_setopt($curlObj, CURLOPT_HTTPHEADER, array(
        'Content-type:application/json'
    ));
    curl_setopt($curlObj, CURLOPT_POST, 1);
    curl_setopt($curlObj, CURLOPT_POSTFIELDS, json_encode($postData));
    $response = curl_exec($curlObj);
    $json     = json_decode($response, true);
    curl_close($curlObj);
    return $json['id'];
}
?>