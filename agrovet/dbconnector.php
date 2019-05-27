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
    public $sitename = "Wakulima connect";

    function __construct()
    {
        session_start();
        define("SITE_NAME", "Our Website!");

        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=kenyafarmers", 'root', '');
        } catch (PDOException $e) {
            $_SESSION['error'] = "Database connection not successful";
            header("Location:index.php");
        }
        function queries($query, $items)
        {
            $res = $this->conn->prepare($query);
            $res->execute($items);
            return $res;
        }


    }

    function AdminSignUp($name, $email, $password, $passwordconf, $pathFrom)
    {
        $sql = "SELECT * FROM wakulimaconnectagrovetadmins WHERE email=?";
        $res = $this->conn->prepare($sql);
        $res->execute([$email]);
        if ($res->rowCount() > 0) {
            $_SESSION['error'] = "email is already used";
            header("Location:$pathFrom?" . $_SESSION['error']);
        } else {
            if ($password === $passwordconf) {
                $passenc = password_hash($password, PASSWORD_BCRYPT);
                $insert = "INSERT INTO wakulimaconnectagrovetadmins (name,email,password,hash)VALUES (?,?,?,?)";
                $result = $this->conn->prepare($insert);
                $result->execute([$name, $email, $passenc, $passenc]);
                if ($result->rowCount() > 0) {
                    $message = "
            <html><head></head>
            <body>
            You have successfully created your account at" . $this->sitename . ". Click on this <a href='localhost/e-commerce/admins/activate.php?hash=$passenc'>link</a> to activate your account
              
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

    function adminLogin($email, $password, $remember, $pathFrom)
    {
        $sql = "SELECT * FROM wakulimaconnectagrovetadmins WHERE email=? AND activated=?";
        $res = $this->conn->prepare($sql);
        $res->execute([$email, TRUE]);
        $encpassword = $res->fetch(PDO::FETCH_OBJ);
        $_SESSION["adm id"] = $encpassword->id;
        if ($res->rowCount() > 0) {
            if (password_verify($password, $encpassword->password)) {
                if (isset($remember)) {
                    setcookie('wakulimaconnectagrovet', $encpassword->password, time() + 60 * 60 * 24 * 70);
                }
                if (!empty($encpassword->admin)) {
                    $_SESSION['sudo'] = true;
                }
                $_SESSION['wakulimaconnectagrovet'] = $email;
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

//customers
    function CustomerSignUp($name, $email, $password, $passwordconf, $pathFrom, $address)
    {
        $sql = "SELECT * FROM wakulimaconnectagrovetcustomers WHERE email=?";
        $res = $this->conn->prepare($sql);
        $res->execute($email);
        if ($res->rowCount() > 0) {
            $_SESSION['error'] = "email is already used";
            header("Location:$pathFrom?" . $_SESSION['error']);
        } else {
            if ($password === $passwordconf) {
                $passenc = password_hash($password, PASSWORD_BCRYPT);
                $insert = "INSERT INTO wakulimaconnectagrovetcustomers (name,email,password,hash,address)VALUES (?,?,?,?,?)";
                $result = $this->conn->prepare($insert);
                $result->execute([$name, $email, $passenc, $passenc, $address]);
                if ($result->rowCount() > 0) {
                    $message = "
            <html><head></head>
            <body>
            You have successfully created your account at" . $this->sitename . ". Click on this <a href='localhost/e-commerce/activate.php?hash=$passenc'>link</a> to activate your account
              
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

    function CustomerLogin($email, $password, $remember, $pathFrom)
    {
        $sql = "SELECT * FROM wakulimaconnectagrovetcustomers WHERE email=? AND activated=?";
        $res = $this->conn->prepare($sql);
        $res->execute([$email, TRUE]);
        $encpassword = $res->fetch(PDO::FETCH_OBJ);
        if ($res->rowCount() > 0) {
            if (password_verify($password, $encpassword->password)) {
                if (isset($remember)) {
                    setcookie('wakulimaconnectagrovetcustomer', $encpassword->password, time() + 60 * 60 * 24 * 70);
                }
                $usr = $_SESSION['wakulimaconnectagrovetcustomer'];
                $_SESSION['wakulimaconnectagrovetcustomer'] = $email;
                $_SESSION['message'] = "Login successful";
                header("Location:index.php?" . $_SESSION['message']);
            } else {
                $_SESSION['error'] = "Enter the correct password";
                header("Location:$pathFrom?" . $_SESSION['error']);
            }
        } else {
            $_SESSION['error'] = "Such an activated user does not exist!!";
            header("Location:$pathFrom?" . $_SESSION['error']);
        }

    }

    function AccountActivate($table, $hash, $redirectToPage)
    {
        $sql = "UPDATE $table set activated=? where hash=?";
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

    function newposts()
    {
        $affected = $this->newpost();
        if ($affected > 0) {
            $_SESSION['message'] = "post successful";
            header("Location:panel.php?" . $_SESSION['message']);
        } else {
            $_SESSION['error'] = "post not successful";
            header("Location:panel.php?" . $_SESSION['error']);
        }
    }

    /**
     * @return int
     * make post
     */

    function newpost()
    {
        $allowedfiles = array("image/jpg", "image/jpeg", "image/bmp", "image/gif", "image/png");
        if (in_array($_FILES['avatar-file']['type'], $allowedfiles)) {
            if ($_FILES['avatar-file']['size'] < 8000000) {
                $img = "uploadedinfo/" . time() . $_FILES["avatar-file"]["name"];
                move_uploaded_file($_FILES['avatar-file']['tmp_name'], $img);
                $sql = "INSERT INTO wakulimaconnectagrovetitems(pic,name,discount,Uploader,categoryid,price,`description`,`identifier`)VALUES(?,?,?,?,?,?,?,?)";
//                $identifier = password_hash($_SESSION['adm id'] . time(), PASSWORD_BCRYPT);
//                $rowsAffected = $this->basicQuery($sql, [$img, strtoupper($_POST['name']), $_POST['discount'], $_SESSION['adm id'], $_POST['category'], $_POST['price'], $_POST['description'], $identifier]);
                $identifier = password_hash($_SESSION['adm id'] . time(), PASSWORD_BCRYPT);
                $rowsAffected = $this->basicQuery($sql, [$img, $_POST['name'], $_POST['discount'], $_SESSION['adm id'], $_POST['category'], $_POST['price'], $_POST['description'], $identifier]);
                return $rowsAffected;
            } else {
                $_SESSION['error'] = "file size is too big";
                header("Location:panel.php?" . $_SESSION['error']);
            }
        } else {
            $_SESSION['error'] = "file type not supported";
            header("Location:panel.php?" . $_SESSION['error']);
        }


    }

    function basicQuery($query, Array $values)
    {
        $res = $this->conn->prepare($query);
        $res->execute($values);
        return $res->rowCount();
    }

    function fetchemall()
    {
        $sql = "SELECT * FROM wakulimaconnectagrovetitems WHERE Uploader=" . $_SESSION['adm id'];
        $res = $this->conn->query($sql);
        return $res;
    }

    function fetchProducts()
    {
        $sql = "SELECT * FROM wakulimaconnectagrovetitems ";
        $res = $this->conn->query($sql);
        return $res;
    }

    function fetchSpecificProducts($factor)
    {
        $sql = "SELECT * FROM wakulimaconnectagrovetitems where categoryid=$factor";
        $res = $this->conn->query($sql);
        return $res;
    }

    function actionOnPosts($id)
    {
        $sql = "DELETE FROM wakulimaconnectagrovetitems WHERE identifier='$id'";
        $sq = "SELECT * FROM wakulimaconnectagrovetitems WHERE identifier=?";
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

    function sudoer()
    {
        $allowedfiles = array("image/jpg", "image/jpeg", "image/bmp", "image/gif", "image/png");
        if (in_array($_FILES['file']['type'], $allowedfiles)) {
            if ($_FILES['file']['size'] < 8000000) {
                $img = "../sudo/categories/" . time() . $_FILES["file"]["name"];
                move_uploaded_file($_FILES['file']['tmp_name'], $img);
                $res = $this->conn->prepare("INSERT INTO wakulimaconnectagrovetcategories(name,pic)VALUES (?,?)");
                $res->execute([$_POST['name'], $img]);
                if ($res->rowCount() > 0) {
                    $_SESSION['error'] = "successful";

                    header("Location:index.php?" . $_SESSION['error']);
                } else {
                    $_SESSION['error'] = "successful";

                    header("Location:index.php?" . $_SESSION['error']);
                }

            } else {
                $_SESSION['error'] = "file size is too big";
                header("Location:index.php?" . $_SESSION['error']);
            }
        } else {
            $_SESSION['error'] = "file type not supported";
            header("Location:index.php?" . $_SESSION['error']);
        }
    }

    //cart

    function runQuery($query, Array $values)
    {
        $result = $this->conn->prepare($query);
        $result->execute($values);
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $resultset[] = $row;
        }
        if (!empty($resultset))
            return $resultset;
    }

    function numRows($query)
    {
        $result = $this->conn->query($query);
        $rowcount = $result->rowCount();
        return $rowcount;
    }

    function search(Array $item)
    {
        $sql = "SELECT * FROM wakulimaconnectagrovetitems WHERE name=?";
        $res = $this->basicQueryret($sql, $item);
        return $res;
    }

    function basicQueryret($query, Array $values)
    {
        $res = $this->conn->prepare($query);
        $res->execute($values);
        return $res;
    }
//    function insertOrders(Array $stritems){
////items customer
//        $sql='UPDATE  wakulimaconnectagrovetorders SET items=?,customer=? WHERE customer';
//        $res=$this->basicQueryret($sql,$stritems);
//        if($res->rowCount()>0){
//            //payment logic
//        }
//    }

    function placeorder()
    {
        if (isset($_SESSION['cart_item'])) {
            $str = json_encode($_SESSION['cart_item']);
            $user = $_SESSION['wakulimaconnectagrovetcustomer'];
            $resultinsert = $this->conn->prepare("INSERT INTO wakulimaconnectagrovetorders (items,customer) VALUES (?,?)");
            $resultinsert->execute([$str, $user]);
//            todo continue from here
            if ($resultinsert->rowCount() > 0) {
                unset($str);
                unset($_SESSION['cart_item']);
                header("Location:checkout.php?inserted");
            } else {
                header("Location:checkout.php? Not inserted");

            }
        } else {
            header("Location:checkout.php?Add items to cart");
        }


    }
}

$connection = new dbconnector();

