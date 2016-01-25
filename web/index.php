<!doctype html>

<?php include 'helper.php'; ?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tic-tac-toe</title>
</head>

<body>
    <h1>Tic-tac-toe</h1>

    <form>
        <?php
        for ($i=0; $i<3; $i++) {
            for ($j=0; $j<3; $j++) {
                $readonly = (!empty($grid[$i][$j])) ? 'readonly' : '';
                print "<input type='text' size='1' name='grid[$i][$j]' value='{$grid[$i][$j]}' $readonly>";
            }
            print '<br>';
        }
        ?>
        <input type="Submit" value="Submit">
    </form>

    <p><a href="/tests/8thLight/TicTacToe/web">Restart</a></p>

    <p class="message"><?php if(isset($message)) {print $message;} ?></p>
</body>
</html>
