<nav id="navigation">
            <span id="logo_container">
               <div id="logo_name">We Care.</div>
            </span>
            <?php
                error_reporting(E_ERROR | E_PARSE);
                session_start();
                if(isset($_SESSION['customer'])){
                    ?>
                   <a href="user-dashboard.php"><span class="nav_link"><span id="get_dashboard">Dashboard</span></span></a>
                    <?php
                }
                elseif(isset($_SESSION['username'])){
                    ?>
                    <a href="user.php"><span class="nav_link"><span id="get_dash">Dashboard</span></span></a>
                    <?php
                }
                elseif(isset($_SESSION['admin'])){
                    ?>
                    <a href="admin-dash.php"><span class="nav_link"><span id="get_dash">Admin</span></span></a>
                    <?php
                }
                else{
                    ?>
                    <a href="loginselection.php"><span class="nav_link"><span id="get_login">Login</span></span></a>
                    <?php
                }
            ?>
            <span class="nav_link"><span id="get_doctor">Doctor</span></span>
            <span class="nav_link"><span id="get_disease">Disease</span></span>
            <span class="nav_link"><span id="get_medicine">Medicine</span></span>
            <span class="nav_link"><span id="get_hospital">Hospital</span></span>
            <span class="nav_link"><span id="get_covid">COVID-19</span></span>
            <span id="menu_container"><img id="menu" src="menu.svg"></span>
</nav>
<div id="mobile_menu">
        <div ><a id="get_login" href="loginselection.php">LOGIN</a></div>
        <div ><a id="get_doc" href="doctor.php?name=">DOCTOR</a></div>
        <div ><a id="get_dis" href="disease.php">DISEASE</a></div>
        <div ><a id="get_med" href="medicine.php">MEDICINE</a></div>
        <div ><a id="get_hos" href="hospital.php">HOSPITAL</a></div>
        <div ><a id="get_covid" href="covid.php">COVID-19</a></div>
    </div>
<script>
    document.getElementById('get_hospital').addEventListener('click',function() {
        window.location.assign('hospital.php');
    });
    document.getElementById('logo_name').addEventListener('click',function() {
        window.location.assign('index.php');
    });
    document.getElementById('get_disease').addEventListener('click',function() {
        window.location.assign('disease.php');
    });
    document.getElementById('get_covid').addEventListener('click',function() {
        window.location.assign('covid.php');
    });
    document.getElementById('get_medicine').addEventListener('click',function() {
        window.location.assign('medicine.php');
    });
    document.getElementById('get_doctor').addEventListener('click',function() {
        window.location.assign('doctor.php?name=');
    });
    document.getElementById('menu_container').addEventListener("click",function(){
                if(document.getElementById('mobile_menu').style.display=="none"){
                    document.getElementById('mobile_menu').style.display="grid";
                }
                else{
                    document.getElementById('mobile_menu').style.display="none";
                }
            });
    var count=0;
</script>
