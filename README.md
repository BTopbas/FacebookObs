FacebookObs
===========

Facebook Obs
-Uygulamanın çalışması için facebookta App aluşturulup appid ve secret keyleri phpde değiştirilmelidir.
-Facebook Ssl kullandığı için uygulamanın oluşturulacağı adresin ssl sertifikasına ihtiyacı vardır. Aksi halde ssl kullanan facebook kullanıcılarında uygulama açılmaz.
-Öğrenci okul no ve tc daha önceden veritabanında olmalıdır. Bunun yannına uygulama fbid ekleyecektir.
-Veritabanı Tabloları
users
-id(otomatik artan)
-fbid(int,NULL)
-sno(int)(okul numarası)
-tc(int)
odevler
-sno(int)(okul numarası)
-odev(text)
notlar
-sno(int)(okul numarası)
-vize(int)
-uygulama(int)
-odev(int)
-final(int)
