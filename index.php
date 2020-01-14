<?php include 'sections/session.php'; ?>

<?php
if(isset($_SESSION['user'])){
    header('location:  profile.php');
}
?>



<!DOCTYPE html>


<html>
<head>
    <title>Login Form in PHP with Session</title>
    <link href="cssfiles/index.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="modal.js"></script>
    <style>.alert-success {
            color: yellow;
            background-color: red;
            border-color: #c3e6cb;
        }</style>
</head>
    <script>
        var d,h,m,s,animate;

        function init(){
            d=new Date();
            h=d.getHours();
            m=d.getMinutes();
            s=d.getSeconds();
            clock();
        };

        function clock(){
            s++;
            if(s==60){
                s=0;
                m++;
                if(m==60){
                    m=0;
                    h++;
                    if(h==24){
                        h=0;
                    }
                }
            }
            $('sec',s);
            $('min',m);
            $('hr',h);
            animate=setTimeout(clock,1000);
        };

        function $(id,val){
            if(val<10){
                val='0'+val;
            }
            document.getElementById(id).innerHTML=val;


        };

        window.onload=init;

        $(document).ready(function(){
            $("login").click(function(){
                $("alert-success").show();
            });
        });</script>
</head>


<body>





<div class="login-form">
    <div class="form-header">
        <div class="user-logo">
            <img src="https://www.pngrepo.com/download/213506/boss-man.png" alt="User"/>
        </div>
        <div class="title">Login</div>

        <div class="title"> <div class="clock">   <span id="hr">00</span>
                <span> : </span>
                <span id="min">00</span>
                <span> : </span>
                <span id="sec">00</span>
            </div> </div>
    </div>


    <form action="verify.php" method="POST">
    <div class="form-container">

        <div class="form-element">
            <label class="fa fa-user" for="login-username"></label>
            <input  id="name" placeholder="Username" type="text" name="username" required minlength="3" maxlength="15" size="10">
        </div>

        <div class="form-element">
            <label class="fa fa-key" for="login-password"></label>
            <input  id="password" placeholder="Password" type="password" name="password" required>
        </div>


        <div class="form-element">
            <input name="login" type="submit" value="Login" class="login" >
        </div>

        <div class="alert-success" >
        <?php
        if(isset($_SESSION['error'])){
            echo "".$_SESSION['error']."";
            unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
            echo "".$_SESSION['success']."";
            unset($_SESSION['success']);
        }
        ?>

        </div>
    </form>


    <br>
    <br>

<!--    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal1">-->
<!--        Launch demo modal-->
<!--    </button>-->
<!---->
<!--     Modal -->
<!--    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
<!--        <div class="modal-dialog" role="document">-->
<!--            <div class="modal-content">-->
<!--                <div class="modal-header">-->
<!--                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>-->
<!--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                        <span aria-hidden="true">&times;</span>-->
<!--                    </button>-->
<!--                </div>-->
<!--                <div class="modal-body">-->
<!--                    ...-->
<!--                </div>-->
<!--                <div class="modal-footer">-->
<!--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
<!--                    <button type="button" class="btn btn-primary">Save changes</button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->




</body>


</html>






?>