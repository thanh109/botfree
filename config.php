<?php
define("_homepage", "vnz-leech.com");
define("_copyright", "Copyright 2015 by <font color=green><b>VNZLeech.Vn</b></font>");

include_once('functions.php');
date_default_timezone_set('Asia/Ho_Chi_Minh');
error_reporting(0);
ini_set('display_errors', 0); 
######### Config FS/4S ##########
$member_fs = "false"; //Get FS cho members tu host VIP hay ko?
$member_4s = "false"; //Get FS cho members tu host VIP hay ko?

//Config XML
$config['cbox_info']    = 'xml/info.xml';
$config['hostlist']     = 'xml/host.xml';
$config['host_check']   = 'xml/check.xml';
$config['other_cbox']   = 'xml/othercbox.xml';
$config['superadmin']   = 'xml/superad.xml';
$config['admin']        = 'xml/admin.xml';
$config['cbox_manager'] = 'xml/manager.xml';
$config['bots']         = 'xml/bots.xml';
$config['cbox_vip']     = 'xml/vip.xml';
$config['blacklist']    = 'xml/blacklist.xml';
$config['badwordlist']    = 'xml/badwordlist.xml';


//Phrase
$phrase['login_fail']       = 'Đặng nhập thất bại!';
$phrase['login_success']    = 'Đăng nhập thành công!';
$phrase['superadmin_exist'] = 'Người này đã có trong danh sách chủ tịch hội đồng quản trị!';
$phrase['admin_exist']      = 'Người này đã có trong danh sách thành viên hội đồng quản trị!';
$phrase['manager_exist']    = 'Người này đã có trong danh sách quản trị viên!';
$phrase['bots_exist']       = 'Người này đã có trong danh sách cộng tác viên của Cbox!';
$phrase['vip_exist']        = 'Người này đã có trong danh sách Vips của cbox!';
$phrase['blacklist_exist']  = 'Thành viên này đã có trong danh sách đen rồi!';

//Get Cbox_Info
$check1    = simplexml_load_file($config['host_check']);
$checklink = urldecode($check1->checklink[0]);
$hostcheck = $checklink;
$info      = simplexml_load_file($config['cbox_info']);
$cbox_url  = urldecode($info->cbox[0]);
$cbox_bot  = $info->name[0];
$cbox_key  = $info->key[0];
$other     = simplexml_load_file($config['other_cbox']);
$cbox_sv   = urldecode($other->sv[0]);
$cbox_id   = urldecode($other->id[0]);
$cbox_tag  = urldecode($other->tag[0]);
$sv1       = $cbox_sv;
$id1       = $cbox_id;
$tag1      = $cbox_tag;
$Bot_Key   = $cbox_key;
$Bot_Name  = $cbox_bot;

################### Bot Working ########################
if ($info->work == "false")
    $bot_start = false;
else
    $bot_start = true;

if ($info->bot_bw == "false") 
    $bot_bw = false;
else
    $bot_bw = true;// tính bandwith

if ($info->notify == "false")
    $bot_notify = false;
else
    $bot_notify = true; // Thong bao

if ($info->chat == "false")
    $bot_chat = false;
else
    $bot_chat = true; // Music, video

if ($info->talk == "false")
    $bot_talk = false;
else
    $bot_talk = true; // Chating

if ($info->ziplink == "false")
    $ziplink = false; 
else
    $ziplink = true;  // Zip Link





//Get hostlist
$hostlist = simplexml_load_file($config['hostlist']);

//Get super admin
$superadmin = simplexml_load_file($config['superadmin']);

//Get adminlist
$adminlist = simplexml_load_file($config['admin']);

//Get list manager
$manager = simplexml_load_file($config['cbox_manager']);

//Get bots
$bots = simplexml_load_file($config['bots']);

//Get list vip
$viplist2 = simplexml_load_file($config['cbox_vip']);
$viplist = List_Vip();
//	$viplist = strtolower($viplist1);
//	print_r($viplist);


//Get blacklist
$blacklist = simplexml_load_file($config['blacklist']);


//Get badwordlist
$badwordlist = simplexml_load_file($config['badwordlist']);


if ($hostlist->rapidgator->swich == "yes")
    $dunghost = false; // Get Dlink
else
    $dunghost = true; // Dung Host


