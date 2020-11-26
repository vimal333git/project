<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <script>
            $(document).ready(function () {
                $(document).on('click','.submit',function () {
                    var username=$('#username').val();
                    var password=$('#password').val();
                    if(!((username=='studentportal') && (password=='pass123'))){
                        $('#username').effect('shake').val('').focus();
                        $('#password').effect('shake').val('')
                        return false;
                    }else {
                     alert('Keep the internet connection always');
                    }
                })
            })
    </script>


</head>
<body style="background-color: whitesmoke">
<div class="container-fluid">

    <div style="width: 50%;float: left;height: auto">
        <img src="pic.jpg" style="width: 100%;">
    </div>

    <div class="container" style="width: 50%;float: right">

        <h4 style="text-align: center;margin: 10%;color: cornflowerblue" class="heading">WELCOME to Student portal ...</h4>

        <form class="form-signin" style="margin-left: 25%" method="post" action="students_test.php">
            <h3 class=" mb-3 font-weight-normal" style="color: cornflowerblue">Please login</h3>
            <div class="form-group">
                <label for="username" style="color: cornflowerblue">USERNAME : <input type="text" style="margin-top: 3%" id="username" class="form-control form-check-inline student_username" placeholder="  Student username" autofocus required></label><span style="color: limegreen;margin-left: 2%">studentportal</span>
            </div>
            <div class="form-group">
                <label for="password" style="color: cornflowerblue">PASSWORD :  <input type="password" style="margin-top: 3%" id="password" class="form-control form-check-inline student_password" placeholder="   password" required></label><span style="color: limegreen;margin-left: 2%">pass123</span>
            </div>

            <button type="submit" class="btn btn-primary submit">Submit</button>
        </form>
    </div>

</div>

</body>
</html>