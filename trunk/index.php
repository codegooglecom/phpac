<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>PHPac</title>
        <script type="text/javascript" src="resources/jquery_1.2.6/jquery-1.2.6.js"></script>
        <link href="css/style.css" rel="stylesheet" type="text/css" >
        <script type="text/javascript">
            $(document).ready(function() {
                $("#crawler").hide();
                $("#validatord").hide();
                $("#validator").hide();
                $("#pacwriterd").hide();
                $("#pacwriter").hide();
                $("#crawlera").click(function(event){
                    event.preventDefault();
                    $("#crawler").slideDown();
                    $.get("crawler.php", function (data){
                        $("#crawler").fadeOut("slow", function(){
                            $("#crawler").html(data);
                            $("#crawler").slideDown("slow");
                            $("#validatord").slideDown();
                            $("#validatora").click();
                        });
                    });
                });
                $("#validatora").click(function(event){
                    event.preventDefault();
                    $("#validator").slideDown();
                    $.get("validator.php", function (data){
                        $("#validator").fadeOut("slow", function(){
                            $("#validator").html(data);
                            $("#validator").slideDown("slow");
                            $("#pacwriterd").slideDown();
                            $("#pacwritera").click();
                        });
                    });
                });
                $("#pacwritera").click(function(event){
                    event.preventDefault();
                    $("#pacwriter").slideDown();
                    $.get("pacwriter.php", function (data){
                        $("#pacwriter").fadeOut("slow", function(){
                            $("#pacwriter").html(data);
                            $("#pacwriter").slideDown("slow");
                        });
                    });
                });
            });
        </script>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h1 title="PHPac">PHPac</h1>
                <h2 title="PHPac">PHPac</h2>
            </div>
            <ul id="nav">
                <li><a href="#" id="Home" class="on">Home</a></li>
            </ul>
            <div id="content">
                <div id="crawlerd"><a href="#" id="crawlera">crawler</a></div>
                <div id="crawler">crawlera working...</div>
                <div id="validatord"><a href="#" id="validatora">validator</a></div>
                <div id="validator">validator working...(5 mins or more)</div>
                <div id="pacwriterd"><a href="#" id="pacwritera">pacwriter</a></div>
                <div id="pacwriter">pacwriter working...</div>
            </div>
            <div id="footer">
                Powered by <b>Roar</b>.
            </div>
        </div>
    </body>
</html>