################### Get Host Support ###################
$sp = "";
foreach ($hostlist->children() as $child) {
    if (strcmp($child->work, "yes") == 0 && strcmp($child->getName(), "the end") != 0) {
        if ($child->getName() == "fshare")
            $sp .= "fshare.vn, ";
        elseif ($child->getName() == "nitroflare")
            $sp .= "nitroflare.com, fboom.me, upstore.net, ";
        elseif ($child->getName() == "foursharevn")
            $sp .= "4share.vn, ";
        elseif ($child->getName() == "foursharemember")
            $sp .= "";
        elseif ($child->getName() == "uplea")
            $sp .= "uplea.com, ";
        elseif ($child->getName() == "sharevnn")
            $sp .= "share.vnn.vn, ";
        elseif ($child->getName() == "tenluavn")
            $sp .= "tenlua.vn, ";
        elseif ($child->getName() == "littlebyte")
            $sp .= "littlebyte.net, ";
        elseif ($child->getName() == "keeptwoshare")
            $sp .= "keep2share.cc, ";
        elseif ($child->getName() == "fourshared")
            $sp .= "4shared.com, ";
        elseif ($child->getName() == "megaconz")
            $sp .= "mega.co.nz, ";
        elseif ($child->getName() == "shareonline")
            $sp .= "share-online.biz, ";
        elseif ($child->getName() == "subyshare")
            $sp .= "subyshare.com, ";
        elseif ($child->getName() == "uploaded")
            $sp .= "uploaded.net, ";
        elseif ($child->getName() == "oboom")
            $sp .= "Oboom.com, ";
        elseif ($child->getName() == "speedy")
            $sp .= "speedy.sh, ";
        elseif ($child->getName() == "scribd")
            $sp .= "scribd.com, ";
        elseif ($child->getName() == "soundcloud")
            $sp .= "soundcloud.com, ";
        elseif ($child->getName() == "megashares")
            $sp .= "megashares.com, ";
        elseif ($child->getName() == "crocko")
            $sp .= "crocko.com, ";
        elseif ($child->getName() == "upfilevn")
            $sp .= "upfile.vn, ";
        elseif ($child->getName() == "uptobox")
            $sp .= "uptobox.com, ";
        elseif ($child->getName() == "depositfiles")
            $sp .= "depositfiles.com, ";
        elseif ($child->getName() == "filepost")
            $sp .= "filepost.com, ";
        elseif ($child->getName() == "turbobit")
            $sp .= "turbobit.net, ";
        elseif ($child->getName() == "novafile")
            $sp .= "novafile.com, ";
        elseif ($child->getName() == "filefactory")
            $sp .= "filefactory.com, ";
        elseif ($child->getName() == "zippyshare")
            $sp .= "zippyshare.com, ";
        elseif ($child->getName() == "ryushare")
            $sp .= "ryushare.com, ";
        elseif ($child->getName() == "uploadable")
            $sp .= "uploadable.ch, bigfile.to, ";
        elseif ($child->getName() == "netload")
            $sp .= "netload.in, ";
        elseif ($child->getName() == "hugefiles")
            $sp .= "hugefiles.net, ";
        elseif ($child->getName() == "filesflash")
            $sp .= "filesflash.com, ";
        elseif ($child->getName() == "letitbit")
            $sp .= "letitbit.net, ";
        elseif ($child->getName() == "rapidgator")
            $sp .= "rapidgator.net, ";
        elseif ($child->getName() == "tusfiles")
            $sp .= "tusfiles.net, ";
        elseif ($child->getName() == "extmatrix")
            $sp .= "extmatrix.com, ";
        elseif ($child->getName() == "depfile")
            $sp .= "depfile.com, ";
        elseif ($child->getName() == "ulto")
            $sp .= "ul.to, ";
        elseif ($child->getName() == "nowdownload")
            $sp .= "nowdownload, ";
        elseif ($child->getName() == "vipfile")
            $sp .= "vip-file.com, ";
        elseif ($child->getName() == "uploading")
            $sp .= "uploading.com, ";
        elseif ($child->getName() == "datafile")
            $sp .= "datafile.com, ";
        elseif ($child->getName() == "onefichier")
            $sp .= "1fichier.com, ";
        elseif ($child->getName() == "shareflare")
            $sp .= "shareflare.net, ";
        elseif ($child->getName() == "sendspace")
            $sp .= "sendspace.com, ";
        elseif ($child->getName() == "filesmonster")
            $sp .= "filesmonster.com, ";
        elseif ($child->getName() == "hitfile")
            $sp .= "hitfile.net, ";
        elseif ($child->getName() == "yunfile")
            $sp .= "yunfile.com, ";
        elseif ($child->getName() == "secureupload")
            $sp .= "secureupload.eu, ";
        elseif ($child->getName() == "mediafire")
            $sp .= "mediafire.com, ";
        elseif ($child->getName() == "speedyshare")
            $sp .= "speedyshare.com, ";
        elseif ($child->getName() == "bitshare")
            $sp .= "bitshare.com, ";
        elseif ($child->getName() == "rarefile")
            $sp .= "rarefile.net, ";
         elseif ($child->getName() == "salefiles")
            $sp .= "salefiles.com, ";
         elseif ($child->getName() == "haibonuploading")
            $sp .= "24uploading.com, ";
         elseif ($child->getName() == "filespace")
            $sp .= "filespace.com, ";
         elseif ($child->getName() == "uploadcd")
            $sp .= "upload.cd, ";
         elseif ($child->getName() == "wushare")
            $sp .= "wushare.com, ";
         elseif ($child->getName() == "uploadrocket")
            $sp .= "uploadrocket.net, ";
        elseif ($child->getName() == "kingfiles")
            $sp .= "kingfiles.net, ";
        elseif ($child->getName() == "freakshare")
            $sp .= "freakshare.com, ";
        elseif ($child->getName() == "youtube")
            $sp .= "youtube.com, ";
        elseif ($child->getName() == "terafile")
            $sp .= "terafile.co, ";
        elseif ($child->getName() == "easybytez")
            $sp .= "easybytez.com, ";
        elseif ($child->getName() == "alfafile")
            $sp .= "alfafile.net, ";
			
        elseif ($child->getName() == "filejoker")
            $sp .= "filejoker.net, ";
        else
            $sp .= strtolower($child->getName()) . ", ";
    }
}
$bot_support = ucwords($sp);

