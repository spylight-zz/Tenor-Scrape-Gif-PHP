<?php
$result = "";
$act = false;
if (!empty($_POST['srch'])) {
    $key_tenor_api = "AIzaSyDgxKUqJwyRgjU3T8tpaQdQ5-M8A37wpy8";
    $act = true;
    $srch = str_replace(" ", "+", $_POST['srch']);
    $url = "https://tenor.googleapis.com/v2/search?q=".$srch."&key=$key_tenor_api&locale=".$_POST['locale']."&limit=".$_POST['limit'];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL,$url);
    $result=curl_exec($ch);
    curl_close($ch);

    $result = json_decode($result);
}
?>
<html>
    <head>
        <title>Tenor Scrape</title>    
    </head>
    <body>
        <form action="index.php" method="post">
        <table>
            <tr>
                <th>Search</th>
                <th>&nbsp;</th>
                <th>
                    <input type="text" name="srch" autocomplete="false" value="<?php echo ($_POST['srch'] != '') ? $_POST['srch'] : ''?>" />
                </th>
                <th>&nbsp;</th>
                <th>Locale</th>
                <th>&nbsp;</th>
                <th>
                    <select name="locale">
                        <?php $sele = ($_POST['locale'] == 'en') ? "selected='selected'" : ''; ?>
                        <?php $sele2 = ($_POST['locale'] == 'id') ? "selected='selected'" : ''; ?>
                        <option value="en" <?php echo $sele;?>>English</option>
                        <option value="id" <?php echo $sele2;?>>Indonesia</option>
                    </select>
                </th>
                <th>&nbsp;</th>
                <th>Limit Data</th>
                <th>
                    <select name="limit">
                        <?php $sele = ($_POST['limit'] == '30') ? "selected='selected'" : ''; ?>
                        <?php $sele1 = ($_POST['limit'] == '50') ? "selected='selected'" : ''; ?>
                        <?php $sele2 = ($_POST['limit'] == '100') ? "selected='selected'" : ''; ?>
                        <option value="30" <?php echo $sele;?>>30</option>
                        <option value="50" <?php echo $sele1;?>>50</option>
                        <option value="100" <?php echo $sele2;?>>100</option>
                    </select>
                </th>
                <th>
                    <input type="submit" value="Display" />     
                </th>
            </tr>
        </table>
        </form>
        </br></br>
        <?php 
            $row = "";
            if ($act) {
        ?>
        <table border="1" width="auto">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Link Gif</th>
                </tr>                
            </thead>
            <tbody>
            <?php
                foreach($result->results as $val) {
                    $row = "<tr>";
                    $row .= "<td>".$val->title."</td>";
                    $row .= "<td><a href='".$val->media_formats->gif->url."' target='blank'>".$val->media_formats->gif->url."</a></td>";
                    $row .= "</tr>";
                    echo $row;
                }
            ?>
            </tbody>
        </table>
        <?php }?>
    </body>
</html>