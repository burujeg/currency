<?

namespace application\core;

class Usd{
	public function __construct() {
		//echo 'that is class Usd';
	}
	public function get_value($code, $date_to_query){
		//as a default cyrrency for today
		//$yesterday  = date("d/m/Y", mktime(0, 0, 0, date("m"), date("d")-2, date("Y")));
		$today  = $date_to_query;
		$yesterday = explode("/", $today);
		if((int)$yesterday[0] <= 9 and (int)$yesterday != 1){
			$zero = '0';
			$day = 1;
		}
		// exception for the start month in date
		else if((int)$yesterday[0] == 1){
			$yesterday = date("t/m/Y", mktime(0, 0, 0, $yesterday[1]-1, $yesterday[0], $yesterday[2]));
			$yesterday = explode("/", $yesterday);
			$day = 0;
			$zero = '';
		}
		else{
			$zero = '';
			$day = 1;
		}
		$yesterday[0] = (int)$yesterday[0] - $day;
		$yesterday = $zero.$yesterday[0]."/".$yesterday[1]."/".$yesterday[2];		
		//query for xml to api cbr.ru
		$query_yesterday = "http://www.cbr.ru/scripts/XML_dynamic.asp?date_req1=$yesterday&date_req2=$yesterday&VAL_NM_RQ=$code";
		$query_today = "http://www.cbr.ru/scripts/XML_dynamic.asp?date_req1=$today&date_req2=$today&VAL_NM_RQ=$code";
		//take result for query date and one day before
		$result_yesterday = simplexml_load_file("$query_yesterday");
		$result_today = simplexml_load_file("$query_today");
		//take values from result
		$value_yesterday = $result_yesterday->Record->Value[0];
		$value_yesterday = str_replace(',', '.', $value_yesterday);
		$value_yesterday = (float)$value_yesterday;
		$value_today = $result_today->Record->Value[0];
		$value_today = str_replace(',', '.', $value_today);
		$value_today = (float)$value_today;
		//math a at query day value and value at one day before
		if($value_today > $value_yesterday){
			$ico = 'level-up'; // the icon if the currency has been increaseble
		}
		else if($value_today < $value_yesterday){
			$ico = 'level-down'; // the icon if the currency has been decreaseble
		}
		else{
			$ico = 'exchange'; // the icon if the currency doesn't be changed
		}
		$this->show($value_today, $ico);

	}
	public function show($value, $ico){
		echo $value;
		echo <<<HTML
		<i class="logo fa fa-$ico">
		</i>
HTML;

	}
}

?>