################### Get Host Not Support ###############
$nsp = "";
foreach ($hostlist->children() as $child) {
    if (strcmp($child->work, "no") == 0 && strcmp($child->getName(), "the end") != 0) {
        $nsp .= strtolower($child->getName()) . ", ";
    }
}
$bot_not_support = $nsp;

################### Config Host Get ####################

//fshare.vn
$fsharevn     = array(
    $hostlist->fshare->sv1,
    $hostlist->fshare->sv2,
    $hostlist->fshare->sv3,
    $hostlist->fshare->sv4,
    $hostlist->fshare->sv5,
    $hostlist->fshare->sv6,
    $hostlist->fshare->sv7,
    $hostlist->fshare->sv8
);
$sv_fshare_vn = rand(0, count($fsharevn) - 1);
$fshare_vn    = $fsharevn[$sv_fshare_vn];
$fsvn         = explode('|', $fshare_vn . '|' . $sv_fshare_vn);

//easybytez.com
$easybytezcom     = array(
    $hostlist->easybytez->sv1,
    $hostlist->easybytez->sv2,
    $hostlist->easybytez->sv3
);
$sv_easybytez = rand(0, count($easybytezcom) - 1);
$easybytez_com    = $easybytezcom[$sv_easybytez];
$easybytez        = explode('|', $easybytez_com . '|' . $sv_easybytez);

//filejoker.net
$filejokernet     = array(
    $hostlist->filejoker->sv1,
    $hostlist->filejoker->sv2,
    $hostlist->filejoker->sv3
);
$sv_filejoker = rand(0, count($filejokernet) - 1);
$filejoker_net    = $filejokernet[$sv_filejoker];
$filejoker        = explode('|', $filejoker_net . '|' . $sv_filejoker);

//alfafile.net
$alfafilenet     = array(
    $hostlist->alfafile->sv1,
    $hostlist->alfafile->sv2,
    $hostlist->alfafile->sv3
);
$sv_alfafile = rand(0, count($alfafilenet) - 1);
$alfafile_net    = $alfafilenet[$sv_alfafile];
$alfafile        = explode('|', $alfafile_net . '|' . $sv_alfafile);

//nitro
$nitroflare     = array(
    $hostlist->nitroflare->sv1,
    $hostlist->nitroflare->sv2,
    $hostlist->nitroflare->sv3,
    $hostlist->nitroflare->sv4,
    $hostlist->nitroflare->sv5
);
$sv_nitro       = rand(0, count($nitroflare) - 1);
$nitroflare_mem = $nitroflare[$sv_nitro];
$nitro          = explode('|', $nitroflare_mem . '|' . $sv_nitro);
$nitrostt = array($hostlist->nitroflare->work);
//secureupload.eu
$secureupload     = array(
    $hostlist->secureupload->sv1,
    $hostlist->secureupload->sv2,
    $hostlist->secureupload->sv3,
    $hostlist->secureupload->sv4,
    $hostlist->secureupload->sv5
);
$sv_secureupload       = rand(0, count($secureupload) - 1);
$secureupload_mem = $secureupload[$sv_secureupload];
$secureuploadeu          = explode('|', $secureupload_mem . '|' . $sv_secureupload);
//uplea.com
$upleacom     = array(
    $hostlist->uplea->sv1,
    $hostlist->uplea->sv2,
    $hostlist->uplea->sv3
);
$sv_uplea       = rand(0, count($upleacom) - 1);
$uplea_mem = $upleacom[$sv_uplea];
$uplea          = explode('|', $uplea_mem . '|' . $sv_uplea);
//salefiles.com
$salefilescom     = array(
    $hostlist->salefiles->sv1,
    $hostlist->salefiles->sv2,
    $hostlist->salefiles->sv3,
    $hostlist->salefiles->sv4,
    $hostlist->salefiles->sv5
);
$sv_salefiles       = rand(0, count($salefilescom) - 1);
$salefiles_mem = $salefilescom[$sv_salefiles];
$salefiles          = explode('|', $salefiles_mem . '|' . $sv_salefiles);
//uploadrocket.net
$uploadrocketnet     = array(
    $hostlist->uploadrocket->sv1,
    $hostlist->uploadrocket->sv2,
    $hostlist->uploadrocket->sv3
);
$sv_uploadrocket       = rand(0, count($uploadrocketnet) - 1);
$uploadrocket_mem = $uploadrocketnet[$sv_uploadrocket];
$uploadrocket          = explode('|', $uploadrocket_mem . '|' . $sv_uploadrocket);

