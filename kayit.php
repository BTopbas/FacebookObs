<?
//Veritabanı bağlantımız burda.
include 'inc/mysql.php';
//Post ile ilgili veriler dolu mu.
if(isset($_POST['sno']) && isset($_POST['tc']) && isset($_POST['fbid'])) 
	{
		//verileri değişlkenlere tanımlayalım.
		$sno = $_POST['sno'];
    	$tc = $_POST['tc'];
    	$fbid = $_POST['fbid'];
		if(empty($sno) || empty($tc) || empty($fbid)) 
		//eğer değişkenlerimiz boşsa uyarı verelim.
			{
     			echo 'Ya boş bıraktın alanları yada bizi hacklemeye falan çalışıosun ne ayaksın bilelim !?!?!';
			}
		else
			//değişkenler boş değilse devam edelim.
			{
				$bilgi=mysql_query("SELECT * FROM users WHERE sno='$sno' AND tc='$tc'");
				if( mysql_num_rows($bilgi) > 0 )
				//Okul veritabanımızda kişinin girmiş olduğu okul numarası ve tc noya ait biri varmı bakalım. Varsa o kişiye fbid atayıp ödev ve not tablolarına okul numarasını koyalım.
					{
						$sql1="UPDATE users SET fbid='$fbid' WHERE sno='$sno'";
    					$kayit=mysql_query($sql1);
						$sql2="INSERT INTO odevler(sno) VALUES('$sno')";
    					$kayit2=mysql_query($sql2);
						$sql3="INSERT INTO notlar(sno) VALUES('$sno')";
    					$kayit3=mysql_query($sql3);
						if(!$kayit)
							{
								echo "bişeyler ters gitmiş olmalı :/";
							}
						else
							//Kayıt başarılıysa kullanıcıyı uygulamamıza geri yönlendirelim.
							{
								echo ("<script> top.location.href='https://apps.facebook.com/akdenizobs'</script>");
							}
					}
				else
					//girilen tc no veya okul numarası hatalı veya böyle bir öğrencimiz yok.
					{
						echo "Öğrenci bulunamadı.";
					}
			}
	}