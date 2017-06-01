<?php
    include('config.php');
    include_once('functions.php');
session_start();
$userinfo = array(
    'admin9' => 'khongnoidau1', //Hello...
    'quansky04' => 'quankun1' //Hello...
);

if (isset($_GET['logout'])) {
    $_SESSION['username'] = '';
    header('Location:  ' . $_SERVER['PHP_SELF']);
}

if (isset($_POST['username'])) {
    if ($userinfo[$_POST['username']] == ($_POST['password'])) {
        $_SESSION['username'] = $_POST['username'];
    } else {
        header("location:fuck.html"); //replace with 403
    }
}
?>
<?php
if ($_SESSION['username']):
?>
<?php
   
    $host = simplexml_load_file($config['hostlist']);
    //Get Cbox_Info
    if (isset($_POST['nick_bot']) || isset($_POST['send'])) {
        
        $selected_radio = $_POST['gender'];
        
        if ($selected_radio == 'vnzleech') {
            $cboxid  = "4240872";
            $cboxtag = "soigia";
            $cboxsv  = "4";
        } elseif ($selected_radio == "other") {
            $cboxsv  = "";
            $cboxid  = "";
            $cboxtag = "";
        }
        
        $cbox_url = "http://www$cboxsv.cbox.ws/box/?boxid=$cboxid&boxtag=$cboxtag";
        
        if (isset($cbox_url)) {
            $info = simplexml_load_file($config['cbox_info']);
            unset($info->cbox);
            $info->addChild('cbox', urlencode($cbox_url));
            $info->asXML($config['cbox_info']);
        }
        if (isset($_POST['cbox_sv'])) {
            $other = simplexml_load_file($config['other_cbox']);
            unset($other->sv[0]);
            $other->addChild('sv', urlencode($_POST['cbox_sv']));
            $other->asXML($config['other_cbox']);
        }
        if (isset($_POST['cbox_id'])) {
            $other = simplexml_load_file($config['other_cbox']);
            unset($other->id[0]);
            $other->addChild('id', urlencode($_POST['cbox_id']));
            $other->asXML($config['other_cbox']);
        }
        if (isset($_POST['cbox_tag'])) {
            $other = simplexml_load_file($config['other_cbox']);
            unset($other->tag[0]);
            $other->addChild('tag', urlencode($_POST['cbox_tag']));
            $other->asXML($config['other_cbox']);
        }
        
        //Enable Bot
        if (isset($_POST['bot_work'])) {
            $info = simplexml_load_file($config['cbox_info']);
            unset($info->work);
            $info->addChild('work', 'true');
            $info->asXML($config['cbox_info']);
        } else {
            $info = simplexml_load_file($config['cbox_info']);
            unset($info->work);
            $info->addChild('work', 'false');
            $info->asXML($config['cbox_info']);
        }
        if ($_POST['bot_password'] != "") {
            //Get Key and save to info.xml
            $key = Get_Key($cbox_url, $_POST['nick_bot'], $_POST['bot_password']);
            if ($key == $phrase['login_fail']) {
                echo $phrase['login_fail'];
            } else {
                //Save
                $info = simplexml_load_file($config['cbox_info']);
                unset($info->key[0]);
                $info->addChild('key', $key);
                unset($info->name[0]);
                $info->addChild('name', $_POST['nick_bot']);
                $info->asXML($config['cbox_info']);
            }
        }
        //Enable Bot Notify
        if (isset($_POST['bot_notify'])) {
            $info = simplexml_load_file($config['cbox_info']);
            unset($info->notify);
            $info->addChild('notify', 'true');
            $info->asXML($config['cbox_info']);
        }else {
			$info = simplexml_load_file($config['cbox_info']);
            unset($info->notify);
            $info->addChild('notify', 'false');
            $info->asXML($config['cbox_info']);
		}
        //Enable Bot Chat
        if (isset($_POST['bot_chat'])) {
            $info = simplexml_load_file($config['cbox_info']);
            unset($info->chat);
            $info->addChild('chat', 'true');
            $info->asXML($config['cbox_info']);
        }else {
			$info = simplexml_load_file($config['cbox_info']);
            unset($info->chat);
            $info->addChild('chat', 'false');
            $info->asXML($config['cbox_info']);
		}
        //Enable Bot Talk
        if (isset($_POST['bot_talk'])) {
            $info = simplexml_load_file($config['cbox_info']);
            unset($info->talk);
            $info->addChild('talk', 'true');
            $info->asXML($config['cbox_info']);
        }else {
			$info = simplexml_load_file($config['cbox_info']);
            unset($info->talk);
            $info->addChild('talk', 'false');
            $info->asXML($config['cbox_info']);
		}
        if (isset($_POST['check_link'])) {
            $check1 = simplexml_load_file($config['host_check']);
            unset($check1->checklink[0]);
            $check1->addChild('checklink', urlencode($_POST['check_link']));
            $check1->asXML($config['host_check']);
        }
        
        
        
        //Config fshare.vn
        if (isset($_POST['fshare_enable'])) {
            $cf_fshare = array(
                $_POST['fshare1'],
                $_POST['fshare2'],
                $_POST['fshare3'],
                $_POST['fshare4'],
                $_POST['fshare5'],
                $_POST['fshare6'],
                $_POST['fshare7'],
                $_POST['fshare8'],
                "yes"
            );
        } else {
            $cf_fshare = array(
                $_POST['fshare1'],
                $_POST['fshare2'],
                $_POST['fshare3'],
				$_POST['fshare4'],
                $_POST['fshare5'],
                $_POST['fshare6'],
                $_POST['fshare7'],
                $_POST['fshare8'],
                "no"
            );
        }
        //Config subyshare
        if (isset($_POST['subyshare_enable'])) {
            $cf_subyshare = array(
                $_POST['subyshare1'],
                $_POST['subyshare2'],
                $_POST['subyshare3'],
                "yes"
            );
        } else {
            $cf_subyshare = array(
                $_POST['subyshare1'],
                $_POST['subyshare2'],
                $_POST['subyshare3'],
                "no"
            );
        }
        //Config alfafile
        if (isset($_POST['alfafile_enable'])) {
            $cf_alfafile = array(
                $_POST['alfafile1'],
                $_POST['alfafile2'],
                $_POST['alfafile3'],
                "yes"
            );
        } else {
            $cf_alfafile = array(
                $_POST['alfafile1'],
                $_POST['alfafile2'],
                $_POST['alfafile3'],
                "no"
            );
        }
        
        //Config nowdownload
        if (isset($_POST['nowdownload_enable'])) {
            $cf_nowdownload = array(
                $_POST['nowdownload1'],
                $_POST['nowdownload2'],
                $_POST['nowdownload3'],
                "yes"
            );
        } else {
            $cf_nowdownload = array(
                $_POST['nowdownload1'],
                $_POST['nowdownload2'],
                $_POST['nowdownload3'],
                "no"
            );
        }
        
        //Config nitroflare
        if (isset($_POST['nitroflare_enable'])) {
            $cf_nitroflare = array(
                $_POST['nitroflare1'],
                $_POST['nitroflare2'],
                $_POST['nitroflare3'],
                $_POST['nitroflare4'],
                $_POST['nitroflare5'],
                "yes"
            );
        } else {
            $cf_nitroflare = array(
                $_POST['nitroflare1'],
                $_POST['nitroflare2'],
                $_POST['nitroflare3'],
                $_POST['nitroflare4'],
                $_POST['nitroflare5'],
                "no"
            );
        }
        
        //Config up.4share.vn
        if (isset($_POST['foursharevn_enable'])) {
            $cf_foursharevn = array(
                $_POST['foursharevn1'],
                $_POST['foursharevn2'],
                $_POST['foursharevn3'],
                $_POST['foursharevn4'],
                $_POST['foursharevn5'],
                $_POST['foursharevn6'],
                $_POST['foursharevn7'],
                $_POST['foursharevn8'],
                "yes"
            );
        } else {
            $cf_foursharevn = array(
                $_POST['foursharevn1'],
                $_POST['foursharevn2'],
                $_POST['foursharevn3'],
                $_POST['foursharevn4'],
                $_POST['foursharevn5'],
                $_POST['foursharevn6'],
                $_POST['foursharevn7'],
                $_POST['foursharevn8'],
                "no"
            );
        }
        
        //Config hitfile
        if (isset($_POST['hitfile_enable'])) {
            $cf_hitfile = array(
                $_POST['hitfile1'],
                $_POST['hitfile2'],
                $_POST['hitfile3'],
                $_POST['hitfile4'],
                $_POST['hitfile5'],
                "yes"
            );
        } else {
            $cf_hitfile = array(
                $_POST['hitfile1'],
                $_POST['hitfile2'],
                $_POST['hitfile3'],
                $_POST['hitfile4'],
                $_POST['hitfile5'],
                "no"
            );
        }
        
        //Config rarefile
        if (isset($_POST['rarefile_enable'])) {
            $cf_rarefile = array(
                $_POST['rarefile1'],
                $_POST['rarefile2'],
                $_POST['rarefile3'],
            
                "yes"
            );
        } else {
            $cf_rarefile = array(
                $_POST['rarefile1'],
                $_POST['rarefile2'],
                $_POST['rarefile3'],
            
                "no"
            );
        }
        
        //Config filesmonstercom
        if (isset($_POST['filesmonster_enable'])) {
            $cf_filesmonster = array(
                $_POST['filesmonster1'],
                $_POST['filesmonster2'],
                $_POST['filesmonster3'],
            
                "yes"
            );
        } else {
            $cf_filesmonster = array(
                $_POST['filesmonster1'],
                $_POST['filesmonster2'],
                $_POST['filesmonster3'],
            
                "no"
            );
        }
        
        //Config salefiles
        if (isset($_POST['salefiles_enable'])) {
            $cf_salefiles = array(
                $_POST['salefiles1'],
                $_POST['salefiles2'],
                $_POST['salefiles3'],
                $_POST['salefiles4'],
                $_POST['salefiles5'],
                "yes"
            );
        } else {
            $cf_salefiles = array(
                $_POST['salefiles1'],
                $_POST['salefiles2'],
                $_POST['salefiles3'],
                $_POST['salefiles4'],
                $_POST['salefiles5'],
                "no"
            );
        }
        
        //Config up.4share.vn member
        if (isset($_POST['secureupload_enable'])) {
            $cf_secureupload = array(
                $_POST['secureupload1'],
                $_POST['secureupload2'],
                $_POST['secureupload3'],
                $_POST['secureupload4'],
                $_POST['secureupload5'],
                "yes"
            );
        } else {
            $cf_secureupload = array(
                $_POST['secureupload1'],
                $_POST['secureupload2'],
                $_POST['secureupload3'],
                $_POST['secureupload4'],
                $_POST['secureupload5'],
                "no"
            );
        }
        
        //Config share.vnn.vn
        if (isset($_POST['sharevnn_enable'])) {
            $cf_sharevnn = array(
                $_POST['sharevnn'],
                $_POST['sharevnn_pass'],
                "yes"
            );
        } else {
            $cf_sharevnn = array(
                $_POST['sharevnn'],
                $_POST['sharevnn_pass'],
                "no"
            );
        }
        
        //Config tenlua.vn
        if (isset($_POST['tenluavn_enable'])) {
            $cf_tenluavn = array(
                $_POST['tenluavn'],
                $_POST['tenluavn_pass'],
                "yes"
            );
        } else {
            $cf_tenluavn = array(
                $_POST['tenluavn'],
                $_POST['tenluavn_pass'],
                "no"
            );
        }
        
        //Config upfile.vn
        if (isset($_POST['upfilevn_enable'])) {
            $cf_upfilevn = array(
                $_POST['upfilevn'],
                $_POST['upfilevn_pass'],
                "yes"
            );
        } else {
            $cf_upfilevn = array(
                $_POST['upfilevn'],
                $_POST['upfilevn_pass'],
                "no"
            );
        }
        
        //Config mediafire.com
        if (isset($_POST['mediafire_enable'])) {
            $cf_mediafire = array(
                $_POST['mediafire1'],
                $_POST['mediafire2'],
                $_POST['mediafire3'],
                "yes"
            );
        } else {
            $cf_mediafire = array(
                $_POST['mediafire1'],
                $_POST['mediafire2'],
                $_POST['mediafire3'],
                "no"
            );
        }
          //Config littlebyte.net
        if (isset($_POST['littlebyte_enable'])) {
            $cf_littlebyte = array(
                $_POST['littlebyte1'],
                $_POST['littlebyte2'],
                $_POST['littlebyte3'],
                "yes"
            );
        } else {
            $cf_littlebyte = array(
                $_POST['littlebyte1'],
                $_POST['littlebyte2'],
                $_POST['littlebyte3'],
                "no"
            );
        }
        
        //Config netload.in
        if (isset($_POST['netload_enable'])) {
            $cf_netload = array(
                $_POST['netload1'],
                $_POST['netload2'],
                $_POST['netload3'],
                "yes"
            );
        } else {
            $cf_netload = array(
                $_POST['netload1'],
                $_POST['netload2'],
                $_POST['netload3'],
                "no"
            );
        }
        //Config uplea.com
        if (isset($_POST['uplea_enable'])) {
            $cf_uplea = array(
                $_POST['uplea1'],
                $_POST['uplea2'],
                $_POST['uplea3'],
                "yes"
            );
        } else {
            $cf_uplea = array(
                $_POST['uplea1'],
                $_POST['uplea2'],
                $_POST['uplea3'],
                "no"
            );
        }
          //Config 1fichier.com
        if (isset($_POST['onefichier_enable'])) {
            $cf_onefichier = array(
                $_POST['onefichier1'],
                $_POST['onefichier2'],
                $_POST['onefichier3'],
                "yes"
            );
        } else {
            $cf_onefichier = array(
                $_POST['onefichier1'],
                $_POST['onefichier2'],
                $_POST['onefichier3'],
                "no"
            );
        }
        
          //Config vipfile.com
        if (isset($_POST['vipfile_enable'])) {
            $cf_vipfile = array(
                $_POST['vipfile1'],
                $_POST['vipfile2'],
                $_POST['vipfile3'],
                "yes"
            );
        } else {
            $cf_vipfile = array(
                $_POST['vipfile1'],
                $_POST['vipfile2'],
                $_POST['vipfile3'],
                "no"
            );
        }
        
        //Config uploaded.net
        if (isset($_POST['uploaded_enable'])) {
            $cf_uploaded = array(
                $_POST['uploaded1'],
                $_POST['uploaded2'],
                $_POST['uploaded3'],
                $_POST['uploaded4'],
                $_POST['uploaded5'],
                $_POST['uploaded6'],
                "yes"
            );
        } else {
            $cf_uploaded = array(
                $_POST['uploaded1'],
                $_POST['uploaded2'],
                $_POST['uploaded3'],
                $_POST['uploaded4'],
                $_POST['uploaded5'],
                $_POST['uploaded6'],
                "no"
            );
        }
        
        //Config rapidgator.com
        if (isset($_POST['rapidgator_enable'])) {
            $cf_rapidgator = array(
                $_POST['rapidgator1'],
                $_POST['rapidgator2'],
                $_POST['rapidgator3'],
                "yes"
            );
        } else {
            $cf_rapidgator = array(
                $_POST['rapidgator1'],
                $_POST['rapidgator2'],
                $_POST['rapidgator3'],
                "no"
            );
        }
		if (isset($_POST['swich_rapidgator_enable'])) {
			$cf_swich = "yes";
		}else{
			$cf_swich = "no";
		}
        
        //Config kingfiles.com
        if (isset($_POST['kingfiles_enable'])) {
            $cf_kingfiles = array(
                $_POST['kingfiles1'],
                $_POST['kingfiles2'],
                $_POST['kingfiles3'],
                "yes"
            );
        } else {
            $cf_kingfiles = array(
                $_POST['kingfiles1'],
                $_POST['kingfiles2'],
                $_POST['kingfiles3'],
                "no"
            );
        }
        
        //Config letitbit.net
        if (isset($_POST['letitbit_enable'])) {
            $cf_letitbit = array(
                $_POST['letitbit1'],
                $_POST['letitbit2'],
                $_POST['letitbit3'],
                "yes"
            );
        } else {
            $cf_letitbit = array(
                $_POST['letitbit1'],
                $_POST['letitbit2'],
                $_POST['letitbit3'],
                "no"
            );
        }
        
        //Config novafile.com
        if (isset($_POST['novafile_enable'])) {
            $cf_novafile = array(
                $_POST['novafile1'],
                $_POST['novafile2'],
                $_POST['novafile3'],
                "yes"
            );
        } else {
            $cf_novafile = array(
                $_POST['novafile1'],
                $_POST['novafile2'],
                $_POST['novafile3'],
                "no"
            );
        }
        
        //Config uploading.com
        if (isset($_POST['uploading_enable'])) {
            $cf_uploading = array(
                $_POST['uploading1'],
                $_POST['uploading2'],
                $_POST['uploading3'],
                "yes"
            );
        } else {
            $cf_uploading = array(
                $_POST['uploading1'],
                $_POST['uploading2'],
                $_POST['uploading3'],
                "no"
            );
        }
        
        //Config turbobit.net
        if (isset($_POST['turbobit_enable'])) {
            $cf_turbobit = array(
                $_POST['turbobit1'],
                $_POST['turbobit2'],
                $_POST['turbobit3'],
                "yes"
            );
        } else {
            $cf_turbobit = array(
                $_POST['turbobit1'],
                $_POST['turbobit2'],
                $_POST['turbobit3'],
                "no"
            );
        }
        
        //Config tusfiles.com
        if (isset($_POST['tusfiles_enable'])) {
            $cf_tusfiles = array(
                $_POST['tusfiles1'],
                $_POST['tusfiles2'],
                $_POST['tusfiles3'],
                "yes"
            );
        } else {
            $cf_tusfiles = array(
                $_POST['tusfiles1'],
                $_POST['tusfiles2'],
                $_POST['tusfiles3'],
                "no"
            );
        }
        
        //Config Uploadrocket.net
        if (isset($_POST['uploadrocket_enable'])) {
            $cf_uploadrocket = array(
                $_POST['uploadrocket1'],
                $_POST['uploadrocket2'],
                $_POST['uploadrocket3'],
                "yes"
            );
        } else {
            $cf_uploadrocket = array(
                $_POST['uploadrocket1'],
                $_POST['uploadrocket2'],
                $_POST['uploadrocket3'],
                "no"
            );
        }
        
        //Config filefactory.com
        if (isset($_POST['filefactory_enable'])) {
            $cf_filefactory = array(
                $_POST['filefactory1'],
                $_POST['filefactory2'],
                $_POST['filefactory3'],
                "yes"
            );
        } else {
            $cf_filefactory = array(
                $_POST['filefactory1'],
                $_POST['filefactory2'],
                $_POST['filefactory3'],
                "no"
            );
        }
        
        //Config filepost.com
        if (isset($_POST['filepost_enable'])) {
            $cf_filepost = array(
                $_POST['filepost1'],
                $_POST['filepost2'],
                $_POST['filepost3'],
                "yes"
            );
        } else {
            $cf_filepost = array(
                $_POST['filepost1'],
                $_POST['filepost2'],
                $_POST['filepost3'],
                "no"
            );
        }
        //Config filejoker.net
        if (isset($_POST['filejoker_enable'])) {
            $cf_filejoker = array(
                $_POST['filejoker1'],
                $_POST['filejoker2'],
                $_POST['filejoker3'],
                "yes"
            );
        } else {
            $cf_filejoker = array(
                $_POST['filejoker1'],
                $_POST['filejoker2'],
                $_POST['filejoker3'],
                "no"
            );
        }
        //Config easybytez.com
        if (isset($_POST['easybytez_enable'])) {
            $cf_easybytez = array(
                $_POST['easybytez1'],
                $_POST['easybytez2'],
                $_POST['easybytez3'],
                "yes"
            );
        } else {
            $cf_easybytez = array(
                $_POST['easybytez1'],
                $_POST['easybytez2'],
                $_POST['easybytez3'],
                "no"
            );
        }
        
        //Config fourshared.com
        if (isset($_POST['fourshared_enable'])) {
            $cf_fourshared = array(
                $_POST['fourshared1'],
                $_POST['fourshared2'],
                $_POST['fourshared3'],
                "yes"
            );
        } else {
            $cf_fourshared = array(
                $_POST['fourshared1'],
                $_POST['fourshared2'],
                $_POST['fourshared3'],
                "no"
            );
        }
        
        //Config depositfiles.com
        if (isset($_POST['depositfiles_enable'])) {
            $cf_depositfiles = array(
                $_POST['depositfiles1'],
                $_POST['depositfiles2'],
                $_POST['depositfiles3'],
                "yes"
            );
        } else {
            $cf_depositfiles = array(
                $_POST['depositfiles1'],
                $_POST['depositfiles2'],
                $_POST['depositfiles3'],
                "no"
            );
        }
        
        //Config terafile.co
        if (isset($_POST['terafile_enable'])) {
            $cf_terafile = array(
                $_POST['terafile1'],
                $_POST['terafile2'],
                $_POST['terafile3'],
                "yes"
            );
        } else {
            $cf_terafile = array(
                $_POST['terafile1'],
                $_POST['terafile2'],
                $_POST['terafile3'],
                "no"
            );
        }
        
        //Config oboom.com
        if (isset($_POST['oboom_enable'])) {
            $cf_oboom = array(
                $_POST['oboom1'],
                $_POST['oboom2'],
                $_POST['oboom3'],
                "yes"
            );
        } else {
            $cf_oboom = array(
                $_POST['oboom1'],
                $_POST['oboom2'],
                $_POST['oboom3'],
                "no"
            );
        }
        
        //Config bitshare.com
        if (isset($_POST['bitshare_enable'])) {
            $cf_bitshare = array(
                $_POST['bitshare1'],
                $_POST['bitshare2'],
                $_POST['bitshare3'],
                "yes"
            );
        } else {
            $cf_bitshare = array(
                $_POST['bitshare1'],
                $_POST['bitshare2'],
                $_POST['bitshare3'],
                "no"
            );
        }
        
        //Config uptobox.com
        if (isset($_POST['uptobox_enable'])) {
            $cf_uptobox = array(
                $_POST['uptobox1'],
                $_POST['uptobox2'],
                $_POST['uptobox3'],
                "yes"
            );
        } else {
            $cf_uptobox = array(
                $_POST['uptobox1'],
                $_POST['uptobox2'],
                $_POST['uptobox3'],
                "no"
            );
        }
        
        //Config extmatrix.com
        if (isset($_POST['extmatrix_enable'])) {
            $cf_extmatrix = array(
                $_POST['extmatrix1'],
                $_POST['extmatrix2'],
                $_POST['extmatrix3'],
                "yes"
            );
        } else {
            $cf_extmatrix = array(
                $_POST['extmatrix1'],
                $_POST['extmatrix2'],
                $_POST['extmatrix3'],
                "no"
            );
        }
        
        //Config mega.co.nz
        if (isset($_POST['megaconz_enable'])) {
            $cf_megaconz = array(
                $_POST['megaconz1'],
                $_POST['megaconz2'],
                $_POST['megaconz3'],
                "yes"
            );
        } else {
            $cf_megaconz = array(
                $$_POST['megaconz1'],
                $_POST['megaconz2'],
                $_POST['megaconz3'],
                "no"
            );
        }
        
        //Config freakshare.com
        if (isset($_POST['freakshare_enable'])) {
            $cf_freakshare = array(
                $_POST['freakshare1'],
                $_POST['freakshare2'],
                $_POST['freakshare3'],
                "yes"
            );
        } else {
            $cf_freakshare = array(
                $_POST['freakshare1'],
                $_POST['freakshare2'],
                $_POST['freakshare3'],
                "no"
            );
        }
        
        //Config firedrive.com
        if (isset($_POST['firedrive_enable'])) {
            $cf_firedrive = array(
                $_POST['firedrive1'],
                $_POST['firedrive2'],
                $_POST['firedrive3'],
                "yes"
            );
        } else {
            $cf_firedrive = array(
                $_POST['firedrive1'],
                $_POST['firedrive2'],
                $_POST['firedrive3'],
                "no"
            );
        }
        
        //Config uploadable.ch
        if (isset($_POST['uploadable_enable'])) {
            $cf_uploadable = array(
                $_POST['uploadable1'],
                $_POST['uploadable2'],
                $_POST['uploadable3'],
                "yes"
            );
        } else {
            $cf_uploadable = array(
                $_POST['uploadable1'],
                $_POST['uploadable2'],
                $_POST['uploadable3'],
                "no"
            );
        }
        
        //Config zippyshare.com
        if (isset($_POST['zippyshare_enable'])) {
            $cf_zippyshare = array(
                $_POST['zippyshare1'],
                $_POST['zippyshare2'],
                $_POST['zippyshare3'],
                "yes"
            );
        } else {
            $cf_zippyshare = array(
                $_POST['zippyshare1'],
                $_POST['zippyshare2'],
                $_POST['zippyshare3'],
                "no"
            );
        }
        
        //Config keeptwoshare.cc
        if (isset($_POST['keeptwoshare_enable'])) {
            $cf_keeptwoshare = array(
                $_POST['keeptwoshare1'],
                $_POST['keeptwoshare2'],
                $_POST['keeptwoshare3'],
                "yes"
            );
        } else {
            $cf_keeptwoshare = array(
                $_POST['keeptwoshare1'],
                $_POST['keeptwoshare2'],
                $_POST['keeptwoshare3'],
                "no"
            );
        }
		
        //Config hugefiles
        if (isset($_POST['hugefiles_enable'])) {
            $cf_hugefiles = array(
                $_POST['hugefiles1'],
                $_POST['hugefiles2'],
                $_POST['hugefiles3'],
                "yes"
            );
        } else {
            $cf_hugefiles = array(
                $_POST['hugefiles1'],
                $_POST['hugefiles2'],
                $_POST['hugefiles3'],
                "no"
            );
        }
        
        //Config megashares.com
        if (isset($_POST['megashares_enable'])) {
            $cf_megashares = array(
                $_POST['megashares1'],
                $_POST['megashares2'],
                $_POST['megashares3'],
                "yes"
            );
        } else {
            $cf_megashares = array(
                $_POST['megashares1'],
                $_POST['megashares2'],
                $_POST['megashares3'],
                "no"
            );
        }
        
        //Config depfile.com
        if (isset($_POST['depfile_enable'])) {
            $cf_depfile = array(
                $_POST['depfile1'],
                $_POST['depfile2'],
                $_POST['depfile3'],
                "yes"
            );
        } else {
            $cf_depfile = array(
                $_POST['depfile1'],
                $_POST['depfile2'],
                $_POST['depfile3'],
                "no"
            );
        }
        
        //Config youtube.com
        if (isset($_POST['youtube_enable'])) {
            $cf_youtube = array(
                $_POST['youtube'],
                $_POST['youtube_pass'],
                "yes"
            );
        } else {
            $cf_youtube = array(
                $_POST['youtube'],
                $_POST['youtube_pass'],
                "no"
            );
        }
        
		//Config datafile
        if (isset($_POST['datafile_enable'])) {
            $cf_datafile = array(
                $_POST['datafile1'],
                $_POST['datafile2'],
                $_POST['datafile3'],
                "yes"
            );
        } else {
            $cf_datafile = array(
                $_POST['datafile1'],
                $_POST['datafile2'],
                $_POST['datafile3'],
                "no"
            );
        }
        
		//Config yunfile
        if (isset($_POST['yunfile_enable'])) {
            $cf_yunfile = array(
                $_POST['yunfile1'],
                $_POST['yunfile2'],
                $_POST['yunfile3'],
                "yes"
            );
        } else {
            $cf_yunfile = array(
                $_POST['yunfile1'],
                $_POST['yunfile2'],
                $_POST['yunfile3'],
                "no"
            );
        }
        
		//Config filesflash
        if (isset($_POST['filesflash_enable'])) {
            $cf_filesflash = array(
                $_POST['filesflash1'],
                $_POST['filesflash2'],
                $_POST['filesflash3'],
                "yes"
            );
        } else {
            $cf_filesflash = array(
                $_POST['filesflash1'],
                $_POST['filesflash2'],
                $_POST['filesflash3'],
                "no"
            );
        }
        
		//Config speedyshare
        if (isset($_POST['speedyshare_enable'])) {
            $cf_speedyshare = array(
                $_POST['speedyshare1'],
                $_POST['speedyshare2'],
                $_POST['speedyshare3'],
                "yes"
            );
        } else {
            $cf_speedyshare = array(
                $_POST['speedyshare1'],
                $_POST['speedyshare2'],
                $_POST['speedyshare3'],
                "no"
            );
        }
        
		//Config scribd
        if (isset($_POST['scribd_enable'])) {
            $cf_scribd = array(
                $_POST['scribd1'],
                $_POST['scribd2'],
                $_POST['scribd3'],
                "yes"
            );
        } else {
            $cf_scribd = array(
                $_POST['scribd1'],
                $_POST['scribd2'],
                $_POST['scribd3'],
                "no"
            );
        }
        
		//Config soundcloud
        if (isset($_POST['soundcloud_enable'])) {
            $cf_soundcloud = array(
                $_POST['soundcloud1'],
                $_POST['soundcloud2'],
                $_POST['soundcloud3'],
                "yes"
            );
        } else {
            $cf_soundcloud = array(
                $_POST['soundcloud1'],
                $_POST['soundcloud2'],
                $_POST['soundcloud3'],
                "no"
            );
        }
        
		//Config sendspace
        if (isset($_POST['sendspace_enable'])) {
            $cf_sendspace = array(
                $_POST['sendspace1'],
                $_POST['sendspace2'],
                $_POST['sendspace3'],
                "yes"
            );
        } else {
            $cf_sendspace = array(
                $_POST['sendspace1'],
                $_POST['sendspace2'],
                $_POST['sendspace3'],
                "no"
            );
        }
        //Config shareonline
        if (isset($_POST['shareonline_enable'])) {
            $cf_shareonline = array(
                $_POST['shareonline1'],
                $_POST['shareonline2'],
                $_POST['shareonline3'],
                "yes"
            );
        } else {
            $cf_shareonline = array(
                $_POST['shareonline1'],
                $_POST['shareonline2'],
                $_POST['shareonline3'],
                "no"
            );
        }
        
        
        
        #############################
        ### Save Info to host.xml ###
        #############################
        
        
        // Fshare.vn
        unset($host->fshare->sv1);
        $host->fshare->addChild('sv1', $cf_fshare[0]);
        unset($host->fshare->sv2);
        $host->fshare->addChild('sv2', $cf_fshare[1]);
        unset($host->fshare->sv3);
        $host->fshare->addChild('sv3', $cf_fshare[2]);
        unset($host->fshare->sv4);
        $host->fshare->addChild('sv4', $cf_fshare[3]);
        unset($host->fshare->sv5);
        $host->fshare->addChild('sv5', $cf_fshare[4]);
        unset($host->fshare->sv6);
        $host->fshare->addChild('sv6', $cf_fshare[5]);
        unset($host->fshare->sv7);
        $host->fshare->addChild('sv7', $cf_fshare[6]);
        unset($host->fshare->sv8);
        $host->fshare->addChild('sv8', $cf_fshare[7]);
        unset($host->fshare->work);
        $host->fshare->addChild('work', $cf_fshare[8]);
        
        // subyshare
        unset($host->subyshare->sv1);
        $host->subyshare->addChild('sv1', $cf_subyshare[0]);
        unset($host->subyshare->sv2);
        $host->subyshare->addChild('sv2', $cf_subyshare[1]);
        unset($host->subyshare->sv3);
        $host->subyshare->addChild('sv3', $cf_subyshare[2]);
        unset($host->subyshare->work);
        $host->subyshare->addChild('work', $cf_subyshare[3]);
        
        // alfafile
        unset($host->alfafile->sv1);
        $host->alfafile->addChild('sv1', $cf_alfafile[0]);
        unset($host->alfafile->sv2);
        $host->alfafile->addChild('sv2', $cf_alfafile[1]);
        unset($host->alfafile->sv3);
        $host->alfafile->addChild('sv3', $cf_alfafile[2]);
        unset($host->alfafile->work);
        $host->alfafile->addChild('work', $cf_alfafile[3]);
        
        // nowdownload
        unset($host->nowdownload->sv1);
        $host->nowdownload->addChild('sv1', $cf_nowdownload[0]);
        unset($host->nowdownload->sv2);
        $host->nowdownload->addChild('sv2', $cf_nowdownload[1]);
        unset($host->nowdownload->sv3);
        $host->nowdownload->addChild('sv3', $cf_nowdownload[2]);
        unset($host->nowdownload->work);
        $host->nowdownload->addChild('work', $cf_nowdownload[3]);
        
        // nitroflare
        unset($host->nitroflare->sv1);
        $host->nitroflare->addChild('sv1', $cf_nitroflare[0]);
        unset($host->nitroflare->sv2);
        $host->nitroflare->addChild('sv2', $cf_nitroflare[1]);
        unset($host->nitroflare->sv3);
        $host->nitroflare->addChild('sv3', $cf_nitroflare[2]);
        unset($host->nitroflare->sv4);
        $host->nitroflare->addChild('sv4', $cf_nitroflare[3]);
        unset($host->nitroflare->sv5);
        $host->nitroflare->addChild('sv5', $cf_nitroflare[4]);
        unset($host->nitroflare->work);
        $host->nitroflare->addChild('work', $cf_nitroflare[5]);
        
        // 4share.vn
        unset($host->foursharevn->sv1);
        $host->foursharevn->addChild('sv1', $cf_foursharevn[0]);
        unset($host->foursharevn->sv2);
        $host->foursharevn->addChild('sv2', $cf_foursharevn[1]);
        unset($host->foursharevn->sv3);
        $host->foursharevn->addChild('sv3', $cf_foursharevn[2]);
        unset($host->foursharevn->sv4);
        $host->foursharevn->addChild('sv4', $cf_foursharevn[3]);
        unset($host->foursharevn->sv5);
        $host->foursharevn->addChild('sv5', $cf_foursharevn[4]);
        unset($host->foursharevn->sv6);
        $host->foursharevn->addChild('sv6', $cf_foursharevn[5]);
        unset($host->foursharevn->sv7);
        $host->foursharevn->addChild('sv7', $cf_foursharevn[6]);
        unset($host->foursharevn->sv8);
        $host->foursharevn->addChild('sv8', $cf_foursharevn[7]);
        unset($host->foursharevn->work);
        $host->foursharevn->addChild('work', $cf_foursharevn[8]);
        
        // secureupload
        unset($host->secureupload->sv1);
        $host->secureupload->addChild('sv1', $cf_secureupload[0]);
        unset($host->secureupload->sv2);
        $host->secureupload->addChild('sv2', $cf_secureupload[1]);
        unset($host->secureupload->sv3);
        $host->secureupload->addChild('sv3', $cf_secureupload[2]);
        unset($host->secureupload->sv4);
        $host->secureupload->addChild('sv4', $cf_secureupload[3]);
        unset($host->secureupload->sv5);
        $host->secureupload->addChild('sv5', $cf_secureupload[4]);
        unset($host->secureupload->work);
        $host->secureupload->addChild('work', $cf_secureupload[5]);
        
		// salefilesnet
        unset($host->salefiles->sv1);
        $host->salefiles->addChild('sv1', $cf_salefiles[0]);
        unset($host->salefiles->sv2);
        $host->salefiles->addChild('sv2', $cf_salefiles[1]);
        unset($host->salefiles->sv3);
        $host->salefiles->addChild('sv3', $cf_salefiles[2]);
        unset($host->salefiles->sv4);
        $host->salefiles->addChild('sv4', $cf_salefiles[3]);
        unset($host->salefiles->sv5);
        $host->salefiles->addChild('sv5', $cf_salefiles[4]);
        unset($host->salefiles->work);
        $host->salefiles->addChild('work', $cf_salefiles[5]);
        
		// hitfilenet
        unset($host->hitfile->sv1);
        $host->hitfile->addChild('sv1', $cf_hitfile[0]);
        unset($host->hitfile->sv2);
        $host->hitfile->addChild('sv2', $cf_hitfile[1]);
        unset($host->hitfile->sv3);
        $host->hitfile->addChild('sv3', $cf_hitfile[2]);
        unset($host->hitfile->sv4);
        $host->hitfile->addChild('sv4', $cf_hitfile[3]);
        unset($host->hitfile->sv5);
        $host->hitfile->addChild('sv5', $cf_hitfile[4]);
        unset($host->hitfile->work);
        $host->hitfile->addChild('work', $cf_hitfile[5]);
        
		// rarefilenet
        unset($host->rarefile->sv1);
        $host->rarefile->addChild('sv1', $cf_rarefile[0]);
        unset($host->rarefile->sv2);
        $host->rarefile->addChild('sv2', $cf_rarefile[1]);
        unset($host->rarefile->sv3);
        $host->rarefile->addChild('sv3', $cf_rarefile[2]);
		unset($host->rarefile->work);
        $host->rarefile->addChild('work', $cf_rarefile[3]); 
        
		// filesmonsternet
        unset($host->filesmonster->sv1);
        $host->filesmonster->addChild('sv1', $cf_filesmonster[0]);
        unset($host->filesmonster->sv2);
        $host->filesmonster->addChild('sv2', $cf_filesmonster[1]);
        unset($host->filesmonster->sv3);
        $host->filesmonster->addChild('sv3', $cf_filesmonster[2]);
		unset($host->filesmonster->work);
        $host->filesmonster->addChild('work', $cf_filesmonster[3]); 
        
        // Share.vnn.vn
        unset($host->sharevnn->url);
        $host->sharevnn->addChild('url', $cf_sharevnn[0]);
        unset($host->sharevnn->pass);
        $host->sharevnn->addChild('pass', $cf_sharevnn[1]);
        unset($host->sharevnn->work);
        $host->sharevnn->addChild('work', $cf_sharevnn[2]);
        
        // Tenlua.vn
        unset($host->tenluavn->url);
        $host->tenluavn->addChild('url', $cf_tenluavn[0]);
        unset($host->tenluavn->pass);
        $host->tenluavn->addChild('pass', $cf_tenluavn[1]);
        unset($host->tenluavn->work);
        $host->tenluavn->addChild('work', $cf_tenluavn[2]);
        
        // Upfile.vn
        unset($host->upfilevn->url);
        $host->upfilevn->addChild('url', $cf_upfilevn[0]);
        unset($host->upfilevn->pass);
        $host->upfilevn->addChild('pass', $cf_upfilevn[1]);
        unset($host->upfilevn->work);
        $host->upfilevn->addChild('work', $cf_upfilevn[2]);
        
        // Mediafire.com
        unset($host->mediafire->sv1);
        $host->mediafire->addChild('sv1', $cf_mediafire[0]);
        unset($host->mediafire->sv2);
        $host->mediafire->addChild('sv2', $cf_mediafire[1]);
        unset($host->mediafire->sv3);
        $host->mediafire->addChild('sv3', $cf_mediafire[2]);
        unset($host->mediafire->work);
        $host->mediafire->addChild('work', $cf_mediafire[3]);
                
        // littlebyte.net
        unset($host->littlebyte->sv1);
        $host->littlebyte->addChild('sv1', $cf_littlebyte[0]);
        unset($host->littlebyte->sv2);
        $host->littlebyte->addChild('sv2', $cf_littlebyte[1]);
        unset($host->littlebyte->sv3);
        $host->littlebyte->addChild('sv3', $cf_littlebyte[2]);
        unset($host->littlebyte->work);
        $host->littlebyte->addChild('work', $cf_littlebyte[3]);
        
        // Netload.in
        unset($host->netload->sv1);
        $host->netload->addChild('sv1', $cf_netload[0]);
        unset($host->netload->sv2);
        $host->netload->addChild('sv2', $cf_netload[1]);
        unset($host->netload->sv3);
        $host->netload->addChild('sv3', $cf_netload[2]);
        unset($host->netload->work);
        $host->netload->addChild('work', $cf_netload[3]);
         
        // uplea.com
        unset($host->uplea->sv1);
        $host->uplea->addChild('sv1', $cf_uplea[0]);
        unset($host->uplea->sv2);
        $host->uplea->addChild('sv2', $cf_uplea[1]);
        unset($host->uplea->sv3);
        $host->uplea->addChild('sv3', $cf_uplea[2]);
        unset($host->uplea->work);
        $host->uplea->addChild('work', $cf_uplea[3]);
                
        // 1fichier.com
        unset($host->onefichier->sv1);
        $host->onefichier->addChild('sv1', $cf_onefichier[0]);
        unset($host->onefichier->sv2);
        $host->onefichier->addChild('sv2', $cf_onefichier[1]);
        unset($host->onefichier->sv3);
        $host->onefichier->addChild('sv3', $cf_onefichier[2]);
        unset($host->onefichier->work);
        $host->onefichier->addChild('work', $cf_onefichier[3]);
             
        // 1fichier.com
        unset($host->vipfile->sv1);
        $host->vipfile->addChild('sv1', $cf_vipfile[0]);
        unset($host->vipfile->sv2);
        $host->vipfile->addChild('sv2', $cf_vipfile[1]);
        unset($host->vipfile->sv3);
        $host->vipfile->addChild('sv3', $cf_vipfile[2]);
        unset($host->vipfile->work);
        $host->vipfile->addChild('work', $cf_vipfile[3]);
        
        // Uploaded.net
        unset($host->uploaded->sv1);
        $host->uploaded->addChild('sv1', $cf_uploaded[0]);
        unset($host->uploaded->sv2);
        $host->uploaded->addChild('sv2', $cf_uploaded[1]);
        unset($host->uploaded->sv3);
        $host->uploaded->addChild('sv3', $cf_uploaded[2]);
        unset($host->uploaded->sv4);
        $host->uploaded->addChild('sv4', $cf_uploaded[3]);
        unset($host->uploaded->sv5);
        $host->uploaded->addChild('sv5', $cf_uploaded[4]);
        unset($host->uploaded->sv6);
        $host->uploaded->addChild('sv6', $cf_uploaded[5]);
        unset($host->uploaded->work);
        $host->uploaded->addChild('work', $cf_uploaded[6]);
        
        // Rapidgator.com
        unset($host->rapidgator->sv1);
        $host->rapidgator->addChild('sv1', $cf_rapidgator[0]);
        unset($host->rapidgator->sv2);
        $host->rapidgator->addChild('sv2', $cf_rapidgator[1]);
        unset($host->rapidgator->sv3);
        $host->rapidgator->addChild('sv3', $cf_rapidgator[2]);
        unset($host->rapidgator->work);
        $host->rapidgator->addChild('work', $cf_rapidgator[3]);
		
		// Swich RG
        unset($host->rapidgator->swich);
        $host->rapidgator->addChild('swich', $cf_swich);
		
		
        
        // kingfiles.com
        unset($host->kingfiles->sv1);
        $host->kingfiles->addChild('sv1', $cf_kingfiles[0]);
        unset($host->kingfiles->sv2);
        $host->kingfiles->addChild('sv2', $cf_kingfiles[1]);
        unset($host->kingfiles->sv3);
        $host->kingfiles->addChild('sv3', $cf_kingfiles[2]);
        unset($host->kingfiles->work);
        $host->kingfiles->addChild('work', $cf_kingfiles[3]);
        
        // Letitbit.net
        unset($host->letitbit->sv1);
        $host->letitbit->addChild('sv1', $cf_letitbit[0]);
        unset($host->letitbit->sv2);
        $host->letitbit->addChild('sv2', $cf_letitbit[1]);
        unset($host->letitbit->sv3);
        $host->letitbit->addChild('sv3', $cf_letitbit[2]);
        unset($host->letitbit->work);
        $host->letitbit->addChild('work', $cf_letitbit[3]);
        
        // Novafile.com
        unset($host->novafile->sv1);
        $host->novafile->addChild('sv1', $cf_novafile[0]);
        unset($host->novafile->sv2);
        $host->novafile->addChild('sv2', $cf_novafile[1]);
        unset($host->novafile->sv3);
        $host->novafile->addChild('sv3', $cf_novafile[2]);
        unset($host->novafile->work);
        $host->novafile->addChild('work', $cf_novafile[3]);
        
        // uploading.com
        unset($host->uploading->sv1);
        $host->uploading->addChild('sv1', $cf_uploading[0]);
        unset($host->uploading->sv2);
        $host->uploading->addChild('sv2', $cf_uploading[1]);
        unset($host->uploading->sv3);
        $host->uploading->addChild('sv3', $cf_uploading[2]);
        unset($host->uploading->work);
        $host->uploading->addChild('work', $cf_uploading[3]);
        
        // Turbobit.net
        unset($host->turbobit->sv1);
        $host->turbobit->addChild('sv1', $cf_turbobit[0]);
        unset($host->turbobit->sv2);
        $host->turbobit->addChild('sv2', $cf_turbobit[1]);
        unset($host->turbobit->sv3);
        $host->turbobit->addChild('sv3', $cf_turbobit[2]);
        unset($host->turbobit->work);
        $host->turbobit->addChild('work', $cf_turbobit[3]);
        
        // tusfiles.com
        unset($host->tusfiles->sv1);
        $host->tusfiles->addChild('sv1', $cf_tusfiles[0]);
        unset($host->tusfiles->sv2);
        $host->tusfiles->addChild('sv2', $cf_tusfiles[1]);
        unset($host->tusfiles->sv3);
        $host->tusfiles->addChild('sv3', $cf_tusfiles[2]);
        unset($host->tusfiles->work);
        $host->tusfiles->addChild('work', $cf_tusfiles[3]);
        
		
        // uploadrocket.net
        unset($host->uploadrocket->sv1);
        $host->uploadrocket->addChild('sv1', $cf_uploadrocket[0]);
        unset($host->uploadrocket->sv2);
        $host->uploadrocket->addChild('sv2', $cf_uploadrocket[1]);
        unset($host->uploadrocket->sv3);
        $host->uploadrocket->addChild('sv3', $cf_uploadrocket[2]);
        unset($host->uploadrocket->work);
        $host->uploadrocket->addChild('work', $cf_uploadrocket[3]);
        
		
        // Filefactory.com
        unset($host->filefactory->sv1);
        $host->filefactory->addChild('sv1', $cf_filefactory[0]);
        unset($host->filefactory->sv2);
        $host->filefactory->addChild('sv2', $cf_filefactory[1]);
        unset($host->filefactory->sv3);
        $host->filefactory->addChild('sv3', $cf_filefactory[2]);
        unset($host->filefactory->work);
        $host->filefactory->addChild('work', $cf_filefactory[3]);
        
        // Filepost.com
        unset($host->filepost->sv1);
        $host->filepost->addChild('sv1', $cf_filepost[0]);
        unset($host->filepost->sv2);
        $host->filepost->addChild('sv2', $cf_filepost[1]);
        unset($host->filepost->sv3);
        $host->filepost->addChild('sv3', $cf_filepost[2]);
        unset($host->filepost->work);
        $host->filepost->addChild('work', $cf_filepost[3]);
         // filejoker.net
        unset($host->filejoker->sv1);
        $host->filejoker->addChild('sv1', $cf_filejoker[0]);
        unset($host->filejoker->sv2);
        $host->filejoker->addChild('sv2', $cf_filejoker[1]);
        unset($host->filejoker->sv3);
        $host->filejoker->addChild('sv3', $cf_filejoker[2]);
        unset($host->filejoker->work);
        $host->filejoker->addChild('work', $cf_filejoker[3]);
        
        // easybytez.com
        unset($host->easybytez->sv1);
        $host->easybytez->addChild('sv1', $cf_easybytez[0]);
        unset($host->easybytez->sv2);
        $host->easybytez->addChild('sv2', $cf_easybytez[1]);
        unset($host->easybytez->sv3);
        $host->easybytez->addChild('sv3', $cf_easybytez[2]);
        unset($host->easybytez->work);
        $host->easybytez->addChild('work', $cf_easybytez[3]);
        
        // Fourshared.com
        unset($host->fourshared->sv1);
        $host->fourshared->addChild('sv1', $cf_fourshared[0]);
        unset($host->fourshared->sv2);
        $host->fourshared->addChild('sv2', $cf_fourshared[1]);
        unset($host->fourshared->sv3);
        $host->fourshared->addChild('sv3', $cf_fourshared[2]);
        unset($host->fourshared->work);
        $host->fourshared->addChild('work', $cf_fourshared[3]);
        
        // Depositfiles.com
        unset($host->depositfiles->sv1);
        $host->depositfiles->addChild('sv1', $cf_depositfiles[0]);
        unset($host->depositfiles->sv2);
        $host->depositfiles->addChild('sv2', $cf_depositfiles[1]);
        unset($host->depositfiles->sv3);
        $host->depositfiles->addChild('sv3', $cf_depositfiles[2]);
        unset($host->depositfiles->work);
        $host->depositfiles->addChild('work', $cf_depositfiles[3]);
        
        // Terafile.co
        unset($host->terafile->sv1);
        $host->terafile->addChild('sv1', $cf_terafile[0]);
        unset($host->terafile->sv2);
        $host->terafile->addChild('sv2', $cf_terafile[1]);
        unset($host->terafile->sv3);
        $host->terafile->addChild('sv3', $cf_terafile[2]);
        unset($host->terafile->work);
        $host->terafile->addChild('work', $cf_terafile[3]);
        
        // Oboom.com
        unset($host->oboom->sv1);
        $host->oboom->addChild('sv1', $cf_oboom[0]);
        unset($host->oboom->sv2);
        $host->oboom->addChild('sv2', $cf_oboom[1]);
        unset($host->oboom->sv3);
        $host->oboom->addChild('sv3', $cf_oboom[2]);
        unset($host->oboom->work);
        $host->oboom->addChild('work', $cf_oboom[3]);
        
        // Bitshare.com
        unset($host->bitshare->sv1);
        $host->bitshare->addChild('sv1', $cf_bitshare[0]);
        unset($host->bitshare->sv2);
        $host->bitshare->addChild('sv2', $cf_bitshare[1]);
        unset($host->bitshare->sv3);
        $host->bitshare->addChild('sv3', $cf_bitshare[2]);
        unset($host->bitshare->work);
        $host->bitshare->addChild('work', $cf_bitshare[3]);
        
        // Uptobox.com
        unset($host->uptobox->sv1);
        $host->uptobox->addChild('sv1', $cf_uptobox[0]);
        unset($host->uptobox->sv2);
        $host->uptobox->addChild('sv2', $cf_uptobox[1]);
        unset($host->uptobox->sv3);
        $host->uptobox->addChild('sv3', $cf_uptobox[2]);
        unset($host->uptobox->work);
        $host->uptobox->addChild('work', $cf_uptobox[3]);
        
        // Extmatrix.com
        unset($host->extmatrix->sv1);
        $host->extmatrix->addChild('sv1', $cf_extmatrix[0]);
        unset($host->extmatrix->sv2);
        $host->extmatrix->addChild('sv2', $cf_extmatrix[1]);
        unset($host->extmatrix->sv3);
        $host->extmatrix->addChild('sv3', $cf_extmatrix[2]);
        unset($host->extmatrix->work);
        $host->extmatrix->addChild('work', $cf_extmatrix[3]);
        
        // Mega.co.nz
        unset($host->megaconz->sv1);
        $host->megaconz->addChild('sv1', $cf_megaconz[0]);
        unset($host->megaconz->sv2);
        $host->megaconz->addChild('sv2', $cf_megaconz[1]);
        unset($host->megaconz->sv3);
        $host->megaconz->addChild('sv3', $cf_megaconz[2]);
        unset($host->megaconz->work);
        $host->megaconz->addChild('work', $cf_megaconz[3]);
        
        // Freakshare.com
        unset($host->freakshare->sv1);
        $host->freakshare->addChild('sv1', $cf_freakshare[0]);
        unset($host->freakshare->sv2);
        $host->freakshare->addChild('sv2', $cf_freakshare[1]);
        unset($host->freakshare->sv3);
        $host->freakshare->addChild('sv3', $cf_freakshare[2]);
        unset($host->freakshare->work);
        $host->freakshare->addChild('work', $cf_freakshare[3]);
        
        // Firedrive.com
        unset($host->firedrive->sv1);
        $host->firedrive->addChild('sv1', $cf_firedrive[0]);
        unset($host->firedrive->sv2);
        $host->firedrive->addChild('sv2', $cf_firedrive[1]);
        unset($host->firedrive->sv3);
        $host->firedrive->addChild('sv3', $cf_firedrive[2]);
        unset($host->firedrive->work);
        $host->firedrive->addChild('work', $cf_firedrive[3]);
        
        // Uploadable.ch
        unset($host->uploadable->sv1);
        $host->uploadable->addChild('sv1', $cf_uploadable[0]);
        unset($host->uploadable->sv2);
        $host->uploadable->addChild('sv2', $cf_uploadable[1]);
        unset($host->uploadable->sv3);
        $host->uploadable->addChild('sv3', $cf_uploadable[2]);
        unset($host->uploadable->work);
        $host->uploadable->addChild('work', $cf_uploadable[3]);
        
        // Zippyshare.com
        unset($host->zippyshare->sv1);
        $host->zippyshare->addChild('sv1', $cf_zippyshare[0]);
        unset($host->zippyshare->sv2);
        $host->zippyshare->addChild('sv2', $cf_zippyshare[1]);
        unset($host->zippyshare->sv3);
        $host->zippyshare->addChild('sv3', $cf_zippyshare[2]);
        unset($host->zippyshare->work);
        $host->zippyshare->addChild('work', $cf_zippyshare[3]);
        
        // keeptwoshare.cc
        unset($host->keeptwoshare->sv1);
        $host->keeptwoshare->addChild('sv1', $cf_keeptwoshare[0]);
        unset($host->keeptwoshare->sv2);
        $host->keeptwoshare->addChild('sv2', $cf_keeptwoshare[1]);
        unset($host->keeptwoshare->sv3);
        $host->keeptwoshare->addChild('sv3', $cf_keeptwoshare[2]);
        unset($host->keeptwoshare->work);
        $host->keeptwoshare->addChild('work', $cf_keeptwoshare[3]);
        
        // hugefiles
        unset($host->hugefiles->sv1);
        $host->hugefiles->addChild('sv1', $cf_hugefiles[0]);
        unset($host->hugefiles->sv2);
        $host->hugefiles->addChild('sv2', $cf_hugefiles[1]);
        unset($host->hugefiles->sv3);
        $host->hugefiles->addChild('sv3', $cf_hugefiles[2]);
        unset($host->hugefiles->work);
        $host->hugefiles->addChild('work', $cf_hugefiles[3]);
        
        // Megashares.com
        unset($host->megashares->sv1);
        $host->megashares->addChild('sv1', $cf_megashares[0]);
        unset($host->megashares->sv2);
        $host->megashares->addChild('sv2', $cf_megashares[1]);
        unset($host->megashares->sv3);
        $host->megashares->addChild('sv3', $cf_megashares[2]);
        unset($host->megashares->work);
        $host->megashares->addChild('work', $cf_megashares[3]);
         
        // depfile.com
        unset($host->depfile->sv1);
        $host->depfile->addChild('sv1', $cf_depfile[0]);
        unset($host->depfile->sv2);
        $host->depfile->addChild('sv2', $cf_depfile[1]);
        unset($host->depfile->sv3);
        $host->depfile->addChild('sv3', $cf_depfile[2]);
        unset($host->depfile->work);
        $host->depfile->addChild('work', $cf_depfile[3]);
                
        // datafile
        unset($host->datafile->sv1);
        $host->datafile->addChild('sv1', $cf_datafile[0]);
        unset($host->datafile->sv2);
        $host->datafile->addChild('sv2', $cf_datafile[1]);
        unset($host->datafile->sv3);
        $host->datafile->addChild('sv3', $cf_datafile[2]);
        unset($host->datafile->work);
        $host->datafile->addChild('work', $cf_datafile[3]);
               
        // yunfile
        unset($host->yunfile->sv1);
        $host->yunfile->addChild('sv1', $cf_yunfile[0]);
        unset($host->yunfile->sv2);
        $host->yunfile->addChild('sv2', $cf_yunfile[1]);
        unset($host->yunfile->sv3);
        $host->yunfile->addChild('sv3', $cf_yunfile[2]);
        unset($host->yunfile->work);
        $host->yunfile->addChild('work', $cf_yunfile[3]);
                
        // speedyshare
        unset($host->speedyshare->sv1);
        $host->speedyshare->addChild('sv1', $cf_speedyshare[0]);
        unset($host->speedyshare->sv2);
        $host->speedyshare->addChild('sv2', $cf_speedyshare[1]);
        unset($host->speedyshare->sv3);
        $host->speedyshare->addChild('sv3', $cf_speedyshare[2]);
        unset($host->speedyshare->work);
        $host->speedyshare->addChild('work', $cf_speedyshare[3]);
                
        // filesflash
        unset($host->filesflash->sv1);
        $host->filesflash->addChild('sv1', $cf_filesflash[0]);
        unset($host->filesflash->sv2);
        $host->filesflash->addChild('sv2', $cf_filesflash[1]);
        unset($host->filesflash->sv3);
        $host->filesflash->addChild('sv3', $cf_filesflash[2]);
        unset($host->filesflash->work);
        $host->filesflash->addChild('work', $cf_filesflash[3]);
                
        // filesflash
        unset($host->filesflash->sv1);
        $host->filesflash->addChild('sv1', $cf_filesflash[0]);
        unset($host->filesflash->sv2);
        $host->filesflash->addChild('sv2', $cf_filesflash[1]);
        unset($host->filesflash->sv3);
        $host->filesflash->addChild('sv3', $cf_filesflash[2]);
        unset($host->filesflash->work);
        $host->filesflash->addChild('work', $cf_filesflash[3]);
                
        // scribd
        unset($host->scribd->sv1);
        $host->scribd->addChild('sv1', $cf_scribd[0]);
        unset($host->scribd->sv2);
        $host->scribd->addChild('sv2', $cf_scribd[1]);
        unset($host->scribd->sv3);
        $host->scribd->addChild('sv3', $cf_scribd[2]);
        unset($host->scribd->work);
        $host->scribd->addChild('work', $cf_scribd[3]);
               
        // soundcloud
        unset($host->soundcloud->sv1);
        $host->soundcloud->addChild('sv1', $cf_soundcloud[0]);
        unset($host->soundcloud->sv2);
        $host->soundcloud->addChild('sv2', $cf_soundcloud[1]);
        unset($host->soundcloud->sv3);
        $host->soundcloud->addChild('sv3', $cf_soundcloud[2]);
        unset($host->soundcloud->work);
        $host->soundcloud->addChild('work', $cf_soundcloud[3]);
                
        // sendspace
        unset($host->sendspace->sv1);
        $host->sendspace->addChild('sv1', $cf_sendspace[0]);
        unset($host->sendspace->sv2);
        $host->sendspace->addChild('sv2', $cf_sendspace[1]);
        unset($host->sendspace->sv3);
        $host->sendspace->addChild('sv3', $cf_sendspace[2]);
        unset($host->sendspace->work);
        $host->sendspace->addChild('work', $cf_sendspace[3]);
                
        // shareonline
        unset($host->shareonline->sv1);
        $host->shareonline->addChild('sv1', $cf_shareonline[0]);
        unset($host->shareonline->sv2);
        $host->shareonline->addChild('sv2', $cf_shareonline[1]);
        unset($host->shareonline->sv3);
        $host->shareonline->addChild('sv3', $cf_shareonline[2]);
        unset($host->shareonline->work);
        $host->shareonline->addChild('work', $cf_shareonline[3]);
        
        // Youtube.com
        unset($host->youtube->url);
        $host->youtube->addChild('url', $cf_youtube[0]);
        unset($host->youtube->pass);
        $host->youtube->addChild('pass', $cf_youtube[1]);
        unset($host->youtube->work);
        $host->youtube->addChild('work', $cf_youtube[2]);
        
        // Save XMl
        $host->asXML($config['hostlist']);
        include('config.php'); //Reload
    }
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Config Bot FREE | VNZ-Leech</title>

	<link rel="stylesheet" href="style.css" />