//kingfiles.net
$kingfilesnet     = array(
    $hostlist->kingfiles->sv1,
    $hostlist->kingfiles->sv2,
    $hostlist->kingfiles->sv3
);
$sv_kingfiles       = rand(0, count($kingfilesnet) - 1);
$kingfiles_mem = $kingfilesnet[$sv_kingfiles];
$kingfiles          = explode('|', $kingfiles_mem . '|' . $sv_kingfiles);

//wushare.com
$wusharecom     = array(
    $hostlist->wushare->sv1,
    $hostlist->wushare->sv2,
    $hostlist->wushare->sv3
);
$sv_wushare       = rand(0, count($wusharecom) - 1);
$wushare_mem = $wusharecom[$sv_wushare];
$wushare          = explode('|', $wushare_mem . '|' . $sv_wushare);

//filespace.com
$filespace     = array(
    $hostlist->filespace->sv1,
    $hostlist->filespace->sv2,
    $hostlist->filespace->sv3,
    $hostlist->filespace->sv4,
    $hostlist->filespace->sv5
);
$sv_filespace       = rand(0, count($filespace) - 1);
$filespace_mem = $filespace[$sv_filespace];
$filespace          = explode('|', $filespace_mem . '|' . $sv_filespace);
//upload.cd
$uploadcd     = array(
    $hostlist->uploadcd->sv1,
    $hostlist->uploadcd->sv2,
    $hostlist->uploadcd->sv3,
    $hostlist->uploadcd->sv4,
    $hostlist->uploadcd->sv5
);
$sv_uploadcd      = rand(0, count($uploadcd) - 1);
$uploadcd_mem = $uploadcd[$sv_uploadcd];
$uploadcd          = explode('|', $uploadcd_mem . '|' . $sv_uploadcd);

//24uploading.com
$haibonuploading     = array(
    $hostlist->haibonuploading->sv1,
    $hostlist->haibonuploading->sv2,
    $hostlist->haibonuploading->sv3,
    $hostlist->haibonuploading->sv4,
    $hostlist->haibonuploading->sv5
);
$sv_haibonuploading       = rand(0, count($haibonuploading) - 1);
$haibonuploading_mem = $haibonuploading[$sv_haibonuploading];
$haibonuld          = explode('|', $haibonuploading_mem . '|' . $sv_haibonuploading);

//hitfile
$hitfilenet     = array(
    $hostlist->hitfile->sv1,
    $hostlist->hitfile->sv2,
    $hostlist->hitfile->sv3,
    $hostlist->hitfile->sv4,
    $hostlist->hitfile->sv5
);
$sv_hitfile       = rand(0, count($hitfilenet) - 1);
$hitfile_mem = $hitfilenet[$sv_hitfile];
$hitfile          = explode('|', $hitfile_mem . '|' . $sv_hitfile);
//	$nitro = array($hostlist->nitroflare->work);

//up.4share.vn vip
$fourshare       = array(
    $hostlist->foursharevn->sv1,
    $hostlist->foursharevn->sv2,
    $hostlist->foursharevn->sv3,
    $hostlist->foursharevn->sv4,
    $hostlist->foursharevn->sv5,
    $hostlist->foursharevn->sv6,
    $hostlist->foursharevn->sv7,
    $hostlist->foursharevn->sv8
);
$sv_fourshare_vn = rand(0, count($fourshare) - 1);
$fourshare_vn    = $fourshare[$sv_fourshare_vn];
$foursvn         = explode('|', $fourshare_vn . '|' . $sv_fourshare_vn);

//1fichier.com
$onefichiercom  = array(
    $hostlist->onefichier->sv1,
    $hostlist->onefichier->sv2,
    $hostlist->onefichier->sv3
);
$sv_onefichier  = rand(0, count($onefichiercom) - 1);
$onefichier_com = $onefichiercom[$sv_onefichier];
$onefichier     = explode('|', $onefichier_com . '|' . $sv_onefichier);

//sendspace.com
$sendspacecom  = array(
    $hostlist->sendspace->sv1,
    $hostlist->sendspace->sv2,
    $hostlist->sendspace->sv3
);
$sv_sendspace  = rand(0, count($sendspacecom) - 1);
$sendspace_com = $sendspacecom[$sv_sendspace];
$sendspace     = explode('|', $sendspace_com . '|' . $sv_sendspace);

