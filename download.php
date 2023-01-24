<?php
ini_set('memory_limit', '256M');
require 'vendor/autoload.php';

session_start();
include('connection/connect.php');
?>
<head>
<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="node_modules/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">

</head>
<?php

use Dompdf\Dompdf;

$html .= '
        <div class="container">
            <h2 style="font-weight: 800; color:red; margin-bottom: 0; padding: 0;" align="center">FOOD JAGUAR</h2>
            <p align="center" style="margin-bottom:0; font-size: 12px;">President Ramon Magsaysay State University, Iba Zambales, <br>Quality Assurance Building, Ground Floor</p>
            <hr style="border: solid 0.5px black">
';

if(isset($_SESSION['user_id'])) 
{
    $get_user = mysqli_query($db, "SELECT * FROM users WHERE u_id = '".$_SESSION['user_id']."'");
    $fetch = mysqli_fetch_array($get_user);
    $fullname = $fetch['f_name']. ' '.$fetch['l_name'];
    $order_id = $_GET['id'];
    $get_orders = mysqli_query($db,'SELECT user_orders.*, (SELECT SUM(price) FROM user_orders WHERE status != "rejected" AND order_number="'.$row['order_number'].'") as total_price FROM user_orders WHERE u_id="'.$_SESSION["user_id"].'" AND order_number="'.$order_id.'"');

    if(mysqli_num_rows($get_orders) > 0) 
    {
        // HEADER
        // <p>Purchase (total '.$total_items.' items)</p>
        $html .= '
        <table width="100%">
            <thead>
            </thead>
            <tbody>
            ';
        // while($row = mysqli_fetch_assoc($get_orders)) 
        while($row = mysqli_fetch_array($get_orders)) 
        {

            $html .= '
                <tr>
                    <td>'.$row['title'].'</td>
                    <td>'.$row['quantity'].' x P'.$row['original_price'].'</td>
                </tr>
            ';

        } 
            $html .= '
                <tr>
                    <td></td>
                </tr>
            ';
        $html .= '
                </tbody>
            </table>
        ';
        // $html .= '  </div>
        //             <hr>
        // ';
    }
    else 
    {
        $html .= 'YOU HAVE NO ORDERS!';
    }
}

$html .= '
        </div>
        ';




echo $html;

$dompdf = new Dompdf();
$dompdf->loadHtml($html, 'UTF-8');
$customPaper = array(0,0,360,560);
$dompdf->set_paper($customPaper);
$dompdf->render();
ob_end_clean();
$dompdf->stream($_GET['id'].'.pdf', array('Attachment'=>false));
exit(0);
