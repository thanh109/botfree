<meta http-equiv='refresh' content='2'>
<title>Free User Running...</title>
<!-- xml version="1.0" encoding="utf-8" -->

<html>
<style>
div {
	background-color:transparent;
	}
	</style>
	<body>
	<div><center><font color=green size=8><b>Free USER GET LINK</b></font>
<br/>
<br/>
<font color=purple size=5><b>Free User Started! Do not close the Tab<br>Close the tab to stop Free User</b></font></center></div>
</html>
<?php
if (file_get_contents("time_clean.txt") <= (time() - 1 * 60)) {
    @file_get_contents("https://huyenthoai.pro/1/botfree/xoa.php");
    @file_get_contents("https://huyenthoai.pro/xoa.php");
    @file_put_contents("time_clean.txt", time());
    
}

include_once('config.php');
include_once('functions.php');
$cboxurl = $cbox_url . "&sec=main";
echo "<br>Cbox: " . $cboxurl;
$a       = file_get_contents($cboxurl);
$matches = explode('<tr id=', $a);
for ($i = 2; $i < 15; $i++) {
    $mess1 = $matches[$i];
    
    //Get ID User
    preg_match('%"(.*)">%U', $mess1, $id);
    $id_user = $id[1];
    $id_chat = $id_user;
    
    //Get User Name
    preg_match('%<b class="(.*)">(.*)</b>%U', $mess1, $mem);
    $name = $mem[2];
    
    
    
    //Get Chat
    preg_match('%</b>:(.*)</td></tr>%U', $mess1, $chat);
    $chat = $chat[1];
    
    ///Get Date
    $date = date('d/m/Y, H:i:s');
    
    
    
    
    //Make userfile
    $user_file     = "user/" . $name . ".txt"; //make link post
    $user_file2    = "time/" . strtolower($name) . ".txt"; //make time post
    $time_ip       = "timeip/" . md5(strtolower($name)) . ".txt";
    $size_file     = 'size/' . $name . '.txt'; // make size
    $total_file    = 'totallink/' . $name . '.txt'; // make totallink
    $download_file = "download/" . md5($name) . "-" . base64_encode($id_user); // make link multi or folder
    $link_download = "http://ita.nguhanh.us/rg/";
    $link_fs       = 'http://13.76.135.119/go/';
    
    //Check Bot, Bots, Media
    if (preg_match('/\[media](.*)\[\/media]/', $mess1) /* Skip bbcode [media] */ || Check_Bot($bots, $name) == true || strcmp($name, $Bot_Name) == 0); //Neu la Bot, Bots thi ko tra loi
    if (preg_match_all('/<a class="autoLink" href="(.*?)" target="_blank">/i', $chat, $temp, PREG_PATTERN_ORDER) && (count($temp[1]) > 2));
	if (Check_SuperAdmin($superadmin, $name) == true && Check_Admin($adminlist, $name) == true && Check_Manager($manager, $name) == true && Check_Vip($viplist, $name) == true && Check_Vip2($viplist2, $name) == true){
	die();
	}
    else { //Neu khong phai la Bot, Bots, Media
        //Kiem tra post cua user co chua link down hay ko?
        $link = explode('<a class="autoLink" href="', $chat);
        $link = explode('"', $link[1]);
        $link = $link[0] . '';
        
        
        if (Check_BlackList($blacklist, $name) == true) {
            
            $nick       = $name;
            $ten        = $name;
            $user_file3 = "banned/" . $nick . ".txt";
            $thongtin   = Check_Banned($user_file3, $ten);
            if ($thongtin != false) //Neu co file user
                {
                list($times_ban, $time_banned, $reason, $bannedby) = $thongtin;
                
                
                if ($times_ban < (time() - $time_banned * 86400)) {
                    for ($i = 0; $i < count($blacklist); $i++) {
                        if ($blacklist->name[$i] == $nick) {
                            unset($blacklist->name[$i]);
                            $blacklist->asXML($config['blacklist']);
                        }
                    }
                    
                    //Xoa file + info
                    $user_file3 = "banned/" . $nick . ".txt";
                    unlink($user_file3);
                    
                    $mess = "[center][b] Đã xóa[color=maroon] " . $nick . " [/color]khỏi danh sách đen[/b] [img]http://i.imgur.com/pttUUJU.gif[/img][br]Mong bạn không tái phạm lần nữa nhé[/center]";
                    //	post_cbox($mess);	
                } else {
                    $time_banned = gmdate('H:i:s - d/m/Y', $times_ban);
                    $mess        = '[den][b]@ ' . $name . ' [/b][/mau] :chi [center][b][color=purple]Bạn[/color][color=blue] ' . $name . ' [/color][color=purple] đang nằm trong danh sách đen do bị BAN[/color][color=red] ' . $time_banned . ' ngày [/color][color=purple]lúc[/color][color=red] ' . $times_ban . ' [/color][color=purple] vì[/color][color=red] ' . $reason . '[/color][color=brown] ban bởi [/color][vang] ' . $bannedby . ' [/mau][/b][/center]';
                    // post_cbox($mess);
                    $banagin     = urlencode('1 days');
                    // _Get($cbox_url . '&sec=delban&n=' . $Bot_Name . '&k=' . $Bot_Key . '&ban=' . $id_user . '&dur=' . $banagin);
                }
                
                
                //	Banned_User($nick, $time_banned, $reason)	;	
                //    _Get($cbox_url . '&sec=delban&n=' . $Bot_Name . '&k=' . $Bot_Key . '&ban=' . $id_user . '&dur=' . $banagin);
                $kiemtra = false;
            }
            //Del_Mess_Blacklist($name);
        }
        
        
        
        if ($link != '') { //Neu co chua' link down
            $link       = str_replace('%7C', '|', $link); //Link have pass
            $link_data  = str_replace('|', "_", $link);
            $host_check = strtolower(parse_url($link, PHP_URL_HOST));
            $host_check = str_replace('www.', '', $host_check);
            /* CHECK ALL CONDITION */
            $kiemtra    = true; //<= First is true, then if wrong condition, it says false
            
            //    if (Check_Support($bot_support, $link) == true) {
            //Get FileSize
            //    		preg_match('%<span style="color:#000000"><b>(.*)</b>%U', $chat, $match);
            //    		$filesize = str_replace(",",".",$match[1]);
            //    		$filesize = strtolower(trim($filesize));				
            ##################
            ###real size ###
            
            if (Check_Support($bot_support, $link) == true) {
                //Check link da duoc get chua
                $check = Check_Link($user_file, $id_user);
                if ($check == true);
                else //Neu link chua get
                    {
                    //Luu link xuong
                    $log  = fopen($user_file, "a", 1);
                    $data = $id_user . '|';
                    fwrite($log, $data);
                    fclose($log);
                    
                    $realcheck1 = "http://vnz-leech.com/checker/check.php?soigia2=ok&links=" . $link;
                    $realcheck3 = "http://vnz-leech.com/checker/check.php?soigia2=ok&links=" . $link;
                    //  $realcheck2 = "http://getlink4u.com/checker/check.php?yyq1mw2=ok&links=" . $link;
                    // $realcheck4 = "http://getlink4u.com/checker/check.php?yyq1mw2=ok&links=" . $link;
                    
                    $randreal  = array(
                        // $realcheck2,
                        $realcheck1,
                        // $realcheck4,
                        $realcheck3
                    );
                    $realcheck = $randreal[rand(0, count($randreal) - 1)];
                    
                    
                    $data = file_get_contents($realcheck);
                    
                    if (mb_detect_encoding($data) == 'UTF-8')
                        $data = preg_replace('/[^(\x20-\x7F)]*/', '', $data);
                    $sizereal = json_decode(substr($data, 1, strlen($data) - 2), true);
                    $filesize = $sizereal['filesize'];
                    $filename = $sizereal['filename'];
                    $checkten = $sizereal['filename'];
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
                    
                    $filesize = strtolower(trim($filesize));
                    
                    if ($filesize == "null")
                        $kiemtra = false;
                    echo '<br/>';
                    echo $link . ' = <b><font color=red>' . $filesize . '</b></font>';
                    
                    
                    
                    //Kiem tra danh sach super admin, admin, manager, vip
                    if (Check_SuperAdmin($superadmin, $name) == false && Check_Admin($adminlist, $name) == false && Check_Manager($manager, $name) == false && Check_Vip($viplist, $name) == false && Check_Vip2($viplist2, $name) == false && Check_BlackList($blacklist, $name) == false) {
                        //Check Time Post
                        $comp = Check_Time_Post($user_file2, $date); //Current Time + Compare
                        if (strcmp($comp, "") != 0) { //Neu post chua du X phut
                            $ab        = explode(":", $comp);
                            $limit_min = $ab[0];
                            $limit_sec = $ab[1];
                            if ($limit_sec == 0) {
                                if ($limmit_min == 1) {
                                    $mess = '' . $iconf . '[den][b]@ ' . $name . ' [/b][/mau][center][b][color=green]Bạn chỉ được get 1 link trong[/color][color=red] ' . $limit_link . ' [/color][color=green]phút[/color]. [color=green]Vui lòng chờ[/color][color=red] ' . $limit_min . ' [/color][color=blue]phút[/color][color=red] [/color][color=blue]  [/color] | [color=green]Vip ko giới hạn[/color][br][color=purple]You can only get 1 link per[/color][color=red] ' . $limit_link . ' [/color][color=purple]minutes[/color]. [color=purple]Please try again in[/color][color=red] ' . $limit_min . ' [/color][color=blue]minutes[/color][color=red][/color][color=blue] [/color] | [color=purple]Vip unlimited[/color][/b][/center]';
                                } else {
                                    $mess = '' . $iconf . '[den][b]@ ' . $name . ' [/b][/mau][center][b][color=green]Bạn chỉ được get 1 link trong[/color][color=red] ' . $limit_link . ' [/color][color=green]phút[/color]. [color=green]Vui lòng chờ[/color][color=red] ' . $limit_min . ' [/color][color=blue]phút[/color][color=red] ' . $limit_sec . ' [/color][color=blue]giây[/color] | [color=green]Vip ko giới hạn[/color][br][color=purple]You can only get 1 link per[/color][color=red] ' . $limit_link . ' [/color][color=purple]minutes[/color]. [color=purple]Please try again in[/color][color=red] ' . $limit_min . ' [/color][color=blue]minutes[/color][color=red] ' . $limit_sec . ' [/color][color=blue]seconds[/color] | [color=purple]Vip unlimited[/color][/b][/center]';
                                }
                            } elseif ($limit_sec == 1) {
                                if ($limmit_min == 1) {
                                    $mess = '' . $iconf . '[den][b]@ ' . $name . ' [/b][/mau][center][b][color=green]Bạn chỉ được get 1 link trong[/color][color=red] ' . $limit_link . ' [/color][color=green]phút[/color]. [color=green]Vui lòng chờ[/color][color=red] ' . $limit_min . ' [/color][color=blue]phút[/color][color=red] ' . $limit_sec . ' [/color][color=blue]giây[/color] | [color=green]Vip ko giới hạn[/color][br][color=purple]You can only get 1 link per[/color][color=red] ' . $limit_link . ' [/color][color=purple]minutes[/color]. [color=purple]Please try again in[/color][color=red] ' . $limit_min . ' [/color][color=blue]minutes[/color][color=red] ' . $limit_sec . ' [/color][color=blue]seconds[/color] | [color=purple]Vip unlimited[/color][/b][/center]';
                                } else {
                                    $mess = '' . $iconf . '[den][b]@ ' . $name . ' [/b][/mau][center][b][color=green]Bạn chỉ được get 1 link trong[/color][color=red] ' . $limit_link . ' [/color][color=green]phút[/color]. [color=green]Vui lòng chờ[/color][color=red] ' . $limit_min . ' [/color][color=blue]phút[/color][color=red] ' . $limit_sec . ' [/color][color=blue]giây[/color] | [color=green]Vip ko giới hạn[/color][br][color=purple]You can only get 1 link per[/color][color=red] ' . $limit_link . ' [/color][color=purple]minutes[/color]. [color=purple]Please try again in[/color][color=red] ' . $limit_min . ' [/color][color=blue]minutes[/color][color=red] ' . $limit_sec . ' [/color][color=blue]seconds[/color] | [color=purple]Vip unlimited[/color][/b][/center]';
                                }
                            } else {
                                if ($limit_min == 0) {
                                    $mess = '' . $iconf . '[den][b]@ ' . $name . ' [/b][/mau][center][b][color=green]Bạn chỉ được get 1 link trong[/color][color=red] ' . $limit_link . ' [/color][color=green]phút[/color]. [color=green]Vui lòng chờ[/color][color=red] ' . $limit_min . ' [/color][color=blue]phút[/color][color=red] ' . $limit_sec . ' [/color][color=blue]giây[/color] | [color=green]Vip ko giới hạn[/color][br][color=purple]You can only get 1 link per[/color][color=red] ' . $limit_link . ' [/color][color=purple]minutes[/color]. [color=purple]Please try again in[/color][color=red] ' . $limit_min . ' [/color][color=blue]minutes[/color][color=red] ' . $limit_sec . ' [/color][color=blue]seconds[/color] | [color=purple]Vip unlimited[/color][/b][/center]';
                                } elseif ($limit_min == 1) {
                                    $mess = '' . $iconf . '[den][b]@ ' . $name . ' [/b][/mau][center][b][color=green]Bạn chỉ được get 1 link trong[/color][color=red] ' . $limit_link . ' [/color][color=green]phút[/color]. [color=green]Vui lòng chờ[/color][color=red] ' . $limit_min . ' [/color][color=blue]phút[/color][color=red] ' . $limit_sec . ' [/color][color=blue]giây[/color] | [color=green]Vip ko giới hạn[/color][br][color=purple]You can only get 1 link per[/color][color=red] ' . $limit_link . ' [/color][color=purple]minutes[/color]. [color=purple]Please try again in[/color][color=red] ' . $limit_min . ' [/color][color=blue]minutes[/color][color=red] ' . $limit_sec . ' [/color][color=blue]seconds[/color] | [color=purple]Vip unlimited[/color][/b][/center]';
                                } else {
                                    $mess = '' . $iconf . '[den][b]@ ' . $name . ' [/b][/mau][center][b][color=green]Bạn chỉ được get 1 link trong[/color][color=red] ' . $limit_link . ' [/color][color=green]phút[/color]. [color=green]Vui lòng chờ[/color][color=red] ' . $limit_min . ' [/color][color=blue]phút[/color][color=red] ' . $limit_sec . ' [/color][color=blue]giây[/color] | [color=green]Vip ko giới hạn[/color][br][color=purple]You can only get 1 link per[/color][color=red] ' . $limit_link . ' [/color][color=purple]minutes[/color]. [color=purple]Please try again in[/color][color=red] ' . $limit_min . ' [/color][color=blue]minutes[/color][color=red] ' . $limit_sec . ' [/color][color=blue]seconds[/color] | [color=purple]Vip unlimited[/color][/b][/center]';
                                }
                            }
                            if ($bot_start == true)
                                post_cbox($mess);
                            $kiemtra = false;
                        } elseif (count(explode('youtube.com', $link)) > 1) {
                            
                            $entry0 = Get_Link_Host($link, $ytb[0], $ytb[1], $size_file, $total_file);
                            
                            $so_sv  = $ytb[2] + 1;
                            //Luu time post
                            $log    = fopen($user_file2, "a", 1);
                            $data   = $date . '|';
                            fwrite($log, $data);
                            fclose($log);
                            Write_File($time_ip, time(), 'w');
                            Write_File($ip_file, $name, 'w', 1);
                            //Luu link xuong
                            $log2  = fopen($user_file, "a", 1);
                            $data2 = $id_user . '|';
                            fwrite($log2, $data2);
                            fclose($log2);
                            $mess = '' . $iconf . '[den][color=white][b]@ ' . $name . ' [/b][/color][/mau][img]http://i.imgur.com/qTUG3QK.gif[/img][right]' . $icon . '[/right][br][center] ' . $entry0 . ' [br][/center][sub](sent from [Host FREE - Sever: ' . $so_sv . '])[/sub]';
                            if ($bot_start == true)
                                post_cbox($mess);
                        }
                        // Check good_link
                            elseif (count(explode($good_link, $chat)) == 1) {
                            if ($bot_start == true)
                                post_cbox("[den][b]@ " . $name . " [/b][/mau][center] " . $check_mess . " [/center]");
                            $kiemtra = false;
                        } else {
                            if (strpos($link, 'share.vnn.vn') != 0 || strpos($checkten, '.tib') != 0 || strpos($checkten, '.GHO') != 0 || strpos($link, 'T5FCNWM10T') != 0 || stristr(strtolower($checkten), 'win') != 0 || stristr(strtolower($checkten), 'office') != 0) {
                                //host VN unlimited
                            } elseif (strpos($link, 'fshare.vn') != 0) {
                                
                                $kiemtra = true; //get cho ca member
                                if (strpos($filesize, 'kb') != 0) {
                                    $kiemtra = true; //filesize kb always < gb
                                } elseif (strpos($filesize, 'mb') != 0) {
                                    $kiemtra = true; //filesize mb always < gb
                                } elseif (strpos($filesize, 'gb') != 0) {
                                    $size      = explode(".", $filesize);
                                    $filesizes = trim($size[0]);
                                    if ($filesize > $limit_sizevip) {
                                        
                                        $mess = '' . $iconf . '[den][b]@ ' . $name . ' [/b][/mau][center][b][color=green][big] Free Member chỉ có thể get link [den]Fshare.Vn[/mau] tối đa [vang]' . $limit_sizevip . ' GB [/mau]| Vip ko giới hạn[/color][/big][br][color=purple] Link của bạn có size là [den](' . strtoupper($filesize) . ')  [/mau] [/color] [url=http://vnzleech.vn/mobilepay/] => Đăng Ký VIP tại đây để get tẹt ga. [/url][/b][/center]';
                                        if ($bot_start == true)
                                            post_cbox($mess);
                                        $kiemtra = false;
                                    }
                                }
                                
                                else {
                                    $kiemtra = false; // get cho member
                                }
                            } elseif (strpos($link, 'tenlua.vn') != 0) {
                                
                                $kiemtra = true; //get cho ca member
                                if (strpos($filesize, 'kb') != 0) {
                                    $kiemtra = true; //filesize kb always < gb
                                } elseif (strpos($filesize, 'mb') != 0) {
                                    $kiemtra = true; //filesize mb always < gb
                                } elseif (strpos($filesize, 'gb') != 0) {
                                    $size      = explode(".", $filesize);
                                    $filesizes = trim($size[0]);
                                    if ($filesize > $limit_sizevip) {
                                        
                                        $mess = '' . $iconf . '[den][b]@ ' . $name . ' [/b][/mau][center][b][color=green][big] Free Member chỉ có thể get link [den]Tenlua.Vn[/mau] tối đa [vang]' . $limit_sizevip . ' GB [/mau]| Vip ko giới hạn[/color][/big][br][color=purple] Link của bạn có size là [den](' . strtoupper($filesize) . ')  [/mau] [/color] [url=http://vnzleech.vn/mobilepay/] => Đăng Ký VIP tại đây để get tẹt ga. [/url][/b][/center]';
                                        if ($bot_start == true)
                                            post_cbox($mess);
                                        $kiemtra = false;
                                    }
                                }
                                
                                else {
                                    $kiemtra = false; // get cho member
                                }
                            } elseif (strpos($link, '4share.vn') != 0) {
                                
                                $kiemtra = true; //get cho ca member
                                if (strpos($filesize, 'kb') != 0) {
                                    $kiemtra = true; //filesize kb always < gb
                                } elseif (strpos($filesize, 'mb') != 0) {
                                    $kiemtra = true; //filesize mb always < gb
                                } elseif (strpos($filesize, 'gb') != 0) {
                                    $size      = explode(".", $filesize);
                                    $filesizes = trim($size[0]);
                                    if ($filesize > $limit_sizevip) {
                                        
                                        $mess = '' . $iconf . '[den][b]@ ' . $name . ' [/b][/mau][center][b][color=green][big] Free Member chỉ có thể get link [den]Up.4share.Vn[/mau] tối đa [vang]' . $limit_sizevip . ' GB [/mau]| Vip ko giới hạn[/color][/big][br][color=purple] Link của bạn có size là [den](' . strtoupper($filesize) . ')  [/mau] [/color] [url=http://vnzleech.vn/mobilepay/] => Đăng Ký VIP tại đây để get tẹt ga. [/url][/b][/center]';
                                        if ($bot_start == true)
                                            post_cbox($mess);
                                        $kiemtra = false;
                                    }
                                }
                                
                                else {
                                    $kiemtra = false; //get cho member
                                }
                            } elseif (strpos($link, 'filejoker.net') != 0 || strpos($link, 'littlebyte') != 0 || strpos($link, 'datafile') != 0 || strpos($link, 'alfafile.net') != 0 || strpos($link, 'fboom.me') != 0 || strpos($link, 'extmatrix.com') != 0 || strpos($link, 'depfile.com') != 0 || strpos($link, 'upstore.net') != 0 || strpos($link, 'subyshare.com') != 0 || strpos($link, 'rapidgator.net') != 0 || strpos($link, 'fboom.me') != 0 || strpos($link, 'keep2share.cc') != 0 || strpos($link, 'nitroflare.com') != 0 || strpos($link, 'letitbit.net') != 0 || strpos($link, 'turbobit.net') != 0 || strpos($link, 'novafile.com') != 0) {
                                $mess = '' . $iconf . '[den][b]@ ' . $name . ' [/b][/mau][center][b][color=green]Xin lỗi, File Host [den]' . ucname($host_check) . '[/mau] chỉ dành cho thành viên Vip | [url=http://vnz-leech.com/donate]Hãy nâng cấp lên Vip[/url][/color][br][color=purple]Sorry, this File Host [den]' . ucname($host_check) . '[/mau] for Vip member only | [url=http://vnz-leech.com/donate]Let upgrade to Vip[/url][/color][/b][/center]';
                                if ($bot_start == true)
                                    post_cbox($mess);
                                $kiemtra = false;
                            } elseif (strpos($filesize, 'kb') != 0) {
                                $kiemtra = true; //filesize kb always < gb
                            } elseif (strpos($filesize, 'mb') != 0) {
                                $kiemtra = true; //filesize mb always < gb
                            } elseif (strpos($filesize, 'gb') != 0) {
                                $size      = explode(".", $filesize);
                                $filesizes = trim($size[0]);
                                if ($filesize > $limit_size) {
                                    $mess = '' . $iconf . '[den][b]@ ' . $name . ' [/b][/mau][center][b][color=green][big] Free Member chỉ có thể get link [den]' . ucwords($host_check) . '[/mau] tối đa [vang]' . $limit_size . ' GB [/mau]| Vip ko giới hạn[/color][/big][br][color=purple] Link của bạn có size là [den](' . strtoupper($filesize) . ')  [/mau] [/color] [url=http://vnzleech.vn/mobilepay/] => Đăng Ký VIP tại đây để get tẹt ga. [/url][/b][/center]';
                                    if ($bot_start == true)
                                        post_cbox($mess);
                                    $kiemtra = false;
                                }
                            }
                        }
                    }
                    
                    if (Check_SuperAdmin($superadmin, $name) == false && Check_Admin($adminlist, $name) == false && Check_Manager($manager, $name) == false && Check_Vip($viplist, $name) == false && Check_Vip2($viplist2, $name) == false && Check_BlackList($blacklist, $name) == false) {
                        /* Check IP Time Post */
                        if (Check_IP_Time_Post($id_user, $name) == true) { //  $name_duplicate  = $name;
                            
                            $user_file_check = 'timeip/' . md5(strtolower($name_duplicate)) . '.txt';
                            if (Check_Time_IP2($user_file_check, time()) == true) {
                                $ipnow = Check_IP($name);
                                $ipnow = substr($ipnow, 1, strlen($ipnow));
                                $mess  = '[b][den]@' . $name . '[/mau]        [/b]: [center][b][color=red][big]' . $name . '[/big][/color][color=blue] có địa chỉ IP giống [/color][color=red][big]' . $name_duplicate . '[/big][/color] [color=blue]Trong ' . $limit_timeip . ' phút vừa qua. Nhờ Mod check giúp![/color][br][color=red]' . $name . '[/color][color=green] has same IP with [/color][color=red]' . $name_duplicate . '[/color][color=blue] In the last ' . $limit_timeip . ' minutes. Mod check please![/color][br][tim]' . $ipnow . '[/mau][/b][/center]';
                                if ($bot_start == true)
                                    post_cbox($mess);
                                $timeban = urlencode('7 days');
                                Banned_User($name, $timeban, 'clone with ' . $name_duplicate);
                                Banned_User($name_duplicate, $timeban, 'clone with ' . $name);
                                $kiemtra = false;
                            } else
                                Write_File($ip_file, strtolower($name), 'w', 1);
                            //$kiemtra = false;
                        }
                        /*Check IP Time Post */
                        
                        	/* if (Check_3x($link) == true) {
                        	$mess = '[b][den]@' . $name . '[/mau]        [/b]: [b][color=green]Đây là link sex. Vui lòng kiểm tra :[/color] | [url=https://www.google.com/search?q=' . $link . ']Tại đây[/url][/b]. ';
                        	if ($bot_start == true) post_cbox($mess);
                        	} */
                        
                    }
                    
                    
                    
                    /* CHECK ALL CONDITION */
                    if ($kiemtra == true) {
                        if ($bot_start == true) {
                            if (Check_Vip($viplist, $name) == true || Check_Vip2($viplist2, $name) == true || Check_Admin($adminlist, $name) == true || Check_SuperAdmin($superadmin, $name) == true || Check_BlackList($blacklist, $name) == true || Check_3x($link) == true) {
                            } else {
                                if (count(explode('fshare.vn/file/', $link)) > 1) {
                                    if ($dunghost_fs == true) {
                                        
                                        $link = file_get_contents($link_fs . 'post.php?apikey=vnz-team&file=' . $download_file . '&data=' . $link);
                                        //	$entry = $link_download . 'index.php?apikey=happy&file=' . $download_file;
                                        
                                        
                                        
                                        
                                        $array_atb  = array(
                                            "[hong] VNZ.TEAM [/mau]",
                                            "[vang] VNZ.TEAM [/mau]",
                                            "[vang] Vip User [/mau]",
                                            "[den]Vip User[/mau]"
                                        );
                                        $atb        = $array_atb[rand(0, count($array_atb) - 1)];
                                        $limit_host = "40 GB";
                                        $total_link = Check_Total_Link($total_file, 1);
                                        Write_File($total_file, date('d/m/Y') . '|' . $total_link, 'w');
                                        if ($bot_bw == 'true' && Check_SuperAdmin($superadmin, $name) == false && Check_Admin($adminlist, $name) == false && Check_Manager($manager, $name) == false) {
                                            $bandwith = Check_Bandwith($size_file, convert_size_bw($filesize), $limit_host);
                                            if ($bandwith != false) {
                                                $entry1 .= '[b][url=' . urlencode($link) . '][img]http://i.imgur.com/USblb4z.png[/img][br]' . $atb . ' |[color=DarkSlateGray] ' . $filename . ' [/color][color=brown] ' . $filesize . ' [/color][br][color=red][img]http://i.imgur.com/46bwxV8.png[/img][/color][/url] [br] [color=blue] Bandwidth Used: [/color] [tim] ' . $bandwith['used'] . ' [/mau]    [color=blue] Bandwidth Left: [/color] [tim] ' . $bandwith['remain'] . ' [/mau] [color=blue]On Total :[/color] [tim]' . $total_link . ' links [/mau][/b]';
                                                Write_File($size_file, date('d/m/Y') . '|' . $bandwith['save'], 'w');
                                                count_file();
                                                //	return $entry1;
                                            } else {
                                                //$bandwith = Check_Bandwith($size_file, convert_size_bw($filesize), $limit_host);
                                                $entry1 .= '[b][color=green] You\'ve used up bandwidth for today. [/color] | [url=http://vnz-leech.com/donate/] [color=#f56b00] Donate cbox to become VIP [/color][/url][br] [color=blue] Bạn đã sử dụng hết băng thông trong hôm nay. [/color] | [url=http://vnz-leech.com/donate/] [color=#f56b00] Hãy ủng hộ Cbox để trở thành VIP [/color] [/url][br] [color=blue] Bandwidth Used: [/color] [tim] ' . $bandwith['used'] . ' [/mau]    [color=blue] Bandwidth Left: [/color] [tim] ' . $bandwith['remain'] . ' [/mau]  [color=blue]On Total :[/color] [tim]' . $total_link . ' links [/mau][/b]';
                                                //count_file();
                                                //return $entry1;
                                            }
                                        } else {
                                            $entry1 .= '[b][url=' . urlencode($link) . '][img]http://i.imgur.com/USblb4z.png[/img][br]' . $atb . ' |[color=DarkSlateGray] ' . $filename . ' [/color][color=brown] ' . $filesize . ' [/color][br][color=red][img]http://i.imgur.com/46bwxV8.png[/img][/color][/url][/b]';
                                            count_file();
                                            // return $entry1;
                                        }
                                        $so_sv = $fsvn[2] + 1;
                                    } else {
                                        
                                        $entry1 = Get_Link_Host($link, $fsvn[0], $fsvn[1]);
                                        
                                        $so_sv = $fsvn[2] + 1;
                                        
                                        
                                    }
                                } elseif (count(explode('4share.vn/f/', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $foursvn[0], $foursvn[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/xJEW2Ny.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/8mqBD6E.png[/img]';
                                    $so_sv  = $foursvn[2] + 1;
                                    
                                } /* 
                                elseif (count(explode('up.4share.vn', $link))>1) {
                                $entry1 = Get_Link_Host($link, $foursvn[0], $foursvn[1], $size_file, $total_file);
                                // $icon = '[img]http://i.imgur.com/xJEW2Ny.png[/img]';
                                $iconf = '[img]http://i.imgur.com/8mqBD6E.png[/img]';
                                } */ elseif (count(explode('share.vnn.vn', $link)) > 1) {
                                    
                                    
                                    $entry1 = Get_Link_Host($link, $svnn[0], $svnn[1], $size_file, $total_file);
                                    //	$icon   = '[img]http://i.imgur.com/Ld0LH3J.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/IZkNxV0.png[/img]';
                                    
                                } elseif (count(explode('depfile.com', $link)) > 1) {
                                    
                                    
                                    $entry1 = Get_Link_Host($link, $depfile[0], $depfile[1], $size_file, $total_file);
                                    //$iconf  = [img]http://i.imgur.com/T5zBkOy.png[/img]';
                                    $so_sv  = $depfile[2] + 1;
                                    
                                } elseif (count(explode('filesmonster.com', $link)) > 1) {
                                    
                                    
                                    $entry1 = Get_Link_Host($link, $filesmonster[0], $filesmonster[1], $size_file, $total_file);
                                    //$iconf  = [img]http://cdn.alldebrid.com/lib/images/hosts/filesmonster.png[/img]';
                                    $so_sv  = $filesmonster[2] + 1;
                                    
                                } elseif (count(explode('datafile.com', $link)) > 1) {
                                    
                                    
                                    $entry1 = Get_Link_Host($link, $datafile[0], $datafile[1], $size_file, $total_file);
                                    //$iconf  = [img]http://i.imgur.com/lRYTqgB.png[/img]';
                                    $so_sv  = $datafile[2] + 1;
                                    
                                } elseif (count(explode('ul.to', $link)) > 1) {
                                    
                                    
                                    $entry1 = Get_Link_Host($link, $ul[0], $ul[1], $size_file, $total_file);
                                    //$iconf  = [img]http://i.imgur.com/td1N5Fb.png[/img]';
                                    $so_sv  = $ul[2] + 1;
                                    
                                } elseif (count(explode('rarefile.net', $link)) > 1) {
                                    
                                    
                                    $entry1 = Get_Link_Host($link, $rarefile[0], $rarefile[1], $size_file, $total_file);
                                    //$iconf  = [img]http://www.rarefile.net/favicon.ico[/img]';
                                    $so_sv  = $rarefile[2] + 1;
                                    
                                } elseif (count(explode('tusfiles.net', $link)) > 1) {
                                    
                                    
                                    $entry1 = Get_Link_Host($link, $tusfiles[0], $tusfiles[1], $size_file, $total_file);
                                    //    $entry1 = '11111111111111111111111';
                                    //$iconf  = [img]http://debriditalia.com/images/TF.png[/img]';
                                    $so_sv  = $tusfiles[2] + 1;
                                    
                                } elseif (count(explode('\/\/uploading.com', $link)) > 1) {
                                    
                                    
                                    $entry1 = Get_Link_Host($link, $uld[0], $uld[1], $size_file, $total_file);
                                    //$iconf  = [img]http://i.imgur.com/aCixJg9.png[/img]';
                                    $so_sv  = $uld[2] + 1;
                                    
                                } elseif (count(explode('nowdownload', $link)) > 1) {
                                    
                                    
                                    $entry1 = Get_Link_Host($link, $nowdownload[0], $nowdownload[1], $size_file, $total_file);
                                    //$iconf  = [img]http://i.imgur.com/c1HXRdT.png[/img]';
                                    $so_sv  = $nowdownload[2] + 1;
                                    
                                } elseif (count(explode('vip-file.com', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $vipfile[0], $vipfile[1], $size_file, $total_file);
                                    //$iconf  = [img]http://i.imgur.com/NtzJOQf.png[/img]';
                                    
                                } elseif (count(explode('upfile.vn', $link)) > 1) {
                                    //    if(Check_SuperAdmin($superadmin, $name)==true || Check_Admin($adminlist, $name)==true || Check_Manager($manager, $name)==true || Check_Vip($viplist, $name)==true) {
                                    //    $entry1 = Get_Link_Host($link, $ufvn[0], $ufvn[1], $size_file, $total_file);
                                    $entry1 = ' [big][b][color=green] Đối với link  [/color][color=purple]upfile.vn [/color][color=green]các bạn đăng ký miễn phí và tải maxspeed nhé( [/color][color=blue] cbox không hỗ trợ host này[/color][color=green] )  [/color][/b][/big][img]http://smiles.vinaget.us/loa_loa.gif[/img]';
                                    // $icon = '[img]http://i.imgur.com/4Odwddz.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/8DPJR9X.png[/img]';
                                }
                                //    }
                                    elseif (count(explode('tenlua.vn/download/', $link)) > 1) {
                                    
                                    //    $entry1 = '[big][b][color=green] Tài khoản VIP host[/color] [color=purple]tenlua.vn[/color] [color=green]là[/color]: [color=blue]jambrucklee@gmail.com[/color] [br] [color=green]password[/color]: [color=blue]vnzleech[/color][br][color=red]Lấy link xong nhớ thoát ra - Đừng đổi mật khẩu vô ích![/color][/b][/big]';
                                    $entry1 = Get_Link_Host($link, $tlvn[0], $tlvn[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/d61PrKw.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/ir6RDW2.png[/img]';
                                    
                                } elseif (count(explode('mediafire.com', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $mf[0], $mf[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/nXqKXQr.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/I1h7TRN.png[/img]';
                                    $so_sv  = $mf[2] + 1;
                                    
                                } elseif (count(explode('netload.in', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $nl[0], $nl[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/fmm1Wzj.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/28C90E2.png[/img]';
                                    $so_sv  = $nl[2] + 1;
                                    
                                } elseif (count(explode('uploaded.net', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $ul[0], $ul[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/BQbnZlV.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/DK7USZK.png[/img]';
                                    $so_sv  = $ul[2] + 1;
                                    
                                } elseif (count(explode('rapidgator.net', $link)) > 1) {
                                    if ($dunghost == true) {
                                        
                                        $link = file_get_contents($link_download . 'post.php?apikey=vnz-team&file=' . $download_file . '&data=' . $link);
                                        //	$entry = $link_download . 'index.php?apikey=happy&file=' . $download_file;
                                        
                                        
                                        
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
                                            $link = file_get_contents($api . urlencode($entry));
                                        
                                        if ($bot_bw == 'true' && Check_SuperAdmin($superadmin, $name) == false && Check_Admin($adminlist, $name) == false && Check_Manager($manager, $name) == false) {
                                            $bandwith = Check_Bandwith($size_file, convert_size_bw($filesize), $limit_host);
                                            if ($bandwith != false) {
                                                $entry1 = '[b][url=' . urlencode($link) . '][img]http://i.imgur.com/USblb4z.png[/img][br]' . $atb . ' |[color=DarkSlateGray] ' . $filename . ' [/color][color=brown] (' . strtoupper($filesize) . ') [/color][br][color=red][img]http://i.imgur.com/46bwxV8.png[/img][/color][/url] [br] [color=blue] Bandwidth Used: [/color] [tim] ' . $bandwith['used'] . ' [/mau]    [color=blue] Bandwidth Left: [/color] [tim] ' . $bandwith['remain'] . ' [/mau] [color=blue]On Total :[/color] [tim]' . $total_link . ' links [/mau][/b]';
                                                Write_File($size_file, date('d/m/Y') . '|' . $bandwith['save'], 'w');
                                                $iconf = '[img]http://i.imgur.com/nJAgza0.png[/img]';
                                                $so_sv = $rg[2] + 1;
                                            } else {
                                                $entry1 = '[b][color=green] You\'ve used up bandwidth for today. [/color] | [url=http://vnz-leech.com/donate/] [color=#f56b00] Donate cbox to become VIP [/color][/url][br] [color=blue] Bạn đã sử dụng hết băng thông trong hôm nay. [/color] | [url=http://vnz-leech.com/donate/] [color=#f56b00] Hãy ủng hộ Cbox để trở thành VIP [/color] [/url][/b]';
                                                //$iconf  = [img]http://i.imgur.com/nJAgza0.png[/img]';
                                                $so_sv  = $rg[2] + 1;
                                            }
                                        } else {
                                            $entry1 = '[b][url=' . urlencode($link) . '][img]http://i.imgur.com/USblb4z.png[/img][br]' . $atb . ' |[color=DarkSlateGray] ' . $filename . ' [/color][color=brown] (' . strtoupper($filesize) . ') [/color][br][color=red][img]http://i.imgur.com/46bwxV8.png[/img][/color][/url][/b]';
                                            //$iconf  = [img]http://i.imgur.com/nJAgza0.png[/img]';
                                            $so_sv  = $rg[2] + 1;
                                        }
                                        
                                    } else {
                                        
                                        
                                        
                                        
                                        $entry1 = Get_Link_Host($link, $rg[0], $rg[1], $size_file, $total_file);
                                        // $icon = '[img]http://i.imgur.com/nilYHA3.png[/img]';
                                        //$iconf  = [img]http://i.imgur.com/nJAgza0.png[/img]';
                                        $so_sv  = $rg[2] + 1;
                                        
                                    }
                                } elseif (count(explode('hitfile.net', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $hitfile[0], $hitfile[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/nilYHA3.png[/img]';
                                    //$iconf  = [img]https://linksnappy.com/templates/images/filehosts/small/hitfile.net.png[/img]';
                                    $so_sv  = $hitfile[2] + 1;
                                    
                                } elseif (count(explode('letitbit.net', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $ltb[0], $ltb[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/bKiXadj.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/bjnfppa.png[/img]';
                                    $so_sv  = $ltb[2] + 1;
                                    
                                } elseif (count(explode('novafile.com', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $nvf[0], $nvf[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/EscVRTn.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/pHO8f5c.png[/img]';
                                    $so_sv  = $nvf[2] + 1;
                                    
                                } elseif (count(explode('turbobit.net', $link)) > 1) {
                                    
                                    
                                    $entry1 = Get_Link_Host($link, $tbb[0], $tbb[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/Um74W2s.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/S9l2MmX.png[/img]';
                                    $so_sv  = $tbb[2] + 1;
                                    
                                    
                                } elseif (count(explode('k2s.cc', $link)) > 1 || count(explode('keep2share.cc', $link)) > 1 || count(explode('k2share.cc', $link)) > 1) {
                                    
                                    
                                    $entry1 = Get_Link_Host($link, $k2s[0], $k2s[1], $size_file, $total_file);
                                    //    $entry1 = '11111111111111111111111';
                                    //    $icon = '[img]http://i.imgur.com/aA4ZFRu.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/ECi0WOG.png[/img]';
                                } elseif (count(explode('filefactory.com', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $ff[0], $ff[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/V1ju05X.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/HR1GIC0.png[/img]';
                                    $so_sv  = $ff[2] + 1;
                                    
                                } elseif (count(explode('filepost.com', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $fp[0], $fp[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/9QVVfz4.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/gUX8lIe.png[/img]';
                                    $so_sv  = $fp[2] + 1;
                                    
                                } elseif (count(explode('4shared.com', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $foursed[0], $foursed[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/A2Z21Rb.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/ZOCDiN1.png[/img]';
                                    $so_sv  = $foursed[2] + 1;
                                    
                                } elseif (count(explode('depositfiles.com', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $df[0], $df[1], $size_file, $total_file);
                                    //$iconf  = [img]http://www.zevera.com/images/hostericons/depositfiles.png[/img]';
                                    // $icon = '[img]http://i.imgur.com/sEPTKOc.png[/img]';
                                    $so_sv  = $df[2] + 1;
                                    
                                } elseif (count(explode('terafile.co', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $tf[0], $tf[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/iDKopkz.png[/img]';
                                    $so_sv  = $tf[2] + 1;
                                    
                                } elseif (count(explode('oboom.com', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $ob[0], $ob[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/M5HEMvt.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/vakxOd5.png[/img]';
                                    $so_sv  = $ob[2] + 1;
                                    
                                } elseif (count(explode('bitshare.com', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $bs[0], $bs[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/uBWw2Ji.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/jTxWJvJ.png[/img]';
                                    $so_sv  = $bs[2] + 1;
                                    
                                } elseif (count(explode('uptobox.com', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $utb[0], $utb[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/n4lhiOM.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/0XgnmIB.png[/img]';
                                    $so_sv  = $utb[2] + 1;
                                    
                                } elseif (count(explode('extmatrix.com', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $exm[0], $exm[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/GxcNBgE.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/iZQm3Xi.png[/img]';
                                    $so_sv  = $exm[2] + 1;
                                    
                                } elseif (count(explode('mega.co.nz', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $mcn[0], $mcn[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/8hUx7mx.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/21MKu1g.png[/img]';
                                    $so_sv  = $mcn[2] + 1;
                                    
                                } elseif (count(explode('freakshare.com', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $frs[0], $frs[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/8NrCjcL.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/nVGLoDT.png[/img]';
                                    
                                } elseif (count(explode('firedrive.com', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $fd[0], $fd[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/qleIz6i.png[/img]';
                                    $so_sv  = $fd[2] + 1;
                                    
                                } elseif (count(explode('zippyshare.com', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $zps[0], $zps[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/aJKHII2.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/TiWmjl7.png[/img]';
                                    $so_sv  = $zps[2] + 1;
                                    
                                } elseif (count(explode('crocko.com', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $crk[0], $crk[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/Cfx0pwf.png[/img]';
                                    $so_sv  = $crk[2] + 1;
                                    
                                } elseif (count(explode('megashares.com', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $mgs[0], $mgs[1], $size_file, $total_file);
                                    // $icon = '[img]http://i.imgur.com/j1kaGbt.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/BZRWXyF.png[/img]';
                                    $so_sv  = $mgs[2] + 1;
                                    
                                } /*  elseif (count(explode('youtube.com', $link)) > 1) {
                                
                                $entry1 = Get_Link_Host($link, $ytb[0], $ytb[1], $size_file, $total_file);
                                //     $icon = '[img]http://i.imgur.com/6NxtEQD.png[/img]';
                                //$iconf  = [img]http://i.imgur.com/qII26m4.png[/img]';
                                $so_sv  = $ytb[2] + 1;
                                
                                } */ elseif (count(explode('fichier', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $onefichier[0], $onefichier[1], $size_file, $total_file);
                                    $so_sv  = $onefichier[2] + 1;
                                    //$iconf  = [img]http://i.imgur.com/5mIxuW9.png[/img]';
                                    
                                } elseif (count(explode('littlebyte.net', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $lttb[0], $lttb[1], $size_file, $total_file);
                                    // $icon = '[img]http://littlebyte.net/images/logo.gif[/img]';
                                    //$iconf  = [img]http://i.imgur.com/eSOjnhV.png[/img]';
                                    $so_sv  = $lttb[2] + 1;
                                    
                                } elseif (count(explode('share-online.biz', $link)) > 1) {
                                    
                                    $entry1 = Get_Link_Host($link, $sob[0], $sob[1], $size_file, $total_file);
                                    //$iconf  = [img]http://www.debriditalia.com/images/SO.png[/img]';
                                    // $icon = '[img]http://i.imgur.com/6d2oFZW.png[/img]';
                                    $so_sv  = $sob[2] + 1;
                                    
                                } elseif (count(explode('subyshare.com', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/15A5l8D.jpg[/img]';
                                    //$iconf  = [img]http://i.imgur.com/eaYm5ye.gif[/img]';
                                    $entry1 = Get_Link_Host($link, $subyshare[0], $subyshare[1], $size_file, $total_file);
                                    $so_sv  = $subyshare[2] + 1;
                                    
                                } elseif (count(explode('bigfile.to', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/JhRgXwv.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/5Jc3h2d.png[/img]';
                                    $entry1 = Get_Link_Host($link, $uab[0], $uab[1], $size_file, $total_file);
                                    $so_sv  = $uab[2] + 1;
                                    
                                } elseif (count(explode('uploadable.ch', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/JhRgXwv.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/5Jc3h2d.png[/img]';
                                    $entry1 = Get_Link_Host($link, $uab[0], $uab[1], $size_file, $total_file);
                                    $so_sv  = $uab[2] + 1;
                                    
                                } elseif (count(explode('speedyshare.com', $link)) > 1 || count(explode('speedy.sh', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/LLMV59i.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/MLdIP4K.png[/img]';
                                    $entry1 = Get_Link_Host($link, $spds[0], $spds[1], $size_file, $total_file);
                                    $so_sv  = $spds[2] + 1;
                                    
                                } elseif (count(explode('ryushare.com', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/e13QUbc.jpg[/img]';
                                    //$iconf  = [img]http://i.imgur.com/shUHU4x.png[/img]';
                                    $entry1 = Get_Link_Host($link, $ryu[0], $ryu[1], $size_file, $total_file);
                                    $so_sv  = $ryu[2] + 1;
                                    
                                } elseif (count(explode('nitroflare.com', $link)) > 1) {
                                    
                                    //$iconf  = [img]http://jetdebrid.com/images/hosts/nitroflare.png[/img]';
                                    $entry1 = Get_Link_Host($link, $nitro[0], $nitro[1], $size_file, $total_file);
                                    $so_sv  = $nitro[2] + 1;
                                    
                                    
                                } elseif (count(explode('scribd.com', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/S0n99jw.png[/img]';
                                    $entry1 = Get_Link_Host($link, $scribd[0], $scribd[1], $size_file, $total_file);
                                    $so_sv  = $scribd[2] + 1;
                                    
                                } elseif (count(explode('hugefiles.net', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/ikAspmL.png[/img]';
                                    $entry1 = Get_Link_Host($link, $hugefiles[0], $hugefiles[1], $size_file, $total_file);
                                    $so_sv  = $hugefiles[2] + 1;
                                    
                                } elseif (count(explode('filesflash.com', $link)) > 1 || count(explode('filesflash.net', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/bQUBbuH.png[/img]';
                                    $entry1 = Get_Link_Host($link, $filesflash[0], $filesflash[1], $size_file, $total_file);
                                    $so_sv  = $filesflash[2] + 1;
                                    
                                } elseif (count(explode('shareflare', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/BT7tKbT.png[/img]';
                                    $entry1 = Get_Link_Host($link, $shareflare[0], $shareflare[1], $size_file, $total_file);
                                    //$so_sv = $filesflash[2]+1;
                                    
                                } elseif (count(explode('soundcloud.com', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/VDdHL5X.png[/img]';
                                    $entry1 = Get_Link_Host($link, $soundcloud[0], $soundcloud[1], $size_file, $total_file);
                                    $so_sv  = $soundcloud[2] + 1;
                                    
                                } elseif (count(explode('.1fichier.com', $link)) > 1 || count(explode('1fichier.com', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //    $iconf = '[img]http://i.imgur.com/VDdHL5X.png[/img]';
                                    $entry1 = Get_Link_Host($link, $onefichier[0], $onefichier[1], $size_file, $total_file);
                                    $so_sv  = $onefichier[2] + 1;
                                    
                                } elseif (count(explode('sendspace.com', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/L36Z9wK.png[/img]';
                                    $entry1 = Get_Link_Host($link, $sendspace[0], $sendspace[1], $size_file, $total_file);
                                    $so_sv  = $sendspace[2] + 1;
                                    
                                } elseif (count(explode('yunfile.com', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/OylZ7Dh.png[/img]';
                                    $entry1 = Get_Link_Host($link, $yunfile[0], $yunfile[1], $size_file, $total_file);
                                    $so_sv  = $yunfile[2] + 1;
                                    
                                } elseif (count(explode('secureupload.eu', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://jetdebrid.com/images/hosts/secureupload.png[/img]';
                                    $entry1 = Get_Link_Host($link, $secureuploadeu[0], $secureuploadeu[1], $size_file, $total_file);
                                    $so_sv  = $secureuploadeu[2] + 1;
                                    
                                } elseif (count(explode('salefiles', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://jetdebrid.com/images/hosts/salefiles.png[/img]';
                                    $entry1 = Get_Link_Host($link, $salefiles[0], $salefiles[1], $size_file, $total_file);
                                    $so_sv  = $salefiles[2] + 1;
                                    
                                } elseif (count(explode('24upload', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://jetdebrid.com/images/hosts/24uploading.png[/img]';
                                    $entry1 = Get_Link_Host($link, $haibonuld[0], $haibonuld[1], $size_file, $total_file);
                                    $so_sv  = $haibonuld[2] + 1;
                                    
                                } elseif (count(explode('filespace', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://jetdebrid.com/images/hosts/filespace.png[/img]';
                                    $entry1 = Get_Link_Host($link, $filespace[0], $filespace[1], $size_file, $total_file);
                                    $so_sv  = $filespace[2] + 1;
                                    
                                } elseif (count(explode('upload.cd', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://jetdebrid.com/images/hosts/upload.png[/img]';
                                    $entry1 = Get_Link_Host($link, $uploadcd[0], $uploadcd[1], $size_file, $total_file);
                                    $so_sv  = $uploadcd[2] + 1;
                                    
                                } elseif (count(explode('wushare', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://jetdebrid.com/images/hosts/wushare.png[/img]';
                                    $entry1 = Get_Link_Host($link, $wushare[0], $wushare[1], $size_file, $total_file);
                                    $so_sv  = $wushare[2] + 1;
                                    
                                } elseif (count(explode('kingfiles', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://jetdebrid.com/images/hosts/kingfiles.png[/img]';
                                    $entry1 = Get_Link_Host($link, $kingfiles[0], $kingfiles[1], $size_file, $total_file);
                                    $so_sv  = $kingfiles[2] + 1;
                                    
                                } elseif (count(explode('uploadrocket', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://jetdebrid.com/images/hosts/uploadrocket.png[/img]';
                                    $entry1 = Get_Link_Host($link, $uploadrocket[0], $uploadrocket[1], $size_file, $total_file);
                                    $so_sv  = $uploadrocket[2] + 1;
                                    
                                } elseif (count(explode('uplea', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://jetdebrid.com/images/hosts/uplea.png[/img]';
                                    $entry1 = Get_Link_Host($link, $uplea[0], $uplea[1], $size_file, $total_file);
                                    $so_sv  = $uplea[2] + 1;
                                } elseif (count(explode('easybytez.com', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/FOtkbUJ.png[/img]';
                                    $entry1 = Get_Link_Host($link, $easybytez[0], $easybytez[1]);
                                    $so_sv  = $easybytez[2] + 1;
                                } elseif (count(explode('alfafile.net', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]https://alfafile.net/img/sep5.png[/img]';
                                    $entry1 = Get_Link_Host($link, $alfafile[0], $alfafile[1]);
                                    $so_sv  = $alfafile[2] + 1;
                                } elseif (count(explode('filejoker.net', $link)) > 1) {
                                    
                                    // $icon = '[img]http://i.imgur.com/1GvSftn.png[/img]';
                                    //$iconf  = [img]http://i.imgur.com/qZYMESx.png[/img]';
                                    $entry1 = Get_Link_Host($link, $filejoker[0], $filejoker[1]);
                                    $so_sv  = $filejoker[2] + 1;
                                }
                                /* elseif (count(explode('ieech.tk', $link)) > 1 || count(explode('getl11.tk', $link)) > 1 || count(explode('getl9.tk', $link)) > 1 || count(explode('getl8.tk', $link)) > 1) {
                                Del_Mess_Blacklist($name);
                                }   */
                            }
                        }
                        if (strcmp($entry1, "") != 0) {
                            //Check and get info about IP
                            $ip = Check_IP($name);
                            if ($ip) {
                                $ip      = substr($ip, 1);
                                $tracker = "http://www.ip-tracker.org/locator/ip-lookup.php?ip=" . $ip;
                                $infos   = file_get_contents($tracker);
                                if (!empty($infos)) {
                                    $info = explode('<div id="maincontent">', $infos);
                                    if (!empty($info[1])) {
                                        $location = explode("<td class='vazno'>", $info[1]);
                                        if (!empty($location[1])) {
                                            $cities = explode('</td></tr><tr><th>', $location[1]);
                                            if (!empty($cities[0])) {
                                                $city = urlencode($cities[0]);
                                            }
                                        }
                                        $locations = explode("<td class='tracking lessimpt'>", $info[1]);
                                        if (!empty($locations[1])) {
                                            $states = explode('</td></tr><tr><th>', $locations[1]);
                                            if (!empty($states[0])) {
                                                $state = urlencode($states[0]);
                                            }
                                        }
                                        $contiment = explode('</tr><tr><th>Country:</th><td>', $info[1]);
                                        if (!empty($contiment[1])) {
                                            $countries = explode(" &nbsp;&nbsp;", $contiment[1]);
                                            if (!empty($countries[0])) {
                                                $country = urlencode($countries[0]);
                                            }
                                        }
                                        $capital = explode("<img src='", $info[1]);
                                        if (!empty($capital[1])) {
                                            $flags = explode("'> (", $capital[1]);
                                            if (!empty($flags[0])) {
                                                $flag = "http://www.ip-tracker.org/" . $flags[0];
                                            }
                                        }
                                    }
                                }
                            }
                            $iconf = '[img]https://www.google.com/s2/favicons?domain=' . strtolower($host_check) . '[/img]';
                            //$arrow = $array_arrow[rand(0, count($array_arrow)-1)];
                            if (Check_SuperAdmin($superadmin, $name) == true) {
                                if (preg_match("/@(.*?):/", $chat, $nem)) {
                                    //	$command = "info '";
                                    //	Del_Mess_One($name, $command);
                                    //Luu file + time
                                    $data = $id_user . '|';
                                    Write_File($user_file, $data, 'a', 1);
                                    $ten = $nem[1];
                                    if (strcmp($name, "Happy") == 0)
                                        $name = "Hap-py";
                                    //    $mess = '' . $iconf . ' [img]http://191.233.40.227/img2.php?hitpro=' . $name . '[/img][img]http://i.imgur.com/qTUG3QK.gif[/img][right]' . $icon . '[/right][br][br][center] ' . $entry1 . '[br] [img]http://i.imgur.com/Hngm0CB.png[/img][br][/center][sub](sent from [Host Vip - Sever: ' . $so_sv . '])[/sub]';
                                    $mess = '' . $iconf . '[big][tim][b]@ ' . $ten . ' [/b][/mau][/big] :tim [den]nhận hàng nè [/mau][img]http://i.imgur.com/qTUG3QK.gif[/img][br][center] ' . $entry1 . ' [br][br][b][color=red]' . $ten . '[/color] hãy nhớ cảm ơn  [color=green]' . $name . '[/color] nhé! [/b][/center][sub](sent from [Host FREE - Sever: ' . $so_sv . '])[/sub]';
                                } else {
                                    if (strcmp($name, "Happy") == 0)
                                        $name = "Hap-py";
                                    //	if (strcmp($name, "quansky04") == 0)	$name = "admin quansky04 (biệt danh quân sịp vàng)";
                                    if (strcmp($name, "Duy Tùng") == 0)
                                        $name = "Tùng Tiền Tỷ";
                                    if (strcmp($name, "hahaha1651996") == 0)
                                        $name = "Tùng Tiền Tỷ";
                                    $mess = '' . $iconf . '[vang][b]@ ' . $name . ' [/b][/mau][img]http://i.imgur.com/qTUG3QK.gif[/img][right]' . $icon . '[/right][br][center] ' . $entry1 . ' [/center][sub](sent from [Host FREE - Sever: ' . $so_sv . '])[/sub]';
                                    
                                }
                            } elseif (Check_Admin($adminlist, $name) == true) {
                                if (preg_match("/@(.*?):/", $chat, $nem)) {
                                    //	$command = "info '";
                                    //	Del_Mess_One($name, $command);
                                    //Luu file + time
                                    $data = $id_user . '|';
                                    Write_File($user_file, $data, 'a', 1);
                                    $ten = $nem[1];
                                    if (strcmp($name, "Happy") == 0)
                                        $name = "Hap-py";
                                    //    $mess = '' . $iconf . ' [img]http://191.233.40.227/img2.php?hitpro=' . $name . '[/img][img]http://i.imgur.com/qTUG3QK.gif[/img][right]' . $icon . '[/right][br][br][center] ' . $entry1 . '[br] [img]http://i.imgur.com/Hngm0CB.png[/img][br][/center][sub](sent from [Host Vip - Sever: ' . $so_sv . '])[/sub]';
                                    $mess    = '' . $iconf . '[big][tim][b]@ ' . $ten . ' [/b][/mau][/big] :tim [den]nhận hàng nè [/mau][img]http://i.imgur.com/qTUG3QK.gif[/img][br][center] ' . $entry1 . ' [br][br][b][color=red]' . $ten . '[/color] hãy nhớ cảm ơn  [color=green]' . $name . '[/color] nhé! [/b][/center][sub](sent from [Host FREE - Sever: ' . $so_sv . '])[/sub]';
                                    $command = "@ " . $ten;
                                    
                                } else {
                                    
                                    $mess = '' . $iconf . '[vang][b]@ ' . $name . ' [/b][/mau][img]http://i.imgur.com/qTUG3QK.gif[/img][right]' . $icon . '[/right][br][center] ' . $entry1 . ' [/center][sub](sent from [Host FREE - Sever: ' . $so_sv . '])[/sub]';
                                    
                                }
                            } elseif (Check_Manager($manager, $name) == true) {
                                if (preg_match("/@(.*?):/", $chat, $nem)) {
                                    
                                    //Luu file + time
                                    $data = $id_user . '|';
                                    Write_File($user_file, $data, 'a', 1);
                                    $ten = $nem[1];
                                    //    $mess = '' . $iconf . ' [img]http://191.233.40.227/img2.php?hitpro=' . $name . '[/img][img]http://i.imgur.com/qTUG3QK.gif[/img][right]' . $icon . '[/right][br][br][center] ' . $entry1 . '[br] [img]http://i.imgur.com/Hngm0CB.png[/img][br][/center][sub](sent from [Host Vip - Sever: ' . $so_sv . '])[/sub]';
                                    $mess    = '' . $iconf . '[big][tim][b]@ ' . $ten . ' [/b][/mau][/big] :tim [den]nhận hàng nè [/mau][img]http://i.imgur.com/qTUG3QK.gif[/img][br][center] ' . $entry1 . ' [br][br][b][color=red]' . $ten . '[/color] hãy nhớ cảm ơn  [color=green]' . $name . '[/color] nhé! [/b][/center][sub](sent from [Host FREE - Sever: ' . $so_sv . '])[/sub]';
                                    $command = $ten;
                                    
                                } else {
                                    $mess = '' . $iconf . '[vang][b]@ ' . $name . ' [/b][/mau][img]http://i.imgur.com/qTUG3QK.gif[/img][right]' . $icon . '[/right][br][center] ' . $entry1 . ' [/center][sub](sent from [Host FREE - Sever: ' . $so_sv . '])[/sub]';
                                    
                                }
                            } elseif (Check_Vip($viplist, $name) == true || Check_Vip2($viplist2, $name) == true) {
                                //    $mess = '' . $iconf . '[cam][color=white][b][big]@ ' . $name . ' [/big][/b][/color][/mau][img]http://i.imgur.com/qTUG3QK.gif[/img][right]' . $icon . '[/right][br][br][center] ' . $entry1 . '[br] [img]http://i.imgur.com/z4JcwRD.png[/img][br][/center][sub](sent from [Host FREE - Sever: ' . $so_sv . '])[/sub]';
                                //    $mess = '' . $iconf . ' [img]http://191.233.40.227/img2.php?hitpro=' . $name . '[/img][img]http://i.imgur.com/qTUG3QK.gif[/img][right]' . $icon . '[/right][br][br][center] ' . $entry1 . '[br][/center][sub](sent from [Host Vip - Sever: ' . $so_sv . '])[/sub]';
                                //$mess='[cam][b][big]@ '.$name.' [/big][/b][/mau][img]http://i.imgur.com/qTUG3QK.gif[/img][right]'.$icon.'[/right][br][center] '.$entry1.'[/center][center][br] [img]http://i.imgur.com/PJs1KBw.gif[/img][/center]';
                            } else {
                                $data = $date . '|';
                                Write_File($user_file2, $data, 'a', 1);
                                Write_File($time_ip, time(), 'w');
                                //$iconf = '[img]http://file.itsuck.net/icons/' . $host_check.'.png[/img]';
                                $mess = '' . $iconf . '[den][color=white][b]@ ' . $name . ' [/b][/color][/mau][img]http://i.imgur.com/qTUG3QK.gif[/img][right]' . $icon . '[/right][br][center] ' . $entry1 . ' [br][/center][sub](sent from [Host FREE - Sever: ' . $so_sv . '])[/sub]';
                            }
                            post_cbox($mess);
                            // break;
                        } else {
                            return false;
                        }
                        if (stristr($entry1, "Please try again")) {
                            unlink("time/" . strtolower($name) . ".txt");
                        } else {
                            //Luu time post
                            
                            $data = $date . '|';
                            Write_File($time_ip, time(), 'w');
                            Write_File($user_file2, $data, 'a', 1);
                            
                        }
                    }
                }
            }
            //hitpro
            
            /* 	else {
            $check = Check_Link($user_file, $id_user);
            if ($check == true);
            else //Neu link chua get
            {
            //Luu link xuong
            $log  = fopen($user_file, "a", 1);
            $data = $id_user . '|';
            fwrite($log, $data);
            fclose($log);
            if (Check_Vip($viplist, $name) == true || Check_Vip2($viplist2, $name) == true) {
            
            $mess = '[luc][b][big]@ ' . $name . ' [/b][/big][/mau][br][center][color=red] Sorry [/color][luc][big]V.I.P[/big][/mau][color=red]! We don\'t Support your link ! [/color][br][color=green]We will try\'in support in the next time[/color] [br][color=blue] Type: \' check sp \' to check are supported. [/color][/center][sub](sent from [Host Vip - Sever: Not Support])[/sub]';
            post_cbox($mess);
            }
            
            elseif (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true || Check_Manager($manager, $name) == true) {
            
            $mess = '[la][b][big]@ ' . $name . ' [/b][/big][/mau][center][color=red] Sorry [/color][la][big]Manager[/big][/mau][color=red]! We don\'t Support your link ! [/color][br][color=green]We will try\'in support in the next time[/color] [br][color=blue] Type: \' check sp \' to check are supported. [/color][/center][sub](sent from [Host Vip - Sever: Not Support])[/sub]';
            post_cbox($mess);
            }else{
            
            }
            
            
            
            }
            }  */
        }
    }
}


?>