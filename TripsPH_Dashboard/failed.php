<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="assets/styles.css?v= <?php echo time(); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/1f1c0e3279.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="failed.css">
    <title>failed</title>
</head>
<style>
    body {
        height: auto;
        background-image: linear-gradient(red, orange);
        background-repeat: no-repeat;
        background-size: cover;

    }

    .card-body {
        border-radius: 20px;
        background-color: whitesmoke;
        padding-bottom: 30px;
    }

    .container {
        text-align: center;
    }


    p {
        font-size: 10px solid #23e323;
        text-align: center;

    }

    .amount p {
        font-size: 15px;
        text-align: left;
        margin-bottom: 20px;
    }

    h1 {
        text-align: center;
        margin-top: 10px;
        color: limegreen;
    }

    h1 {
        color: red;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-weight: 900;
        font-size: 40px;
        margin-bottom: 10px;
        text-align: center;
    }

    p {
        color: #404F5E;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-size: 20px;
        margin: 0;
    }

    .Triangle {
        color: darkred;
        font-size: 30px;
        padding-top: 20px;

    }

    .card {
        background: white;
        padding: 20px;

        border-radius: 20px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
    }


    .button {
        text-align: center;
        display: inline-block;
        font-size: 30px;
        cursor: pointer;
        transition-duration: 0.4s;
        transition-duration: 0.4s;


    }

    .button2:hover {
        box-shadow: 0 5px 5px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h1>Payment</h1>
                    <p>Oops! Something went wrong.</p>

                    <body>
                        <div class="card">
                            <div style="border-radius:100px; height:100px; width:100px; background: #F8FAF5; margin:0 auto;">
                                <div class="Triangle">
                                    <i class="fa-solid fa-triangle-exclamation fa-2xl"></i>
                                </div>
                            </div>
                            <h1>Failed</h1>
                            <p>Your payment process has an error!</p>
                            <p>Please Try Again!</p>
                        </div>

                </div>
            </div>
        </div>
    </div>
    <a href="./payment.php" class="btn btn-primary">Try again </a>
</div>

</div>

</html>