</head>

<body>
<script language="Javascript" src="decor.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>

<div class="server" id="server">
 <center><b><font size="6" color="brown">VNZ-LEECH GROUP Manager BOT</b></font>&nbsp;&nbsp;&nbsp;<span align="right"><a href="logout.php">LOG OUT</a></span></center>
<br/>
<br/>
<form method="post" name="hostget" action="">
<center>
	<tr valign="top"><td width="100%" bgcolor="#229944" valign="center">
		Cbox SV &nbsp;&nbsp; <textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 10%; height: 20px' id="sv" name="cbox_sv"><?php
    echo $cboxsv;
?></textarea>
		Cbox ID &nbsp;&nbsp; <textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 10%; height: 20px' id="id" name="cbox_id"><?php
    echo $cboxid;
?></textarea>
		Cbox TAG &nbsp;&nbsp; <textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 10%; height: 20px' id="tag" name="cbox_tag"><?php
    echo $cboxtag;
?></textarea>
	</td></tr><br/>
	<td height=5></td><br>
		Host Check &nbsp;&nbsp;&nbsp; <textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 40%; height: 22px' id="check" name="check_link"><?php
    echo $hostcheck;
?></textarea>
</center><br/>

<table>
	<tr>
		<td width=30></td><td width=70>Nick Bot</td><td width=200><textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 50%; height: 20px' id="nick" name="nick_bot"><?php
    echo $cbox_bot;
