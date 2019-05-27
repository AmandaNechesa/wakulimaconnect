<?php

/**
 * Created by PhpStorm.
 * User: steve muema
 * Date: 9/21/2018
 * Time: 10:47 PM
 */
class dbconnector
{
    public $allowedfiles = array("image/jpg", "image/jpeg", "image/bmp", "image/gif", "image/png");
    public $conn;
    public $sitename = "  Wakulima Connect  ";

    function __construct()
    {
        session_start();
        define("SITE_NAME", "Our Website!");

        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=kenyafarmers", 'root', '');
        } catch (PDOException $e) {
            $_SESSION['error'] = "Database connection not successful";
            header("Location:index.php?" . $_SESSION['error']);
        }
        function queries($query, $items)
        {
            $res = $this->conn->prepare($query);
            $res->execute($items);
            return $res;
        }


    }

    function FarmerSignUp($name, $email, $phone, $location, $password, $passwordconf, $pathFrom)
    {
        $sql = "SELECT * FROM kenyafarmersusers WHERE email=?";
        $res = $this->conn->prepare($sql);
        $res->execute([$email]);
        if ($res->rowCount() > 0) {
            $_SESSION['error'] = "email is already used";
            header("Location:$pathFrom?" . $_SESSION['error']);
        } else {
            if ($password === $passwordconf) {
                $passenc = password_hash($password, PASSWORD_BCRYPT);
                $insert = "INSERT INTO kenyafarmersusers (name,email,phonenumber,location,password,hash)VALUES (?,?,?,?,?,?)";
                $result = $this->conn->prepare($insert);
                $result->execute([$name, $email, $phone, $location, $passenc, $passenc]);
                if ($result->rowCount() > 0) {
                    $message = "
            <html><head></head>
            <body>
            You have successfully created your account at" . $this->sitename . ". Click on this <a href='localhost/smallscalefarmers/post/activate.php?hash=$passenc'>link</a> to activate your account
              
</body></html>
            ";
                    $send = mail($email, "ACTIVATE ACCOUNT", $message);
                    if ($send) {
                        $_SESSION['message'] = "account created.Activate!!";
                        header("Location:$pathFrom?" . $_SESSION['message']);
                    } else {
                        $_SESSION['error'] = "message not sent.Contact the admin";
                        header("Location:$pathFrom?" . $_SESSION['error']);
                    }

                }
            } else {
                $_SESSION['error'] = "passwords do not match";
                header("Location:$pathFrom?" . $_SESSION['error']);
            }
        }
    }

    function FarmerLogin($email, $password, $remember, $pathFrom)
    {
        $sql = "SELECT * FROM kenyafarmersusers WHERE email=? AND activated=?";
        $res = $this->conn->prepare($sql);
        $res->execute([$email, TRUE]);
        $encpassword = $res->fetch(PDO::FETCH_OBJ);
        $_SESSION["adm id"] = $encpassword->id;
        if ($res->rowCount() > 0) {
            if (password_verify($password, $encpassword->password)) {
                if (isset($remember)) {
                    setcookie('shopit', $encpassword->password, time() + 60 * 60 * 24 * 70);
                }
                if ($encpassword->admin == true) {
                    $_SESSION['admin'] = "true";

                }
                $_SESSION['shopit'] = $email;
                $_SESSION['message'] = "Login successful";
                header("Location:panel.php?" . $_SESSION['message']);
            } else {
                $_SESSION['error'] = "Enter the correct password";
                header("Location:$pathFrom?" . $_SESSION['error']);
            }
        } else {
            $_SESSION['error'] = "Such an activated user does not exist!!";
            header("Location:$pathFrom?" . $_SESSION['error']);
        }

    }

    function AccountActivate($hash, $redirectToPage)
    {
        $sql = "UPDATE kenyafarmersusers SET activated=? WHERE hash=?";
        $res = $this->conn->prepare($sql);
        $res->execute([TRUE, $hash]);
        if ($res->rowCount() > 0) {
            $_SESSION['message'] = 'activation was successful';
            header("Location:$redirectToPage?" . $_SESSION['message']);
        } else {
            $_SESSION['error'] = 'activation was not successful';
            header("Location:$redirectToPage?" . $_SESSION['error']);
        }
    }

    function basicQueryret($query, Array $values)
    {
        $res = $this->conn->prepare($query);
        $res->execute($values);
        return $res;
    }
//
//    function newposts()
//    {
//        $affected = $this->newpost();
//        if ($affected > 0) {
//            $_SESSION['message'] = "post successful";
//            header("Location:panel.php?" . $_SESSION['message']);
//        } else {
//            $_SESSION['error'] = "post not successful";
//            header("Location:panel.php?" . $_SESSION['error']);
//        }
//    }

    function newpost()
    {
        $allowedfiles = array("image/jpg", "image/jpeg", "image/bmp", "image/gif", "image/png", 'image/*');
        if (in_array($_FILES['avatar-file']['type'], $allowedfiles)) {
            if ($_FILES['avatar-file']['size'] < 8000000000) {
                $img = "uploadedinfo/" . time() . $_FILES["avatar-file"]["name"];
                move_uploaded_file($_FILES['avatar-file']['tmp_name'], $img);
                $sql = "INSERT INTO kenyafarmersitems(pic,name,quantity,uploaderid,categoryid,price,location)VALUES(?,?,?,?,?,?,?)";
                $rowsAffected = $this->basicQuery($sql, [$img, strtoupper($_POST['name']), $_POST['quantity'], $_SESSION['adm id'], $_POST['category'], $_POST['price'], $_POST['location']]);
                if ($rowsAffected > 0) {
                    header("Location:panel.php?upload successful");

                }
            } else {
                $_SESSION['error'] = "file size is too big";
                header("Location:panel.php?" . $_SESSION['error']);
            }
        } else {
            $_SESSION['error'] = "file type not supported";
            header("Location:panel.php?" . $_SESSION['error']);
        }


    }

//todo continue with posting

    function basicQuery($query, Array $values)
    {
        $res = $this->conn->prepare($query);
        $res->execute($values);
        return $res->rowCount();
    }

    function fetchemall()
    {
        $sql = "SELECT * FROM kenyafarmersitems WHERE uploaderid=" . $_SESSION['adm id'];
        $res = $this->conn->query($sql);
        return $res;
    }

    function fetchProducts()
    {
        $sql = "SELECT * FROM kenyafarmersitems ";
        $res = $this->conn->query($sql);
        return $res;
    }

    function fetchSpecificProducts($factor)
    {
        $sql = "SELECT * FROM kenyafarmersitems where categoryid=$factor";
        $res = $this->conn->query($sql);
        return $res;
    }

    function actionOnPosts($id)
    {
        $sql = "DELETE FROM kenyafarmersitems WHERE id='$id'";
        $sq = "SELECT * FROM kenyafarmersitems WHERE id=?";
        $result = $this->conn->prepare($sq);
        $result->execute([$id]);
        $row = $result->fetch(PDO::FETCH_OBJ);
        if (unlink($row->pic)) {
            $res = $this->conn->exec($sql);
            if ($res > 0) {

                $_SESSION["message"] = "deleted successfully  item " . $_GET["id"];
                header("Location:panel.php?" . $_SESSION['message']);
            } else {
                $_SESSION["error"] = " item  " . $_GET["id"] . " was not deleted  from database ";
                header("Location:panel.php?" . $_SESSION['error']);
            }
        } else {
            $_SESSION["error"] = " item " . $_GET["id"] . "was not deleted from file system ";
            header("Location:panel.php?" . $_SESSION['error']);
        }

    }


}

$connection = new dbconnector();

