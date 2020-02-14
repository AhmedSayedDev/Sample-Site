 <?php
/******//******//******//******//******//******//******//******//******//******//******//******/
	/*
	** Get User Ip
	*/
    function GetUserIp() {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
        if(filter_var($client, FILTER_VALIDATE_IP))  { $ip = $client; }
        elseif(filter_var($forward, FILTER_VALIDATE_IP)) { $ip = $forward; } else { $ip = $remote; }
        return $ip;
    }
    /*
	** Get Ip Details
	*/
    function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }

/******//******//******//******//******//******//******//******//******//******//******//******/
/*
** Get Date OR Time
*/
    function DateTime($Status = "Date"){
        date_default_timezone_set("Asia/Riyadh");
        $Date = date("Y-m-d");
        $Time = date("h:i:s(a)");
        $All = "[".$Date."]-[".$Time."]";
        if($Status == "Date"){return $Date;}elseif($Status == "Time"){return $Time;}else{return $All;}
    }
/******//******//******//******//******//******//******//******//******//******//******//******/
/*
** Connect To DB Function
*/
    function Connect($Server,$Username,$Password,$DBname){
        global $con;
        $dsn  = 'mysql:host='.$Server.';dbname='.$DBname;
        $option = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);
        try{
            $con = new PDO($dsn, $Username, $Password, $option);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){echo 'Failed To Connect: ' . $e->getMessage();}
    }
/******//******//******//******//******//******//******//******//******//******//******//******/
/*
** Delete Data From DB
*/
    function DeleteData($Table,$Col,$Data){
        global $con;
        $stmt = $con->prepare("DELETE FROM $Table WHERE $Col = '$Data'");
        $stmt->execute();
        echo "<div class='container' ><div class='alert alert-success'>Success</div></div>";
    }
/******//******//******//******//******//******//******//******//******//******//******//******/
/*
** Get Selected Data
*/
    function GetData($Field, $Table, $where = NULL, $and = NULL, $OrderField, $Order = "DESC") {
        global $con;
        $getAll = $con->prepare("SELECT $Field FROM $Table $where $and ORDER BY $OrderField $Order");
        $getAll->execute();
        $AllData = $getAll->fetchAll();
        return $AllData;
    }
/******//******//******//******//******//******//******//******//******//******//******//******/
/*
** Check Function
*/
    function CheckData($select, $from, $val) {
        global $con;
        $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
        $statement->execute(array($val));
        $CountNum = $statement->rowCount();
        return $CountNum;
    }
/******//******//******//******//******//******//******//******//******//******//******//******/
/*
** Title Of Page
*/
    function GetTitle() {
        global $PageTitle;
        if (isset($PageTitle)){echo $PageTitle;}else{echo 'BHM Accessories';}
    }
/******//******//******//******//******//******//******//******//******//******//******//******/
/*
** Redirect Function
*/
    function Redirect($theMsg, $url = null, $seconds = 3) {
        if ($url === null) {
            $url = 'index.php';
            $link = 'HomePage';
        } else {
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
                $url = $_SERVER['HTTP_REFERER'];
                $link = 'Previous Page';
            } else {
                $url = 'index.php';
                $link = 'HomePage';
            }
        }
        echo $theMsg;
        echo "<div class='alert alert-info'>You Will Be Redirected to $link After $seconds Seconds.</div>";
        header("refresh:$seconds;url=$url");
        exit();
    }
/******//******//******//******//******//******//******//******//******//******//******//******/
/*
** Count Data
*/
    function CountData($item, $table) {
        global $con;
        $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
        $stmt2->execute();
        return $stmt2->fetchColumn();
    }
/******//******//******//******//******//******//******//******//******//******//******//******/
/*
** Get Last Data From Selected Table
*/
    function GetLatest($select, $table, $order, $limit = 5) {
        global $con;
        $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
        $getStmt->execute();
        $rows = $getStmt->fetchAll();
        return $rows;
    }
