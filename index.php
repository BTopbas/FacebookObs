<html><meta http-equiv="content-type" content="text/html; charset=utf-8" /></html>
<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */
//Bu dosya facebook uygulaması çalışması için gereklidir.
require 'inc/fb.php';
//Veritabanı bağlantı dosyamız. Ayarları inc içindeki mysql.php dosyasından düzenleyiniz.
include 'inc/mysql.php';
//Uygulama ilk girişte izin verdiğimizde nereye yönlendircek o adres.
define('REDIRECT_URI',"https://apps.facebook.com/akdenizobs/");
    $user = null;
//Facebookta oluşturduğumuz uygulamanın appid ve secret kodları.
$facebook = new Facebook(array(
  'appId'  => '550543265042770',
  'secret' => '89d25d28c644f841f7d0c6b89383a708',
));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

	if($user == 0)
 	{
        // If the user is not connected to your application, redirect the user to authentication page
        /**
         * Get a Login URL for use with redirects. By default, full page redirect is
         * assumed. If you are using the generated URL with a window.open() call in
         * JavaScript, you can pass in display=popup as part of the $params.
         * 
         * The parameters:
         * - redirect_uri: the url to go to after a successful login
         * - scope: comma separated list of requested extended perms
         */
		//Kullanıcı bağlı değilse izin verme sayfasını aç. İzin verdikten sonra uygulamaya yönlendir.
        $login_url = $facebook->getLoginUrl($params = array('redirect_uri' => REDIRECT_URI));

        echo ("<script> top.location.href='".$login_url."'</script>");

    } 
    else 
    {
        // Eğer kullanıcı uygulamaya zaten izin vermişse uygulama sayfasını aç.
        //Daha önce bu facebook kullanıcısı veritabanımızda mevcut mu kontrol et.
        $bilgi=mysql_query("SELECT * FROM users WHERE fbid='$user'");
		if( mysql_num_rows($bilgi) > 0 )
		//mevcutsa ilgili verileri çekerek yazdır.
			{
  				while($satir = mysql_fetch_array($bilgi) )
  				{
    			// okul numarasını yazdır.
    			$sno=$satir["sno"];
    			echo "okul numaranız:".$sno."</br>";
					$odev=mysql_query("SELECT * FROM odevler WHERE sno='$sno'");
					if( mysql_num_rows($odev) > 0 )
				{
  					while($satir = mysql_fetch_array($odev) )
  				{
    			//ödev girilmişse ödev yazdır.
    				echo "odeviniz:".$satir["odev"]."</br>";
				}
					$not=mysql_query("SELECT * FROM notlar WHERE sno='$sno'");
					if( mysql_num_rows($not) > 0 )
				{
  					while($satir = mysql_fetch_array($not) )
  				{
    			//not girilmişse not yazdır.
    				echo "Notlarınız:".$satir["vize"].",".$satir["uygulama"].",".$satir["odev"].",".$satir["final"];
				}
				}
				}
				}
			}
		else
			//Kullanıcı sistemimizde kayıtlı değilse birdefaya mahsus veritabanımızla kullanıcıyı bağlayan kayıt işlemi gerçekleştirelim.
			{
				echo "Sanırım sisteme ilk girişiniz. Okul ve tc numaranızı bikereye mahsus girerek sisteme kayıt olabilirsiniz.";
				?>
				<html>
				<form action="kayit.php" method="post">
 Okul Numarası:
 <input type="text" name="sno" /><br/>
 Tc Kimlik: 
 <input type="text" name="tc" /><br/><input type="hidden" name="fbid" value="<?echo $user;?>"/><input name="gonder" type="submit" value="Tamamdır!" /></form></html><?
			}
    }

?>