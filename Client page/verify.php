
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
            $con->beginTransaction();
            
            if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){

                // Verify data 
                $email = $_GET['email']; // Set email variable 
                $hash = $_GET['hash']; // Set hash variable
                $apid = $_GET['apid']; // Set hash variable

        
                
                $stmt_verif = $con->prepare("Select client_id, first_name,last_name,phone_number,active,client_email,hash,active from clients where client_email = ? and hash = ?");
                $stmt_verif->execute(array($email,$hash));
                $row_verif = $stmt_verif->fetch();
                $count = $stmt_verif->rowCount();

                if($count > 0){
                    
                    if ($row_verif['active']==0){
                        $stmt = $con->prepare("UPDATE clients SeT active=? where client_email = ?");
                        $stmt->execute(array(1,$email));
                        $message='Your email has been validated, in the future this step will no longer be required. Thanks for trusting us !';

                        // check appointment availibility
                        $stmt_apt_inf = $con->prepare("Select date_created, client_id,employee_id,start_time,end_time_expected from appointments where appointment_id = ?");
                        $stmt_apt_inf->execute(array($apid));
                        $pre_apt_val = $stmt_apt_inf->fetch();
                        $count_pre_apt =$stmt_apt_inf->rowCount();

                        if ($count_pre_apt>0){


                            $stmt_check_apt = $con->prepare("Select * from appointments where date(start_time) = date(?) and employee_id = ? and canceled = 0 and ((time(start_time) >= time(?) and time(start_time) < time(?)) or (time(end_time_expected) > time(?) and time(end_time_expected) <= time(?)))");
                            $stmt_check_apt->execute(array($pre_apt_val['start_time'],$pre_apt_val['employee_id'],$pre_apt_val['start_time'],$pre_apt_val['end_time_expected'],$pre_apt_val['start_time'],$pre_apt_val['end_time_expected']));
                            $other_apt=$stmt_check_apt->fetchAll();
                            $count2 = $stmt_check_apt->rowCount();

                            if ($count2==0){
                                $stage=0;
                                // book appointment
                                $update_apt = $con->prepare("UPDATE appointments SET cancellation_reason = ?,canceled= ? WHERE appointment_id= ?");
                                $update_apt->execute([NULL,0,$apid]);  
                                $message=$message.' Also, your appointment has been confirmed, thank you for chosing BarberSHop ! You will receive an email with the details of your booking soon';      

                                $stmtname = $con->prepare('select first_name, last_name from employees where employee_id = ?');
                                $stmtname->execute(array($pre_apt_val['employee_id']));
                                $getname= $stmtname->fetch(); 

                                $getnamefirst=$getname['first_name'];

                                //send email

                                $to      = $email;
                                $subject = 'Appointment with BarberShop';
                                $message2 = 'Thank you for booking an appointment with us. 

    Your appointment is on the: '.$pre_apt_val['start_time'].'
    With: '.$getnamefirst.'
    We advise you to arrive 5 minutes earlier so that we can take care of you as soon as possible

    You can also cancel your appointment by clicking on the following link:
    http://localhost:8080/BarbershopWebsite/cancel.php?email='.$email.'&hash='.$hash.'&apid='.$apid.'';

                                $headers = 'From:noreply@BarbershopWebsite.com'; // Set from headers

                                mail($to, $subject, $message2, $headers);
                                
                            }
                            else{
                                $stage=3;
                                $apt_del = $con->prepare("delete from appointments where appointment_id = ?");
                                $apt_del->execute(array($apid));
                                $message1='However, we could not book your appointment, someone else booked this time window before we could verify your email. Please accpet our appologies. Note that you will not have to verify your email anymore.';  

                            }
                        }
                        else{
                            $stage=2;
                            $message='No appointment corresponding to the informations has been booked.';
                        }

                    }
                        
                    else {
                        $stage=1;
                        $message='Your email has already been validated, you can book an appointment without further verification';
                    }
                }
                else{
                    $stage=2;
                    $message='No match has been foud. Please make sure that the email you entered when booking your appointment is valid.';
                }

            }
            else{
                $stage=2;
                $message='Link not valid';
            };
            $con->commit();
            //$stmtCheckClient = $con->prepare("SELECT * FROM clients WHERE client_email = ?");
            //$stmtCheckClient->execute(array($username,$hashedPass));
            //$row_verif = $stmtCheckClient->fetch();
        ?>
        <div class="verification_div" id="verification_div">
            <?php
                if($stage==0){
                    ?>
                    <div class="update_made">
                        <div class="text_header">
                            <span>
                                Email validated
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
                    <div class="already_active">
                        <div class="text_header">
                            <span>
                                Email already activated
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
                if($stage==2){
                    ?>
                    <div class="no_match_found">
                        <div class="text_header">
                            <span>
                                Email not validated
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
                if($stage==3){
                    ?>
                    <div class="update_made">
                        <div class="text_header">
                            <span>
                                Email validated
                            </span>
                        </div>
                        <div class="text_answer">   
                            <?php echo $message; ?>                             
                        </div>
                    </div>
                    <div class="no_match_found">
                        <div class="text_header">
                            <span>
                                Appointment not processed
                            </span>
                        </div>
                        <div class="text_answer">   
                            <?php echo $message1; ?>                             
                        </div>
                    </div>
                    <?php
                }
            ?>
            

        </div>

    </div>
</section>