//yunfile.com
$yunfilecom  = array(
    $hostlist->yunfile->sv1,
    $hostlist->yunfile->sv2,
    $hostlist->yunfile->sv3
);
$sv_yunfile  = rand(0, count($yunfilecom) - 1);
$yunfile_com = $sendspacecom[$sv_yunfile];
$yunfile     = explode('|', $yunfile_com . '|' . $sv_yunfile);

//up.4share.vn member
$foursharemem  = array(
    $hostlist->foursharemember->sv1,
    $hostlist->foursharemember->sv2,
    $hostlist->foursharemember->sv3,
    $hostlist->foursharemember->sv4,
    $hostlist->foursharemember->sv5
);
$fourshare_mem = $foursharemem[rand(0, count($foursharemem) - 1)];
$foursmem      = explode('|', $fourshare_mem);
$foursprx      = array(

);

//share.vnn.vn
$svnn       = array(
    $hostlist->sharevnn->url,
    $hostlist->sharevnn->pass,
    $hostlist->sharevnn->work
);
//rarefile.net
$rarefilenet       = array(
    $hostlist->rarefile->sv1,
    $hostlist->rarefile->sv2,
    $hostlist->rarefile->sv3
);
$sv_rf       = rand(0, count($rarefilenet) - 1);
$rarefile_net = $rarefilenet[$sv_rf];
$rarefile           = explode('|', $rarefile_net . '|' . $sv_rf);

//shareflare
$shareflare = array(
    $hostlist->shareflare->url,
    $hostlist->shareflare->pass,
    $hostlist->shareflare->work
);

//nowdownload
$nowdownloadch = array(
    $hostlist->nowdownload->sv1,
    $hostlist->nowdownload->sv2,
    $hostlist->nowdownload->sv3
);
$sv_nowdownload       = rand(0, count($nowdownloadch) - 1);
$nowdownload_ch = $nowdownloadch[$sv_nowdownload];
$nowdownload           = explode('|', $nowdownload_ch . '|' . $sv_nowdownload);

//uploading.com
$uploadingcom         = array(
    $hostlist->uploading->sv1,
    $hostlist->uploading->sv2,
    $hostlist->uploading->sv3
);
$sv_uploading       = rand(0, count($uploadingcom) - 1);
$uploading_com = $uploadingcom[$sv_uploading];
$uld           = explode('|', $uploading_com . '|' . $sv_uploading);

//vipfile
$vipfilecom     = array(
    $hostlist->vipfile->sv1,
    $hostlist->vipfile->sv2,
    $hostlist->vipfile->sv3
);
$sv_vipfile       = rand(0, count($vipfilecom) - 1);
$vipfile_com = $vipfilecom[$sv_vipfile];
$vipfile           = explode('|', $vipfile_com . '|' . $sv_vipfile);

//depfile.com
$depfilecom     = array(
    $hostlist->depfile->sv1,
    $hostlist->depfile->sv2,
    $hostlist->depfile->sv3
);
$sv_depfile       = rand(0, count($depfilecom) - 1);
$depfile_com = $depfilecom[$sv_depfile];
$depfile           = explode('|', $depfile_com . '|' . $sv_depfile);

//filesmonster.com
$filesmonstercom     = array(
    $hostlist->filesmonster->sv1,
    $hostlist->filesmonster->sv2,
    $hostlist->filesmonster->sv3
);
$sv_fmc       = rand(0, count($filesmonstercom) - 1);
$filesmonster_com = $filesmonstercom[$sv_fmc];
$filesmonster           = explode('|', $filesmonster_com . '|' . $sv_fmc);

//datafile.com
$datafilecom    = array(
    $hostlist->datafile->sv1,
    $hostlist->datafile->sv2,
    $hostlist->datafile->sv3
);
$sv_df        = rand(0, count($datafilecom) - 1);
$datafile_com = $datafilecom[$sv_df];
$datafile           = explode('|', $datafile_com . '|' . $sv_df);


//ul.to
$ulto        = array(
    $hostlist->ulto->url,
    $hostlist->ulto->pass,
    $hostlist->ulto->work
);

//speedy.sh
$speedysharecom        = array(
    $hostlist->speedyshare->sv1,
    $hostlist->speedyshare->sv2,
    $hostlist->speedyshare->sv3
);
$sv_spd        = rand(0, count($speedysharecom) - 1);
$speedyshare_com = $speedysharecom[$sv_spd];
$spds           = explode('|', $speedyshare_com . '|' . $sv_spd);


//shareonline
$sobiz         = array(
    $hostlist->shareonline->sv1,
    $hostlist->shareonline->sv2,
    $hostlist->shareonline->sv3
);
$sv_sob       = rand(0, count($sobiz) - 1);
$sob_com = $sobiz[$sv_sob];
$sob           = explode('|', $sob_com . '|' . $sv_sob);

//tenlua.vn
$tlvn = array(
    $hostlist->tenluavn->url,
    $hostlist->tenluavn->pass,
    $hostlist->tenluavn->work
);

