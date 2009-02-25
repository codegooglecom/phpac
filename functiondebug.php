<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        include_once "config.inc.php";
        include_once "common.inc.php";
        $freeips = get_free_ip_from_string(file_get_contents($config['free_ip_url']));
        foreach($freeips as $l) {
            echo ($l);
            echo ("<br/>");
        }
        ?>
    </body>
</html>
