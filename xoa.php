<Title>Bot Cleanning...</Title>
<!-- xml version="1.0" encoding="utf-8" --> 
Đã d&#7885;n d&#7865;p s&#7841;ch s&#7869;. Clean finished
<?php 
error_reporting(1);

$time_now = time() - 120*60;
$time_link = time() - 1440*60;
//$time_link = time() - 2880*60;
$time_ip = time() - 51*60;

###### FUNCTION DELETE ALL FILES AND SUBFOLDERS IN USER #######
$files = glob('user/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    if (filemtime($file) <= $time_now) unlink($file); // delete file
}
###### FUNCTION DELETE ALL FILES AND SUBFOLDERS IN USER #######

###### FUNCTION DELETE ALL FILES AND SUBFOLDERS IN USER #######
$files = glob('chat/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    if (filemtime($file) <= $time_now) unlink($file); // delete file
}
###### FUNCTION DELETE ALL FILES AND SUBFOLDERS IN USER #######

###### FUNCTION DELETE ALL FILES AND SUBFOLDERS IN TIME #######
$files = glob('time/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    if (filemtime($file) <= $time_now) unlink($file); // delete file
}
###### FUNCTION DELETE ALL FILES AND SUBFOLDERS IN TIME #######

###### FUNCTION DELETE ALL FILES AND SUBFOLDERS IN TIME #######
 $files = glob('timeip/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    if (filemtime($file) <= $time_ip) unlink($file); // delete file
} 
###### FUNCTION DELETE ALL FILES AND SUBFOLDERS IN TIME #######

###### FUNCTION DELETE ALL FILES AND SUBFOLDERS IN TIME #######
 $files = glob('ip/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    if (filemtime($file) <= $time_ip) unlink($file); // delete file
} 
###### FUNCTION DELETE ALL FILES AND SUBFOLDERS IN TIME #######


###### FUNCTION DELETE ALL FILES AND SUBFOLDERS IN TIME #######
$files = glob('size/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    if (filemtime($file) <= $time_link) unlink($file); // delete file
}
###### FUNCTION DELETE ALL FILES AND SUBFOLDERS IN TIME #######


###### FUNCTION DELETE ALL FILES AND SUBFOLDERS IN TIME #######
$files = glob('totallink/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    if (filemtime($file) <= $time_link) unlink($file); // delete file
}
###### FUNCTION DELETE ALL FILES AND SUBFOLDERS IN TIME #######



?>