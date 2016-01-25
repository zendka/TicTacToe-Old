<!doctype html>

<?php include 'helper.php'; ?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tic-tac-toe</title>

    <script type="text/javascript">
        window.onload = function() {
            // When user clicks inside an input set value to 'X' and autosubmit the form
            var inputs = document.getElementsByTagName('input');
            for (var i=inputs.length; i--;) {
                if (inputs[i].getAttribute('type') == 'text') {
                    inputs[i].onfocus = function() {
                        if (!this.readOnly) {
                            this.readOnly = true;
                            this.value = 'X';
                            var form = this.parentElement;
                            setTimeout(function() {
                                form.submit();
                            }, 500);
                        }
                    }
                }
            }
        };
    </script>

    <style>
        body {
            background-color: #E6E1DC;
            text-align: center;
            font-size: 25px;
        }
        h1 {
            font-size: 40px;
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

    <form>
        <?php
        for ($i=0; $i<3; $i++) {
            for ($j=0; $j<3; $j++) {
                $readonly = (!empty($grid[$i][$j]) || $gameOver) ? 'readonly' : '';
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
