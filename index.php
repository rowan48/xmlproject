<?php
session_start();
$i=0;
$xml = simplexml_load_file('data.xml');
if (isset($_POST["insert"])) {
    $employee = $xml->addChild('employee');
    $employee->addchild('name', $_POST['name']);
    $employee->addChild('phone', $_POST['phonenumber']);
    $employee->addChild('adress', $_POST['Adress']);
    $employee->addChild('email', $_POST['email']);
   // file_put_contents('data.xml', $xml->asXML());
    $xml->asXML('data.xml');
}
elseif(isset($_POST["update"])){
    if (isset($_SESSION["id"])) {
        $i = $_SESSION["id"];
        $xml[0]->employee[$i]->name=$_POST["name"];
        $xml[0]->employee[$i]->phone=$_POST["phonenumber"];
        $xml[0]->employee[$i]->adress=$_POST["Adress"];
        $xml[0]->employee[$i]->email=$_POST["email"];
    }
    else{
        $i = 0;
        $xml[0]->employee[$i]->name=$_POST["name"];
        $xml[0]->employee[$i]->phone=$_POST["phonenumber"];
        $xml[0]->employee[$i]->adress=$_POST["Adress"];
        $xml[0]->employee[$i]->email=$_POST["email"];
    }
    $xml->asXML('data.xml');
}elseif(isset($_POST["delete"])){
    if (isset($_SESSION["id"])) {
        $i=$_SESSION["id"];
        unset($xml[0]->employee[$i]);
    }
    else{
        $i=0;
        unset($xml[0]->employee[$i]);

    }
    $xml->asXML('data.xml');
}elseif (isset($_POST["prev"])) {
    if(isset($_SESSION["id"])) {
        if ($_SESSION["id"] <= 0) {
            $i = 0;
            $_SESSION["id"] = $i;
        } else {
            $_SESSION["id"] = $_SESSION["id"] - 1;
            $i = $_SESSION["id"];
        }
    }

}
elseif (isset($_POST["searchbyname"])) {
    $key=$_POST["name"];
    $found=0;
    for ($j=0 ; $j<count($xml[0]->employee);$j++)
    {
        if(strcmp($key,$xml->employee[$j]->name)==0)
        {
            $i=$j;
            $_SESSION["id"]=$i;
            $found=1;
        }
    }
    if(!$found)
    {
        echo "<h1 style='color: #0d5699; '><i>there is no employee with this name</i></h1>";
    }
    else{
        echo "<h1 style='color: #0d5699;'><i>found</i></h1>";
    }

}elseif (isset($_POST["next"])) {
    if (isset($_SESSION["id"])) {
        $_SESSION["id"] = $_SESSION["id"] + 1;
        if($_SESSION["id"]<count($xml[0]->employee))
        {
            $i = $_SESSION["id"];
        }
        else{
            $i=0;
            $_SESSION["id"]=0;
        }

    } else {
        $i++;
        $_SESSION["id"] = $i;}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>XML-Form</title>

</head>
<body>
<div class="content">
    <div class="left">
<!--        <img src="../images/img2.png" alt="">-->

        <h1 class = "form">Form</h1>
    </div>
    <div class="right">
        <form class="bckgrndform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">


            <h2>Name</h2>
            <input  class="name" type="text" placeholder="" value="<?php echo $xml[0]->employee[$i]->name;?>" name="name">
            <h2>phone</h2>
            <input class="phone" type="text" placeholder="phone" value="<?php echo $xml[0]->employee[$i]->phone;?>" name="phonenumber">
            <h2>Adress</h2>
            <input class="address" type="text"  name="Adress"value="<?php echo $xml[0]->employee[$i]->adress;?>" placeholder="Address">
            <h2>Email</h2>
            <input class="email" type="email" placeholder="E-mail" value="<?php echo $xml[0]->employee[$i]->email;?>" name="email">

          <pre>        <table class="table">
                <tr>
                    <th><button class="prev"   type="submit" name="prev">prev</button></th>
                    <th> <button class="next"  type="submit" name="next">next</button></th>
                </tr>
                <br>
                <br>
                <tr>
                    <td><button class="insert"  type="submit" name="insert">insert</button></td>
                    <td><button class="update"  type="submit" name="update">update</button></td>
                </tr>
                <br>
                <br>
                <tr>
                    <td><button class="delete"  name="delete">delete</button></td>
                    <td><button class="search" type="submit" name="searchbyname">search</button></td>
                </tr>
            </table>
              </pre>
        </form>
        <br>
    </div>
</div>
</body>
</html>