//tusfiles.net
$tusfilescom = array(
    $hostlist->tusfiles->sv1,
    $hostlist->tusfiles->sv2,
    $hostlist->tusfiles->sv3
);
$sv_tus      = rand(0, count($tusfilescom) - 1);
$tusfiles_net = $tusfilescom[$sv_tus];
$tusfiles           = explode('|', $tusfiles_net . '|' . $sv_tus);

//upfile.vn
$ufvn = array(
    $hostlist->upfilevn->url,
    $hostlist->upfilevn->pass,
    $hostlist->upfilevn->work
);

//mediafire.com
$mediafirecom  = array(
    $hostlist->mediafire->sv1,
    $hostlist->mediafire->sv2,
    $hostlist->mediafire->sv3
);
$sv_mf = rand(0, count($mediafirecom) - 1);
$mediafire_com = $mediafirecom[$sv_mf];
$mf            = explode('|', $mediafire_com . '|' .$sv_mf);

//netload.in
$netloadin  = array(
    $hostlist->netload->sv1,
    $hostlist->netload->sv2,
    $hostlist->netload->sv3
);
$sv_nl      = rand(0, count($netloadin) - 1);
$netload_in = $netloadin[$sv_nl];
$nl         = explode('|', $netload_in . '|' . $sv_nl);

//uploaded.net
$uploadednet  = array(
    $hostlist->uploaded->sv1,
    $hostlist->uploaded->sv2,
    $hostlist->uploaded->sv3,
    $hostlist->uploaded->sv4,
    $hostlist->uploaded->sv5,
    $hostlist->uploaded->sv6
);
$sv_ul        = rand(0, count($uploadednet) - 1);
$uploaded_net = $uploadednet[$sv_ul];
$ul           = explode('|', $uploaded_net . '|' . $sv_ul);

//rapidgator.net
$rapidgatornet  = array(
    $hostlist->rapidgator->sv1,
    $hostlist->rapidgator->sv2,
    $hostlist->rapidgator->sv3
);
$sv_rg          = rand(0, count($rapidgatornet) - 1);
$rapidgator_net = $rapidgatornet[$sv_rg];
$swich = array($hostlist->rapidgator->swich);
$rg             = explode('|', $rapidgator_net . '|' . $sv_rg . '|' .$swich);

//letitbit.net
$letitbitnet  = array(
    $hostlist->letitbit->sv1,
    $hostlist->letitbit->sv2,
    $hostlist->letitbit->sv3
);
$sv_ltb       = rand(0, count($letitbitnet) - 1);
$letitbit_net = $letitbitnet[$sv_ltb];
$ltb          = explode('|', $letitbit_net . '|' . $sv_ltb);

//novafile.com
$novafilecom  = array(
    $hostlist->novafile->sv1,
    $hostlist->novafile->sv2,
    $hostlist->novafile->sv3
);
$sv_nv        = rand(0, count($novafilecom) - 1);
$novafile_com = $novafilecom[$sv_nv];
$nvf          = explode('|', $novafile_com . '|' . $sv_nv);

//turbobit.net
$turbobitnet  = array(
    $hostlist->turbobit->sv1,
    $hostlist->turbobit->sv2,
    $hostlist->turbobit->sv3
);
$sv_tbb       = rand(0, count($turbobitnet) - 1);
$turbobit_net = $turbobitnet[$sv_tbb];
$tbb          = explode('|', $turbobit_net . '|' . $sv_tbb);

//ryushare.com
$ryusharecom  = array(
    $hostlist->ryushare->sv1,
    $hostlist->ryushare->sv2,
    $hostlist->ryushare->sv3
);
$sv_ryu       = rand(0, count($ryusharecom) - 1);
$ryushare_com = $ryusharecom[$sv_ryu];
$ryu          = explode('|', $ryushare_com . '|' . $sv_ryu);

//filefactory.com
$filefactorycom  = array(
    $hostlist->filefactory->sv1,
    $hostlist->filefactory->sv2,
    $hostlist->filefactory->sv3
);
$sv_ff           = rand(0, count($filefactorycom) - 1);
$filefactory_com = $filefactorycom[$sv_ff];
$ff              = explode('|', $filefactory_com . '|' . $sv_ff);

//filepost.com
$filepostcom  = array(
    $hostlist->filepost->sv1,
    $hostlist->filepost->sv2,
    $hostlist->filepost->sv3
);
$sv_fp        = rand(0, count($filepostcom) - 1);
$filepost_com = $filepostcom[$sv_fp];
$fp           = explode('|', $filepost_com . '|' . $sv_fp);

//4shared.com
$foursharedcom  = array(
    $hostlist->fourshared->sv1,
    $hostlist->fourshared->sv2,
    $hostlist->fourshared->sv3
);
$sv_fourshared  = rand(0, count($foursharedcom) - 1);
$fourshared_com = $foursharedcom[$sv_fourshared];
$foursed        = explode('|', $fourshared_com . '|' . $sv_fourshared);

