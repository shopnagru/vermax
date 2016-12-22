<?php
header('Content-type: text/html; charset=utf-8');
$result = "";
if(isset($_POST['json'])) {
    $data = $_POST['json'];

    $ch = curl_init('http://vermax2.illumi-nation.ru/stat.php');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    $result = curl_exec($ch);
}
?>
<form id="json" method="POST">
    <textarea form="json" name="json" style="width: 500px; height: 300px; margin: 0px;"></textarea>
    <input type="submit">
</form>
<pre>
<?php echo $result;
?>
</pre>