?></textarea></td>
		<td width=30></td><td width=100></td><td width=300>Option Cbox &nbsp;&nbsp; <select name="gender" id="hostget">
			<option value="vnzleech" select>VNZ-Leech</option>
			<option value="other">Other</option>
		</select></td>
	</tr>
	<tr>
		<td width=30></td><td width=70>Password</td><td width=200><textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 50%; height: 20px' id="CboxPass" name="bot_password"></textarea></td>
		<td width=30></td><td width=100>Cbox Info</td><td width=350><textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 35px' id="text" name="cbox">Bot loging Cbox <?php
    echo $cbox_url;
?></textarea></td>
<td width=30></td><td width=350>
<?php
 printf("<br/>Server load: <font color=red> %s </font> %s <br/><br/><font color=red> %s </font>", get_load(),"%",date('d/m/Y, H:i:s')); 
 ?>
</td><td width=30></td><td width=350>
Total links: <?php echo file_get_contents("log/total.txt"); ?>
</td><br>
	</tr>
	<tr><td width=30></td><td width=100><font color=red>Bot On / Off</font></td><td width=350>
			<?php
    if (strcmp($info->work, "false") == 0)
        echo '<input type="checkbox" name="bot_work" value="on">off</input>';
    else
        echo '<input type="checkbox" name="bot_work" value="on" checked="yes">on</input>';
