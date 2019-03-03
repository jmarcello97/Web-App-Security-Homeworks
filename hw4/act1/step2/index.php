<!DOCTYPE html>
<html>
<body>
        <div id=plugins></div>
</body>

<?php
        $referer = $_SERVER['HTTP_REFERER'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        echo("Referer: ".$referer);
        echo("<br>");
        echo("IP: ".$ip);
        echo("<br>");
        echo("User-Agent: ".$user_agent);
        echo("<br>")
?>
<script>
        var plugin_len = navigator.plugins.length;
        var plugin_lst = "Plugins: "
        for(var i = 0; i < plugin_len; i++) {

                if (i != plugin_len-1) {
                        plugin_lst+=navigator.plugins[i].name + ", ";
                }
                else {
                        plugin_lst+=navigator.plugins[i].name
                }
        }

        document.getElementById("plugins").innerHTML = plugin_lst;

</script>
</html>