//depositfiles.com
$depositfilescom  = array(
    $hostlist->depositfiles->sv1,
    $hostlist->depositfiles->sv2,
    $hostlist->depositfiles->sv3
);
$sv_depo = rand(0, count($depositfilescom) - 1);
$depositfiles_com = $depositfilescom[$sv_depo];
$df               = explode('|', $depositfiles_com .'|' . $sv_depo);

//terafile.co
$terafileco  = array(
    $hostlist->terafile->sv1,
    $hostlist->terafile->sv2,
    $hostlist->terafile->sv3
);
$sv_tfc = rand(0, count($terafileco) - 1);
$terafile_co = $terafileco[$sv_tfc];
$tf          = explode('|', $terafile_co .'|' .$sv_tfc);

//oboom.com
$oboomcom  = array(
    $hostlist->oboom->sv1,
    $hostlist->oboom->sv2,
    $hostlist->oboom->sv3
);
$sv_obc = rand(0, count($oboomcom) - 1);
$oboom_com = $oboomcom[$sv_obc];
$ob        = explode('|', $oboom_com . '|' . $sv_obc);

//bitshare.com
$bitsharecom  = array(
    $hostlist->bitshare->sv1,
    $hostlist->bitshare->sv2,
    $hostlist->bitshare->sv3
);
$bitshare_com = $bitsharecom[rand(0, count($bitsharecom) - 1)];
$bs           = explode('|', $bitshare_com);

//uptobox.com
$uptoboxcom  = array(
    $hostlist->uptobox->sv1,
    $hostlist->uptobox->sv2,
    $hostlist->uptobox->sv3
);
$sv_utb = rand(0, count($uptoboxcom) - 1);
$uptobox_com = $uptoboxcom[$sv_utb];
$utb         = explode('|', $uptobox_com . '|' . $sv_utb);

//extmatrix.com
$extmatrixcom  = array(
    $hostlist->extmatrix->sv1,
    $hostlist->extmatrix->sv2,
    $hostlist->extmatrix->sv3
);
$sv_exm = rand(0, count($extmatrixcom) - 1);
$extmatrix_com = $extmatrixcom[$sv_exm];
$exm           = explode('|', $extmatrix_com . '|' . $sv_exm);

//mega.co.nz
$mega_conz  = array(
    $hostlist->megaconz->sv1,
    $hostlist->megaconz->sv2,
    $hostlist->megaconz->sv3
);
$sv_mcnz = rand(0, count($mega_conz) - 1);
$mega_co_nz = $mega_conz[$sv_mcnz];
$mcn        = explode('|', $mega_co_nz . '|' . $sv_mcnz);

//freakshare.com
$freaksharecom  = array(
    $hostlist->freakshare->sv1,
    $hostlist->freakshare->sv2,
    $hostlist->freakshare->sv3
);
$sv_frs = rand(0, count($freaksharecom) - 1);
$freakshare_com = $freaksharecom[$sv_frs];
$frs            = explode('|', $freakshare_com . '|' . $sv_frs);

//firedrive.com
$firedrivecom  = array(
    $hostlist->firedrive->sv1,
    $hostlist->firedrive->sv2,
    $hostlist->firedrive->sv3
);
$sv_fdrs = rand(0, count($firedrivecom) - 1);
$firedrive_com = $firedrivecom[$sv_fdrs];
$fd            = explode('|', $firedrive_com . '|' . $sv_fdrs);

//uploadable.ch
$uploadablech  = array(
    $hostlist->uploadable->sv1,
    $hostlist->uploadable->sv2,
    $hostlist->uploadable->sv3
);
$sv_uab        = rand(0, count($uploadablech) - 1);
$uploadable_ch = $uploadablech[$sv_uab];
$uab           = explode('|', $uploadable_ch . '|' . $sv_uab);

//zippyshare.com
$zippysharecom  = array(
    $hostlist->zippyshare->sv1,
    $hostlist->zippyshare->sv2,
    $hostlist->zippyshare->sv3
);
$sv_zippy       = rand(0, count($zippysharecom) - 1);
$zippyshare_com = $zippysharecom[$sv_zippy];
$zps            = explode('|', $zippyshare_com . '|' . $sv_zippy);

//keep2share.cc
$keep2sharecc  = array(
    $hostlist->keeptwoshare->sv1,
    $hostlist->keeptwoshare->sv2,
    $hostlist->keeptwoshare->sv3
);
$sv_k2s		   = rand(0, count($keep2sharecc) - 1);
$keep2share_cc = $keep2sharecc[$sv_k2s];
$k2s           = explode('|', $keep2share_cc . '|' . $sv_k2s);

