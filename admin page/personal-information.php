<?php 
	session_start();

	//Check If user is already logged in
	if(isset($_SESSION['username_barbershop_Xw211qAAsq4']) && isset($_SESSION['password_barbershop_Xw211qAAsq4']))
	{
        //Page Title
        $pageTitle = 'Dashboard';

        //Includes
        include 'connect.php';
        include 'Includes/functions/functions.php'; 
        include 'Includes/templates/header.php';

        

?>
    <link rel="stylesheet" href="Design/css/profile.css">
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8 mx-auto">
            <h2 class="h3 mb-4 page-title">Profile</h2>
            <div class="my-4">
                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Profile</a>
                    </li>
                </ul>
                
                <form method="POST" onsubmit="setTimeout(function(){window.location.reload();},10);">                   
                    <?php 
                        
                        $stmt = $con->prepare('select * from barber_admin where username = ?');
                        $stmt->execute(array($_SESSION['username_barbershop_Xw211qAAsq4']));
                        $admin = $stmt->fetchAll();  
                        
                    ?>
                    <div class="row mt-5 align-items-center">
                        <div class="col-md-3 text-center mb-5">
                            <div class="avatar avatar-xl">
                                <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="..." class="avatar-img rounded-circle" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    
                                    <h4 class="mb-1"><?php echo $admin[0]['full_name'] ?></h4>
                                    <p class="small mb-3"><span class="badge badge-dark">New York, USA</span></p>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-7">
                                    <p class="text-muted">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit nisl ullamcorper, rutrum metus in, congue lectus. In hac habitasse platea dictumst. Cras urna quam, malesuada vitae risus at,
                                        pretium blandit sapien.
                                    </p>
                                </div>
                                <div class="col">
                                    <p class="small mb-0 text-muted">Nec Urna Suscipit Ltd</p>
                                    <p class="small mb-0 text-muted">P.O. Box 464, 5975 Eget Avenue</p>
                                    <p class="small mb-0 text-muted">(537) 315-1481</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4" />
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="<?php echo $admin[0]['full_name'] ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail4">Email</label>
                        <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="<?php echo $admin[0]['email'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="inputAddress5">Address</label>
                        <input type="text" class="form-control" id="inputAddress5" placeholder="P.O. Box 464, 5975 Eget Avenue" />
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCompany5">Company</label>
                            <input type="text" class="form-control" id="inputCompany5" placeholder="Nec Urna Suscipit Ltd" />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState5">State</label>
                            <select id="inputState5" class="form-control">
                                <option selected="">Choose...</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZip5">Zip</label>
                            <input type="text" class="form-control" id="inputZip5" placeholder="98232" />
                        </div>
                    </div>
                    <hr class="my-4" />
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPassword4">Old Password</label>
                                <input type="password" name="password" class="form-control" id="inputPassword4" />
                            </div>
                            <div class="form-group">
                                <label for="inputPassword5">New Password</label>
                                <input type="password" name="new_password" class="form-control" id="inputPassword5" />
                            </div>
                            <div class="form-group">
                                <label for="inputPassword6">Confirm Password</label>
                                <input type="password" name=confirm_password class="form-control" id="inputPassword6" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">Password requirements</p>
                            <p class="small text-muted mb-2">To create a new password, we advise you to meet all of the following requirements:</p>
                            <ul class="small text-muted pl-4 mb-0">
                                <li>Minimum 8 character</li>
                                <li>At least one special character</li>
                                <li>At least one number</li>
                                <li>Can’t be the same as a previous password</li>
                            </ul>
                        </div>
                    </div>
                    <button type="submit" name="save-button3" class="btn btn-primary">Save Change</button>
                 
                </form>
            </div>
            <div class="my-4">
            
                <?php
                    if(isset($_POST['save-button3']))
                    {

                        $stmt2 = $con->prepare('select * from barber_admin where username = ?');
                        $stmt2->execute(array($_SESSION['username_barbershop_Xw211qAAsq4']));
                        $admin2 = $stmt2->fetchAll();  

                        $username = $admin2[0]['username'];
                        $password = $admin2[0]['password'];
                        $password_check = test_input($_POST['password']);
                        $new_password = test_input($_POST['new_password']);
                        $confirm_password = test_input($_POST['confirm_password']);
                        $hashedPass = sha1($password_check);

                        //Check if User Exist In database

                        $stmt_verif = $con->prepare("Select admin_id, username,email,full_name,password from barber_admin where username = ? and password = ?");
                        $stmt_verif->execute(array($username,$hashedPass));
                        $row_verif = $stmt_verif->fetch();
                        $count = $stmt_verif->rowCount();



                    // Check if count > 0 which mean that the database contain a record about this username

                        if($count > 0)
                        {

                            if($new_password!=$password)
                            {
                                if($confirm_password==$new_password)
                                {
                                    $stmt_del = $con->prepare("delete from barber_admin where username = ?");
                                    $stmt_del->execute(array($username));

                                    $hassed_new=sha1($new_password);
                                    $email = $_POST['email'];
                                    if(empty($email))
                                    {
                                        $email=$row_verif['email'];
                                    }
                                    else
                                    {
                                        $email = $_POST['email'];
                                    }

                                    $name = $_POST['name'];
                                    if(empty($name))
                                    {
                                        $name=$row_verif['full_name'];
                                    }
                                    else
                                    {
                                        $name = $_POST['name'];
                                    }

                                    $stmt = $con->prepare("insert into barber_Admin(admin_id,username,email,full_name,password) values(?, ?, ?, ?, ?)");
                                    $stmt->execute(array($row_verif['admin_id'],$username,$email,$name,$hassed_new));
                                    
                                    $message = "You have successfully updated employee schedule!";
                                    ?>

                                        <div class="alert alert-success">
                                            <button data-dismiss="alert" class="close close-sm" type="button">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <div class="messages">
                                                <div>Password successfuly updated</div>
                                            </div>
                                        </div>

                                    <?php
                                    
                                    
                                }
                                else
                                {
                                    ?>

                                    <div class="alert alert-danger">
                                        <button data-dismiss="alert" class="close close-sm" type="button">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <div class="messages">
                                            <div>Incorrect confirm password</div>
                                        </div>
                                    </div>

                                    <?php
                                }

                            }
                            else
                            {
                                ?>

                                <div class="alert alert-danger">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <div class="messages">
                                        <div>Choose a different password!</div>
                                    </div>
                                </div>

                                <?php

                            }
                        }
                        else
                        {
                            ?>

                            <div class="alert alert-danger">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <div class="messages">
                                    <div>Incorrect password!</div>
                                </div>
                            </div>

                            <?php
                        }
                        
                    }
                    

                ?>
            </div>
        </div>
    </div>

    </div>


<?php
        
		//Include Footer
		include 'Includes/templates/footer.php';
	}
	else
    {
    	header('Location: login.php');
        exit();
    }

?>