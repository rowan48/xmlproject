<?php
session_start();
$i=0;
$xml = simplexml_load_file('data.xml');
//$xml[]=simplexml_load_string($myXMLData) or die("Error: Cannot create object");

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
    if ($_SESSION["id"]<= 0) {
        $i = 0;
        $_SESSION["id"]=$i;
    } else {
        $_SESSION["id"]=$_SESSION["id"]-1;
        $i=$_SESSION["id"];
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
        echo "there is no employee with this name";
    }
    else{
        echo "found";
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



//print_r($xml);
highlight_string('<?php ' . var_export($xml, true) . ';?>');
echo count($xml[0]->employee);


foreach ($xml as $key=>$value){
    echo $value;
    echo "<br>";
    //echo $value[$key];
    echo "<br>";
}
echo "hey";
//for($i=0;$i<count($xml);$i++){
//    echo $xml[0];
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XYZ </title>

</head>
<body>
<div class="content">
    <div class="left">
<!--        <img src="../images/img2.png" alt="">-->
        <h1 class = "form">Form</h1>
    </div>
    <div class="right">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">


            <h2>Name</h2>
            <input type="text" placeholder="" value="<?php echo $xml[0]->employee[$i]->name;?>" name="name">
            <h2>phone</h2>
            <input type="text" placeholder="phone" value="<?php echo $xml[0]->employee[$i]->phone;?>" name="phonenumber">
            <h2>Adress</h2>
            <input type="text"  name="Adress"value="<?php echo $xml[0]->employee[$i]->adress;?>" placeholder="Address">
            <h2>Email</h2>
            <input type="email" placeholder="E-mail" value="<?php echo $xml[0]->employee[$i]->email;?>" name="email">
            <br><br><br>
            <button type="submit" name="prev">prev</button>  <br><br>  <button type="submit" name="next">next</button><br><br>
            <button type="submit" name="insert">insert</button>  <br> <br>  <button type="submit" name="update">update</button><br><br>
            <button type="submit" name="delete">delete</button>  <br> <br>   <button type="submit" name="searchbyname">searchbyname</button>
<!---->
        </form>
        <br>
    </div>
</div>
</body>
</html>