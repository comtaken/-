<?php

$host = 'mysql:dbname=taion_2022;host192.168.1.8';

$user_name = 'root';

$pasw = 'P@ssw0rd';

//$yyyy_mm_dd =  date("Y/m/d");
//仮で日付を入れる
//$yyyy_mm_dd =  "2022/02/26";

try {
    $pdo = new PDO($host, $user_name, $pasw);

    //$date='; delete from user;';
    $select_date = '20220224';

    $bind[':select_date'] = $select_date;

    $sql = 'SELECT name, t1.created_at, line_message FROM users' 

    . ' LEFT OUTER JOIN (SELECT * FROM line_messages' 

    . ' WHERE DATE_FORMAT(created_at, \'%Y%m%d\') = :select_date'

    . ') t1 ON t1.line_user_id = users.line_user_id';

    $stmt = $pdo->prepare($sql);

    $stmt->execute($bind);
    
    $sth = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //print_r($sth);
    // $sth = $pdo->query($sql);

} catch (PDOxceptiionE $e) {
    print "エラー!: " . $e->getMessage() . "<br/gt;";

    die();
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="UTF-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>体温管理システム</title>

    </head>

    <body>

        <h3>体温報告</h3>
        <h5><&nbsp;&nbsp;&nbsp;<?php echo $yyyy_mm_dd ?>&nbsp;&nbsp;&nbsp;></h5>
        <br>
        <h3>未報告者</h3>

        <table border="1" style = "border-collapse: collapse" width = "600">


        </table>

        <br>

        <h3>報告者</h3>


        <tr><td>①体温&nbsp;</td></tr>
        <tr><td>②せきの有無&nbsp;</td></tr>
        <tr><td>③倦怠感の有無&nbsp;</td></tr>
        <tr><td>④味覚嗅覚異常の有無&nbsp;</td></tr>



        <table border="1" style = "border-collapse: collapse" width = "700">
        <?php ?>
            <?php foreach ($sth as $row) 
            {?>
                <?php
                    $zikan = explode(" ", $row['created_at']);
                    $zikan = explode(":", $zikan[1]);
                ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $zikan[0] . ":" . $zikan[1] ?></td>
                <td><?php echo $row['line_message']; ?></td>
            </tr>

            <?php }?>
        </table>

    </body>
</html>