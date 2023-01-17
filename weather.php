<?php
error_reporting(false);
header('Content-type: application/json;'); 

$urlside=$_GET['name'];

$ch = curl_init();
//curl_setopt($ch, CURLOPT_POST, true);
//curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
curl_setopt($ch, CURLOPT_URL,"https://www.yjc.news/fa/weather");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR,"cookie.txt");
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
curl_setopt($ch, CURLOPT_HEADER, false);
$meysam1= curl_exec($ch);
curl_close($ch);    

preg_match_all('#<div class="weather_city_title2"> 					<a href="(.*?)" onclick="showWeather((.*?));return false;"> 						(.*?) 					</a> 				</div>#is',$meysam1,$sidepath1);

$citys=$sidepath1[4];
for($i=0;$i<=count($sidepath1[4])-1;$i++){
$city=$sidepath1[4][$i];
$code=$sidepath1[3];    
$code1=str_replace("('","",$code[$i]);
$code2=str_replace("')","",$code1);
$ages[$city]=$code2;
}


if(in_array($urlside,$citys)){
    
$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_POST, true);
curl_setopt($ch1, CURLOPT_POSTFIELDS,"wcode: $ages[$urlside]");
curl_setopt($ch1, CURLOPT_URL,"https://www.yjc.news/fa/weather/".$ages[$urlside]);
curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch1, CURLOPT_COOKIEJAR,"cookie.txt");
curl_setopt($ch1, CURLOPT_COOKIEFILE, "cookie.txt");
curl_setopt($ch1, CURLOPT_HEADER, false);
$meysam2= curl_exec($ch1);
curl_close($ch1);        


preg_match_all('#<span(.*?)class="(.*?)"(.*?)>(.*?)</span>#is',$meysam2,$sidepath2);


$resultarz['شهر']= $sidepath2[4][0];  
$resultarz['آخرين بروز رساني']= $sidepath2[4][3];  
$resultarz['وضعيت']= $sidepath2[4][5];  
$resultarz['سرعت باد']= $sidepath2[4][7];  
$resultarz['رطوبت']= $sidepath2[4][9];  
$resultarz['طلوع آفتاب']= $sidepath2[4][11];  
$resultarz['غروب آفتاب']= $sidepath2[4][13];  

$resultarz['کمینه']= $sidepath2[4][14];  
$resultarz['بیشینه']= $sidepath2[4][15];  


$resultarz['وضعيت فردا']= $sidepath2[4][17];  
$resultarz['كمينه فردا']= $sidepath2[4][19];  
$resultarz['بیشینه فردا']= $sidepath2[4][21];  


//========================================================= 
echo json_encode(['ok' => true, 'channel' => '@SIDEPATH','writer' => '@meysam_s71',  'Results' =>['result'=>$resultarz,'city'=>$citys]], 448);
//========================================================= 

}else{
//========================================================= 
echo json_encode(['ok' => true, 'channel' => '@SIDEPATH','writer' => '@meysam_s71',  'Results' =>['result'=>"wrong city",'city'=>$citys]], 448);
//========================================================= 
}




