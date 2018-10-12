<!-- https://bandori.ga/assets/characters/resourceset/res[CharID(3)][CardID(3)]_rip/card_[CardStat(normal||after_training)].png -->


<?php

function zerofill($y, $x = 3){
	$l = floor(log10($y)) + 1;
	$r = '';
	for($i = 1; $i <= $x - $l; $i++){
		$r .= '0';
	}
	$r .= $y;

	return $r;
}

//	This scraper uses bandori.ga data to scrape Bandori's member card.

//	$band_id indicates the band of the member that you want to download the card.
//	Set the $band_id to :
//	 1 if the band is Poppin' Party
//	 2 if the band is Afterglow
//	 3 if the band is Hello, Happy World!
//	 4 if the band is Pastel * Palletes
//	 5 if the band is Roselia
	$band_id = 5;

//	$instr_id indicates the member's role.
//	Set the $instr_id to :
//	 1 if the member's role is vocalist
//	 2 if the member's role is guitarist
//	 3 if the member's role is bassist
//	 4 if the member's role is drummer
//	 5 if the member's role is keyboardist / DJ
	$role_id = 5;

//	The default value of $band_id is 5, indicating that we will download the cards from Roselia's 		member.
//	The default value of $role_id is 5, indicating that we will download the cards of Roselia's keyboardist, Rinko Shirokane. 

	$member_id = (($band_id - 1) * 5) + $role_id;
	$member_id = zerofill($member_id);

	$c = 1;
	$cf = zerofill($c);

	$httpcode = 0;
	$first = 0;
	$sec = true;
	echo $cf." ";
	

	while($sec){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 5);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_URL, "https://www.bandori.ga/assets/characters/resourceset/res".$member_id.$cf."_rip/card_normal.png");
		$o = curl_exec($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		if($httpcode != 404){
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "https://www.bandori.ga/assets/characters/resourceset/res".$member_id.$cf."_rip/card_normal.png");
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_NOBODY, false);
			curl_setopt($curl, CURLOPT_TIMEOUT, 999);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$o = curl_exec($curl);
			curl_close($curl);

			file_put_contents("img/".$member_id.$cf.".png", $o);
		}

		$c++;
		$cf = zerofill($c);

		if($httpcode == 404){
			$first++;
		}else{
			$first = 0;
		}

		if($httpcode == 404 && $first >= 3){
			$sec = false;
		}
	}

?>