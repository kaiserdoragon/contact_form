<!-- 管理者宛てのメールの内容です -->

管理者宛てのメールの内容です

<?php echo date("Y/m/d H:i:s") ?> 以下の申込みがありました。

[ <?php echo $element['name01']['Label']; ?> ] <?php echo $values['name01'] . "\n"; ?>
[ <?php echo $element['name02']['Label']; ?> ] <?php echo $values['name02'] . "\n"; ?>
[ <?php echo $element['name']['Label']; ?> ] <?php echo $values['name'] . "\n"; ?>
[ <?php echo $element['name03']['Label']; ?> ] <?php echo $values['name03'] . "\n"; ?>
[ <?php echo $element['zipcode']['Label']; ?> ] <?php echo $values['zipcode'] . "\n"; ?>
[ <?php echo $element['address01']['Label']; ?> ] <?php echo $values['address01'] . "\n"; ?>
[ <?php echo $element['address02']['Label']; ?> ] <?php echo $values['address02'] . "\n"; ?>
[ <?php echo $element['tel']['Label']; ?> ] <?php echo $values['tel'] . "\n"; ?>
[ <?php echo $element['email']['Label']; ?> ] <?php echo $values['email'] . "\n"; ?>
[ <?php echo $element['email_match']['Label']; ?> ] <?php echo $values['email_match'] . "\n"; ?>
[ <?php echo $element['age']['Label']; ?> ] <?php echo $values['age'] . "\n"; ?>
[ <?php echo $element['affiliation']['Label']; ?> ] <?php echo $values['affiliation'] . "\n"; ?>
[ <?php echo $element['multiplecheck']['Label']; ?> ] <?php echo $values['multiplecheck'] . "\n"; ?>
[ <?php echo $element['radiobutton']['Label']; ?> ] <?php echo $values['radiobutton'] . "\n"; ?>
[ <?php echo $element['kiyaku']['Label']; ?> ] <?php echo $values['kiyaku'] . "\n"; ?>
<?php echo "\n"; ?>
<?php echo "【適宜自由に挿入できるテキスト】\n"; ?>
[ <?php echo $element['select']['Label']; ?> ] <?php echo $values['select'] . "\n"; ?>
[ <?php echo $element['color']['Label']; ?> ] <?php echo $values['color'] . "\n"; ?>
[ <?php echo $element['size']['Label']; ?> ] <?php echo $values['size'] . "\n"; ?>
[ <?php echo $element['comment']['Label']; ?> ] <?php echo $values['comment'] . "\n"; ?>

<?php echo date("Y/m/d H:i:s") ?>