//megashares.com
$megasharescom  = array(
    $hostlist->megashares->sv1,
    $hostlist->megashares->sv2,
    $hostlist->megashares->sv3
);
$sv_mgs = rand(0, count($megasharescom) - 1);
$megashares_com = $megasharescom[$sv_mgs];
$mgs            = explode('|', $megashares_com .'|' . $sv_mgs);

//youtube.com
$ytb = array(
    $hostlist->youtube->url,
    $hostlist->youtube->pass,
    $hostlist->youtube->work
);

//littlebyte.net
$lttb1          = array(
    $hostlist->littlebyte->sv1,
    $hostlist->littlebyte->sv2,
    $hostlist->littlebyte->sv3
);
$sv_lttb        = rand(0, count($lttb1) - 1);
$littlebyte_net = $lttb1[$sv_lttb];
$lttb           = explode('|', $littlebyte_net . '|' . $sv_lttb);


//scribd.com
$scribdcom  = array(
    $hostlist->scribd->sv1,
    $hostlist->scribd->sv2,
    $hostlist->scribd->sv3
);
$sv_scribd  = rand(0, count($scribdcom) - 1);
$scribd_com = $scribdcom[$sv_scribd];
$scribd     = explode('|', $scribd_com . '|' . $sv_scribd);


//hugefiles.net
$hugefilesnet  = array(
    $hostlist->hugefiles->sv1,
    $hostlist->hugefiles->sv2,
    $hostlist->hugefiles->sv3
);
$sv_hugefiles  = rand(0, count($hugefilesnet) - 1);
$hugefiles_net = $hugefilesnet[$sv_hugefiles];
$hugefiles     = explode('|', $hugefiles_net . '|' . $sv_hugefiles);


//filesflash.net
$filesflashcom  = array(
    $hostlist->filesflash->sv1,
    $hostlist->filesflash->sv2,
    $hostlist->filesflash->sv3
);
$sv_filesflash  = rand(0, count($filesflashcom) - 1);
$filesflash_com = $filesflashcom[$sv_filesflash];
$filesflash     = explode('|', $filesflash_com . '|' . $sv_filesflash);


//soundcloud.com
$soundcloudcom  = array(
    $hostlist->soundcloud->sv1,
    $hostlist->soundcloud->sv2,
    $hostlist->soundcloud->sv3
);
$sv_soundcloud  = rand(0, count($soundcloudcom) - 1);
$soundcloud_com = $soundcloudcom[$sv_soundcloud];
$soundcloud     = explode('|', $soundcloud_com . '|' . $sv_soundcloud);


//subyshare.com
$subysharecom = array(
    $hostlist->subyshare->sv1,
    $hostlist->subyshare->sv2,
    $hostlist->subyshare->sv3
);
$sv_sbs  = rand(0, count($subysharecom) - 1);
$subyshare_com = $subysharecom[$sv_sbs];
$subyshare     = explode('|', $subyshare_com . '|' . $sv_sbs);



################### Check Link Messsage ################
$check_mess = '[b][url=' . $hostcheck . '][color=green]Bạn phải check link tại đây rồi copy kết quả post lên Cbox[/color][br][color=purple]Please click here to check link and copy result then post-on Cbox[/color][/url][/b]';

################### Limit .... post/1 min ################
### on | off limit 1 post/...mins  ==> set 0 ==> off ###
$limit_post = 4;

################### Limit 1 link/...min ################
### on | off limit 1 link/...mins  ==> set 0 ==> off ###
$limit_link = 5;

################### Limit filesize/link ################
### on | off limit 1 link/...mins  ==> set 0 ==> off ###
$limit_size = 2;

################### Limit filesize/link ################
### on | off limit 1 link/...mins  ==> set 0 ==> off ###
$limit_sizevip = 4;

################### Limit 1 song/...min ################
### on | off limit 1 song/...mins  ==> set 0 ==> off ###
$limit_music = 1;

################### Limit danh ngon/...min ################

$danhngon = 5;

################### Limit 1 nick Per IP / min ################
$limit_timeip = 59;
################### Limit Size on day / GB ################
$limit_host = '40 GB';


################### Check Link #########################
$good_link = 'VNZ.Team';
//$good_link = '//i.imgur.com/bZugB5h.gif';

################### ZIP Link ###########################
$randapi = array(
//"http://sieuthinet.info/zip1.php?shink=",
"https://huyenthoai.pro/zip1.php?shink=",
"https://huyenthoai.pro/zip1.php?shink="
//"http://ouo.io/api/63P7NKET?s="
);


//"https://api.shorte.st/stxt/9c17c36eef0d38d5df2be9e8489346ab/"
//"https://adshort.in/api/?api=a857e464e25394e4415d11f4995cfbf6be33e6d9&format=text&url=",
//"https://linkshrink.net/api.php?key=REp&url=",


//$randapi = array($api1,$api2,$api3,$api4,$api5,$api6,$api7,$api8,$api9);


$api = $randapi[rand(0, count($randapi)-1)];
################### Command ############################

?>