?>
		</td>
	<td width=30></td><td width=100><font color=red>Bot chat On / Off</font></td><td width=350>
			<?php
    if (strcmp($info->chat, "false") == 0)
        echo '<input type="checkbox" name="bot_chat" value="on">off</input>';
    else
        echo '<input type="checkbox" name="bot_chat" value="on" checked="yes">on</input>';
?>
		</td><!--/tr><tr-->
		
	<td width=30></td><td width=100><font color=red>Bot talk On / Off</font></td><td width=350>
			<?php
    if (strcmp($info->talk, "false") == 0)
        echo '<input type="checkbox" name="bot_talk" value="on">off</input>';
    else
        echo '<input type="checkbox" name="bot_talk" value="on" checked="yes">on</input>';
?>
		</td>
	<td width=30></td><td width=100><font color=red>Danh Ngôn On / Off</font></td><td width=350>
			<?php
    if (strcmp($info->notify, "false") == 0)
        echo '<input type="checkbox" name="bot_notify" value="on">off</input>';
    else
        echo '<input type="checkbox" name="bot_notify" value="on" checked="yes">on</input>';
?>
		</td></tr>
		
</table><br/>


	<table>
		<tr><td width=30></td><td width=100>Fshare.vn</td><td width=350>
			<?php
    if (strcmp($hostlist->fshare->work, "no") == 0)
        echo '<input type="checkbox" name="fshare_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="fshare_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='fshare1'><?php
    echo $fsharevn[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='fshare2'><?php
    echo $fsharevn[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='fshare3'><?php
    echo $fsharevn[2];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='fshare4'><?php
    echo $fsharevn[3];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='fshare5'><?php
    echo $fsharevn[4];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='fshare6'><?php
    echo $fsharevn[5];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='fshare7'><?php
    echo $fsharevn[6];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='fshare8'><?php
    echo $fsharevn[7];
?></textarea></td>

		<td width=30></td><td width=100>Up.4share.vn</td><td width=350>
			<?php
    if (strcmp($hostlist->foursharevn->work, "no") == 0)
        echo '<input type="checkbox" name="foursharevn_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="foursharevn_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='foursharevn1'><?php
    echo $fourshare[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='foursharevn2'><?php
    echo $fourshare[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='foursharevn3'><?php
    echo $fourshare[2];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='foursharevn4'><?php
    echo $fourshare[3];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='foursharevn5'><?php
    echo $fourshare[4];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='foursharevn6'><?php
    echo $fourshare[5];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='foursharevn7'><?php
    echo $fourshare[6];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='foursharevn8'><?php
    echo $fourshare[7];
?></textarea></td>

		<td width=30></td><td width=100>Subyshare.com</td><td width=350>
			<?php
    if (strcmp($hostlist->subyshare->work, "no") == 0)
        echo '<input type="checkbox" name="subyshare_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="subyshare_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='subyshare1'><?php
    echo $subysharecom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='subyshare2'><?php
    echo $subysharecom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='subyshare3'><?php
    echo $subysharecom[2];
?></textarea></td></tr>


		<tr><td width=30></td><td width=100>Nitroflare.Com</td><td width=350>
			<?php
    if (strcmp($hostlist->nitroflare->work, "no") == 0)
        echo '<input type="checkbox" name="nitroflare_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="nitroflare_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='nitroflare1'><?php
    echo $nitroflare[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='nitroflare2'><?php
    echo $nitroflare[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='nitroflare3'><?php
    echo $nitroflare[2];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='nitroflare4'><?php
    echo $nitroflare[3];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='nitroflare5'><?php
    echo $nitroflare[4];
?></textarea></td>

		<td width=30></td><td width=100>Secureupload.eu</td><td width=350>
			<?php
    if (strcmp($hostlist->secureupload->work, "no") == 0)
        echo '<input type="checkbox" name="secureupload_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="secureupload_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='secureupload1'><?php
    echo $secureupload[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='secureupload2'><?php
    echo $secureupload[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='secureupload3'><?php
    echo $secureupload[2];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='secureupload4'><?php
    echo $secureupload[3];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='secureupload5'><?php
    echo $secureupload[4];
?></textarea></td>
		<td width=30></td><td width=100>Nowdownload.ch</td><td width=350>
			<?php
    if (strcmp($hostlist->nowdownload->work, "no") == 0)
        echo '<input type="checkbox" name="nowdownload_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="nowdownload_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='nowdownload1'><?php
    echo $nowdownloadch[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='nowdownload2'><?php
    echo $nowdownloadch[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='nowdownload3'><?php
    echo $nowdownloadch[2];
?></textarea>
</tr>

		<tr><td width=30></td><td width=100>Salefiles.com</td><td width=350>
			<?php
    if (strcmp($hostlist->salefiles->work, "no") == 0)
        echo '<input type="checkbox" name="salefiles_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="salefiles_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='salefiles1'><?php
    echo $salefilescom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='salefiles2'><?php
    echo $salefilescom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='salefiles3'><?php
    echo $salefilescom[2];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='salefiles4'><?php
    echo $salefilescom[3];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='salefiles5'><?php
    echo $salefilescom[4];
?></textarea></td>

		<td width=30></td><td width=100>Hitfile</td><td width=350>
			<?php
    if (strcmp($hostlist->hitfile->work, "no") == 0)
        echo '<input type="checkbox" name="hitfile_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="hitfile_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='hitfile1'><?php
    echo $hitfilenet[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='hitfile2'><?php
    echo $hitfilenet[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='hitfile3'><?php
    echo $hitfilenet[2];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='hitfile4'><?php
    echo $hitfilenet[3];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='hitfile5'><?php
    echo $hitfilenet[4];
?></textarea></td>
		<td width=30></td><td width=100>Rarefile</td><td width=350>
			<?php
    if (strcmp($hostlist->rarefile->work, "no") == 0)
        echo '<input type="checkbox" name="rarefile_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="rarefile_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='rarefile1'><?php
    echo $rarefilenet[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='rarefile2'><?php
    echo $rarefilenet[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='rarefile3'><?php
    echo $rarefilenet[2];
?></textarea>
		</td></tr>


		<tr><td width=30></td><td width=100>Share.vnn.vn</td><td width=350>
			<?php
    if (strcmp($hostlist->sharevnn->work, "no") == 0)
        echo '<input type="checkbox" name="sharevnn_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="sharevnn_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='sharevnn'><?php
    echo $svnn[0];
?></textarea></td>

		<td width=30></td><td width=100>Tenlua.vn</td><td width=350>
			<?php
    if (strcmp($hostlist->tenluavn->work, "no") == 0)
        echo '<input type="checkbox" name="tenluavn_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="tenluavn_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='tenluavn'><?php
    echo $tlvn[0];
?></textarea></td>
<td width=30></td><td width=100>Filesmonster.com</td><td width=350>
			<?php
    if (strcmp($hostlist->filesmonster->work, "no") == 0)
        echo '<input type="checkbox" name="filesmonster_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="filesmonster_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='filesmonster1'><?php
    echo $filesmonstercom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='filesmonster2'><?php
    echo $filesmonstercom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='filesmonster3'><?php
    echo $filesmonstercom[2];
?></textarea>
		</td></tr>

		<tr><td width=30><td width=100>Password</td><td width=350>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='sharevnn_pass'><?php
    echo $svnn[1];
?></textarea></td>
		<td width=30><td width=100>Password</td><td width=350>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='tenluavn_pass'><?php
    echo $tlvn[1];
?></textarea></td>

				</tr>


		<tr><td width=30></td><td width=100>Upfile.vn</td><td width=350>
			<?php
    if (strcmp($hostlist->upfilevn->work, "no") == 0)
        echo '<input type="checkbox" name="upfilevn_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="upfilevn_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='upfilevn'><?php
    echo $ufvn[0];
?></textarea></td>

		<td width=30></td><td width=100>Youtube.com</td><td width=350>
			<?php
    if (strcmp($hostlist->youtube->work, "no") == 0)
        echo '<input type="checkbox" name="youtube_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="youtube_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='youtube'><?php
    echo $ytb[0];
?></textarea></td>

<td width=30></td><td width=100>depfile.com</td><td width=350>
			<?php
    if (strcmp($hostlist->depfile->work, "no") == 0)
        echo '<input type="checkbox" name="depfile_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="depfile_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='depfile1'><?php
    echo $depfilecom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='depfile2'><?php
    echo $depfilecom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='depfile3'><?php
    echo $depfilecom[2];
?></textarea></td></tr>

		<tr><td width=30><td width=100>Password</td><td width=350>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='upfilevn_pass'><?php
    echo $ufvn[1];
?></textarea></td>
		<td width=30><td width=100>Password</td><td width=350>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='youtube_pass'><?php
    echo $ytb[1];
?></textarea></td></tr>


		<tr><td width=30></td><td width=100>Mediafire.com</td><td width=350>
			<?php
    if (strcmp($hostlist->mediafire->work, "no") == 0)
        echo '<input type="checkbox" name="mediafire_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="mediafire_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='mediafire1'><?php
    echo $mediafirecom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='mediafire2'><?php
    echo $mediafirecom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='mediafire3'><?php
    echo $mediafirecom[2];
?></textarea></td>

				<td width=30></td><td width=100>1fichier.com</td><td width=350>
			<?php
    if (strcmp($hostlist->onefichier->work, "no") == 0)
        echo '<input type="checkbox" name="onefichier_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="onefichier_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='onefichier1'><?php
    echo $onefichiercom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='onefichier2'><?php
    echo $onefichiercom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='onefichier3'><?php
    echo $onefichiercom[2];
?></textarea></td>
				<td width=30></td><td width=100>vip-file.com</td><td width=350>
			<?php
    if (strcmp($hostlist->vipfile->work, "no") == 0)
        echo '<input type="checkbox" name="vipfile_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="vipfile_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='vipfile1'><?php
    echo $vipfilecom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='vipfile2'><?php
    echo $vipfilecom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='vipfile3'><?php
    echo $vipfilecom[2];
?></textarea></td></tr>


		<tr><td width=30></td><td width=100>Littlebyte.net</td><td width=350>
			<?php
    if (strcmp($hostlist->littlebyte->work, "no") == 0)
        echo '<input type="checkbox" name="littlebyte_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="littlebyte_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='littlebyte1'><?php
    echo $lttb1[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='littlebyte2'><?php
    echo $lttb1[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='littlebyte3'><?php
    echo $lttb1[2];
?></textarea></td>

		<td width=30></td><td width=100>Netload.in</td><td width=350>
			<?php
    if (strcmp($hostlist->netload->work, "no") == 0)
        echo '<input type="checkbox" name="netload_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="netload_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='netload1'><?php
    echo $netloadin[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='netload2'><?php
    echo $netloadin[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='netload3'><?php
    echo $netloadin[2];
?></textarea></td>

	

		<td width=30></td><td width=100>Uplea.com</td><td width=350>
			<?php
    if (strcmp($hostlist->uplea->work, "no") == 0)
        echo '<input type="checkbox" name="uplea_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="uplea_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uplea1'><?php
    echo $upleacom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uplea2'><?php
    echo $upleacom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uplea3'><?php
    echo $upleacom[2];
?></textarea></td></tr>

	</table>


	<table id='host'  style='display: none;'>
		<tr><td width=30></td><td width=100>Uploaded.net</td><td width=350>
			<?php
    if (strcmp($hostlist->uploaded->work, "no") == 0)
        echo '<input type="checkbox" name="uploaded_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="uploaded_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uploaded1'><?php
    echo $uploadednet[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uploaded2'><?php
    echo $uploadednet[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uploaded3'><?php
    echo $uploadednet[2];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uploaded4'><?php
    echo $uploadednet[3];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uploaded5'><?php
    echo $uploadednet[4];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uploaded6'><?php
    echo $uploadednet[5];
?></textarea></td>

		<td width=30></td><td width=100>Rapidgator.net</td><td width=350>
			<?php
    if (strcmp($hostlist->rapidgator->work, "no") == 0)
        echo '<input type="checkbox" name="rapidgator_enable" value="on">off</input>off</input><br/>';
    else
        echo '<input type="checkbox" name="rapidgator_enable" value="on" checked="yes">on</input><br/>';

    if (strcmp($hostlist->rapidgator->swich, "no") == 0)
        echo '<input type="checkbox" name="swich_rapidgator_enable" value="on">&#272;ang Không Dùng Host</input>';
    else
        echo '<input type="checkbox" name="swich_rapidgator_enable" value="on" checked="yes">&#272;ang D&#249;ng Qua Host</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='rapidgator1'><?php
    echo $rapidgatornet[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='rapidgator2'><?php
    echo $rapidgatornet[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='rapidgator3'><?php
    echo $rapidgatornet[2];
?></textarea></td>

		<td width=30></td><td width=100>Kingfiles.com</td><td width=350>
			<?php
    if (strcmp($hostlist->kingfiles->work, "no") == 0)
        echo '<input type="checkbox" name="kingfiles_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="kingfiles_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='kingfiles1'><?php
    echo $kingfilesnet[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='kingfiles2'><?php
    echo $kingfilesnet[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='kingfiles3'><?php
    echo $kingfilesnet[2];
?></textarea></td></tr>


		<tr><td width=30></td><td width=100>Letitbit.net</td><td width=350>
			<?php
    if (strcmp($hostlist->letitbit->work, "no") == 0)
        echo '<input type="checkbox" name="letitbit_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="letitbit_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='letitbit1'><?php
    echo $letitbitnet[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='letitbit2'><?php
    echo $letitbitnet[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='letitbit3'><?php
    echo $letitbitnet[2];
?></textarea></td>

		<td width=30></td><td width=100>Novafile.com</td><td width=350>
			<?php
    if (strcmp($hostlist->novafile->work, "no") == 0)
        echo '<input type="checkbox" name="novafile_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="novafile_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='novafile1'><?php
    echo $novafilecom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='novafile2'><?php
    echo $novafilecom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='novafile3'><?php
    echo $novafilecom[2];
?></textarea></td>
		<td width=30></td><td width=100>Uploading.com</td><td width=350>
			<?php
    if (strcmp($hostlist->uploading->work, "no") == 0)
        echo '<input type="checkbox" name="uploading_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="uploading_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uploading1'><?php
    echo $uploadingcom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uploading2'><?php
    echo $uploadingcom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uploading3'><?php
    echo $uploadingcom[2];
?></textarea></td></tr>


		<tr><td width=30></td><td width=100>Turbobit.net</td><td width=350>
			<?php
    if (strcmp($hostlist->turbobit->work, "no") == 0)
        echo '<input type="checkbox" name="turbobit_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="turbobit_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='turbobit1'><?php
    echo $turbobitnet[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='turbobit2'><?php
    echo $turbobitnet[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='turbobit3'><?php
    echo $turbobitnet[2];
?></textarea></td>

		<td width=30></td><td width=100>Tusfiles.net</td><td width=350>
			<?php
    if (strcmp($hostlist->tusfiles->work, "no") == 0)
        echo '<input type="checkbox" name="tusfiles_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="tusfiles_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='tusfiles1'><?php
    echo $tusfilescom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='tusfiles2'><?php
    echo $tusfilescom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='tusfiles3'><?php
    echo $tusfilescom[2];
?></textarea></td>


		<td width=30></td><td width=100>Uploadrocket.net</td><td width=350>
			<?php
    if (strcmp($hostlist->uploadrocket->work, "no") == 0)
        echo '<input type="checkbox" name="uploadrocket_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="uploadrocket_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uploadrocket1'><?php
    echo $uploadrocketnet[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uploadrocket2'><?php
    echo $uploadrocketnet[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uploadrocket3'><?php
    echo $uploadrocketnet[2];
?></textarea></td></tr>


		<tr><td width=30></td><td width=100>Filefactory.com</td><td width=350>
			<?php
    if (strcmp($hostlist->filefactory->work, "no") == 0)
        echo '<input type="checkbox" name="filefactory_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="filefactory_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='filefactory1'><?php
    echo $filefactorycom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='filefactory2'><?php
    echo $filefactorycom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='filefactory3'><?php
    echo $filefactorycom[2];
?></textarea></td>

		<td width=30></td><td width=100>Filepost.com</td><td width=350>
			<?php
    if (strcmp($hostlist->filepost->work, "no") == 0)
        echo '<input type="checkbox" name="filepost_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="filepost_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='filepost1'><?php
    echo $filepostcom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='filepost2'><?php
    echo $filepostcom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='filepost3'><?php
    echo $filepostcom[2];
?></textarea></td>
		<td width=30></td><td width=100>Easybytez.com</td><td width=350>
			<?php
    if (strcmp($hostlist->easybytez->work, "no") == 0)
        echo '<input type="checkbox" name="easybytez_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="easybytez_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='easybytez1'><?php
    echo $easybytezcom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='easybytez2'><?php
    echo $easybytezcom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='easybytez3'><?php
    echo $easybytezcom[2];
?></textarea></td></tr>


		<tr><td width=30></td><td width=100>4shared.com</td><td width=350>
			<?php
    if (strcmp($hostlist->fourshared->work, "no") == 0)
        echo '<input type="checkbox" name="fourshared_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="fourshared_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='fourshared1'><?php
    echo $foursharedcom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='fourshared2'><?php
    echo $foursharedcom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='fourshared3'><?php
    echo $foursharedcom[2];
?></textarea></td>

		<td width=30></td><td width=100>Depositfiles.com</td><td width=350>
			<?php
    if (strcmp($hostlist->depositfiles->work, "no") == 0)
        echo '<input type="checkbox" name="depositfiles_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="depositfiles_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='depositfiles1'><?php
    echo $depositfilescom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='depositfiles2'><?php
    echo $depositfilescom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='depositfiles3'><?php
    echo $depositfilescom[2];
?></textarea></td>
		<td width=30></td><td width=100>Alfafile.net</td><td width=350>
			<?php
    if (strcmp($hostlist->alfafile->work, "no") == 0)
        echo '<input type="checkbox" name="alfafile_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="alfafile_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='alfafile1'><?php
    echo $alfafilenet[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='alfafile2'><?php
    echo $alfafilenet[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='alfafile3'><?php
    echo $alfafilenet[2];
?></textarea></td></tr>


		<tr><td width=30></td><td width=100>Terafile.co</td><td width=350>
			<?php
    if (strcmp($hostlist->terafile->work, "no") == 0)
        echo '<input type="checkbox" name="terafile_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="terafile_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='terafile1'><?php
    echo $terafileco[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='terafile2'><?php
    echo $terafileco[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='terafile3'><?php
    echo $terafileco[2];
?></textarea></td>

		<td width=30></td><td width=100>Oboom.com</td><td width=350>
			<?php
    if (strcmp($hostlist->oboom->work, "no") == 0)
        echo '<input type="checkbox" name="oboom_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="oboom_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='oboom1'><?php
    echo $oboomcom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='oboom2'><?php
    echo $oboomcom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='oboom3'><?php
    echo $oboomcom[2];
?></textarea></td>

		<td width=30></td><td width=100>Filejoker.net</td><td width=350>
			<?php
    if (strcmp($hostlist->filejoker->work, "no") == 0)
        echo '<input type="checkbox" name="filejoker_enable" value="on">';
    else
        echo '<input type="checkbox" name="filejoker_enable" value="on" checked="yes">';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='filejoker1'><?php
    echo $filejokernet[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='filejoker2'><?php
    echo $filejokernet[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='filejoker3'><?php
    echo $filejokernet[2];
?></textarea></td></tr>


		<tr><td width=30></td><td width=100>Bitshare.com</td><td width=350>
			<?php
    if (strcmp($hostlist->bitshare->work, "no") == 0)
        echo '<input type="checkbox" name="bitshare_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="bitshare_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='bitshare1'><?php
    echo $bitsharecom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='bitshare2'><?php
    echo $bitsharecom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='bitshare3'><?php
    echo $bitsharecom[2];
?></textarea></td>

		<td width=30></td><td width=100>Uptobox.com</td><td width=350>
			<?php
    if (strcmp($hostlist->uptobox->work, "no") == 0)
        echo '<input type="checkbox" name="uptobox_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="uptobox_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uptobox1'><?php
    echo $uptoboxcom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uptobox2'><?php
    echo $uptoboxcom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uptobox3'><?php
    echo $uptoboxcom[2];
?></textarea></td></tr>


		<tr><td width=30></td><td width=100>Extmatrix.com</td><td width=350>
			<?php
    if (strcmp($hostlist->extmatrix->work, "no") == 0)
        echo '<input type="checkbox" name="extmatrix_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="extmatrix_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='extmatrix1'><?php
    echo $extmatrixcom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='extmatrix2'><?php
    echo $extmatrixcom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='extmatrix3'><?php
    echo $extmatrixcom[2];
?></textarea></td>

		<td width=30></td><td width=100>Mega.co.nz</td><td width=350>
			<?php
    if (strcmp($hostlist->megaconz->work, "no") == 0)
        echo '<input type="checkbox" name="megaconz_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="megaconz_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='megaconz1'><?php
    echo $mega_conz[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='megaconz2'><?php
    echo $mega_conz[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='megaconz3'><?php
    echo $mega_conz[2];
?></textarea></td></tr>


		<tr><td width=30></td><td width=100>Freakshare.com</td><td width=350>
			<?php
    if (strcmp($hostlist->freakshare->work, "no") == 0)
        echo '<input type="checkbox" name="freakshare_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="freakshare_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='freakshare1'><?php
    echo $freaksharecom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='freakshare2'><?php
    echo $freaksharecom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='freakshare3'><?php
    echo $freaksharecom[2];
?></textarea></td>

		<td width=30></td><td width=100>Firedrive.com</td><td width=350>
			<?php
    if (strcmp($hostlist->firedrive->work, "no") == 0)
        echo '<input type="checkbox" name="firedrive_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="firedrive_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='firedrive1'><?php
    echo $firedrivecom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='firedrive2'><?php
    echo $firedrivecom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='firedrive3'><?php
    echo $firedrivecom[2];
?></textarea></td></tr>


		<tr><td width=30></td><td width=100>Uploadable.ch</td><td width=350>
			<?php
    if (strcmp($hostlist->uploadable->work, "no") == 0)
        echo '<input type="checkbox" name="uploadable_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="uploadable_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uploadable1'><?php
    echo $uploadablech[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uploadable2'><?php
    echo $uploadablech[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='uploadable3'><?php
    echo $uploadablech[2];
?></textarea></td>

		<td width=30></td><td width=100>Zippyshare.com</td><td width=350>
			<?php
    if (strcmp($hostlist->zippyshare->work, "no") == 0)
        echo '<input type="checkbox" name="zippyshare_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="zippyshare_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='zippyshare1'><?php
    echo $zippysharecom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='zippyshare2'><?php
    echo $zippysharecom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='zippyshare3'><?php
    echo $zippysharecom[2];
?></textarea></td></tr>


		<tr><td width=30></td><td width=100>Keep2share.cc</td><td width=350>
			<?php
    if (strcmp($hostlist->keeptwoshare->work, "no") == 0)
        echo '<input type="checkbox" name="keeptwoshare_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="keeptwoshare_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='keeptwoshare1'><?php
    echo $keep2sharecc[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='keeptwoshare2'><?php
    echo $keep2sharecc[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='keeptwoshare3'><?php
    echo $keep2sharecc[2];
?></textarea></td>

		<td width=30></td><td width=100>Megashares.com</td><td width=350>
			<?php
    if (strcmp($hostlist->megashares->work, "no") == 0)
        echo '<input type="checkbox" name="megashares_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="megashares_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='megashares1'><?php
    echo $megasharescom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='megashares2'><?php
    echo $megasharescom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='megashares3'><?php
    echo $megasharescom[2];
?></textarea></td></tr>

		<tr><td width=30></td><td width=100>Hugefiles.net</td><td width=350>
			<?php
    if (strcmp($hostlist->hugefiles->work, "no") == 0)
        echo '<input type="checkbox" name="hugefiles_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="hugefiles_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='hugefiles1'><?php
    echo $hugefilesnet[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='hugefiles2'><?php
    echo $hugefilesnet[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='hugefiles3'><?php
    echo $hugefilesnet[2];
?></textarea></td>

		<td width=30></td><td width=100>Datafile.com</td><td width=350>
			<?php
    if (strcmp($hostlist->datafile->work, "no") == 0)
        echo '<input type="checkbox" name="datafile_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="datafile_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='datafile1'><?php
    echo $datafilecom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='datafile2'><?php
    echo $datafilecom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='datafile3'><?php
    echo $datafilecom[2];
?></textarea></td>
		<td width=30></td><td width=100>Yunfile.com</td><td width=350>
			<?php
    if (strcmp($hostlist->yunfile->work, "no") == 0)
        echo '<input type="checkbox" name="yunfile_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="yunfile_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='yunfile1'><?php
    echo $yunfilecom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='yunfile2'><?php
    echo $yunfilecom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='yunfile3'><?php
    echo $yunfilecom[2];
?></textarea></td></tr>

		<tr><td width=30></td><td width=100>Filesflash.net</td><td width=350>
			<?php
    if (strcmp($hostlist->filesflash->work, "no") == 0)
        echo '<input type="checkbox" name="filesflash_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="filesflash_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='filesflash1'><?php
    echo $filesflashcom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='filesflash2'><?php
    echo $filesflashcom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='filesflash3'><?php
    echo $filesflashcom[2];
?></textarea></td>

		<td width=30></td><td width=100>Scribd.com</td><td width=350>
			<?php
    if (strcmp($hostlist->scribd->work, "no") == 0)
        echo '<input type="checkbox" name="scribd_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="scribd_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='scribd1'><?php
    echo $scribdcom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='scribd2'><?php
    echo $scribdcom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='scribd3'><?php
    echo $scribdcom[2];
?></textarea></td>

		<td width=30></td><td width=100>Soundcloud.com</td><td width=350>
			<?php
    if (strcmp($hostlist->soundcloud->work, "no") == 0)
        echo '<input type="checkbox" name="soundcloud_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="soundcloud_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='soundcloud1'><?php
    echo $soundcloudcom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='soundcloud2'><?php
    echo $soundcloudcom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='soundcloud3'><?php
    echo $soundcloudcom[2];
?></textarea></td></tr>

		<tr><td width=30></td><td width=100>Speedyshare.com</td><td width=350>
			<?php
    if (strcmp($hostlist->speedyshare->work, "no") == 0)
        echo '<input type="checkbox" name="speedyshare_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="speedyshare_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='speedyshare1'><?php
    echo $speedysharecom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='speedyshare2'><?php
    echo $speedysharecom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='speedyshare3'><?php
    echo $speedysharecom[2];
?></textarea></td>

		<td width=30></td><td width=100>Sendspace.com</td><td width=350>
			<?php
    if (strcmp($hostlist->sendspace->work, "no") == 0)
        echo '<input type="checkbox" name="sendspace_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="sendspace_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='sendspace1'><?php
    echo $sendspacecom[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='sendspace2'><?php
    echo $sendspacecom[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='sendspace3'><?php
    echo $sendspacecom[2];
?></textarea></td>
		<td width=30></td><td width=100>Share-Online.biz</td><td width=350>
			<?php
    if (strcmp($hostlist->shareonline->work, "no") == 0)
        echo '<input type="checkbox" name="shareonline_enable" value="on">off</input>';
    else
        echo '<input type="checkbox" name="shareonline_enable" value="on" checked="yes">on</input>';
?>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='shareonline1'><?php
    echo $sobiz[0];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='shareonline2'><?php
    echo $sobiz[1];
?></textarea>
		<textarea onclick='javascript:this.focus();this.select()' rows='1' cols='1' style='width: 100%; height: 20px' name='shareonline3'><?php
    echo $sobiz[2];
?></textarea></td></tr>

	</table>
<br>
<center>
	<a onclick="showhide('host');return false" href="javascript:void(0)"><font color=#FF6600>More Host >>></font></a><br><br>
	<input id="send" name="send" type="submit" value="&nbsp; Save &nbsp;" onclick="return Tab_Click(this)">
</center>
		</form>
<br/>
<!-- Copyright please don't remove-->
<center><span style="FONT-FAMILY: Arial; FONT-SIZE: 11px; color:#FF8700"><strong>Skin by <FONT color=blue><b>Hitpro</b></FONT></span><br><span style="FONT-FAMILY: Arial; FONT-SIZE: 12px"><?php
    echo _copyright;
?>. All rights reserved.</span>
<b><a target="startbot" href="./bot.php"><blink><font size="5" color="red">Start Bot</font></a></blink></b>
---
<b><a target="startbot" href="./chat.php"><blink><font size="5" color="red">Start Chat</font></a></blink></b>
<br>
</center><br>
<!-- Copyright please don't remove-->
</div>
</body>
</html>
<?php
else:
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<title>BOT Kenfree - config</title>
<meta charset="UTF-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
	<body>
 <div id="form-container" align="center">
         <center>   <h1>Login BOT Ken - Free member</h1>
		 <hr>
            <form name="login" action="" method="post">
			<center>
               
                   
                        <h2><strong>System Login</strong></h2>
                   
                    
                        <td width="78">Username:</td>
                        <td width="294"><input name="username" type="text" id="username"></td>
                   
						 <td>&nbsp;</td> <td>&nbsp;</td>
                        <td>Password:</td>
                        <td><input name="password" type="password" id="password"></td>
                    
                  
                        <td>&nbsp;</td><br>
                        <td>&nbsp;</td><br>
                       <input style="width:100px;" class="green" type="submit" name="btn-submit" size=10 onClick="this.value='Waiting...';" value="Login">
					   <br>
					   <br>
					   <br>
					   <hr>
					   <br>
					   <br>
						<b><a target="startbot" href="./bot.php"><blink><font size="5" color="blue">Start Bot</font></a></blink></b>
						---
						<b><a target="startbot" href="./chat.php"><blink><font size="5" color="blue">Start Chat</font></a></blink></b>
						<br></center>
                   
              
            </form>
        </body>
    </html>
<?php
endif;
?>