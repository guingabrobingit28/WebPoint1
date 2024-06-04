<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("./php/connection.php");
include("functions.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$user_data = null;
$logged_in = isset($_SESSION['User_id']);

if ($logged_in) {
    $user_data = check_login($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/txtReadexPro.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/fontawesome-free-6.1.1-web/fontawesome-free-6.1.1-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="css/css1/bootstrap.min.css">
    <link rel="stylesheet" href="css/admstyles.css">
    <title>Maintenance</title>
    <link href="./fullcalendar-5.11.4/lib/main.css" rel="stylesheet">
    
<script src="./fullcalendar-5.11.4/lib/main.js"></script>
<script src="./node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>


</head>
<body>
<div class="container-fluid position-relative d-flex p-0">
    <!--side bar section-->
    <div class="sidebar pe-4 pb-3">
        <nav class="navbar sidebarGraColor navbar-dark">
            <a href="dashboard.php" class="navbar-brand mx-4 mb-3">
                <img src="icon/webpoint.png" width="175">
            </a>
            <div class="d-flex align-items-center ms-4 mb-4">
                <div class="position-relative">
                    <img class="rounded-circle" src="miguel mangulabnan.jpg" alt="" style="width: 40px; height: 40px;">
                </div>
                <div class="ms-3">
                    <h6 class="mb-0"><?php echo $logged_in ? $user_data['Username'] : '';?></h6>
                    <span>Cashier</span>
                </div>
            </div>
            <div class="navbar-nav w-100">
                <a href="dashboard.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-item nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Transactions</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="POS.php" class="dropdown-item"><b>POS</b></a>
                            <a href="#" class="dropdown-item"><b>History</b></a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-item nav-link dropdown-toggle" data-bs-toggle="dropdown"><img src="icon/repairing-service.png" width="35" class="imageInverter">&emsp;Services</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="schedCalendar.php" class="dropdown-item"><b>Active Appointments</b></a>
                            <a href="addAppointment.php" class="dropdown-item"><b>Scheduling</b></a>
                            
                        </div>
                    </div> 
            </div>
        </nav>
    </div>
    
    <div class="content">
        <!--Nav bar Section-->
        <nav class="navbar navbar-expand navGraColor navbar-dark sticky-top px-4 py-0">
            <a href="dashboard.php" class="navbar-brand d-flex d-lg-none me-4">
                <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
            </a>
            <a href="#" class="sidebar-toggler flex-shrink-0">
                <i class="fa fa-bars"></i>
            </a>
            <div class="navbar-nav align-items-center ms-auto">

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fa fa-bell me-lg-2"></i>
                        <span class="d-none d-lg-inline-flex">Notification</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end sidebarGraColor border-0 rounded-0 rounded-bottom m-0">
                        <a href="#" class="dropdown-item">
                            <h6 class="fw-normal mb-0">Profile updated</h6>
                            <small>15 minutes ago</small>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">
                            <h6 class="fw-normal mb-0">New user added</h6>
                            <small>15 minutes ago</small>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">
                            <h6 class="fw-normal mb-0">Password changed</h6>
                            <small>15 minutes ago</small>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item text-center">See all notifications</a>
                    </div>
                </div>
                <!--nav Admin section-->
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img class="rounded-circle me-lg-2" src="miguel mangulabnan.jpg" alt="" style="width: 40px; height: 40px;">
                        <span class="d-none d-lg-inline-flex"><?php echo $logged_in ? $user_data['Username'] : '';?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end sidebarGraColor border-0 rounded-0 rounded-bottom m-0">
                        <a href="#" class="dropdown-item">My Profile</a>
                        <a href="#" class="dropdown-item">Settings</a>
                        <a href="#" id="logout-link" class="dropdown-item">Log Out</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid pt-0 px-4">
            <div class="row vh-120 sidebarGraColor rounded align-items-center justify-content-between mx-0">
                <div class="container">
                    <div class="wrapper">
                        <div id="calendar">

                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        var calendarElement = document.getElementById('calendar');
        
        var prevSelectedEventEl = null;

        var calendar = new FullCalendar.Calendar(calendarElement,{
            headerToolbar:{
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay,listWeek'
            },
            dayMaxEvents: true,
            // initialView: 'dayGridMonth',
            height: 650,
            events: './php/calendarEvents.php',

            eventClick:function(info){
                info.jsEvent.preventDefault();

                if (prevSelectedEventEl) {
                    prevSelectedEventEl.style.borderColor = '';
                }

                // Apply border color to currently selected event
                info.el.style.borderColor = 'red';
                prevSelectedEventEl = info.el;

                let servicesHtml = '';
                let services = info.event.extendedProps.customer.split(',');
                for(let i = 0; i < services.length; i++){
                    // servicesHtml += '<p>' + services[i].trim() + '</p>';
                    // if(i < services.length -1) {
                    //     servicesHtml += ', ';
                    // }
                    servicesHtml += services[i] + ', ';
                }
                servicesHtml = servicesHtml.slice(0, -2);
                Swal.fire({
                    title: info.event.title,
                    icon: 'info',
                    html: '<p>'+info.event.extendedProps.time+'</p><b>Services:</b>' + servicesHtml
                });
            }
        });

        calendar.render();
    });
</script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="admjs.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>logOut();</script>
</body>

</html>