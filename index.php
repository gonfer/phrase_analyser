<?php 
require_once("inc/analyser.class.php");
$analyser->init();
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head></head>
    <body>
    <div>
        <h1>Phrase Analyser</h1>
        <div>
            <form method="POST" action="">
            <label for="texttoanalyse">Text to analyse:</label>
            <input id="texttoanalyse" name="texttoanalyse">
            <input type="submit" maxlength="255" value="Analyse">
            </form>
        </div>
    </div>
    </body>
<html>