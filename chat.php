<meta http-equiv='refresh' content='1'>
<title>FREE CHAT Running...</title>
<!-- xml version="1.0" encoding="utf-8" -->
<?php
//set_time_limit(0);
date_default_timezone_set("Asia/Ho_Chi_Minh");
//echo date('d/m/Y, H:i:s');
echo "<center><font color=purple size=8><b>FREE USER CHATTING</b></font></center>";
echo "<center><font color=purple size=5><b>FREE USER Started! Do not close the Tab<br>Close the tab to stop FREE USER</b></font></center>";
//Include acc
include_once('config.php');
include_once('cmd.php');
include_once('danhngon.php');
include_once('functions.php');
$cboxurl = $cbox_url . "&sec=main";
echo "<br>Cbox: " . $cboxurl;
$arr     = "";
$arrid   = "";
$a       = file_get_contents($cboxurl);
$matches = explode('<tr id=', $a);
for ($i = 2; $i < 15; $i++) {
    $mess1 = $matches[$i];
    //Get ID User
    preg_match('%"(.*)">%U', $mess1, $id);
    $id_user       = $id[1];
    $arrid[$i - 3] = $id_user;
    //Get User Name
    preg_match('%<b class="(.*)">(.*)</b>%U', $mess1, $mem);
    $name        = $mem[2];
    $arr[$i - 3] = $name;
    //Get Chat
    preg_match('%</b>:(.*?)</td></tr>%U', $mess1, $chat);
    $chat = $chat[1];
    //Get Date
    preg_match('%<div class="(.*)">%U', $mess1, $dc);
    preg_match('%<div class="' . $dc[1] . '">(.*)</div>%U', $mess1, $date);
    $date       = $date[1];
    $date2      = date('d/m/Y, H:i:s');
    //Make userfile
    $user_file  = "chat/" . $name . ".txt"; //make chat post
    $user_file2 = "AUTOPOST.txt"; //make notification
    //Check Bot, Bots, Media
    if (preg_match('/\[media](.*)\[\/media]/', $mess1) /* Skip bbcode [media] */ || Check_Bot($bots, $name) == true || strcmp($name, $Bot_Name) == 0); //Neu la Bot, Bots thi ko tra loi
    else { //Neu khong phai la Bot, Bots, Media
        //Kiem tra post cua user co chua link down hay ko?
        $link = explode('<a class="autoLink" href="', $chat);
        $link = explode('"', $link[1]);
        $link = $link[0];
        if (strpos(str_replace(" ", "",$chat), 'multileech') != 0 || strpos($chat, 'is.gd/xbjth8') != 0 ||  strpos($chat, 'all host online free unlimited no ads') != 0 || strpos($chat, '144.217.146.53') != 0 || strpos($chat, 'http://wmshort.link/YfRj') != 0 || strpos($chat, 'http://techdebrid.com') != 0 || strpos($chat, 'http://ko.tc/EhG') != 0 || strpos(strtolower($chat), 'fas.st/h-t') != 0 || strpos(strtolower($chat), '185.132.127.26') != 0 || strpos(strtolower($chat), 'free debrid') != 0 || strpos(strtolower($chat), '213.238.168.23') != 0 || strpos(strtolower($chat), 'rapigator uploded turbobit depfile bigfile allhost realdebrid') != 0 || strpos(strtolower($chat), 'bit.ly/2kRypmU') != 0 || strpos(strtolower($chat), 'free debrid rapigator') != 0 || strpos(strtolower($chat), 'www.kisa.link') != 0 || strpos(strtolower($chat), '188.214.134.216') != 0 || strpos(strtolower($chat), 'techdebrid.com') != 0 || strpos(strtolower($chat), 'kisalt.xyz/T3jMS') != 0 || strpos(strtolower($chat), 'http://tiny.cc/1411iy') != 0 || strpos(strtolower($chat), 'tinyurl.com/zk8gsbz') != 0) {
            //Luu file + time
            $data = $id_user . '|';
            Write_File($user_file, $data, 'a', 1);
            if (Check_Blacklist($blacklist, $name) == false) {
                $bl = simplexml_load_file($config['blacklist']);
                $bl->addChild('name', $name);
                $bl->asXML($config['blacklist']);
                $mess       = "[center][b] Đã thêm[color=blue] " . $name . " [/color]vào danh sách đen[color=red] forever [/color]vì lý do[color=green] Spam [/color][/b] bye [/center]";
                //	post_cbox($mess);
                //Luu file + info
                $nick       = $name;
                $user_file3 = "banned/" . $nick . ".txt";
                $log        = fopen($user_file3, "a", 1);
                $data       = time() . '\r\n999\r\nSpam\r\nAUTO BANNED|';
                fwrite($log, $data);
                fclose($log);
            } else { //Neu da co trong danh sach den
                //	post_cbox("[center][b]Thành viên[color=blue] ".$arr[0]." [/color]đã có trong danh sách đen![/b] ");
                //Luu file + info
                $nick       = $name;
                $user_file3 = "banned/" . $nick . ".txt";
                $log        = fopen($user_file3, "a", 1);
                //	$data = $date2.'-forever-Spam-AUTO+BANNED|';
                $data       = time() . '\r\n999\r\nSpam\r\nAUTO BANNED|';
                fwrite($log, $data);
                fclose($log);
            }
            Banned_Spamer($name, $id_user);
            Del_Mess_Blacklist($name);
            Del_Mess_Nick($name);
        }
        if (!$link) { //Neu ko chua link down
            if ($bot_notify == true) { //Neu post thong bao du X phut
                if (file_get_contents("AUTOPOST.txt") <= (time() - $danhngon * 60)) {
                    @file_put_contents("AUTOPOST.txt", time());
                    $mess = '[center][b][den][color=white]' . $loihay . ' [/color][/mau][/b][/center]';
                    post_dn($mess);
                }
            }
            if ($bot_talk == true) { //Neu bot talk on
                $check = Check_Chat($chat, $user_file, $id_user);
                if ($check == true);
                else {
                    if (strpos(strtolower($chat), 'free') != 0 && strpos(strtolower($chat), ':tim') != 0) {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[b][color=blue]" . $name . "[/color], Vẫn sống đây. tìm gì thế ?[/b] :toiha ";
                        post_cbox($mess);
                    } elseif (strpos(strtolower($chat), 'idm ') != 0 || strpos(strtolower($chat), 'idm crack') != 0 || strpos(strtolower($chat), 'tải idm') != 0 || strpos(strtolower($chat), 'tai idm') != 0 || strpos(strtolower($chat), 'idm mới nhất') != 0 || strpos(strtolower($chat), 'idm moi nhat') != 0) {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[b][color=blue]" . $name . " [/color]: tải IDM tại đây : [url=http://www.fshare.vn/file/AN4D7L5NMTX2][den]Internet Download Manager (IDM) 6.23 Build 11 Registered Fake Serial Fixed (32bit 64bit Patch)[/mau][/url] [/b]";
                        post_cbox($mess);
                    } elseif (strpos(strtolower($chat), 'hdvip') != 0 || strpos(strtolower($chat), 'hd vip') != 0) {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[b][color=blue]" . $name . "[/b][/color] vip chỉ có lệnh ' check sp ' và ' infovip '  thôi hehe ";
                        post_cbox($mess);
                    } elseif (strpos(strtolower($chat), 'dkm') != 0 || strpos(strtolower($chat), 'vcc') != 0 || strpos(strtolower($chat), 'vkl') != 0) {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[b][color=blue]" . $name . "[/color], [color=red]Vui lòng không sử dụng những từ ngữ thô tục nếu không bạn sẽ bị kỷ luật[/color][/b] :ban ";
                        post_cbox($mess);
                    } elseif (strpos(strtolower($chat), 'infovip') != 0 || strpos(strtolower($chat), 'my vip') != 0 || strpos(strtolower($chat), 'info vip') != 0) {
                        $command = "infovip";
                        Del_Mess_One($name, $command);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $ten      = $nem[1];
                        $timepre  = file_get_contents("http://vnz-leech.com/mobilepay/check_vip.php?apikey=vnzleech_vip_checker&user=" . urlencode($name));
                        $time_GMT = new DateTime('@' . $timepre); // ngày hết hạn
                        $time_GMT->setTimeZone(new DateTimeZone('Asia/Ho_Chi_Minh'));
                        $time_premium = $time_GMT->format('d/m/Y, G:i a');
                        $timepremium  = intval(abs($timepre - time()) / 86400);
                        $timecount    = $timepremium; // số ngày còn lại
                        if (Check_Vip($viplist, $name) == true) { //Neu khong phai super admin, admin hay manager va chua du X phut
                            if ($timepre == "User khong ton tai") {
                                $mess = "[b][big][cam]@" . $name . "[/big][/b][/mau]: [b][color=brown]Không tìm được thông tin vip của bạn[/b][/color] potay ";
                                post_cbox($mess);
                            } else {
                                $mess = "[b][big][cam]@" . $name . "[/big][/b][/mau] [center][b][den] ngày hết hạn vip của bạn :[/mau][big][tim] " . $time_premium . " [/mau][/big] [br][color=blue]" . $timecount . " ngày [/color][/b][/center]";
                                post_cbox($mess);
                            }
                        } elseif (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true || Check_Manager($manager, $name) == true) {
                            $mess = "[b][big][vang]@" . $name . "[/big][/b][/mau]   [b][color=blue]Đùa nhau à ??? BQT rồi còn đòi check vip [/b][/color][img]http://i.imgur.com/odrDCrm.gif[/img]";
                            post_cbox($mess);
                        } elseif ($timepre == "0") {
                            $mess = "[b][big][cam]@" . $name . "[/big][/b][/mau]: [b][color=brown]Không tìm được thông tin vip của bạn[/b][/color]  ";
                            post_cbox($mess);
                        } else {
                            $mess = "[b][big][den]@" . $name . "[/big][/b][/mau] [center][b][color=blue] Sory bạn không phải là VIP [br] [url=http://vnz-leech.com/mobilepay/] Nạp vip ở đây để mình check ngày vip cho bạn nhé[/url][/b][/color][img]http://i.imgur.com/DEOCNoJ.gif[/img] [/center]";
                            post_cbox($mess);
                        }
                    } elseif (preg_match("/info '(.*?)'(.*)/", $chat, $nem)) {
                        $command = "info '";
                        Del_Mess_One($name, $command);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $ten      = $nem[1];
                        $timepre  = file_get_contents("http://vnz-leech.com/mobilepay/check_vip.php?apikey=vnzleech_vip_checker&user=" . urlencode($ten));
                        $time_GMT = new DateTime('@' . $timepre); // ngày hết hạn
                        $time_GMT->setTimeZone(new DateTimeZone('Asia/Ho_Chi_Minh'));
                        $time_premium = $time_GMT->format('d/m/Y, G:i a');
                        $timepremium  = intval(abs($timepre - time()) / 86400);
                        $timecount    = $timepremium; // số ngày còn lại
                        if (stristr($timepre, 'User khong ton tai') != 0) {
                            $mess = "[b][cam]@" . $name . "[/b][/mau]: [b][color=brown]Không tìm được thông tin vip của " . $ten . "[/b][/color] potay ";
                            post_cbox($mess);
                        } elseif (stristr($timepre, '0') != 0) {
                            $mess = "[b][big][cam]@" . $name . "[/big][/b][/mau]: [b][color=brown]Không tìm được thông tin vip của " . $ten . "[/b][/color]  ";
                            post_cbox($mess);
                        } elseif (Check_SuperAdmin($superadmin, $ten) == true || Check_Admin($adminlist, $ten) == true || Check_Manager($manager, $ten) == true) { //Neu khong phai super admin, admin hay manager va chua du X phut
                            $mess = "[b][big][vang]@" . $name . "[/big][/b][/mau]   [b][color=blue]Đùa nhau à ??? bạn " . $ten . " là BQT rồi còn đòi check vip [/b][/color][img]http://i.imgur.com/odrDCrm.gif[/img]";
                            post_cbox($mess);
                        } elseif (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true || Check_Manager($manager, $name) == true) { //Neu khong phai super admin, admin hay manager
                            $mess = "[b][cam]@" . $name . "[/b][/mau] [center][b][den] ngày hết hạn vip của bạn [color=white]" . $ten . "[/color] :[/mau][big][tim] " . $time_premium . " [/mau][/big] [br][color=brown]" . $timecount . " ngày[/color][/b][/center]";
                            post_cbox($mess);
                        }
                    } elseif (strpos(strtolower($chat), 'ai get') != 0 || strpos(strtolower($chat), 'ko get') != 0 || strpos(strtolower($chat), 'khong get') != 0 || strpos(strtolower($chat), 'không get') != 0) {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[b][color=blue]" . $name . "[/color], Vui lòng chờ Mod/S.Vip/Pro online get cho bạn nhé[/b] :( ";
                        //	post_cbox($mess);
                    } elseif (strpos(strtolower($chat), 'fuck') != 0 || strpos(strtolower($chat), 'fucking') != 0 || strpos(strtolower($chat), 'shit') != 0 || strpos(strtolower($chat), 'beep') != 0) {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[b][color=blue]" . $name . "[/color], Do not using the churlish words or you will be banned[/b] :ban ";
                        post_cbox($mess);
                    } elseif (strpos(strtolower($chat), 'my link') != 0 || strpos(strtolower($chat), 'my links') != 0 || strpos(strtolower($chat), 'help') != 0) {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[b][color=blue]" . $name . "[/color], Please wait Mod or S.Vip/Pro online to get link for you![/b] [img]http://i.imgur.com/cAkVYyP.gif[/img]";
                        //	post_cbox($mess);
                    } elseif (strpos(strtolower($chat), 'sex') != 0 || strpos(strtolower($chat), 'porn') != 0 || strpos(strtolower($chat), 'adult') != 0 || strpos(strtolower($chat), 'jav') != 0 || strpos(strtolower($chat), 'hentai') != 0) {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = '[b]Anh nào xem XXX thế cho em xem với được ko?[/b] :mogi ';
                        //	post_cbox($mess);
                    } elseif (strpos($chat, 'Thank') != 0 || strpos($chat, 'Thanks') != 0 || strpos(strtolower($chat), 'cam on') != 0 || strpos(strtolower($chat), 'cám on') != 0 || strpos(strtolower($chat), 'cảm ơn') != 0) {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = 'Mình có giúp được gì đâu, cảm ơn làm chi, ngại lắm :2ngai ';
                        //	post_cbox($mess);
                    } elseif (strpos(strtolower($chat), 'donate') != 0 || strpos(strtolower($chat), 'ung ho') != 0 || strpos(strtolower($chat), 'ủng hộ') != 0 || strpos(strtolower($chat), 'dong gop') != 0 || strpos(strtolower($chat), 'đóng góp') != 0 || strpos(strtolower($chat), 'len vip') != 0 || strpos(strtolower($chat), 'lên vip') != 0 || strpos(strtolower($chat), 'thanh vip') != 0 || strpos(strtolower($chat), 'thành vip') != 0) {
                        if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true || Check_Manager($manager, $name) == true || Check_Vip($viplist, $name) == true || Check_Vip2($viplist2, $name) == true) {
                        } else {
                            //Luu file + time
                            $data = $id_user . '|';
                            Write_File($user_file, $data, 'a', 1);
                            $mess = "[b][color=blue]" . $name . "[/color], [url=http://vnz-leech.com/donate]Mời bạn vào đây để đóng góp ủng hộ Cbox nhé[/url][/b] :ken ";
                            post_cbox($mess);
                        }
                    } elseif (strpos(strtolower($chat), 'resume') != 0 || strpos(strtolower($chat), 'resume the nao') != 0 || strpos(strtolower($chat), 'resume thế nào') != 0 || strpos(strtolower($chat), 'resume nhu nao') != 0 || strpos(strtolower($chat), 'resume như nào') != 0 || strpos(strtolower($chat), 'resume nhu the nao') != 0 || strpos(strtolower($chat), 'resume như thế nào') != 0 || strpos(strtolower($chat), 'resume sao') != 0 || strpos(strtolower($chat), 'resume ra sao') != 0 || strpos(strtolower($chat), 'sao resume') != 0 || strpos(strtolower($chat), 'de resume') != 0 || strpos(strtolower($chat), 'để resume') != 0 || strpos(strtolower($chat), 'add proxy') != 0) {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[b][color=blue]" . $name . "[/color], [color=red]Hướng dẫn download bằng proxy, resume[/color]: [url=http://huongdan-vnzleech.blogspot.jp/p/huong-dan-resume.html][color=green]Hướng Dẫn[/color][/url][/b]";
                        post_cbox($mess);
                    } elseif (strpos(strtolower($chat), 'bot off') != 0 || strpos(strtolower($chat), 'stop bot') != 0) {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[b][color=blue]" . $name . "[/color], Tuổi gì mà đòi ra lệnh cho anh[/b] :2lac ";
                        //	post_cbox($mess);
                    } elseif (strpos(strtolower($chat), 'talk off') != 0 || strpos(strtolower($chat), 'stop talk') != 0) {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[b][color=blue]" . $name . "[/color], Còn lâu mới off nhé, cứ chém gió đấy làm gì nhau?[/b] :2leu ";
                        //	post_cbox($mess);
                    }
                }
            }
            if ($bot_chat == true) { //Neu bot chat on
                $check = Check_Chat($chat, $user_file, $id_user);
                if ($check == true);
                else {
                    if (preg_match("/(.*?)'VNZ-FREE'(.*?)/", strtolower($chat))) {
                        if (Check_SuperAdmin($superadmin, $name) == false && Check_Admin($adminlist, $name) == false && Check_Manager($manager, $name) == false) {
                            //Luu file + time
                            $data = $id_user . '|';
                            Write_File($user_file, $data, 'a', 1);
                            $mess = "[center] :ban [b][color=red]BANNED[/color][color=green] " . $name . " [/color][color=red]forever[/color] [color=blue]Reason:[/color] [color=black]Chống chụy à[/color][/b] :leu [/center]";
                            post_cbox($mess);
                        }
                    } elseif (preg_match("/check '(.*?)'(.*)/", $chat, $nem)) {
                        $command = "check '";
                        Del_Mess_One($name, $command);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $ten        = $nem[1];
                        $nick       = $nem[1];
                        $user_file3 = "banned/" . $nick . ".txt";
                        $thongtin   = Check_Banned($user_file3, $ten);
                        if ($thongtin != false) //Neu co file user
                            {
                            list($times_ban, $time_banned, $reason, $bannedby) = $thongtin;
                            $time_ban = gmdate('H:i:s - d/m/Y', $times_ban);
                            $mess     = '[den][b]@ ' . $name . ' [/b][/mau] :chi [center][b][color=purple]Bạn[/color][color=blue] ' . $ten . ' [/color][color=purple]đang nằm trong danh sách đen do bị BAN[/color][color=red] ' . $time_banned . ' ngày [/color][color=purple]lúc[/color][color=red] ' . $time_ban . ' [/color][color=purple] vì[/color][color=red] ' . $reason . '[/color][color=brown] ban bởi [/color][vang] ' . $bannedby . ' [/mau][br][/b][/center]';
                            post_cbox($mess);
                        } else {
                            $mess = '[center][b][color=purple]' . $name . '[/color] : [color=blue] ' . $ten . ' [/color][color=purple]không bị kỷ luật[/color][/b] : [/center]';
                            post_cbox($mess);
                        }
                    } elseif (strpos(strtolower($chat), 'check sp') != 0 || strpos(strtolower($chat), 'check support') != 0) {
                        if (Check_Vip($viplist, $name) == true || Check_Vip2($viplist2, $name) == true) {
                        } else {
                            //Luu file + time
                            $data = $id_user . '|';
                            Write_File($user_file, $data, 'a', 1);
                            $numhost = explode(",", $bot_support);
                            $numhost = count($numhost);
                            $mess    = "[b][color=blue]" . $name . "[/color] :chi [center][color=purple]I only support [la][big](" . $numhost . " Host)[/big][/mau] for Free Member:[/color][br][color=green]" . $bot_support . "[/color][br][color=red]Lưu ý (Note)[/color]: [color=#F0F]Letitbit, Turbobit, Novafile, Datafile, Littlebyte, Keep2share[/color] [color=purple]chỉ dành cho thành viên Vip (only for Vip members)[/color][/center][/b]";
                            post_cbox($mess);
                        }
                    } elseif (strpos(strtolower($chat), 'hd ken') != 0) {
                        $command = "hd ken";
                        Del_Mess_One($name, $command);
                        if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true || Check_Manager($manager, $name) == true) { //Neu la super admin, admin hoac manager
                            //Luu file + time
                            $log  = fopen($user_file, "a", 1);
                            $data = $id_user . '|';
                            fwrite($log, $data);
                            fclose($log);
                            $mess = "[center][b] :muiten [color=green]HƯỚNG DẪN SỬ DỤNG AUTOBOT[/color][br][br][color=red]check/add/del super admin[/color]: kiểm tra/thêm/xóa Super Admin[br][color=red]check/add/del admin[/color]: kiểm tra/thêm/xóa thành viên Admin[br][color=blue]check manager[/color]/[color=red]add manager/del manager[/color]: kiểm tra/thêm xóa MOD[br][color=purple]check bot/add bot/del bot[/color]: kiểm tra/thêm xóa các cộng tác viên[br][color=purple]check mvip/add mvip/del mvip[/color]: kiểm tra/thêm/xóa thành viên Vip của Cbox[br][color=purple]check bl/add bl 'user/time/reason'/del bl[/color]: kiểm tra/thêm/xóa thành viên danh sách đen[br][color=purple]check ip 'user'[/color]: kiểm tra địa chỉ ip của thành viên[br][color=purple]check user 'name'[/color]: kiểm tra địa chỉ hiện tại của thành viên[br][color=purple]del mess 'user'[/color]: xóa chat của thành viên[br][color=red]ban/clear all[/color]: kỷ luật tất cả/xóa toàn bộ chat trong cbox[br][color=purple]kill 'user/time/reason'/summon 'user'[/color]: kỷ luật/triệu hồi thành viên[br][color=purple]begin autobot/end autobot[/color]: kích hoạt/ngừng get link của autobot[br][color=purple]notify on/notify off[/color]: mở/dừng thông thông báo cho thành viên[br][color=purple]chat on/chat off[/color]: kích hoạt/ngừng chế độ giải trí - xả stress[br][color=purple]start chat/stop chat[/color]: khởi động/vô hiệu chat của autobot[br][color=purple]fs/4s/nl/ul/rg/... on/off[/color]: mở/tắt get link các file host[br][color=purple]all host on/off[/color]: mở/tắt get link tất cả các file host[br][color=purple]check host[/color]: kiểm tra trạng thái file host hỗ trợ và ko hỗ trợ[/b][/center]";
                            //	post_cbox($mess);
                        }
                    } elseif (strpos(strtolower($chat), 'phat nhac') != 0 || strpos(strtolower($chat), 'phát nhạc') != 0 || strpos(strtolower($chat), 'mo nhac') != 0 || strpos(strtolower($chat), 'mở nhạc') != 0 || strpos(strtolower($chat), 'nghe nhac') != 0 || strpos(strtolower($chat), 'nghe nhạc') != 0 || strpos(strtolower($chat), 'yeu cau nhac') != 0 || strpos(strtolower($chat), 'yêu cầu nhạc') != 0) {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center] :nghenhac [b][color=purple]Yêu cầu nhạc =>> [/color][color=blue]music[/color][big] '[/big][color=red]Tên bài hát (Song Name)[/color] - [color=green]Tên ca sĩ (Singer)[/color][big]'[/big][/b] :nghenhac [b] [br] [color=purple] Request Music Sample : music [big]'[/big]Đêm nằm mơ phố - thùy chi[big]'[/big][/color][/b]  [/center]";
                        post_cbox($mess);
                    } elseif (strpos(strtolower($chat), 'phat clip') != 0 || strpos(strtolower($chat), 'phát clip') != 0 || strpos(strtolower($chat), 'mo clip') != 0 || strpos(strtolower($chat), 'mở clip') != 0 || strpos(strtolower($chat), 'xem clip ') != 0 || strpos(strtolower($chat), 'coi clip') != 0 || strpos(strtolower($chat), 'yeu cau clip') != 0 || strpos(strtolower($chat), 'yêu cầu clip') != 0) {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center] :dbanh [b][color=purple]Yêu cầu clip =>> [/color][color=blue]clip[/color] '[color=red]Tên clip (Clip Name)[/color] / [color=green]Tên ca sĩ (Singer)[/color]' [color=purple] <<= Request Clip[/color][/b] :dbanh [/center]";
                        //post_cbox($mess);
                    } elseif (strpos(strtolower($chat), 'phat video') != 0 || strpos(strtolower($chat), 'phát video') != 0 || strpos(strtolower($chat), 'mo video') != 0 || strpos(strtolower($chat), 'mở video') != 0 || strpos(strtolower($chat), 'xem video ') != 0 || strpos(strtolower($chat), 'coi video') != 0 || strpos(strtolower($chat), 'yeu cau video') != 0 || strpos(strtolower($chat), 'yêu cầu video') != 0) {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center] :dbanh [b][color=purple]Yêu cầu video =>> [/color][color=blue]video[/color] '[color=red]Tên video (Video Name)[/color] - [color=green]Tên ca sĩ (Singer)[/color]' [color=purple] <<= Request Video[/color][/b] :dbanh [/center]";
                        post_cbox($mess);
                    } elseif (preg_match("/ken '(.*?)'(.*)/", $chat, $chip)) {
                        $command = "ken '";
                        if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true /* || Check_Manager($manager, $name) == true */ ) { //Lenh danh cho tat ca super admin, admin va manager
                            //Luu file + time
                            $log  = fopen($user_file, "a", 1);
                            $data = $id_user . '|';
                            fwrite($log, $data);
                            fclose($log);
                            $sip = $chip[1];
                            if (strcmp($sip, "Ni") == 0) { // Neu nick can banned la Ni
                                $mess = "[center][b][color=purple]Không được phép động tới người con gái dễ thương và đáng yêu nhất Cbox [/color] [hong]Ni[/mau][/b] :2yeu [/center]";
                                //	post_dj($mess);
                            } else {
                                $data         = file_get_contents("http://mp3.max-debrid.com/getmusic1.php?url=" . $sip);
                                $getlinkmusic = json_decode(substr($data, 1, strlen($data) - 2), true);
                                $linknhac     = $getlinkmusic['link'];
                                $tieude       = $getlinkmusic['title'];
                                $casy         = $getlinkmusic['artist'];
                                //	$mess = "[center][b]Thưa sếp[color=blue] ".$name." [/color], sịp của[color=red] ".$sip." [/color]có màu: ".$color." và in hình ".$hinh_anh." [/b] hehe [/center]";
                                //	$mess = "[b] ".$name." [/b] :chi [media] ".$sip." [/media]";
                                $mess         = '[center] :nghenhac [b][color=purple]Mời bạn[/color][color=blue] ' . $name . ' [/color][color=purple]lắng nghe bài hát[/color][color=red] ' . $tieude . ' [/color][color=purple]do ca sỹ[/color][color=green] ' . $casy . ' [/color][color=purple]trình bày[/color][/b] :nghenhac [b] [br] [media] ' . $linknhac . ' [/media][/b][/center]';
                                post_dj($mess);
                            }
                        } else {
                            $sip  = $chip[1];
                            //	$mess = "[b] ".$name." [/b] :chi [media] ".$sip." [/media]";
                            $mess = '[center] :nghenhac [b][color=purple]Mời bạn[/color][color=blue] ' . $name . ' [/color][color=purple]lắng nghe bài hát[/color][color=red] ' . $tieude . ' [/color][color=purple]do ca sỹ[/color][color=green] ' . $casy . ' [/color][color=purple]trình bày[/color][/b] :nghenhac [b] [br] [media] ' . $linknhac . ' [/media][/b][/center]';
                            post_cbox($mess);
                        }
                        Del_Mess_One($name, $command);
                    } elseif (preg_match("/music '(.*?)'/", $chat, $song)) {
                        $command = "music '";
                        if (Check_Blacklist($blacklist, $name) == true) { //Neu nam trong danh sach den
                            $mess = '[color=blue][b] @' . $name . ' [/b][/color] [center][b][color=green]Bạn đang nằm trong danh sách đen nên không thể yêu cầu nhạc[/color][br][color=purple]You are in the blacklist so you can not request music[/color][/b][/center]';
                            post_cbox($mess);
                            //Luu file + time
                            $log  = fopen($user_file, "a", 1);
                            $data = $id_user . '|';
                            fwrite($log, $data);
                            fclose($log);
                        } elseif (Check_Music($user_file, $date) == true && Check_SuperAdmin($superadmin, $name) == false && Check_Admin($adminlist, $name) == false && Check_Manager($manager, $name) == false && Check_Vip($viplist, $name) == false) { //Neu khong phai super admin, admin hay manager va chua du X phut
                            $mess = '[color=blue][b] @' . $name . ' [/b][/color] [center][b][color=green]Bạn chỉ có thể yêu cầu bài hát 1 lần trong ' . $limit_music . ' phút | Vip ko gi?i h?n[/color][br][color=purple]You just can request only 1 song per ' . $limit_music . ' minutes | Vip unlimited[/color][/b][/center]';
                            post_cbox($mess);
                            //Luu file + time
                            $log  = fopen($user_file, "a", 1);
                            $data = $id_user . '|';
                            fwrite($log, $data);
                            fclose($log);
                        } else {
                            //Luu file + time
                            $log  = fopen($user_file, "a", 1);
                            $data = $id_user . '|';
                            fwrite($log, $data);
                            fclose($log);
                            // Match word $mp3_play and name
                            $mp3_search = trim($song[1]);
                            // Define Keywords
                            $post       = str_replace("%20", "+", urlencode($mp3_search));
                            
                            $data = file_get_contents("http://botfree.itsuck.net/getmp3.php?s=" . $post);
                            
                            if ($data == "notfound") {
                                $mess = "[color=blue][b] @" . $name . " [/b][/color]: [b][color=purple]Không tìm được bài hát nào với từ khoá:[/color][color=green] " . $mp3_search . " [/color][/b] potay ";
                                post_cbox($mess);
                            } else {
                                $mp3_zing   = json_decode($data, true);
                                $name_mp3   = $mp3_zing['title'];
                                $artist_mp3 = $mp3_zing['artist'];
                                $url_mp3    = $mp3_zing['link'];
                                $url_tai    = $mp3_zing['link_tai'];
                                // Format artist_mp3
                                $artist_mp3 = urlencode($artist_mp3);
                                // Format name_mp3
                                $name_mp3   = urlencode($name_mp3);
                                $mess       = '[center] :nghenhac [b][color=purple]Mời bạn[/color][color=blue] ' . $name . ' [/color][color=purple]lắng nghe bài hát[/color][color=red] ' . $name_mp3 . ' [/color][color=purple]do ca sỹ[/color][color=green] ' . $artist_mp3 . ' [/color][color=purple]trình bày[/color][/b] :nghenhac [b] [br][big][den] lệnh yêu cầu nhạc : music \' ten_bai_hat - ca sy \' [/mau][/big][br][vang] Click here to play >> [/mau] [media] ' . $url_mp3 . ' [/media][/b][/center]';
                                if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true || Check_Manager($manager, $name) == true) {
                                    post_dj($mess);
                                } else {
                                    post_cbox($mess); 
									Del_Mess_One($name, $command);
                                }
                            }
                        }
                        Del_Mess_One($name, $command);
                    } /* elseif (preg_match("/music '(.*?)'/", $chat, $song)) {
                    $command = "music '";
                    Del_Mess_One($name, $command);
                    if (Check_Blacklist($blacklist, $name) == true) { //Neu nam trong danh sach den
                    $mess = '[color=blue][b] @' . $name . ' [/b][/color] [center][b][color=green]Bạn đang nằm trong danh sách đen nên không thể yêu cầu nhạc[/color][br][color=purple]You are in the blacklist so you can not request music[/color][/b][/center]';
                    post_cbox($mess);
                    //Luu file + time
                    $log  = fopen($user_file, "a", 1);
                    $data = $chat . '|';
                    fwrite($log, $data);
                    fclose($log);
                    } elseif (Check_Music($user_file, $date) == true && Check_SuperAdmin($superadmin, $name) == false && Check_Admin($adminlist, $name) == false && Check_Manager($manager, $name) == false && Check_Vip($viplist, $name) == false) { //Neu khong phai super admin, admin hay manager va chua du X phut
                    $mess = '[color=blue][b] @' . $name . ' [/b][/color] [center][b][color=green]Bạn chỉ có thể yêu cầu bài hát 1 lần trong ' . $limit_music . ' phút | Vip ko giới hạn[/color][br][color=purple]You just can request only 1 song per ' . $limit_music . ' minutes | Vip unlimited[/color][/b][/center]';
                    post_cbox($mess);
                    //Luu file + time
                    $log  = fopen($user_file, "a", 1);
                    $data = $chat . '|';
                    fwrite($log, $data);
                    fclose($log);
                    } else {
                    //Luu file + time
                    $log  = fopen($user_file, "a", 1);
                    $data = $date . '|' . $chat . '|';
                    fwrite($log, $data);
                    fclose($log);
                    
                    $name_search = trim($song[1]);
                    //Prepare data to search
                    $title       = str_replace("%20", "+", urlencode($name_search));
                    $url         = "http://search.chiasenhac.com/search.php?s=" . $title . '&cat=music';
                    
                    //Request to chiasenhac.com to get data
                    $datas = file_get_contents($url);
                    
                    //Fetching data
                    $music     = "";
                    $names     = "";
                    $artist    = "";
                    $link_song = "";
                    
                    //*=== Find first song result (near by header) 
                    if (!empty($datas)) {
                    $songs = explode('<div class="page-dsms">', $datas);
                    if (!empty($songs[1])) {
                    $link = explode('<p><a href="', $songs[1]);
                    if (!empty($link[1])) {
                    $link_result = explode("\" class=", $link[1]);
                    if (!empty($link_result[0])) {
                    $musics_url = "http://download.chiasenhac.com/" . $link_result[0];
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
                    $mess = '[center] :nghenhac [b][color=purple]Mời bạn[/color][color=blue] ' . $name . ' [/color][color=purple]lắng nghe bài hát[/color][color=red] ' . $names . ' [/color][color=purple]do ca sỹ[/color][color=green] ' . $artist . ' [/color][color=purple]trình bày[/color][/b] :nghenhac [b] [br][big][den] lệnh yêu cầu nhạc : music \' ten_bai_hat - ca sy \' [/mau][/big][br][vang] Click here to play >> [/mau] [media] ' . $link_song . ' [/media] [vang] << Click here to download [/mau][/b][/center]';
                    if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true || Check_Manager($manager, $name) == true) {
                    post_dj($mess);
                    } else {
                    post_cbox($mess);
                    }
                    }
                    } else {
                    $mess = "[color=blue][b] @" . $name . " [/b][/color]: [b][color=purple]Không tìm được bài hát nào với từ khoá:[/color][color=green] " . $name_search . " [/color][/b] potay ";
                    post_cbox($mess);
                    }
                    }
                    }
                    }
                    }
                    }  */ elseif (preg_match("/lyric '(.*?)'/", $chat, $song)) {
                        $command = "lyric '";
                        Del_Mess_One($name, $command);
                        $song = trim($song[1]);
                        if (Check_Blacklist($blacklist, $name) == true) { //Neu nam trong danh sach den
                            $mess = '[color=blue][b] @' . $name . ' [/b][/color] [center][b][color=green]Bạn đang nằm trong danh sách đen nên không thể yêu cầu nhạc[/color][br][color=purple]You are in the blacklist so you can not request music[/color][/b][/center]';
                            post_cbox($mess);
                            //Luu file + time
                            $log  = fopen($user_file, "a", 1);
                            $data = $chat . '|';
                            fwrite($log, $data);
                            fclose($log);
                        } elseif (Check_Music($user_file, $date) == true && Check_SuperAdmin($superadmin, $name) == false && Check_Admin($adminlist, $name) == false && Check_Manager($manager, $name) == false && Check_Vip($viplist, $name) == false) { //Neu khong phai super admin, admin hay manager va chua du X phut
                            $mess = '[color=blue][b] @' . $name . ' [/b][/color] [center][b][color=green]Bạn chỉ có thể yêu cầu bài hát 1 lần trong ' . $limit_music . ' phút | Vip ko giới hạn[/color][br][color=purple]You just can request only 1 song per ' . $limit_music . ' minutes | Vip unlimited[/color][/b][/center]';
                            post_cbox($mess);
                            //Luu file + time
                            $log  = fopen($user_file, "a", 1);
                            $data = $chat . '|';
                            fwrite($log, $data);
                            fclose($log);
                        } else {
                            $mess = lyric($user_file, $song, $name, $date, $chat);
                            if (!empty($mess)) {
                                if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true || Check_Manager($manager, $name) == true) {
                                    post_dj($mess);
                                } else {
                                    post_cbox($mess);
                                }
                            } else {
                                $mess = "[color=blue][b] @" . $name . " [/b][/color]: [b][color=purple]Không tìm được bài hát nào với từ khoá:[/color][color=green] " . $name_search . " [/color][/b] potay ";
                                post_cbox($mess);
                            }
                        }
                    } elseif (preg_match("/video '(.*?)'/", $chat, $video)) {
                        $command = "video '";
                        if (Check_Blacklist($blacklist, $name) == true) { //Neu nam trong danh sach den
                            $mess = '[color=blue][b] @' . $name . ' [/b][/color] [center][b][color=green]Bạn đang nằm trong danh sách đen nên không thể yêu cầu video[/color][br][color=purple]You are in the blacklist so you can not request video[/color][/b][/center]';
                            post_cbox($mess);
                            //Luu file + time
                            $log  = fopen($user_file, "a", 1);
                            $data = $chat . '|';
                            fwrite($log, $data);
                            fclose($log);
                        } elseif (Check_Video($user_file, $date) == true && Check_SuperAdmin($superadmin, $name) == false && Check_Admin($adminlist, $name) == false && Check_Manager($manager, $name) == false && Check_Vip($viplist, $name) == false) { //Neu khong phair super admin, admin hay manager va chua du X phut
                            $mess = '[color=blue][b] @' . $name . ' [/b][/color] [center][b][color=green]Bạn chỉ có thể yêu cầu video 1 lần trong ' . $limit_music . ' phút | Vip ko giới hạn[/color][br][color=purple]You just can request only 1 video per ' . $limit_music . ' minutes | Vip unlimited[/color][/b][/center]';
                            post_cbox($mess);
                            //Luu file + time
                            $log  = fopen($user_file, "a", 1);
                            $data = $chat . '|';
                            fwrite($log, $data);
                            fclose($log);
                        } else {
                            //Luu file + time
                            $log  = fopen($user_file, "a", 1);
                            $data = $chat . '|';
                            fwrite($log, $data);
                            fclose($log);
                            $name_search = $video[1];
                            //Prepare data to search
                            $title       = trim(strtolower($name_search));
                            $url         = "https://www.youtube.com/results?search_query=" . urlencode($title);
                            $data        = file_get_contents($url);
                            $matches     = explode('class="section-list">', $data);
                            $mess        = $matches[1];
                            preg_match('%<a href="(.*)" class="yt-uix-tile-link yt-ui-ellipsis yt-ui-ellipsis-2 yt-uix-sessionlink%U', $mess, $id);
                            $url = $id[1];
                            preg_match('%title="(.*)" aria-describedby="description-id-(.*)" rel="spf-prefetch" dir="%U', $mess, $id);
                            $title = $id[1];
                            $link  = 'https://www.youtube.com' . $url;
                            /*=== Find first song result (near by header) ===*/
                            $mess  = "[center] :hat [b][color=purple]Mời bạn[/color][color=blue] " . $name . " [/color][color=purple]xem video[/color][color=green] " . $title . " [/color] [media] " . $link . " [/media][/b][/center]";
                            if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true || Check_Manager($manager, $name) == true) {
                                post_dj($mess);
                            } else {
                                post_cbox($mess);
                            }
                        }
                        Del_Mess_One($name, $command);
                    }
                }
            }
            if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true || Check_Manager($manager, $name) == true) { //Lenh danh cho tat ca super admin, admin va manager
                if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true) {
                    //Lenh chi danh cho ca super admin va admin
                    $chat = trim($chat);
                    //Check Super Admin
                    if (count(explode($check_superadmin, strtolower($chat))) > 1) {
                        $command = $check_superadmin;
                        Del_Mess_One($name, $command);
                        $check = Check_Chat($chat, $user_file, $id_user);
                        if ($check == true);
                        else {
                            //Luu file + time
                            $log  = fopen($user_file, "a", 1);
                            $data = $id_user . '|';
                            fwrite($log, $data);
                            fclose($log);
                            $sadm = "";
                            for ($i = 0; $i < count($superadmin); $i++) {
                                $sadm .= $superadmin->name[$i] . ', ';
                            }
                            $mess = "[center][b][color=green]Super Admin hiện tại gồm có:[/color][color=red] " . $sadm . " [/color][/b][br][img]http://i.imgur.com/klhSesH.gif[/img][/center]";
                            post_cbox($mess);
                        }
                    }
                    //Add super admin
                    elseif (count(explode($add_superadmin, strtolower($chat))) > 1) {
                        $command = $add_superadmin;
                        Del_Mess_One($name, $command);
                        //Get name to add
                        preg_match("%'(.*)'%U", $chat, $nick);
                        $nick  = $nick[1];
                        $check = Check_Chat($chat, $user_file, $id_user);
                        if ($check == true);
                        else {
                            //Luu file + time
                            $log  = fopen($user_file, "a", 1);
                            $data = $id_user . '|';
                            fwrite($log, $data);
                            fclose($log);
                            if ($nick != "") {
                                //Kiem tra nick nguoi ra lenh co la super admin hay khong?
                                if (Check_SuperAdmin($superadmin, $name) == true) {
                                    //Kiem tra xem nick da co trong list super admin chua?
                                    if (Check_SuperAdmin($superadmin, $nick) == true) {
                                        $mess = "[center][b][color=red]" . $nick . "[/color][color=red]" . $phrase['superadmin_exist'] . "[/color][/b][/center]";
                                    }
                                    //Kiem tra xem nick da co trong list admin chua?
                                    elseif (Check_Admin($adminlist, $nick) == true) {
                                        $mess = "[center][b][color=red]" . $nick . "[/color] [color=red]" . $phrase['admin_exist'] . "[/color][/b][/center]";
                                    }
                                    //Kiem tra xem nick da co trong list manager chua?
                                        elseif (Check_Manager($manager, $nick) == true) {
                                        $mess = "[center][b][color=blue]" . $nick . "[/color] [color=red]" . $phrase['manager_exist'] . "[/color][/b][/center]";
                                    }
                                    //Kiem tra xem nick da co trong list vip chua?
                                        elseif (Check_Vip($viplist, $nick) == true) {
                                        $mess = "[center][b][color=purple]" . $nick . "[/color] [color=red]" . $phrase['vip_exist'] . "[/color][/b][/center]";
                                    }
                                    //Kiem tra xem nick da co trong list bots chua?
                                        elseif (Check_Bot($bots, $nick) == true) {
                                        $mess = "[center][b][color=magenta]" . $nick . "[/color] [color=red]" . $phrase['bots_exist'] . "[/color][/b][/center]";
                                    }
                                    //Kiem tra xem nick da co trong blacklist chua?
                                        elseif (Check_Blacklist($blacklist, $nick) == true) {
                                        $mess = "[center][b][color=maroon]" . $nick . "[/color] [color=red]" . $phrase['blacklist_exist'] . "[/color][/b][/center]";
                                    } else {
                                        //Add
                                        $superadmin = simplexml_load_file($config['superadmin']);
                                        $superadmin->addChild('name', $nick);
                                        $superadmin->asXML($config['superadmin']);
                                        $mess = "[center][b] Đã thêm[color=red] " . $nick . " [/color]vào danh sách Super Admin[/b] [img]http://i.imgur.com/HGr45JV.gif[img][/center]";
                                    }
                                    post_cbox($mess);
                                } else {
                                    post_cbox("[center][b]Xin lỗi, chỉ có duy nhất Super Admin mới có thể thêm Super Admin[/b] :2cuoi [/center]");
                                }
                            }
                        }
                    }
                    //Remove super admin
                        elseif (count(explode($remove_superadmin, strtolower($chat))) > 1) {
                        $command = $remove_superadmin;
                        Del_Mess_One($name, $command);
                        //Get name to add
                        preg_match("%'(.*)'%U", $chat, $nick);
                        $nick  = $nick[1];
                        $check = Check_Chat($chat, $user_file, $id_user);
                        if ($check == true);
                        else {
                            //Luu file + time
                            $log  = fopen($user_file, "a", 1);
                            $data = $id_user . '|';
                            fwrite($log, $data);
                            fclose($log);
                            if ($nick != "") {
                                //Kiem tra nick nguoi ra lenh co la super admin hay khong?
                                if (Check_SuperAdmin($superadmin, $name) == true) {
                                    //Kiem tra xem nick da co trong list super admin chua?
                                    if (Check_SuperAdmin($superadmin, $nick) == true) {
                                        for ($i = 0; $i < count($superadmin); $i++) {
                                            if ($superadmin->name[$i] == $nick) {
                                                unset($superadmin->name[$i]);
                                                $superadmin->asXML($config['superadmin']);
                                            }
                                        }
                                        $mess = "[center][b] Đã xóa[color=red] " . $nick . " [/color]khỏi danh sách Super Admin[/b] [img]http://i.imgur.com/HGr45JV.gif[img][/center]";
                                        post_cbox($mess);
                                    } else {
                                        post_cbox("[center][b]Không tìm thấy [color=red]" . $nick . "[/color] trong danh sách Super Admin[/b] :dauhang [/center]");
                                    }
                                } else {
                                    post_cbox("[center][b]Bạn chưa đủ trình xóa Super Admin[/b] [/center]");
                                }
                            }
                        }
                    }
                    //Check Admin
                        elseif (count(explode($check_admin, strtolower($chat))) > 1) {
                        $command = $check_admin;
                        Del_Mess_One($name, $command);
                        $check = Check_Chat($chat, $user_file, $id_user);
                        if ($check == true);
                        else {
                            //Luu file + time
                            $log  = fopen($user_file, "a", 1);
                            $data = $id_user . '|';
                            fwrite($log, $data);
                            fclose($log);
                            $adm = "";
                            for ($i = 0; $i < count($adminlist); $i++) {
                                $adm .= $adminlist->name[$i] . ', ';
                            }
                            $mess = "[center][b][color=green]Admin hiện tại gồm có:[/color][color=red] " . $adm . " [/color][/b][br][img]http://i.imgur.com/9WgDclP.gif[/img][/center]";
                            post_cbox($mess);
                        }
                    }
                    //Add admin
                        elseif (count(explode($add_admin, strtolower($chat))) > 1) {
                        $command = $add_admin;
                        Del_Mess_One($name, $command);
                        //Get name to add
                        preg_match("%'(.*)'%U", $chat, $nick);
                        $nick  = $nick[1];
                        $check = Check_Chat($chat, $user_file, $id_user);
                        if ($check == true);
                        else {
                            //Luu file + time
                            $log  = fopen($user_file, "a", 1);
                            $data = $id_user . '|';
                            fwrite($log, $data);
                            fclose($log);
                            if ($nick != "") {
                                //Kiem tra nick nguoi ra lenh co la super admin hay khong?
                                if (Check_SuperAdmin($superadmin, $name) == true) {
                                    //Kiem tra xem nick da co trong list super admin chua?
                                    if (Check_SuperAdmin($superadmin, $nick) == true) {
                                        $mess = "[center][b][color=red]" . $nick . "[/color] [color=red]" . $phrase['superadmin_exist'] . "[/color][/b][/center]";
                                    }
                                    //Kiem tra xem nick da co trong list admin chua?
                                    elseif (Check_Admin($adminlist, $nick) == true) {
                                        $mess = "[center][b][color=red]" . $nick . "[/color] [color=red]" . $phrase['admin_exist'] . "[/color][/b][/center]";
                                    }
                                    //Kiem tra xem nick da co trong list manager chua?
                                        elseif (Check_Manager($manager, $nick) == true) {
                                        $mess = "[center][b][color=blue]" . $nick . "[/color] [color=red]" . $phrase['manager_exist'] . "[/color][/b][/center]";
                                    }
                                    //Kiem tra xem nick da co trong list vip chua?
                                        elseif (Check_Vip($viplist, $nick) == true) {
                                        $mess = "[center][b][color=purple]" . $nick . "[/color] [color=red]" . $phrase['vip_exist'] . "[/color][/b][/center]";
                                    }
                                    //Kiem tra xem nick da co trong list bots chua?
                                        elseif (Check_Bot($bots, $nick) == true) {
                                        $mess = "[center][b][color=magenta]" . $nick . "[/color] [color=red]" . $phrase['bots_exist'] . "[/color][/b][/center]";
                                    }
                                    //Kiem tra xem nick da co trong blacklist chua?
                                        elseif (Check_Blacklist($blacklist, $nick) == true) {
                                        $mess = "[center][b][color=maroon]" . $nick . "[/color] [color=red]" . $phrase['blacklist_exist'] . "[/color][/b][/center]";
                                    } else {
                                        //Add
                                        $adminlist = simplexml_load_file($config['admin']);
                                        $adminlist->addChild('name', $nick);
                                        $adminlist->asXML($config['admin']);
                                        $mess = "[center][b] Đã thêm[color=red] " . $nick . " [/color]vào danh sách Admin[/b] [img]http://i.imgur.com/Qh1TchB.gif[/img][/center]";
                                    }
                                    post_cbox($mess);
                                } else {
                                    post_cbox("[center][b]Xin lỗi, chỉ có duy nhất Super Admin mới có thể thêm thành viên Admin[/b] :he [/center]");
                                }
                            }
                        }
                    }
                    //Remove admin
                        elseif (count(explode($remove_admin, strtolower($chat))) > 1) {
                        $command = $remove_admin;
                        Del_Mess_One($name, $command);
                        //Get name to add
                        preg_match("%'(.*)'%U", $chat, $nick);
                        $nick  = $nick[1];
                        $check = Check_Chat($chat, $user_file, $id_user);
                        if ($check == true);
                        else {
                            //Luu file + time
                            $log  = fopen($user_file, "a", 1);
                            $data = $id_user . '|';
                            fwrite($log, $data);
                            fclose($log);
                            if ($nick != "") {
                                //Kiem tra nick nguoi ra lenh co la super admin hay khong?
                                if (Check_SuperAdmin($superadmin, $name) == true) {
                                    //Kiem tra xem nick da co trong list admin chua?
                                    if (Check_Admin($adminlist, $nick) == true) {
                                        for ($i = 0; $i < count($adminlist); $i++) {
                                            if ($adminlist->name[$i] == $nick) {
                                                unset($adminlist->name[$i]);
                                                $adminlist->asXML($config['admin']);
                                            }
                                        }
                                        $mess = "[center][b] Đã xóa[color=red] " . $nick . " [/color]khỏi danh sách thành viên Admin[/b] [img]http://i.imgur.com/Qh1TchB.gif[/img][/center]";
                                        post_cbox($mess);
                                    } else {
                                        post_cbox("[center][b]Không tìm thấy[color=red] " . $nick . " [/color]trong danh sách thành viên Admin[/b] :dauhang [/center]");
                                    }
                                } else {
                                    post_cbox("[center][b]Bạn chưa đủ trình xóa thành viên Admin[/b] [/center]");
                                }
                            }
                        }
                    }
                }
                //Start Bot
                if (count(explode($start_bot, strtolower($chat))) > 1) {
                    $command = $start_bot;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $info = simplexml_load_file($config['cbox_info']);
                        unset($info->work);
                        $info->addChild('work', "true");
                        $info->asXML($config['cbox_info']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b][color=blue]BOT is on [/color][br][/b][img]http://i.imgur.com/U8CoAx6.gif[/img] [b][color=green]everybody ![/color][/b] [/center]";
                        post_cbox($mess);
                    }
                }
                //Stop Bot
                elseif (count(explode($stop_bot, strtolower($chat))) > 1) {
                    $command = $stop_bot;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $info = simplexml_load_file($config['cbox_info']);
                        unset($info->work);
                        $info->addChild('work', "false");
                        $info->asXML($config['cbox_info']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b][color=blue]Bot is Off ! [/color][/b][br] bye " . $name . " [/center]";
                        post_cbox($mess);
                    }
                }
                //Start bot notify
                    elseif (count(explode($start_notify, strtolower($chat))) > 1) {
                    $command = $start_notify;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $info = simplexml_load_file($config['cbox_info']);
                        unset($info->notify);
                        $info->addChild('notify', "true");
                        $info->asXML($config['cbox_info']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b][color=blue]OK ! [/color][color=red] " . $name . " [/color][br][color=blue]danh ngôn is on![/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop bot notify
                    elseif (count(explode($stop_notify, strtolower($chat))) > 1) {
                    $command = $stop_notify;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $info = simplexml_load_file($config['cbox_info']);
                        unset($info->notify);
                        $info->addChild('notify', "false");
                        $info->asXML($config['cbox_info']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b][color=blue]OK ! [/color][color=red] " . $name . " [/color][br][color=blue]danh ngôn is off ![/color][/b] [/center]";
                        post_cbox($mess);
                    }
                }
                //Start bot chat
                    elseif (count(explode($start_chat, strtolower($chat))) > 1) {
                    $command = $start_chat;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $info = simplexml_load_file($config['cbox_info']);
                        unset($info->chat);
                        $info->addChild('chat', "true");
                        $info->asXML($config['cbox_info']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b][color=blue]OK ! [/color][color=red] " . $name . " [/color][br][color=blue]Chat is On ![/color][/b] [/center]";
                        post_cbox($mess);
                    }
                }
                //Stop bot chat
                    elseif (count(explode($stop_chat, strtolower($chat))) > 1) {
                    $command = $stop_chat;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $info = simplexml_load_file($config['cbox_info']);
                        unset($info->chat);
                        $info->addChild('chat', "false");
                        $info->asXML($config['cbox_info']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b][color=blue]OK ! [/color][color=red] " . $name . " [/color][br][color=blue]Chat is Off ![/color][/b] :3bye [/center]";
                        post_cbox($mess);
                    }
                }
                //Start bot talk
                    elseif (count(explode($start_talk, strtolower($chat))) > 1) {
                    $command = $start_talk;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $info = simplexml_load_file($config['cbox_info']);
                        unset($info->talk);
                        $info->addChild('talk', "true");
                        $info->asXML($config['cbox_info']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b][color=blue]OK ! [/color][color=red] " . $name . " [/color][br][color=blue]Talk is On ![/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop bot talk
                    elseif (count(explode($stop_talk, strtolower($chat))) > 1) {
                    $command = $stop_talk;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $info = simplexml_load_file($config['cbox_info']);
                        unset($info->talk);
                        $info->addChild('talk', "false");
                        $info->asXML($config['cbox_info']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b][color=blue]OK ! [/color][color=red] " . $name . " [/color][br][color=blue]Talk is Off ![/color][/b] [/center]";
                        post_cbox($mess);
                    }
                }
                //Start ZIP link
                    elseif (count(explode($start_ziplink, strtolower($chat))) > 1) {
                    $command = $start_ziplink;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $info = simplexml_load_file($config['cbox_info']);
                        unset($info->ziplink);
                        $info->addChild('ziplink', "true");
                        $info->asXML($config['cbox_info']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b][color=blue]OK ! [/color][color=red] " . $name . " [/color][br][color=green]ZipLink is On ![/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop ZIP link
                    elseif (count(explode($stop_ziplink, strtolower($chat))) > 1) {
                    $command = $stop_ziplink;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $info = simplexml_load_file($config['cbox_info']);
                        unset($info->ziplink);
                        $info->addChild('ziplink', "false");
                        $info->asXML($config['cbox_info']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b][color=blue]OK ! [/color][color=red] " . $name . " [/color][br][color=green]Ziplink is Off ![/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Check manager
                    elseif (count(explode($check_manager, strtolower($chat))) > 1) {
                    $command = $check_manager;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mod = "";
                        for ($i = 0; $i < count($manager); $i++) {
                            $mod .= $manager->name[$i] . ', ';
                        }
                        $mess = "[center][b][color=green]MOD hiện tại gồm có:[/color][color=blue] " . $mod . " [/color][/b][br][/center]";
                        post_cbox($mess);
                    }
                }
                //Add manager
                    elseif (count(explode($add_manager, strtolower($chat))) > 1) {
                    $command = $add_manager;
                    Del_Mess_One($name, $command);
                    //Get name to add
                    preg_match("%'(.*)'%U", $chat, $nick);
                    $nick  = $nick[1];
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        if ($nick != "") {
                            //Kiem tra nick nguoi ra lenh la admin tro len hay khong?
                            if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true) {
                                //Kiem tra xem nick da co trong list super admin chua?
                                if (Check_SuperAdmin($superadmin, $nick) == true) {
                                    $mess = "[center][b][color=red]" . $nick . "[/color] [color=red]" . $phrase['superadmin_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong list admin chua?
                                elseif (Check_Admin($adminlist, $nick) == true) {
                                    $mess = "[center][b][color=red]" . $nick . "[/color] [color=red]" . $phrase['admin_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong list manager chua?
                                    elseif (Check_Manager($manager, $nick) == true) {
                                    $mess = "[center][b][color=blue]" . $nick . "[/color] [color=red]" . $phrase['manager_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong list vip chua?
                                    /* elseif (Check_Vip($viplist, $nick) == true) {
                                $mess = "[center][b][color=purple]".$nick."[/color] [color=red]".$phrase['vip_exist']."[/color][/b][/center]";
                                } */ 
                                //Kiem tra xem nick da co trong list bots chua?
                                    elseif (Check_Bot($bots, $nick) == true) {
                                    $mess = "[center][b][color=magenta]" . $nick . "[/color] [color=red]" . $phrase['bots_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong blacklist chua?
                                    elseif (Check_Blacklist($blacklist, $nick) == true) {
                                    $mess = "[center][b][color=maroon]" . $nick . "[/color] [color=red]" . $phrase['blacklist_exist'] . "[/color][/b][/center]";
                                } else {
                                    //Add
                                    $manager = simplexml_load_file($config['cbox_manager']);
                                    $manager->addChild('name', $nick);
                                    $manager->asXML($config['cbox_manager']);
                                    $mess = "[center][b] Đã thêm[color=blue] " . $nick . " [/color]vào danh sách MOD[/b] [/center]";
                                }
                                post_cbox($mess);
                            } else {
                                post_cbox("[center][b]Xin lỗi, chỉ thành viên Admin mới có thể thêm MOD[/b] :hoho [/center]");
                            }
                        }
                    }
                }
                //Remove manager
                    elseif (count(explode($remove_manager, strtolower($chat))) > 1) {
                    $command = $remove_manager;
                    Del_Mess_One($name, $command);
                    //Get name to add
                    preg_match("%'(.*)'%U", $chat, $nick);
                    $nick  = $nick[1];
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        if ($nick != "") {
                            //Kiem tra nick nguoi ra lenh la admin tro len hay khong?
                            if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true) {
                                //Kiem tra xem nick da co trong list manager chua?
                                if (Check_Manager($manager, $nick) == true) {
                                    for ($i = 0; $i < count($manager); $i++) {
                                        if ($manager->name[$i] == $nick) {
                                            unset($manager->name[$i]);
                                            $manager->asXML($config['cbox_manager']);
                                        }
                                    }
                                    $mess = "[center][b] Đã xóa[color=blue] " . $nick . " [/color]khỏi danh sách MOD[/b] [/center]";
                                    post_cbox($mess);
                                } else {
                                    post_cbox("[center][b]Không tìm thấy[color=blue] " . $nick . " [/color]trong danh sách MOD[/b] :dauhang [/center]");
                                }
                            } else {
                                post_cbox("[center][b]Bạn chưa đủ trình xóa MOD[/b] [/center]");
                            }
                        }
                    }
                }
                //Check bots
                    elseif (count(explode($check_bot, strtolower($chat))) > 1) {
                    $command = $check_bot;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $bot = "";
                        for ($i = 0; $i < count($bots); $i++) {
                            $bot .= $bots->name[$i] . ', ';
                        }
                        $mess = "[center][b][color=green]Danh sách cộng tác viên gồm có:[/color][color=magenta] " . $bot . " [/color][/b][br][/center]";
                        post_cbox($mess);
                    }
                }
                //Add bots
                    elseif (count(explode($add_bot, strtolower($chat))) > 1) {
                    $command = $add_bot;
                    Del_Mess_One($name, $command);
                    //Get name to add
                    preg_match("%'(.*)'%U", $chat, $nick);
                    $nick  = $nick[1];
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        if ($nick != "") {
                            //Kiem tra nick nguoi ra lenh la manager tro len hay khong?
                            if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true || Check_Manager($manager, $name) == true) {
                                //Kiem tra xem nick da co trong list super admin chua?
                                if (Check_SuperAdmin($superadmin, $nick) == true) {
                                    $mess = "[center][b][color=red]" . $nick . "[/color] [color=red]" . $phrase['superadmin_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong list admin chua?
                                elseif (Check_Admin($adminlist, $nick) == true) {
                                    $mess = "[center][b][color=red]" . $nick . "[/color] [color=red]" . $phrase['admin_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong list manager chua?
                                    elseif (Check_Manager($manager, $nick) == true) {
                                    $mess = "[center][b][color=blue]" . $nick . "[/color] [color=red]" . $phrase['manager_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong list vip chua?
                                    elseif (Check_Vip($viplist, $nick) == true) {
                                    $mess = "[center][b][color=purple]" . $nick . "[/color] [color=red]" . $phrase['vip_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong list bots chua?
                                    elseif (Check_Bot($bots, $nick) == true) {
                                    $mess = "[center][b][color=magenta]" . $nick . "[/color] [color=red]" . $phrase['bots_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong blacklist chua?
                                    elseif (Check_Blacklist($blacklist, $nick) == true) {
                                    $mess = "[center][b][color=maroon]" . $nick . "[/color] [color=red]" . $phrase['blacklist_exist'] . "[/color][/b][/center]";
                                } else {
                                    //Add
                                    $bots = simplexml_load_file($config['bots']);
                                    $bots->addChild('name', $nick);
                                    $bots->asXML($config['bots']);
                                    $mess = "[center][b] Đã thêm[color=magenta] " . $nick . " [/color]vào danh sách cộng tác viên[/b] [/center]";
                                }
                                post_cbox($mess);
                            } else {
                                post_cbox("[center][b]Chỉ có MOD trở lên mới được quyền thêm thành viên vào danh sách cộng tác viên[/b] :haha [/center]");
                            }
                        }
                    }
                }
                //Remove bots
                    elseif (count(explode($remove_bot, strtolower($chat))) > 1) {
                    $command = $remove_bot;
                    Del_Mess_One($name, $command);
                    //Get name to add
                    preg_match("%'(.*)'%U", $chat, $nick);
                    $nick  = $nick[1];
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        if ($nick != "") {
                            //Kiem tra nick nguoi ra lenh la manager tro len hay khong?
                            if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true || Check_Manager($manager, $name) == true) {
                                //Kiem tra xem nick da co trong list bots chua?
                                if (Check_Bot($bots, $nick) == true) {
                                    for ($i = 0; $i < count($bots); $i++) {
                                        if ($bots->name[$i] == $nick) {
                                            unset($bots->name[$i]);
                                            $bots->asXML($config['bots']);
                                        }
                                    }
                                    $mess = "[center][b] Đã xóa[color=magenta] " . $nick . " [/color]khỏi danh sách cộng tác viên[/b] [/center]";
                                    post_cbox($mess);
                                } else {
                                    post_cbox("[center][b]Không tìm thấy[color=magenta] " . $nick . " [/color]trong danh sách cộng tác viên[/b] :dauhang [/center]");
                                }
                            } else {
                                post_cbox("[center][b]Bạn chưa đủ trình xóa thành viên khỏi danh sách cộng tác viên[/b] [/center]");
                            }
                        }
                    }
                }
                //Check Vip
                    elseif (count(explode($check_vip, strtolower($chat))) > 1) {
                    $command = $check_vip;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $vip = "";
                        for ($i = 0; $i < 100; $i++) {
                            $vip1 .= $viplist[$i] . ', ';
                        }
                        for ($i = 101; $i < 200; $i++) {
                            $vip2 .= $viplist[$i] . ', ';
                        }
                        for ($i = 201; $i < 300; $i++) {
                            $vip3 .= $viplist[$i] . ', ';
                        }
                        for ($i = 301; $i < 400; $i++) {
                            $vip4 .= $viplist[$i] . ', ';
                        }
                        for ($i = 401; $i < count($viplist); $i++) {
                            $vip5 .= $viplist[$i] . ', ';
                        }
                        $mess = "[center][b][color=green]Danh sách Vips (1) gồm có:[/color][br][/center][center][color=purple] " . $vip1 . " [/color][/b][/center]";
                        post_cbox($mess);
                        $mess = "[center][b][color=green]Danh sách Vips (2) gồm có:[/color][br][/center][center][color=purple] " . $vip2 . " [/color][/b][/center]";
                        post_cbox($mess);
                        $mess = "[center][b][color=green]Danh sách Vips (3) gồm có:[/color][br][/center][center][color=purple] " . $vip3 . " [/color][/b][/center]";
                        post_cbox($mess);
                        $mess = "[center][b][color=green]Danh sách Vips (4) gồm có:[/color][br][/center][center][color=purple] " . $vip4 . " [/color][/b][/center]";
                        post_cbox($mess);
                        $mess = "[center][b][color=green]Danh sách Vips (5) gồm có:[/color][/center][center][br][color=purple] " . $vip5 . " [/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Add Vip
                    elseif (count(explode($add_vip, strtolower($chat))) > 1) {
                    $command = $add_vip;
                    Del_Mess_One($name, $command);
                    //Get name to add
                    preg_match("%'(.*)'%U", $chat, $nick);
                    $nick  = $nick[1];
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        if ($nick != "") {
                            //Kiem tra nick nguoi ra lenh la manager tro len hay khong?
                            if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true || Check_Manager($manager, $name) == true) {
                                //Kiem tra xem nick da co trong list super admin chua?
                                if (Check_SuperAdmin($superadmin, $nick) == true) {
                                    $mess = "[center][b][color=red]" . $nick . "[/color] [color=red]" . $phrase['superadmin_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong list admin chua?
                                elseif (Check_Admin($adminlist, $nick) == true) {
                                    $mess = "[center][b][color=red]" . $nick . "[/color] [color=red]" . $phrase['admin_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong list manager chua?
                                    elseif (Check_Manager($manager, $nick) == true) {
                                    $mess = "[center][b][color=blue]" . $nick . "[/color] [color=red]" . $phrase['manager_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong list vip chua?
                                    elseif (Check_Vip($viplist, $nick) == true) {
                                    $mess = "[center][b][color=purple]" . $nick . "[/color] [color=red]" . $phrase['vip_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong list bots chua?
                                    elseif (Check_Bot($bots, $nick) == true) {
                                    $mess = "[center][b][color=magenta]" . $nick . "[/color] [color=red]" . $phrase['bots_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong blacklist chua?
                                    elseif (Check_Blacklist($blacklist, $nick) == true) {
                                    $mess = "[center][b][color=maroon]" . $nick . "[/color] [color=red]" . $phrase['blacklist_exist'] . "[/color][/b][/center]";
                                } else {
                                    //Add
                                    $viplist = simplexml_load_file($config['cbox_vip']);
                                    $viplist->addChild('name', $nick);
                                    $viplist->asXML($config['cbox_vip']);
                                    $mess = "[center][b] Đã thêm thành viên[color=purple] " . $nick . " [/color]vào danh sách Vip[/b] [/center]";
                                }
                                post_cbox($mess);
                            } else {
                                post_cbox("[center][b]Chỉ có MOD trở lên mới được quyền thêm thành viên vào danh sách Vip[/b] :cuoi [/center]");
                            }
                        }
                    }
                }
                //Remove vip
                    elseif (count(explode($remove_vip, strtolower($chat))) > 1) {
                    $command = $remove_vip;
                    Del_Mess_One($name, $command);
                    //Get name to add
                    preg_match("%'(.*)'%U", $chat, $nick);
                    $nick  = $nick[1];
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        if ($nick != "") {
                            //Kiem tra nick nguoi ra lenh la manager tro len hay khong?
                            if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true || Check_Manager($manager, $name) == true) {
                                //Kiem tra xem nick da co trong list vip chua?
                                if (Check_Vip($viplist, $nick) == true) {
                                    for ($i = 0; $i < count($viplist); $i++) {
                                        if ($viplist->name[$i] == $nick) {
                                            unset($viplist->name[$i]);
                                            $viplist->asXML($config['cbox_vip']);
                                        }
                                    }
                                    $mess = "[center][b] Thành viên[color=purple] " . $nick . " [/color]đã bị xóa khỏi danh sách Vip[/b] [/center]";
                                    post_cbox($mess);
                                } else {
                                    post_cbox("[center][b]Không tìm thấy[color=purple] " . $nick . " [/color]trong danh sách Vip[/b] :dauhang [/center]");
                                }
                            } else {
                                post_cbox("[center][b]Bạn chưa đủ trình xóa thành viên khỏi danh sách Vip[/b] [/center]");
                            }
                        }
                    }
                }
                //Check blacklist
                    elseif (count(explode($check_blackList, strtolower($chat))) > 1) {
                    $command = $check_blackList;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $bl = "";
                        for ($i = 0; $i < count($blacklist); $i++) {
                            $bl .= $blacklist->name[$i] . ', ';
                        }
                        $mess = "[center][b][color=green]Danh sách đen gồm có:[/color][color=maroon] " . $bl . " [/color][/b][br][img]http://i.imgur.com/pttUUJU.gif[/img][/center]";
                        post_cbox($mess);
                    }
                }
                //Add blacklist
                    elseif (count(explode($add_blacklist, strtolower($chat))) > 1) {
                    $command = $add_blacklist;
                    Del_Mess_One($name, $command);
                    $time_banned = "";
                    //Get name to add
                    preg_match("%'(.*)'%U", $chat, $nick);
                    $nick   = $nick[1];
                    //Phan tich lay ra thoi gian banned
                    $t      = explode(',', $nick);
                    $nick   = $t[0];
                    $time   = $t[1];
                    $reason = $t[2];
                    if (count($t) > 1) {
                        if (!is_numeric($time)) {
                            post_cbox("[center][b]Thời gian ban nick không phải là số. Vui lòng sửa lại[/b][/center]");
                            continue;
                        }
                        $time_banned = urlencode($time . ' days');
                    } else { //Mac dinh  == > banned 7 days vidu:  banned 'zet'
                        $time_banned = urlencode('7 days');
                        $time        = 7;
                    }
                    if (count($t) > 2) {
                        $reason = urlencode($reason);
                    } else { //Mac dinh  == > banned 7 days vidu:  banned 'zet'
                        $reason = urlencode('Post Porn');
                    }
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        if ($nick != "") {
                            //Kiem tra nick nguoi ra lenh la manager tro len hay khong?
                            if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true || Check_Manager($manager, $name) == true) {
                                //Kiem tra xem nick da co trong list super admin chua?
                                if (Check_SuperAdmin($superadmin, $nick) == true) {
                                    $mess = "[center][b][color=red]" . $nick . "[/color] [color=red]" . $phrase['superadmin_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong list admin chua?
                                elseif (Check_Admin($adminlist, $nick) == true) {
                                    $mess = "[center][b][color=red]" . $nick . "[/color] [color=red]" . $phrase['admin_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong list manager chua?
                                    elseif (Check_Manager($manager, $nick) == true) {
                                    $mess = "[center][b][color=blue]" . $nick . "[/color] [color=red]" . $phrase['manager_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong list vip chua?
                                    elseif (Check_Vip($viplist, $nick) == true) {
                                    //Add
                                    $bl = simplexml_load_file($config['blacklist']);
                                    $bl->addChild('name', $nick);
                                    $bl->asXML($config['blacklist']);
                                    $mess       = "[center][b] Thêm [color=maroon] " . $nick . " [/color]vào danh sách đen trong [color=red] " . $time_banned . " [/color]với lý do[color=green] " . $reason . " [/color][/b] [img]http://i.imgur.com/pttUUJU.gif[/img][/center]";
                                    //Luu file + info
                                    $user_file3 = "banned/" . $nick . ".txt";
                                    $log        = fopen($user_file3, "a", 1);
                                    $data       = time() . '\r\n' . $time . '\r\n' . $reason . '\r\n' . $name . '|';
                                    fwrite($log, $data);
                                    fclose($log);
                                }
                                //Kiem tra xem nick da co trong list bots chua?
                                    elseif (Check_Bot($bots, $nick) == true) {
                                    $mess = "[center][b][color=magenta]" . $nick . "[/color] [color=red]" . $phrase['bots_exist'] . "[/color][/b][/center]";
                                }
                                //Kiem tra xem nick da co trong blacklist chua?
                                    elseif (Check_Blacklist($blacklist, $nick) == true) {
                                    $mess       = "[center][b][color=maroon]" . $nick . "[/color] [color=red]" . $phrase['blacklist_exist'] . "[/color][/b][/center]";
                                    //Luu file + info
                                    $user_file3 = "banned/" . $nick . ".txt";
                                    $log        = fopen($user_file3, "a", 1);
                                    $data       = time() . '\r\n' . $time . '\r\n' . $reason . '\r\n' . $name . '|';
                                    fwrite($log, $data);
                                    fclose($log);
                                } else {
                                    //Add
                                    $bl = simplexml_load_file($config['blacklist']);
                                    $bl->addChild('name', $nick);
                                    $bl->asXML($config['blacklist']);
                                    $mess       = "[center][b] Thêm [color=maroon] " . $nick . " [/color]vào danh sách đen trong [color=red] " . $time_banned . " [/color]với lý do[color=green] " . $reason . " [/color][/b] [img]http://i.imgur.com/pttUUJU.gif[/img][/center]";
                                    //Luu file + info
                                    $user_file3 = "banned/" . $nick . ".txt";
                                    $log        = fopen($user_file3, "a", 1);
                                    $data       = time() . '\r\n' . $time . '\r\n' . $reason . '\r\n' . $name . '|';
                                    fwrite($log, $data);
                                    fclose($log);
                                }
                                post_cbox($mess);
                            } else {
                                post_cbox("[center][b]Chỉ có MOD trở lên mới được quyền thêm thành viên vào danh sách đen[/b] :suong [/center]");
                            }
                        }
                    }
                }
                //Remove blacklist
                    elseif (count(explode($remove_blacklist, strtolower($chat))) > 1) {
                    $command = $remove_blacklist;
                    Del_Mess_One($name, $command);
                    //Get name to add
                    preg_match("%'(.*)'%U", $chat, $nick);
                    $nick  = $nick[1];
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        if ($nick != "") {
                            //Kiem tra nick nguoi ra lenh la manager tro len hay khong?
                            if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true || Check_Manager($manager, $name) == true) {
                                //Kiem tra xem nick da co trong blacklist chua?
                                if (Check_Blacklist($blacklist, $nick) == true) {
                                    for ($i = 0; $i < count($blacklist); $i++) {
                                        if ($blacklist->name[$i] == $nick) {
                                            unset($blacklist->name[$i]);
                                            $blacklist->asXML($config['blacklist']);
                                        }
                                    }
                                    $mess = "[center][b] Đã xóa[color=maroon] " . $nick . " [/color]khỏi danh sách đen[/b] [img]http://i.imgur.com/pttUUJU.gif[/img][/center]";
                                    post_cbox($mess);
                                    //Xoa file + info
                                    $user_file3 = "banned/" . $nick . ".txt";
                                    unlink($user_file3);
                                } else {
                                    post_cbox("[center][b]Không tìm thấy[color=maroon] " . $nick . " [/color]trong danh sách đen[/b] :dauhang [/center]");
                                }
                            } else {
                                post_cbox("[center][b]Bạn chưa đủ trình xóa thành viên khỏi danh sách đen[/b] [/center]");
                            }
                        }
                    }
                }
                //Banned User
                    elseif (count(explode($ban_user, strtolower($chat))) > 1) {
                    $command = $ban_user;
                    Del_Mess_One($name, $command);
                    $time_banned = "";
                    //Get name to add
                    preg_match("%'(.*)'%U", $chat, $nick);
                    $nick   = $nick[1];
                    //Phan tich lay ra thoi gian banned
                    $t      = explode(',', $nick);
                    $nick   = $t[0];
                    $time   = $t[1];
                    $reason = $t[2];
                    if (count($t) > 1) {
                        if (!is_numeric($time)) {
                            post_cbox("[center][b]Thời gian ban nick không phải là số. Vui lòng sửa lại[/b][/center]");
                            continue;
                        }
                        $time_banned = urlencode($time . ' days');
                    } else { //Mac dinh  == > banned 7 days vidu:  banned 'zet'
                        $time_banned = urlencode('7 days');
                        $time        = 7;
                    }
                    if (count($t) > 2) {
                        $reason = urlencode($reason);
                    } else { //Mac dinh  == > banned 7 days vidu:  banned 'zet'
                        $reason = urlencode('Post Porn');
                    }
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $log  = fopen($user_file, "a", 1);
                        $data = $id_user . '+' . $chat . '|';
                        fwrite($log, $data);
                        fclose($log);
                        if ($nick != "") {
                            if (strcmp($nick, $Bot_Name) == 0) { // Neu nick can banned la bot
                                $nick        = $name;
                                $time_banned = urlencode('100 days');
                                $check       = Banned_User($nick, $time_banned);
                                if ($check == true) {
                                    $mess = " :ban  [b][color=red]BANNED[/color][color=green] " . $nick . " [/color][/b][color=red][b] " . $time_banned . " [/b][/color][b][color=blue]Reason:[/color][color=black] Chống à [/color][/b] :thodai ";
                                    post_cbox("[center]" . $mess . "[/center]");
                                }
                            }
                            //Kiem tra xem nick co phai la super admin, admin hay manager ko?
                            elseif (Check_SuperAdmin($superadmin, $nick) == true || Check_Admin($adminlist, $nick) == true || Check_Manager($manager, $nick) == true) {
                                post_cbox("[center][b]Em sợ đại ca[color=blue] " . $nick . " [/color]chém em lắm[/b] :so [/center]");
                            } else {
                                $check = Banned_User($nick, $time_banned);
                                if ($check == true) {
                                    $mess = " :ban  [b][color=red]BANNED[/color][color=green] " . $nick . " [/color][/b]";
                                    $mess .= "[color=red][b] " . $time_banned . " [/b][/color] ";
                                    if ($reason)
                                        $mess .= "[b][color=blue]Reason:[/color][color=black] " . $reason . "[/color] - [color=blue]banned by:[/color] [cam]" . $name . " [/mau][/b]";
                                    $mess .= "[br][b] Thêm [color=maroon] " . $nick . " [/color]vào danh sách đen trong [color=red] " . $time_banned . " [/color]với lý do[color=green] " . $reason . " [/color][/b] [img]http://i.imgur.com/pttUUJU.gif[/img]";
                                    post_cbox("[center]" . $mess . "[/center]");
                                    //Add blacklist
                                    if (Check_Blacklist($blacklist, $nick) == false) {
                                        //Kiem tra xem nick da co trong list vip chua?
                                        if (Check_Vip($viplist, $nick) == true) {
                                            //Add
                                            $bl = simplexml_load_file($config['blacklist']);
                                            $bl->addChild('name', $nick);
                                            $bl->asXML($config['blacklist']);
                                            $mess       = "[center][b] Thêm [color=maroon] " . $nick . " [/color]vào danh sách đen trong [color=red] " . $time_banned . " [/color]với lý do[color=green] " . $reason . " [/color][/b] [img]http://i.imgur.com/pttUUJU.gif[/img][/center]";
                                            //Luu file + info
                                            $user_file3 = "banned/" . $nick . ".txt";
                                            $log        = fopen($user_file3, "a", 1);
                                            $data       = time() . '\r\n' . $time . '\r\n' . $reason . '\r\n' . $name . '|';
                                            fwrite($log, $data);
                                            fclose($log);
                                            //	post_cbox($mess);
                                        }
                                        //Kiem tra xem nick da co trong list bots chua?
                                        //	elseif (Check_Bot($bots, $nick) == true) {
                                        elseif (Check_Bot($bots, $nick) == true) {
                                            $mess = "[center][b][color=magenta]" . $nick . "[/color] [color=red]" . $phrase['bots_exist'] . "[/color][/b][/center]";
                                        } else {
                                            $bl = simplexml_load_file($config['blacklist']);
                                            $bl->addChild('name', $nick);
                                            $bl->asXML($config['blacklist']);
                                            $mess       = "[center][b][img]http://i.imgur.com/9UqC0yY.gif[/img] Thêm[color=blue] " . $nick . " [/color]vào danh sách đen trong [color=red] " . $time_banned . " [/color]với lý do[color=green] " . $reason . " [/color][/b] bye [br][b][tim]Lệnh ban : ken-ban 'nick,so ngay ban, ly do ban'[/mau][/b][/center]";
                                            //Luu file + info
                                            $user_file3 = "banned/" . $nick . ".txt";
                                            $log        = fopen($user_file3, "a", 1);
                                            $data       = time() . '\r\n' . $time . '\r\n' . $reason . '\r\n' . $name . '|';
                                            fwrite($log, $data);
                                            fclose($log);
                                        }
                                        //	post_cbox($mess);
                                    } else { //Neu da co trong danh sach den
                                        //	post_cbox("[center][b]Thành viên[color=blue] ".$nick." [/color]đã có trong danh sách đen[/b] [img]http://i.imgur.com/lN1HSDq.gif[/img][/center]");
                                        //Luu file + info
                                        $user_file3 = "banned/" . $nick . ".txt";
                                        $log        = fopen($user_file3, "a", 1);
                                        $data       = time() . '\r\n' . $time . '\r\n' . $reason . '\r\n' . $name . '|';
                                        fwrite($log, $data);
                                        fclose($log);
                                    }
                                } else {
                                    post_cbox("[center][b]Không tìm thấy[color=blue] " . $nick . " [/color]trong Cbox [br][tim]Lệnh ban : ken-ban 'nick,so ngay ban, ly do ban'[/mau][/b][/center]");
                                }
                            }
                        }
                    }
                }
                //Banned All
                    elseif (count(explode($ban_all, strtolower($chat))) > 1) {
                    $command = $ban_all;
                    Del_Mess_One($name, $command);
                    //Mac dinh banned
                    $time_banned = urlencode('999 days');
                    $check       = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        //Kiem tra nick nguoi ra lenh la super admin hay admin khong?
                        if (Check_SuperAdmin($superadmin, $name) == true) {
                            $checks = Banned_All($time_banned);
                            if ($checks > 0) {
                                Del_Mess_All();
                                $mess = " :ban [b][color=red]BANNED[/color][color=green] " . $checks . " nhóc[/color][/b][color=red][b] " . $time_banned . " [/b][/color] [b][color=blue]Reason:[/color] biu [/b]";
                                post_cbox("[center]" . $mess . "[/center]");
                            }
                            if ($checks == 0) {
                                post_cbox("[center][b]Không có thành viên nào trong Cbox ngoài các Staff[/b] coccoc [/center]");
                            }
                        } else {
                            post_cbox("[center][b]Chỉ có Super Admin mới được quyền kỷ luật toàn bộ thành viên[/b] :2he [/center]");
                        }
                    }
                }
                //Unban
                    elseif (count(explode($unban_user, strtolower($chat))) > 1) {
                    $command = $unban_user;
                    Del_Mess_One($name, $command);
                    $time_banned = "1 seconds";
                    //Get name to add
                    preg_match("%'(.*)'%U", $chat, $nick);
                    $nick  = $nick[1];
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        if (Check_SuperAdmin($superadmin, $name) == true) {
                            if ($nick != "") {
                                $check = removebanned($nick);
                                if ($check == true) {
                                    post_cbox("[center][b][color=red]UNBANNED[/color][color=blue] " . $nick . " [/color] [img]http://i.imgur.com/rVrxoah.gif[/img] [color=green]Please come back after 10 minutes![/color][/b][/center]");
                                    //Xoa khoi blacklist
                                    if (Check_Blacklist($blacklist, $nick) == true) {
                                        for ($i = 0; $i < count($blacklist); $i++) {
                                            if ($blacklist->name[$i] == $nick) {
                                                unset($blacklist->name[$i]);
                                                $blacklist->asXML($config['blacklist']);
                                            }
                                        }
                                        $mess = "[center][b] Đã xóa [color=blue] " . $nick . " [/color]khỏi danh sách đen[/b] bye [/center]";
                                        post_cbox($mess);
                                        //Xoa file + info
                                        $user_file3 = "banned/" . $nick . ".txt";
                                        unlink($user_file3);
                                    } else {
                                        post_cbox("[center][b]Không tìm thấy[color=maroon] " . $nick . " [/color]trong danh sách đen[/b] :dauhang [/center]");
                                    }
                                } else {
                                    post_cbox("[center][b]Không tìm thấy [color=blue] " . $nick . " [/color]trong Cbox[/b][/center]");
                                }
                            }
                        }
                    }
                }
                //Del mess
                    elseif (count(explode($delete_message, strtolower($chat))) > 1) {
                    $command = $delete_message;
                    Del_Mess_One($name, $command);
                    //Get name to del messs
                    preg_match("%'(.*)'%U", $chat, $nick);
                    $nick  = $nick[1];
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        if ($nick != "") {
                            $total = Del_Mess_Nick($nick);
                            if ($total > 0) {
                                $mess = "[center][b]Đã xóa[color=green] " . $total . " [/color]messages của [color=blue] " . $nick . " [/color][/b][/center]";
                                post_cbox($mess);
                            }
                            if ($total == 0) {
                                $mess = "[center][b]Không tìm thấy[color=blue] " . $nick . " [/color]trong cBox[/b][/center]";
                                post_cbox($mess);
                            }
                        }
                    }
                }
                //Del mess all
                    elseif (count(explode($delete_message_all, strtolower($chat))) > 1) {
                    $command = $delete_message_all;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        //Kiem tra nick nguoi ra lenh la super admin hay admin khong?
                        if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true) {
                            $totals = Del_Mess_All();
                            if ($totals > 0) {
                                $mess = "[center] :3:ngau [b][color=green]Đã dọn dẹp sạch sẽ hoàn toàn Cbox[/color][/b] :ngau [/center]";
                                post_cbox($mess);
                            }
                            if ($totals == 0) {
                                $mess = "[center][b]Không có dòng chat nào trong cBox thì dọn dẹp cái gì?[/b] :ginua [/center]";
                                post_cbox($mess);
                            }
                        } else {
                            post_cbox("[center][b]Chỉ thành viên Admin mới được quyền xóa toàn bộ chat của thành viên[/b] :venh [/center]");
                        }
                    }
                }
                //Delete User_Files
                    elseif (count(explode($delete_user_files, strtolower($chat))) > 1) {
                    $command = $delete_user_files;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Kiem tra nick nguoi ra lenh la super admin hay admin khong?
                        if (Check_SuperAdmin($superadmin, $name) == true || Check_Admin($adminlist, $name) == true) {
                            $chat_files = glob('chat/*'); // get all file names
                            $time_now   = time() - 5 * 60;
                            foreach ($chat_files as $chat_file) { // iterate files
                                if (is_file($chat_file))
                                    if (filemtime($chat_file) <= $time_now)
                                        unlink($chat_file); // delete file
                            }
                            $files_chat = count($chat_files);
                            $time_files = glob('time/*'); // get all file names
                            foreach ($time_files as $time_file) { // iterate files
                                if (is_file($time_file))
                                    if (filemtime($time_file) <= $time_now)
                                        unlink($time_file); // delete file
                            }
                            $files_time  = count($time_files);
                            $users_files = glob('user/*'); // get all file names
                            foreach ($users_files as $users_file) { // iterate files
                                if (is_file($users_file))
                                    if (filemtime($users_file) <= $time_now)
                                        unlink($users_file); // delete file
                            }
                            $files_users = count($users_files);
                            unlink($user_files);
                            $mess = "[center][b][color=blue]Đã xóa tất cả[/color][color=red] " . $files_chat . " [/color][color=blue]files chat[/color],[color=red] " . $files_time . " [/color][color=blue]files time[/color],[color=red] " . $files_users . " [/color][color=blue]files user[/color][/b] :ancom [/center]";
                            post_cbox($mess);
                        } else {
                            post_cbox("[center][b]Chỉ thành viên Admin mới được quyền xóa toàn bộ userfiles[/b] :met [/center]");
                        }
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                    }
                }
                //Check IP
                    elseif (count(explode($check_ip, strtolower($chat))) > 1) {
                    $command = $check_ip;
                    Del_Mess_One($name, $command);
                    //Get name to check ip
                    preg_match("%'(.*)'%U", $chat, $nick);
                    $nick  = $nick[1];
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        if ($nick != "") {
                            if (strcmp($nick, $Bot_Name) == 0) { // Neu nick can check IP la bot
                                $nick = $name;
                                $ip   = Check_IP($nick);
                                if ($ip) {
                                    $ip   = substr($ip, 1);
                                    $mess = "[center][b]Thưa bạn[color=red] " . $name . " [/color], bạn không thể kiểm tra IP của [color=green]tôi[/color]. Địa chỉ IP của bạn là:[color=blue] " . $ip . " [/color][url=http://www.ip-tracker.org/locator/ip-lookup.php?ip=" . $ip . "][color=Magenta]>>> ip tracker[/color][/url][/b][/center]";
                                    post_cbox($mess);
                                } else {
                                    $mess = "[center][b]Không tìm thấy[color=blue] " . $name . " [/color]trong cBox[/b][/center]";
                                    post_cbox($mess);
                                }
                            } else {
                                $ip = Check_IP($nick);
                                if ($ip) {
                                    $ip   = substr($ip, 1);
                                    $mess = "[center][b]Thưa sếp[color=red] " . $name . " [/color], thành viên [color=green] " . $nick . " [/color]có dịa chỉ IP là:[color=blue] " . $ip . " [/color][url=http://www.ip-tracker.org/locator/ip-lookup.php?ip=" . $ip . "][color=Magenta]>>> ip tracker[/color][/url][/b][/center]";
                                    post_cbox($mess);
                                } else {
                                    $mess = "[center][b]Không tìm thấy[color=blue] " . $nick . " [/color]trong cBox[/b][/center]";
                                    post_cbox($mess);
                                }
                            }
                        }
                    }
                }
                //Check User Info Location
                    elseif (count(explode($check_user, strtolower($chat))) > 1) {
                    $command = $check_user;
                    Del_Mess_One($name, $command);
                    //Get name to check ip
                    preg_match("%'(.*)'%U", $chat, $nick);
                    $nick  = $nick[1];
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        if ($nick != "") {
                            if (strcmp($nick, $Bot_Name) == 0) { // Neu nick can check info la bot
                                $nick = $name;
                                $ip   = Check_IP($nick);
                                if ($ip) {
                                    $ip      = substr($ip, 1);
                                    $tracker = "http://www.ip-tracker.org/locator/ip-lookup.php?ip=" . $ip;
                                    $infos   = getContent($tracker);
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
                                    $mess = "[center][b]Thưa bạn[color=red] " . $name . " [/color], bạn không thể kiểm tra địa chỉ của [color=green]tôi[/color]. Địa chỉ hiện tại của bạn là:[br][color=blue]" . $city . ", " . $state . ", " . $country . " [/color][img]" . $flag . "[/img] ([color=purple] " . $ip . " [/color])[url=http://www.ip-tracker.org/locator/ip-lookup.php?ip=" . $ip . "] [color=Magenta]>>> chi tiết[/color][/url][/b][/center]";
                                    post_cbox($mess);
                                } else {
                                    $mess = "[center][b]Không tìm thấy[color=blue] " . $name . " [/color]trong cBox[/b][/center]";
                                    post_cbox($mess);
                                }
                            } else {
                                $ip = Check_IP($nick);
                                if ($ip) {
                                    $ip      = substr($ip, 1);
                                    $tracker = "http://www.ip-tracker.org/locator/ip-lookup.php?ip=" . $ip;
                                    $infos   = getContent($tracker);
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
                                    $mess = "[center][b]Thưa sếp[color=red] " . $name . " [/color], thành viên [color=green] " . $nick . " [/color]hiện nay đang ở [color=blue]" . $city . ", " . $state . ", " . $country . " [/color][img]" . $flag . "[/img] ([color=purple] " . $ip . " [/color])[url=http://www.ip-tracker.org/locator/ip-lookup.php?ip=" . $ip . "] [color=Magenta]>>> chi tiết[/color][/url][/b][/center]";
                                    post_cbox($mess);
                                } else {
                                    $mess = "[center][b]Không tìm thấy[color=blue] " . $nick . " [/color]trong cBox[/b][/center]";
                                    post_cbox($mess);
                                }
                            }
                        }
                    }
                }
                //Check support
                    elseif (count(explode($check_support, strtolower($chat))) > 1) {
                    $command = $check_support;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b][color=Green]Support/Hỗ trợ:[/color][color=Purple] " . $bot_support . " [/color][br][color=Green]Not Support/Không hỗ trợ:[/color][color=Purple] " . $bot_not_support . " [/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //add 3x
                    elseif (count(explode($add3x, strtolower($chat))) > 1) {
                    $command = $add3x;
                    Del_Mess_One($name, $command);
                    preg_match("%'(.*)'%U", $chat, $word);
                    //	$word = $word[1];
                    $word = str_replace('.', ' ', $word[1]);
                    //Luu file + time
                    $data = $id_user . '|';
                    Write_File($user_file, $data, 'a', 1);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['badwordlist']);
                        $host->addChild('word', $word);
                        $host->asXML($config['badwordlist']);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]đã thêm [/color] [color=blue]" . $word . "[/color][color=green]vào từ khóa 3x [/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //remove 3x
                    elseif (count(explode($remove3x, strtolower($chat))) > 1) {
                    $command = $remove3x;
                    Del_Mess_One($name, $command);
                    preg_match("%'(.*)'%U", $chat, $word);
                    $word  = $word[1];
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['badwordlist']);
                        $host->addChild('word', $word);
                        $host->asXML($config['badwordlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]đã thêm [/color] [color=blue]" . $word . "[/color][color=green]vào từ khóa 3x [/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start fshare
                    elseif (count(explode($fshare_on, strtolower($chat))) > 1) {
                    $command = $fshare_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->fshare->work);
                        $host->fshare->addChild('work', "yes");
                        $host->fshare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Fshare.Vn[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop fshare
                    elseif (count(explode($fshare_off, strtolower($chat))) > 1) {
                    $command = $fshare_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->fshare->work);
                        $host->fshare->addChild('work', "no");
                        $host->fshare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Fshare.vn[/color] [/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start share-oneline
                    elseif (count(explode($shareonline_on, strtolower($chat))) > 1) {
                    $command = $shareonline_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->shareonline->work);
                        $host->shareonline->addChild('work', "yes");
                        $host->shareonline->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Share-Online.Biz[/color] [/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop shareonline
                    elseif (count(explode($shareonline_off, strtolower($chat))) > 1) {
                    $command = $shareonline_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->shareonline->work);
                        $host->shareonline->addChild('work', "no");
                        $host->shareonline->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Share-Online.Biz[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start fshare member
                    elseif (count(explode($fsharemember_on, strtolower($chat))) > 1) {
                    $command = $fsharemember_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->fsharemember->work);
                        $host->fsharemember->addChild('work', "yes");
                        $host->fsharemember->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Fshare.vn[/color] [color=red] " . $proxyfs . " [/color][/b][/center]";
                        //	post_cbox($mess);
                    }
                }
                //Stop fshare member
                    elseif (count(explode($fsharemember_off, strtolower($chat))) > 1) {
                    $command = $fsharemember_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->fsharemember->work);
                        $host->fsharemember->addChild('work', "no");
                        $host->fsharemember->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Fshare.vn[/color] [color=red] " . $proxyfs . " [/color][/b][/center]";
                        //	post_cbox($mess);
                    }
                }
                //Start 4sharevn
                    elseif (count(explode($foursharevn_on, strtolower($chat))) > 1) {
                    $command = $foursharevn_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->foursharevn->work);
                        $host->foursharevn->addChild('work', "yes");
                        $host->foursharevn->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]4share.vn[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop 4sharevn
                    elseif (count(explode($foursharevn_off, strtolower($chat))) > 1) {
                    $command = $foursharevn_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->foursharevn->work);
                        $host->foursharevn->addChild('work', "no");
                        $host->foursharevn->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]4share.vn[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start 4sharevn member
                    elseif (count(explode($foursharemember_on, strtolower($chat))) > 1) {
                    $command = $foursharemember_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->foursharemember->work);
                        $host->foursharemember->addChild('work', "yes");
                        $host->foursharemember->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        //	$mess = "[center][b] [color=red]".$name."[/color][br][color=green]Bắt đầu get link[/color] [color=blue]4share.vn[/color] [color=red] ".$proxy4s." [/color][/b][/center]";
                        //	post_cbox($mess);
                    }
                }
                //Stop 4sharevn member
                    elseif (count(explode($foursharemember_off, strtolower($chat))) > 1) {
                    $command = $foursharemember_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->foursharemember->work);
                        $host->foursharemember->addChild('work', "no");
                        $host->foursharemember->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        //	$mess = "[center][b] [color=red]".$name."[/color][br][color=green]Đã dừng get link[/color] [color=blue]4share.vn[/color] [color=red] ".$proxy4s." [/color][/b][/center]";
                        //	post_cbox($mess);
                    }
                }
                //Start sharevnn
                    elseif (count(explode($sharevnn_on, strtolower($chat))) > 1) {
                    $command = $sharevnn_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->sharevnn->work);
                        $host->sharevnn->addChild('work', "yes");
                        $host->sharevnn->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Share.vnn.vn[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop sharevnn
                    elseif (count(explode($sharevnn_off, strtolower($chat))) > 1) {
                    $command = $sharevnn_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->sharevnn->work);
                        $host->sharevnn->addChild('work', "no");
                        $host->sharevnn->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Share.vnn.vn[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start tenluavn
                    elseif (count(explode($tenluavn_on, strtolower($chat))) > 1) {
                    $command = $tenluavn_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->tenluavn->work);
                        $host->tenluavn->addChild('work', "yes");
                        $host->tenluavn->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Tenlua.vn[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop tenluavn
                    elseif (count(explode($tenluavn_off, strtolower($chat))) > 1) {
                    $command = $tenluavn_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->tenluavn->work);
                        $host->tenluavn->addChild('work', "no");
                        $host->tenluavn->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Tenlua.vn[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start upfilevn
                    elseif (count(explode($upfilevn_on, strtolower($chat))) > 1) {
                    $command = $upfilevn_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->upfilevn->work);
                        $host->upfilevn->addChild('work', "yes");
                        $host->upfilevn->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Upfile.vn[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop upfilevn
                    elseif (count(explode($upfilevn_off, strtolower($chat))) > 1) {
                    $command = $upfilevn_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->upfilevn->work);
                        $host->upfilevn->addChild('work', "no");
                        $host->upfilevn->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Upfile.vn[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start mediafire
                    elseif (count(explode($mediafire_on, strtolower($chat))) > 1) {
                    $command = $mediafire_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->mediafire->work);
                        $host->mediafire->addChild('work', "yes");
                        $host->mediafire->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Mediafire.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop mediafire
                    elseif (count(explode($mediafire_off, strtolower($chat))) > 1) {
                    $command = $mediafire_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->mediafire->work);
                        $host->mediafire->addChild('work', "no");
                        $host->mediafire->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Mediafire.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start netload
                    elseif (count(explode($netload_on, strtolower($chat))) > 1) {
                    $command = $netload_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->netload->work);
                        $host->netload->addChild('work', "yes");
                        $host->netload->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Netload.in[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop netload
                    elseif (count(explode($netload_off, strtolower($chat))) > 1) {
                    $command = $netload_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->netload->work);
                        $host->netload->addChild('work', "no");
                        $host->netload->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Netload.in[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start uploaded
                    elseif (count(explode($uploaded_on, strtolower($chat))) > 1) {
                    $command = $uploaded_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->uploaded->work);
                        $host->uploaded->addChild('work', "yes");
                        $host->uploaded->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Uploaded.net[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop uploaded
                    elseif (count(explode($uploaded_off, strtolower($chat))) > 1) {
                    $command = $uploaded_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->uploaded->work);
                        $host->uploaded->addChild('work', "no");
                        $host->uploaded->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Uploaded.net[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start rapidgator
                    elseif (count(explode($rapidgator_on, strtolower($chat))) > 1) {
                    $command = $rapidgator_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->rapidgator->work);
                        $host->rapidgator->addChild('work', "yes");
                        $host->rapidgator->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Rapidgator.net[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop rapidgator
                    elseif (count(explode($rapidgator_off, strtolower($chat))) > 1) {
                    $command = $rapidgator_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->rapidgator->work);
                        $host->rapidgator->addChild('work', "no");
                        $host->rapidgator->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Rapidgator.net[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start letitbit
                    elseif (count(explode($letitbit_on, strtolower($chat))) > 1) {
                    $command = $letitbit_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->letitbit->work);
                        $host->letitbit->addChild('work', "yes");
                        $host->letitbit->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Letitbit.net[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop letitbit
                    elseif (count(explode($letitbit_off, strtolower($chat))) > 1) {
                    $command = $letitbit_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->letitbit->work);
                        $host->letitbit->addChild('work', "no");
                        $host->letitbit->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Letitbit.net[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start novafile
                    elseif (count(explode($novafile_on, strtolower($chat))) > 1) {
                    $command = $novafile_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->novafile->work);
                        $host->novafile->addChild('work', "yes");
                        $host->novafile->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Novafile.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop novafile
                    elseif (count(explode($novafile_off, strtolower($chat))) > 1) {
                    $command = $novafile_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->novafile->work);
                        $host->novafile->addChild('work', "no");
                        $host->novafile->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Novafile.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start turbobit
                    elseif (count(explode($turbobit_on, strtolower($chat))) > 1) {
                    $command = $turbobit_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->turbobit->work);
                        $host->turbobit->addChild('work', "yes");
                        $host->turbobit->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Turbobit.net[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop turbobit
                    elseif (count(explode($turbobit_off, strtolower($chat))) > 1) {
                    $command = $turbobit_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->turbobit->work);
                        $host->turbobit->addChild('work', "no");
                        $host->turbobit->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Turbobit.net[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start ryushare
                    elseif (count(explode($ryushare_on, strtolower($chat))) > 1) {
                    $command = $ryushare_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->ryushare->work);
                        $host->ryushare->addChild('work', "yes");
                        $host->ryushare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Ryushare.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop ryushare
                    elseif (count(explode($ryushare_off, strtolower($chat))) > 1) {
                    $command = $ryushare_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->ryushare->work);
                        $host->ryushare->addChild('work', "no");
                        $host->ryushare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Ryushare.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start filefactory
                    elseif (count(explode($filefactory_on, strtolower($chat))) > 1) {
                    $command = $filefactory_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->filefactory->work);
                        $host->filefactory->addChild('work', "yes");
                        $host->filefactory->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Filefactory.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop filefactory
                    elseif (count(explode($filefactory_off, strtolower($chat))) > 1) {
                    $command = $filefactory_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->filefactory->work);
                        $host->filefactory->addChild('work', "no");
                        $host->filefactory->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Filefactory.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start filepost
                    elseif (count(explode($filepost_on, strtolower($chat))) > 1) {
                    $command = $filepost_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->filepost->work);
                        $host->filepost->addChild('work', "yes");
                        $host->filepost->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Filepost.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop filepost
                    elseif (count(explode($filepost_off, strtolower($chat))) > 1) {
                    $command = $filepost_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->filepost->work);
                        $host->filepost->addChild('work', "no");
                        $host->filepost->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Filepost.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start fourshared
                    elseif (count(explode($fourshared_on, strtolower($chat))) > 1) {
                    $command = $fourshared_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->fourshared->work);
                        $host->fourshared->addChild('work', "yes");
                        $host->fourshared->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]4shared.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop fourshared
                    elseif (count(explode($fourshared_off, strtolower($chat))) > 1) {
                    $command = $fourshared_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->fourshared->work);
                        $host->fourshared->addChild('work', "no");
                        $host->fourshared->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]4shared.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start depositfiles
                    elseif (count(explode($depositfiles_on, strtolower($chat))) > 1) {
                    $command = $depositfiles_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->depositfiles->work);
                        $host->depositfiles->addChild('work', "yes");
                        $host->depositfiles->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Depositfiles.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop depositfiles
                    elseif (count(explode($depositfiles_off, strtolower($chat))) > 1) {
                    $command = $depositfiles_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->depositfiles->work);
                        $host->depositfiles->addChild('work', "no");
                        $host->depositfiles->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Depositfiles.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start terafile
                    elseif (count(explode($terafile_on, strtolower($chat))) > 1) {
                    $command = $terafile_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->terafile->work);
                        $host->terafile->addChild('work', "yes");
                        $host->terafile->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Terafile.co[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop terafile
                    elseif (count(explode($terafile_off, strtolower($chat))) > 1) {
                    $command = $terafile_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->terafile->work);
                        $host->terafile->addChild('work', "no");
                        $host->terafile->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Terafile.co[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start oboom
                    elseif (count(explode($oboom_on, strtolower($chat))) > 1) {
                    $command = $oboom_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->oboom->work);
                        $host->oboom->addChild('work', "yes");
                        $host->oboom->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Oboom.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop oboom
                    elseif (count(explode($oboom_off, strtolower($chat))) > 1) {
                    $command = $oboom_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->oboom->work);
                        $host->oboom->addChild('work', "no");
                        $host->oboom->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Oboom.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start bitshare
                    elseif (count(explode($bitshare_on, strtolower($chat))) > 1) {
                    $command = $bitshare_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->bitshare->work);
                        $host->bitshare->addChild('work', "yes");
                        $host->bitshare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Bitshare.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop bitshare
                    elseif (count(explode($bitshare_off, strtolower($chat))) > 1) {
                    $command = $bitshare_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->bitshare->work);
                        $host->bitshare->addChild('work', "no");
                        $host->bitshare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Bitshare.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start uptobox
                    elseif (count(explode($uptobox_on, strtolower($chat))) > 1) {
                    $command = $uptobox_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->uptobox->work);
                        $host->uptobox->addChild('work', "yes");
                        $host->uptobox->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Uptobox.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop uptobox
                    elseif (count(explode($uptobox_off, strtolower($chat))) > 1) {
                    $command = $uptobox_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->uptobox->work);
                        $host->uptobox->addChild('work', "no");
                        $host->uptobox->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Uptobox.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start extmatrix
                    elseif (count(explode($extmatrix_on, strtolower($chat))) > 1) {
                    $command = $extmatrix_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->extmatrix->work);
                        $host->extmatrix->addChild('work', "yes");
                        $host->extmatrix->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Extmatrix.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop extmatrix
                    elseif (count(explode($extmatrix_off, strtolower($chat))) > 1) {
                    $command = $extmatrix_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->extmatrix->work);
                        $host->extmatrix->addChild('work', "no");
                        $host->extmatrix->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Extmatrix.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start megaconz
                    elseif (count(explode($megaconz_on, strtolower($chat))) > 1) {
                    $command = $megaconz_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->megaconz->work);
                        $host->megaconz->addChild('work', "yes");
                        $host->megaconz->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Mega.co.nz[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop megaconz
                    elseif (count(explode($megaconz_off, strtolower($chat))) > 1) {
                    $command = $megaconz_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->megaconz->work);
                        $host->megaconz->addChild('work', "no");
                        $host->megaconz->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Mega.co.nz[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start freakshare
                    elseif (count(explode($freakshare_on, strtolower($chat))) > 1) {
                    $command = $freakshare_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->freakshare->work);
                        $host->freakshare->addChild('work', "yes");
                        $host->freakshare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Freakshare.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop freakshare
                    elseif (count(explode($freakshare_off, strtolower($chat))) > 1) {
                    $command = $freakshare_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->freakshare->work);
                        $host->freakshare->addChild('work', "no");
                        $host->freakshare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Freakshare.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start firedrive
                    elseif (count(explode($firedrive_on, strtolower($chat))) > 1) {
                    $command = $firedrive_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->firedrive->work);
                        $host->firedrive->addChild('work', "yes");
                        $host->firedrive->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Firedrive.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop firedrive
                    elseif (count(explode($firedrive_off, strtolower($chat))) > 1) {
                    $command = $firedrive_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->firedrive->work);
                        $host->firedrive->addChild('work', "no");
                        $host->firedrive->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Firedrive.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start uploadable
                    elseif (count(explode($uploadable_on, strtolower($chat))) > 1) {
                    $command = $uploadable_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->uploadable->work);
                        $host->uploadable->addChild('work', "yes");
                        $host->uploadable->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Uploadable.ch[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop uploadable
                    elseif (count(explode($uploadable_off, strtolower($chat))) > 1) {
                    $command = $uploadable_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->uploadable->work);
                        $host->uploadable->addChild('work', "no");
                        $host->uploadable->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Uploadable.ch[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start zippyshare
                    elseif (count(explode($zippyshare_on, strtolower($chat))) > 1) {
                    $command = $zippyshare_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->zippyshare->work);
                        $host->zippyshare->addChild('work', "yes");
                        $host->zippyshare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Zippyshare.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop zippyshare
                    elseif (count(explode($zippyshare_off, strtolower($chat))) > 1) {
                    $command = $zippyshare_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->zippyshare->work);
                        $host->zippyshare->addChild('work', "no");
                        $host->zippyshare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Zippyshare.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start keep2share
                    elseif (count(explode($keep2share_on, strtolower($chat))) > 1) {
                    $command = $keep2share_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->keep2share->work);
                        $host->keep2share->addChild('work', "yes");
                        $host->keep2share->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Keep2share.cc[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop keep2share
                    elseif (count(explode($keep2share_off, strtolower($chat))) > 1) {
                    $command = $keep2share_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->keep2share->work);
                        $host->keep2share->addChild('work', "no");
                        $host->keep2share->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Keep2share.cc[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start megashares
                    elseif (count(explode($megashares_on, strtolower($chat))) > 1) {
                    $command = $megashares_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->megashares->work);
                        $host->megashares->addChild('work', "yes");
                        $host->megashares->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Megashares.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop megashares
                    elseif (count(explode($megashares_off, strtolower($chat))) > 1) {
                    $command = $megashares_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->megashares->work);
                        $host->megashares->addChild('work', "no");
                        $host->megashares->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Megashares.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start youtube
                    elseif (count(explode($youtube_on, strtolower($chat))) > 1) {
                    $command = $youtube_on;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->youtube->work);
                        $host->youtube->addChild('work', "yes");
                        $host->youtube->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]Youtube.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop youtube
                    elseif (count(explode($youtube_off, strtolower($chat))) > 1) {
                    $command = $youtube_off;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->youtube->work);
                        $host->youtube->addChild('work', "no");
                        $host->youtube->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]Youtube.com[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Start All Host
                    elseif (count(explode($start_allhost, strtolower($chat))) > 1) {
                    $command = $start_allhost;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option start
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->fshare->work);
                        $host->fshare->addChild('work', "yes");
                        $host->fshare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->fsharemember->work);
                        $host->fsharemember->addChild('work', "yes");
                        $host->fsharemember->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->foursharevn->work);
                        $host->foursharevn->addChild('work', "yes");
                        $host->foursharevn->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->foursharemember->work);
                        $host->foursharemember->addChild('work', "yes");
                        $host->foursharemember->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->sharevnn->work);
                        $host->sharevnn->addChild('work', "yes");
                        $host->sharevnn->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->upfilevn->work);
                        $host->upfilevn->addChild('work', "yes");
                        $host->upfilevn->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->tenluavn->work);
                        $host->tenluavn->addChild('work', "yes");
                        $host->tenluavn->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->mediafire->work);
                        $host->mediafire->addChild('work', "yes");
                        $host->mediafire->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->netload->work);
                        $host->netload->addChild('work', "yes");
                        $host->netload->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->uploaded->work);
                        $host->uploaded->addChild('work', "yes");
                        $host->uploaded->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->rapidgator->work);
                        $host->rapidgator->addChild('work', "yes");
                        $host->rapidgator->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->letitbit->work);
                        $host->letitbit->addChild('work', "yes");
                        $host->letitbit->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->novafile->work);
                        $host->novafile->addChild('work', "yes");
                        $host->novafile->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->turbobit->work);
                        $host->turbobit->addChild('work', "yes");
                        $host->turbobit->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->ryushare->work);
                        $host->ryushare->addChild('work', "yes");
                        $host->ryushare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->filefactory->work);
                        $host->filefactory->addChild('work', "yes");
                        $host->filefactory->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->filepost->work);
                        $host->filepost->addChild('work', "yes");
                        $host->filepost->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->fourshared->work);
                        $host->fourshared->addChild('work', "yes");
                        $host->fourshared->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->depositfiles->work);
                        $host->depositfiles->addChild('work', "yes");
                        $host->depositfiles->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->terafile->work);
                        $host->terafile->addChild('work', "yes");
                        $host->terafile->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->oboom->work);
                        $host->oboom->addChild('work', "yes");
                        $host->oboom->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->bitshare->work);
                        $host->bitshare->addChild('work', "yes");
                        $host->bitshare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->uptobox->work);
                        $host->uptobox->addChild('work', "yes");
                        $host->uptobox->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->extmatrix->work);
                        $host->extmatrix->addChild('work', "yes");
                        $host->extmatrix->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->megaconz->work);
                        $host->megaconz->addChild('work', "yes");
                        $host->megaconz->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->freakshare->work);
                        $host->freakshare->addChild('work', "yes");
                        $host->freakshare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->firedrive->work);
                        $host->firedrive->addChild('work', "yes");
                        $host->firedrive->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->uploadable->work);
                        $host->uploadable->addChild('work', "yes");
                        $host->uploadable->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->zippyshare->work);
                        $host->zippyshare->addChild('work', "yes");
                        $host->zippyshare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->keep2share->work);
                        $host->keep2share->addChild('work', "yes");
                        $host->keep2share->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->megashares->work);
                        $host->megashares->addChild('work', "yes");
                        $host->megashares->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->youtube->work);
                        $host->youtube->addChild('work', "yes");
                        $host->youtube->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Bắt đầu get link[/color] [color=blue]tất cả các File Host[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
                //Stop all Host
                    elseif (count(explode($stop_allhost, strtolower($chat))) > 1) {
                    $command = $stop_allhost;
                    Del_Mess_One($name, $command);
                    $check = Check_Chat($chat, $user_file, $id_user);
                    if ($check == true);
                    else {
                        //Set option stop
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->fshare->work);
                        $host->fshare->addChild('work', "no");
                        $host->fshare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->fsharemember->work);
                        $host->fsharemember->addChild('work', "no");
                        $host->fsharemember->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->foursharevn->work);
                        $host->foursharevn->addChild('work', "no");
                        $host->foursharevn->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->foursharemember->work);
                        $host->foursharemember->addChild('work', "no");
                        $host->foursharemember->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->sharevnn->work);
                        $host->sharevnn->addChild('work', "no");
                        $host->sharevnn->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->upfilevn->work);
                        $host->upfilevn->addChild('work', "no");
                        $host->upfilevn->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->tenluavn->work);
                        $host->tenluavn->addChild('work', "no");
                        $host->tenluavn->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->mediafire->work);
                        $host->mediafire->addChild('work', "no");
                        $host->mediafire->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->netload->work);
                        $host->netload->addChild('work', "no");
                        $host->netload->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->uploaded->work);
                        $host->uploaded->addChild('work', "no");
                        $host->uploaded->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->rapidgator->work);
                        $host->rapidgator->addChild('work', "no");
                        $host->rapidgator->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        unset($host->letitbit->work);
                        $host->letitbit->addChild('work', "no");
                        $host->letitbit->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->novafile->work);
                        $host->novafile->addChild('work', "no");
                        $host->novafile->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->turbobit->work);
                        $host->turbobit->addChild('work', "no");
                        $host->turbobit->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->ryushare->work);
                        $host->ryushare->addChild('work', "no");
                        $host->ryushare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->filefactory->work);
                        $host->filefactory->addChild('work', "no");
                        $host->filefactory->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->filepost->work);
                        $host->filepost->addChild('work', "no");
                        $host->filepost->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->fourshared->work);
                        $host->fourshared->addChild('work', "no");
                        $host->fourshared->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->depositfiles->work);
                        $host->depositfiles->addChild('work', "no");
                        $host->depositfiles->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->terafile->work);
                        $host->terafile->addChild('work', "no");
                        $host->terafile->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->oboom->work);
                        $host->oboom->addChild('work', "no");
                        $host->oboom->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->bitshare->work);
                        $host->bitshare->addChild('work', "no");
                        $host->bitshare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->uptobox->work);
                        $host->uptobox->addChild('work', "no");
                        $host->uptobox->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->extmatrix->work);
                        $host->extmatrix->addChild('work', "no");
                        $host->extmatrix->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->megaconz->work);
                        $host->megaconz->addChild('work', "no");
                        $host->megaconz->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->freakshare->work);
                        $host->freakshare->addChild('work', "no");
                        $host->freakshare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->firedrive->work);
                        $host->firedrive->addChild('work', "no");
                        $host->firedrive->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->uploadable->work);
                        $host->uploadable->addChild('work', "no");
                        $host->uploadable->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->zippyshare->work);
                        $host->zippyshare->addChild('work', "no");
                        $host->zippyshare->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->keep2share->work);
                        $host->keep2share->addChild('work', "no");
                        $host->keep2share->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->megashares->work);
                        $host->megashares->addChild('work', "no");
                        $host->megashares->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        $host = simplexml_load_file($config['hostlist']);
                        unset($host->youtube->work);
                        $host->youtube->addChild('work', "no");
                        $host->youtube->asXML($config['hostlist']);
                        $host->asXML($config['hostlist']);
                        //Luu file + time
                        $data = $id_user . '|';
                        Write_File($user_file, $data, 'a', 1);
                        $mess = "[center][b] [color=red]" . $name . "[/color][br][color=green]Đã dừng get link[/color] [color=blue]tất cả các File Host[/color][/b][/center]";
                        post_cbox($mess);
                    }
                }
            }
        }
    }
}
//Anti-Spam
$so_chat = 0;
for ($i = 1; $i < count($arr); $i++) {
    if (strcmp($arr[0], $Bot_Name) == 0 || Check_SuperAdmin($superadmin, $arr[0]) == true || Check_Admin($adminlist, $arr[0]) == true || Check_Manager($manager, $arr[0]) == true || Check_Vip($viplist, $arr[0]) == true || Check_Bot($bots, $arr[0]) == true) {
    } else {
        if ($arr[0] == $arr[$i]) {
            $so_chat++;
        } else {
        }
        if ($so_chat == 4) {
            Banned_Spamer($arr[0], $arrid[0]);
            Del_Mess_Nick($arr[0]);
            //Add blacklist
            if (Check_Blacklist($blacklist, $arr[0]) == false) {
                $bl = simplexml_load_file($config['blacklist']);
                $bl->addChild('name', $arr[0]);
                $bl->asXML($config['blacklist']);
                $mess       = "[center][b] Đã thêm[color=blue] " . $arr[0] . " [/color]vào danh sách đen[color=red] forever [/color]vì lý do[color=green] Spam [/color][/b] bye [/center]";
                //	post_cbox($mess);
                //Luu file + info
                $nick       = $arr[0];
                $user_file3 = "banned/" . $nick . ".txt";
                $log        = fopen($user_file3, "a", 1);
                $data       = time() . '\r\n999\r\nSpam\r\nAUTO BANNED|';
                fwrite($log, $data);
                fclose($log);
            } else { //Neu da co trong danh sach den
                //	post_cbox("[center][b]Thành viên[color=blue] ".$arr[0]." [/color]đã có trong danh sách đen![/b] ");
                //Luu file + info
                $nick       = $arr[0];
                $user_file3 = "banned/" . $nick . ".txt";
                $log        = fopen($user_file3, "a", 1);
                //	$data = $date2.'-forever-Spam-AUTO+BANNED|';
                $data       = time() . '\r\n999\r\nSpam\r\nAUTO BANNED|';
                fwrite($log, $data);
                fclose($log);
            }
        }
    }
}
?>