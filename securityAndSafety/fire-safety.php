<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency-procedure</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!--Sa Boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Sa Boostrap-->
</head>
<body class="fire-safety">
<!-- Add css -->
<style>



</style>

<div class="emergency-procedure-body">
<div class="emergency-procedure-buttons">
    <button class='' data-file='securityAndSafety/emergency_procedure.php' onclick=' loadPHP(this);' >EVACUATION CENTER</button>
    <button class='' data-file='securityAndSafety/fire-safety.php' onclick=' loadPHP(this);' style='color: #666CAA;'>FIRE SAFETY</button>
  </div>

<!-- Only the container-wrapper will have a top margin -->
 <!-- Change mo na lng ung color ng background ng container  -->
<div class="container-wrapper">
<div class="container1">
    <div class="fire-exit">
        <h5>Fire Exit Plan</h5>
        <img src="images/fire-exit-plan.png" width="100%" height="90%" alt="">
    </div>
    <div class="fire-procedure">
        <h5>Fire Procedure</h5>
        <img src="images/emergency-procedure.gif" alt="" height="90%">
    </div>
</div>

    <div class="container2">
    <h5>Emergency Contacts</h5>

    <div class="contact-columns">
        <!-- Left Column -->
        <div class="left-column">
            <div class="contact-item">
                <img src="images/ph-red-cross.png" alt="">
                <h6>Philippine Red Cross 143</h6>
            </div>
            <div class="contact-item">
                <img src="images/pnp.png" alt="">
                <h6>Philippine National Police 911</h6>
            </div>
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <div class="contact-item">
                <img src="images/fire-protection.png" alt="">
                <h6>Bureau of Fire Protection 911</h6>
            </div>
            <div class="contact-item">
                <img src="images/doh.png" alt="">
                <h6>Department of Health 911</h6>
            </div>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
</body>
</html>