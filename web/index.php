<!doctype html>

<?php include 'helper.php'; ?>
<?php extract($data); ?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tic-tac-toe</title>

    <script type="text/javascript">
        var currentPlayer = '<?php print $currentPlayer; ?>';
        var gameOver = <?php print $gameOver ? 'true' : 'false'; ?>;
        var gameType = <?php print $gameType; ?>;
        var COMPUTER_VS_COMPUTER = <?php print COMPUTER_VS_COMPUTER; ?>;
    </script>

    <script type="text/javascript">
        function autosubmitIfComputersPlay() {
            if (gameType == COMPUTER_VS_COMPUTER && !gameOver) {
                var forms = document.getElementsByTagName('form');
                var form = forms[0];
                setTimeout(function() {
                    form.submit();
                }, 1000);
            }
        }

        function submitOnUserClick() {
            var inputs = document.getElementsByTagName('input');
            for (var i=inputs.length; i--;) {
                if (inputs[i].getAttribute('type') == 'text' && !inputs[i].readOnly) {
                    inputs[i].onfocus = function() {
                        this.readOnly = true;
                        this.value = currentPlayer;
                        var form = this.parentElement;
                        setTimeout(function() {
                            form.submit();
                        }, 500);
                    }
                }
            }
        }

        window.onload = function() {
            autosubmitIfComputersPlay();
            submitOnUserClick()
        };
    </script>

    <style>
        body {
            background-color: #E6E1DC;
            text-align: center;
            font-size: 20px;
        }
        h1 {
            font-size: 40px;
        }
        .message {
            background-color: red;
            line-height: 3rem;
        }
        form {
            margin: 2rem;
        }
        input {
            font-size: 30px;
            padding: 5px 10px;
            border: 3px solid #444;
            width: 25px;
            margin:0;
        }
        input:hover {
            cursor: pointer !important;
        }
        input[readonly] {
            background-color: #E6E1DC;
        }
        input[type="submit"] {
            display: none;
        }
    </style>
</head>

<body>
    <h1>Tic-tac-toe</h1>

    <p class="message"><?php if(isset($message)) {print $message;} ?></p>

    <form>
        <?php
        for ($i=0; $i<9; $i++) {
            $readonly = (!empty($grid[$i]) || $gameOver || $gameType == 3) ? 'readonly' : '';
            print "<input type='text' size='1' name='grid[$i]' value='{$grid[$i]}' $readonly>";
            if ($i%3 == 2) {
                print '<br>';
            }
        }
        ?>
        <input type="hidden" name="gameType" value="<?php print $gameType; ?>">
        <input type="Submit" value="Submit">
    </form>

    <p><a href=".?humanStarts=1">Play against computer - you first</a></p>
    <p><a href=".?humanStarts=0">Play against computer - computer first</a></p>
    <p><a href=".?gameType=<?php print HUMAN_VS_HUMAN;?>">Play against human</a></p>
    <p><a href=".?gameType=<?php print COMPUTER_VS_COMPUTER;?>">Let computers play</a></p>
</body>
</html>
