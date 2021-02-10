<?php

?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Kalkulator</title>
    <link rel="stylesheet" href="https://unpkg.com/purecss@2.0.5/build/pure-min.css" integrity="sha384-LTIDeidl25h2dPxrB2Ekgc9c7sEC3CWGM6HeFmuDNUjX76Ert4Z4IY714dhZHPLd" crossorigin="anonymous">
</head>
<body>

<div style="width:90%; margin: 2em auto;">
    <a href="<?php print(_APP_ROOT); ?>/app/inna_chroniona.php" class="pure-button">Chroniona strona</a>
    <a href="<?php print(_APP_ROOT); ?>/app/security/logout.php" class="pure-button pure-button-active">Wyloguj</a>
</div>

<div style="width: 90%; margin: 2em auto;">
    <form class="pure-form pure-form-aligned" action="<?php print(_APP_URL);?>/app/calc.php" method="post">
        <legend>Uproszczony kalkulator kredytowy</legend>
        <fieldset>
            <div class="pure-control-group">
                <label for="id_val">Kwota kredytu: </label>
                <input id="id_val" type="text" name="amo" value="<?php out($amo); ?>" /><br />
            </div>
            <div class="pure-control-group">
                <label for="id_yr">Liczba lat: </label>
                <input id="id_yr" type="text" name="yr" value="<?php out($yr ); ?>" /><br />
            </div>
            <div class="pure-control-group">
                <label for="id_pct">Oprocentowanie: </label>
                <input id="id_pct" type="text" name="pct" value="<?php out($pct ); ?>" /><br />
            </div>
            <div class="pure-controls">
                <input class="pure-button pure-button-primary" type="submit" value="Oblicz" />
            </div>
        </fieldset>
    </form>

    <?php
    //wyświeltenie listy błędów, jeśli istnieją
    if (isset($messages)) {
	if (count ( $messages ) > 0) {
        echo '<ol style="background: #ff8888; margin: 1em; margin-top: 2em; margin-right: 0px; margin-bottom: 2em; margin-left: 0px; padding: .3em 1em; border-radius: 5px; color: #fff;">';
        foreach ( $messages as $key => $msg ) {
            echo '<li>'.$msg.'</li>';
        }
        echo '</ol>';
    }
    }
    ?>

    <?php if (isset($result)){ ?>
        <div style="background: #1fadfa; margin: 1em; margin-top: 2em; margin-right: 0px; margin-bottom: 3em; margin-left: 0px; padding: .3em 1em; border-radius: 5px; color: #fff;">
            <?php echo 'Miesięczna rata będzie wynosić ok. : '.number_format($result, 2,'.',''); ?>
        </div>
    <?php } ?>

</div>
</body>
</html>