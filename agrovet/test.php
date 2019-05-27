<html>
<head>
    <style>
        #gear1, #gear2, #gear3 {
            color: #888;
            display: block;
            float: left;
            position: absolute;
        }

        #gear1 {
            top: 25px;
            left: 55px;
        }

        #gear2 {
            left: 61px;
        }

        #gear3 {
            top: 25px;
            left: 70px;
        }

        .spin {
            -webkit-animation: spin 4s linear infinite;
            -moz-animation: spin 4s linear infinite;
            animation: spin 4s linear infinite;
        }

        .spin-back {
            -webkit-animation: spin-back 4s linear infinite;
            -moz-animation: spin-back 4s linear infinite;
            animation: spin-back 4s linear infinite;
        }

        @-moz-keyframes spin {
            100% {
                -moz-transform: rotate(360deg);
            }
        }

        @-webkit-keyframes spin {
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-moz-keyframes spin-back {
            100% {
                -moz-transform: rotate(-360deg);
            }
        }

        @-webkit-keyframes spin-back {
            100% {
                -webkit-transform: rotate(-360deg);
            }
        }

        @keyframes spin-back {
            100% {
                -webkit-transform: rotate(-360deg);
                transform: rotate(-360deg);
            }
        }
    </style>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


</head>
<body>
<a href="#"><i id="gear1" class="fa fa-5x fa-gear spin" style='font-size:20px;'></i>
    <i id="gear2" class="fa fa-5x fa-gear spin-back" style='font-size:20px;'></i>
    <i id="gear3" class="fa fa-5x fa-gear spin" style='font-size:20px;'></i></a>
</body>
</html>
//cart
if (isset($_GET['id'])){
$sql="SELECT * FROM shopititems WHERE id=".$_GET['id'];
$results=$connection->conn->query($sql);
}
if(isset($_GET['category'])){
$sql="SELECT * FROM shopititems WHERE categoryid=".$_GET['category'];
$results=$connection->conn->query($sql);
}