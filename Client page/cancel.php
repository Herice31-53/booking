<!-- PHP INCLUDES -->

<?php

    include "connect.php";
    include "Includes/templates/header.php";
    include "Includes/templates/navbar.php";

?>

<link rel="stylesheet" href="Design/css/verification.css">

<section class="booking_section">
    
    <div class="container">
        <?php
            $today_date = date('Y-m-d');
            
            $con->beginTransaction();
            if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) AND isset($_GET['apid']) && !empty($_GET['apid'])){
                $email = $_GET['email']; // Set email variable 
                $hash = $_GET['hash']; // Set hash variable
                $apid = $_GET['apid']; // Set hash variable

                

                $today_date = date('Y-m-d');

                $stmt_clt_verif = $con->prepare("Select client_id, first_name,last_name,phone_number,active,client_email,hash,active from clients where client_email = ? and hash = ?");
                $stmt_clt_verif->execute(array($email,$hash));
                $row_clt_verif = $stmt_clt_verif->fetch();
                $count_clt = $stmt_clt_verif->rowCount();


                if($count_clt > 0 ){
                    if ($row_clt_verif['active']==1){
                        $stmt_apt_verif = $con->prepare("Select date_created, client_id,employee_id,start_time,end_time_expected from appointments where client_id = ? and appointment_id = ?");
                        $stmt_apt_verif->execute(array($row_clt_verif['client_id'],$apid));
                        $row_apt_verif = $stmt_apt_verif->fetch();
                        $count_apt = $stmt_apt_verif->rowCount();

                        if($count_apt > 0 ){
                            if (date($row_apt_verif['start_time'])>date('Y-m-d', strtotime($today_date . ' +1 day'))){
                                $update_apt = $con->prepare("UPDATE appointments SET cancellation_reason = ?,canceled= ? WHERE appointment_id= ?");
                                $update_apt->execute(['Client cancellation',1,$apid]);  
                                $stage=0;
                                $message='Your appointment has been successfully deleted, please feel free to book another one whenever you are ready.';

                            }
                            else{
                                $stage=1;
                                $message='Sorry, we do not accept cancelation less that on day before the appointment';
                            }
                        }
                        else{
                            $stage=1;
                            $message='We do not see an appointment corresponding to the information provided.';
                        }


                    }
                    else{
                        $stage=1;
                        $message='Your account has not been activated yet, please check your emails.';
                    }
                }
                else{
                    $stage=1;
                    $message='No match has been foud. Please make sure that the email you entered when booking your appointment is valid.';
                }
            }
            else{
                $stage=1;
                $message='Link not valid';
            };
            $con->commit();
        ?>
        <div class="verification_div" id="verification_div">
        <?php
            if($stage==0){
                ?>
                <div class="update_made">
                    <div class="text_header">
                        <span>
                            Appointment cancelled
                        </span>
                    </div>
                    <div class="text_answer">   
                        <?php echo $message; ?>                             
                    </div>
                </div>
                <?php
            }
        ?>
        <?php
            if($stage==1){
                ?>
                <div class="no_match_found">
                    <div class="text_header">
                        <span>
                            Appointment not cancelled
                        </span>
                    </div>
                    <div class="text_answer">   
                        <?php echo $message; ?>                             
                    </div>
                </div>
                <?php
            }
        ?>
        </div>
    </div>

</section>

