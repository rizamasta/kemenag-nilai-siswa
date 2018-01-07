<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* @package     Converter
* @author      Arief Budi SAntoso
* @copyright   Copyright(c) 2016
* @version     1.0.0
**/

class Converter
{
	// ====================================================================================================
	// =========================================  ARRAY - OBJECT ==========================================
	// ====================================================================================================
	/**
	* Convert Object to Array
	*
	* Convert Object Data to Array Data
	*
	* @return	Array Data
	*/
	function objectToArray($d) {
		if (is_object($d)) {
			$d = get_object_vars($d);
		}
 
		if (is_array($d)) {
			return array_map(null, $d);
		}else {
			return $d;
		}
	}

	/**
	* Convert Array to Object
	*
	* Convert Array Data to Object Data
	*
	* @return	Object Data
	*/
	function arrayToObject($d) {
		if (is_array($d)) {
			return (object) array_map(null, $d);
		}else{
			return $d;
		}
	}

	// ====================================================================================================
	// ====================================================================================================
	// ====================================================================================================

	// ====================================================================================================
	// ==========================================  DATETIME  ==============================================
	// ====================================================================================================
	public function DateDiff($Date1, $Date2, $Interval){
		if ($Date1 < $Date2) {
			$dt1 = $Date1;
			$dt2 = $Date2;
		} else {
			$dt1 = $Date2;
			$dt2 = $Date1;
		}
		$d1 = GetDate($dt1);
		$d2 = GetDate($dt2);
		$Date = $dt2 - $dt1;
		$d = GetDate($Date);
		
		Switch ($Interval) {
			Case "Y":
				//year
				$Number = GetYear($d1[year], $d2[year], $d1[mon], $d2[mon], $d1[mday], $d2[mday]);
				Break;
			Case "m":
				//month
				//1 part, the same as in "Y" case
				$y = GetYear($d1[year], $d2[year], $d1[mon], $d2[mon], $d1[mday], $d2[mday]);
				//2 part, rest months
				$dt1 = DateAdd($dt1, "Y", $y);
				$d1 = GetDate($dt1);
				While (True) {
					$m++;
					$dt1 = DateAdd($dt1, "m", 1);
					if ($dt1 >= $dt2) Break;
				}
				if ($dt1 > $dt2) $m--;
				$Number = ($y * 12) + $m;
				Break;
			Case "d":
				//day
				$Number = $Date / 86400; //60 sek. * 60 min. * 24 h.
				Break;
			Case "H":
				//hour
				$Number = $Date / 3600; //60 sek. * 60 min.
				Break;
			Case "M":
				//minute
				$Number = $Date / 60; //60 sek.
				Break;
			Case "S":
				//second
				$Number = $Date;
				Break;
		}
		if ($Date1 < $Date2) {
			Return $Number;
		} else {
			Return $Number * (-1);
		}
	}
	
	public function DateAdd($Date, $Interval, $Number){
		$d = GetDate($Date);
		Switch ($Interval) {
			Case ("Y"):
				//year
				$Date = MkTime($d['hours'], $d['minutes'], $d['seconds'],
				$d['mon'], $d['mday'], $d['year'] + $Number);
				Break;
			Case "m":
				//month
				$Date = MkTime($d['hours'], $d['minutes'], $d['seconds'],
				$d['mon'] + $Number, $d['mday'], $d['year']);
				Break;
			Case "d":
				//day
				$Date = MkTime($d['hours'], $d['minutes'], $d['seconds'],
				$d['mon'], $d['mday'] + $Number, $d['year']);
				Break;
			Case "H":
				//hour
				$Date = MkTime($d['hours'] + $Number, $d['minutes'], $d['seconds'],
				$d['mon'], $d['mday'], $d['year']);
				Break;
			Case "M":
				//minute
				$Date = MkTime($d['hours'], $d['minutes'] + $Number, $d['seconds'],
				$d['mon'], $d['mday'], $d['year']);
				Break;
			Case "S":
				//second
				$Date = MkTime($d['hours'], $d['minutes'], $d['seconds'] + $Number,
				$d['mon'], $d['mday'], $d['year']);
				Break;
		}
		Return $Date;
	}
	
	public function GetYear($y1, $y2, $m1, $m2, $d1, $d2){
		if ($y1 == $y2) {
			$Year = 0;
		} elseif (($m2 < $m1) Or ($m2 == $m1 And $d2 < $d1)) {
			$Year = $y2 - $y1 - 1;
		} else {
			$Year = $y2 - $y1;
		}
		Return $Year;
	}

	public function MonthFirstDay($Year, $Month){
		$Date = cDate($Year, $Month, 1);
		Return $Date;
	}

	public function MonthLastDay($Year, $Month){
		if ($Month == 12) {
			$Date = cDate($Year, $Month, 31);
		} else {
			$Date = MkTime(0, 0, 0, $Month + 1, 1 - 1, $Year);
		}
		Return $Date;
	}

	public function cDateTime($Year, $Month, $Day, $Hour, $Minute, $Second){
		$Date = MkTime($Hour, $Minute, $Second, $Month, $Day, $Year);
		Return $Date;
	}

	public function cDate($Year, $Month, $Day){
		$Date = MkTime(0, 0, 0, $Month, $Day, $Year);
		Return $Date;
	}

	public function Year($Date){
		$d = GetDate($Date);
		Return $d['year'];
	}

	public function Month($Date){
		$d = GetDate($Date);
		Return $d['mon'];
	}

	public function Day($Date){
		$d = GetDate($Date);
		Return $d['mday'];
	}

	public function Hour($Date){
		$d = GetDate($Date);
		Return $d['hours'];
	}

	public function Minute($Date){
		$d = GetDate($Date);
		Return $d['minutes'];
	}

	public function Second($Date){
		$d = GetDate($Date);
		Return $d[second];
	}

	public function cDateTimePL($Date){
		Return StrFTime("%Y-%m-%d %H:%M:%S", $Date);
	}

	public function cDatePL($Date){
		Return StrFTime("%Y-%m-%d", $Date);
	}

	public function cTimePL($Date){
		Return StrFTime("%Y-%m-%d %H:%M:%S", $Date);
	}

	public function cDateTimeUS($Date){
		Return StrFTime("%m/%d/%y %I:%M:%S%p", $Date);
	}

	public function cDateUS($Date){
		Return StrFTime("%m/%d/%y", $Date);
	}

	public function cTimeUS($Date){
		Return StrFTime("%I:%M:%S%p", $Date);
	}

	function ago($stime){
		$now = time();
        $time=strtotime($stime);
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");

        $difference     = $now - $time;
        $tense         = "ago";

        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if($difference != 1) {
            $periods[$j].= "s";
        }

        if($j > 4) {
            return date("d F Y",$time);
        }else{
            return "$difference $periods[$j] 'ago' ";
        }
    }

    // ====================================================================================================
	// ====================================================================================================
	// ====================================================================================================
	
}