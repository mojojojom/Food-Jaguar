<?php
ini_set('memory_limit', '256M');
require 'vendor/autoload.php';

session_start();
include('connection/connect.php');

use Dompdf\Dompdf;

if(isset($_SESSION['user_id'])) 
{
    $get_user = mysqli_query($db, "SELECT * FROM users WHERE u_id = '".$_SESSION['user_id']."'");
    $fetch = mysqli_fetch_array($get_user);
    $fullname = $fetch['f_name']. ' '.$fetch['l_name'];
    $order_id = $_GET['id'];
    // GET ALL ORDERS
    $get_orders = mysqli_query($db,'SELECT user_orders.*, (SELECT SUM(price) FROM user_orders WHERE status != "rejected" AND order_number="'.$row['order_number'].'") as total_price FROM user_orders WHERE u_id="'.$_SESSION["user_id"].'" AND order_number="'.$order_id.'" AND status != "rejected"');
    // GET TOTAL PRICE
    $get_total_price = mysqli_query($db, "SELECT SUM(price) as total_price FROM user_orders WHERE status != 'rejected' AND order_number = '".$order_id."'");
    $get_all_total_price = mysqli_fetch_array($get_total_price);
    $total_price = $get_all_total_price['total_price'];
    // GET TOTAL ITEM
    $get_items = mysqli_query($db, "SELECT COUNT(*) as total_items FROM user_orders WHERE status != 'rejected' AND order_number = '".$order_id."'");
    $get_all = mysqli_fetch_array($get_items);
    $total_items = $get_all['total_items'];
    // GET MOP
    $get_mop = mysqli_query($db, "SELECT mop FROM user_orders WHERE u_id='".$_SESSION['user_id']."' AND status <> 'rejected' GROUP BY mop");
    $get_all_mop = mysqli_fetch_array($get_mop);
    $all_mop = $get_all_mop['mop'];
    // GET SHIPPING FEE
    $get_sfee = mysqli_query($db, "SELECT s_fee FROM user_orders WHERE u_id='".$_SESSION['user_id']."' AND status <> 'rejected' GROUP BY s_fee");
    $get_all_sfee = mysqli_fetch_assoc($get_sfee);
    // $all_sfee = $get_all_sfee['s_fee'];
    // GET CANTEEN
    $get_canteen = mysqli_query($db, "SELECT c_id FROM user_orders WHERE u_id='".$_SESSION['user_id']."' AND status <> 'rejected' GROUP BY c_id");
    $fetch_cid = mysqli_fetch_assoc($get_canteen);
    $get_canteen_name = mysqli_query($db, "SELECT * FROM canteen_table WHERE id='".$fetch_cid['c_id']."'");
    $fcname = mysqli_fetch_assoc($get_canteen_name);
    $cname = $fcname['canteen_name'];

    $final_price = $get_all_sfee['s_fee']+$total_price;

    $html .= '
        <div class="container">
            <h2 style="font-weight: 800; color:black; margin-bottom: 0; padding: 0;" align="center">'.$cname.'</h2>
            <p align="center" style="margin-bottom:0; font-size: 12px;">President Ramon Magsaysay State University, Iba Zambales, <br>Quality Assurance Building, Ground Floor</p>
            <hr style="border: solid 0.5px black">
    ';

    $html .= '
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <p>ORDER #'.$order_id.'</p>
        </div>
    ';



    if(mysqli_num_rows($get_orders) > 0) 
    {
        $html .= '
        <p stlye="margin-bottom: 0;"><b>Purchase (total '.$total_items.' items)</b></p>
        <table width="100%">
            <thead>
            </thead>
            <tbody>
            ';
        while($row = mysqli_fetch_array($get_orders)) 
        {

            $html .= '
                <tr>
                    <td>'.$row['title'].'</td>
                    <td align="right">'.$row['quantity'].' <span style="margin: 0 10px;">x</span> P'.$row['original_price'].'</td>
                </tr>
                <tr><td style="border-bottom: 1px solid black; width:100%; height: 10px;"></td><td style="border-bottom: 1px solid black; width:100%; height: 10px;"></td></tr>
            ';

        } 
            $html .= '
                <tr style="margin-top: 50px;">
                    <td>Subtotal</td>
                    <td align="right">P'.$total_price.'</td>
                </tr>
                <tr>
                    <td>Delivery Fee</td>
                    <td align="right">P'.$get_all_sfee['s_fee'].'</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Total Price</td>
                    <td align="right" style="font-weight: bold;">P'.$final_price.'</td>
                </tr>
            ';
        $html .= '
                </tbody>
            </table>
        ';
    }
    else 
    {
        $html .= 'YOU HAVE NO ORDERS!';
    }

    $html .= '<div style="height: 20px; display: block; width: 100%;"></div>';


} else {
    header('Location: login.php');
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