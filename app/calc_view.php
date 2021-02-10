<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator</title>
<link rel="stylesheet" href="https://unpkg.com/purecss@2.0.5/build/pure-min.css" integrity="sha384-LTIDeidl25h2dPxrB2Ekgc9c7sEC3CWGM6HeFmuDNUjX76Ert4Z4IY714dhZHPLd" crossorigin="anonymous">
</head>
<body>
<div >

</div>

<div style="width: 90%; margin: 2em auto;">
    <form class="pure-form pure-form-aligned" action="<?php print(_APP_URL);?>/app/calc.php" method="post">
        <fieldset>
            <div class="pure-control-group">
                <label for="id_val">Kwota kredytu: </label>
                <input id="id_val" type="text" name="amo" value="<?php print(isset($amo) ? $amo : '' ); ?>" /><br />
            </div>
            <div class="pure-control-group">
                <label for="id_yr">Liczba lat: </label>
                <input id="id_yr" type="text" name="yr" value="<?php print(isset($yr) ? $yr : '' ); ?>" /><br />
            </div>
            <div class="pure-control-group">
                <label for="id_pct">Oprocentowanie: </label>
                <input id="id_pct" type="text" name="pct" value="<?php print(isset($pct) ? $pct : '' ); ?>" /><br />
            </div>
            <input class="pure-button pure-button-primary" type="submit" value="Oblicz" />
        </fieldset>
    </form>

    <?php
    //wyświeltenie listy błędów, jeśli istnieją
    if (isset($messages)) {
//	if (count ( $messages ) > 0) {
        echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #ff9c95; width:300px;">';
        foreach ( $messages as $key => $msg ) {
            echo '<li>'.$msg.'</li>';
        }
        echo '</ol>';
    }
    //}
    ?>

    <?php if (isset($result)){ ?>
        <div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ffff67; width:300px;">
            <?php echo 'Miesięczna rata będzie wynosić ok. : '.number_format($result, 2,'.',''); ?>
        </div>
    <?php } ?>

</div>



</body>
</html>