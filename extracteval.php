<?php
$connect = mysqli_connect("localhost", "root", "", "accounts");
if(isset($_POST["interv"]))
{

    $data = '{"description":" ", count:0}';

//query to get data of clients under contributor portfolio in the current year
    $year = $_POST["year"];
    $nextyear = $year + 1;
    $date1 = $year . "-04-01";
    $date2 = $nextyear . "-03-11";
    $interv = $_POST["interv"];
    $query = "SELECT count(*) AS year_actif_client FROM client WHERE id_interv='$interv' AND date_cloture IS NULL AND date_creation BETWEEN '$date1' AND '$date2'";

//execute query
    $result = mysqli_query($connect, $query) or die(mysqli_error());

    $row1 = mysqli_fetch_array($result);

//query to get data from the table

    $trim = $_POST["trim"];

    if($trim == 1) {

        $date1 = $year . "-04-01";
        $date2 = $year . "-06-30";
        $trim  = "Trim_1";
    }

    if($trim == 2) {

        $date1 = $year . "-06-01";
        $date2 = $year . "-09-30";
        $trim  = "Trim_2";
    }

    if($trim == 3) {

        $date1 = $year . "-10-01";
        $date2 = $year . "-12-31";
        $trim  = "Trim_3";
    }

    if($trim == 4) {

        $date1 = $nextyear . "-01-01";
        $date2 = $nextyear . "-03-31";
        $trim  = "Trim_4";
    }

//query to get data of actif clients under contributor portfolio in the selected quarter
    $query = "SELECT count(*) AS trim_actif_client FROM client WHERE id_interv='$interv' AND date_cloture IS NULL AND date_creation BETWEEN '$date1' AND '$date2'";

//execute query
    $result = mysqli_query($connect, $query) or die(mysqli_error());

    $row2 = mysqli_fetch_array($result);

//query to get data of closed clients under contributor portfolio in the selected quarter
    $query = "SELECT count(*) AS trim_closed_client FROM client WHERE id_interv='$interv' AND date_cloture IS NOT NULL AND date_cloture BETWEEN '$date1' AND '$date2'";

//execute query
    $result = mysqli_query($connect, $query) or die(mysqli_error());

    $row3 = mysqli_fetch_array($result);

    $value = "{y:'" . $trim . "', a:" . $row1["year_actif_client"] . ", b:" . $row2["trim_actif_client"] . ", c:" . $row3["trim_closed_client"] . "}, ";
    $value1 = "[" . $row1["year_actif_client"] . ", " . $row2["trim_actif_client"] . ", " . $row3["trim_closed_client"] . "]";

    $chart_data = array();

    $chart_data = [
        [
            "label" => "Actifs annuel",
            "value" => $row1["year_actif_client"]
        ],
        [
            "label" => "Créations trimestriels",
            "value" => $row2["trim_actif_client"]
        ],
        [
            "label" => "Clotûres trimestriels",
            "value" => $row3["trim_closed_client"]
        ]
    ];


//free memory associated with result
    $result->close();

//close connection
    $connect->close();

    $data = substr($value, 0, -2);

    //echo $data;

    echo json_encode($chart_data);
}

?>