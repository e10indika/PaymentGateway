<html>
    <body>
        <form method="POST">
            Enter a filename <input type="text" name="filepath"><br />
            <input type="submit" /><br />
        </form>
    </body>
</html>

<?php
if(isset($_POST['filepath'])) {
    $filename  = $_POST['filepath'];
    $inputDir  = "C:/wamp/www/finalyearProject/gobuy.com";
    $command = "matlab -sd ".$inputDir." -nodisplay -nosplash -nodesktop -r myFunc('".$filename."')";
    $output = exec($command);
    echo "The following command was run: ".$command."<br/>";
}
?>
