<?php
$type = '';
$content = '';

if (isset($_GET['number'])) {
    if ($_GET['number'] == "all")
        $number = 'all';
    else
        $number = (int) $_GET['number'];
}

function outNumAsLink($x)
{

    if ($x <= 9) {
        //        return '<a href="?content=' . $x . '&html_type=' . $_GET['html_type'] . '">' . $x . '</a>';
        return '<a href="?content=' . urlencode($x) . '">' . $x . '</a>';
    } elseif ($x <= 99) {
        $digits = str_split($x);
        $linkedDigits = array_map(function ($digit) {
            return '<a href="?content=' . urlencode($digit) . '">' . $digit . '</a>';
        }, $digits);

        return implode('', $linkedDigits);
    } else {
        return $x;
    }
}
function outTableForm()
{
    if ($_GET['content'] == 'all') {
        echo '<div class="columns">';
        for ($i = 2; $i < 10; $i++) {
            echo '<div class="column">';
            echo '<table>';
            for ($k = 1; $k <= 9; $k++) {
                echo '<tr>';
                echo '<td>' . outNumAsLink((int)$k) . 'x' . outNumAsLink($i) . '</td>';
                echo '<td>' . outNumAsLink((int)$k * $i) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<table>';
        for ($i = 1; $i <= 9; $i++) {
            echo '<tr>';
            echo '<td>' . outNumAsLink((int)$_GET['content']) . 'x' . outNumAsLink($i) . '</td>';
            echo '<td>' . outNumAsLink((int)$_GET['content'] * $i) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
}
function outDivForm()
{
    if (!isset($_GET['content']) || $_GET['content'] == 'all') {
        echo '<div class="columns">';  
        for ($i = 2; $i < 10; $i++)  
        {
            echo '<div class="column">';  
            outRow($i);  
 
            echo '</div> ';  
        }
        echo '</div><br>'; 
    } else {
        echo '<div class="singleColumn">';  
        outRow($_GET['content']);  
        echo '</div>';
    }
}
function outRow($n)
{
    if ($n != 'all' || $n != '') {
        for ($i = 2; $i <= 9; $i++) {
            echo '<div>' . outNumAsLink($n) . '*' . outNumAsLink($i) . '=' . outNumAsLink($i * $n) . '</div>';
        }
    } else {
        for ($i = 2; $i <= 9; $i++) {
            echo '<div>' . outNumAsLink($_GET['content']) . '*' . outNumAsLink($i) . '=' . outNumAsLink($i * $_GET['content']) . '</div>';
        }
    }
}
if (!isset($_GET['html_type'])) {
    $_GET['html_type'] = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Лабораторная 11</title>
</head>

<body>
    <header>
        <a href="?html_type=TABLE<?php if (!empty($_GET['content'])) echo '&content=' . $_GET['content']; ?>" <?php
                                                                                                                if ($_GET['html_type'] == 'TABLE') {
                                                                                                                    echo 'class="selected"';
                                                                                                                } ?>>Табличная верстка</a>
        <a href="?html_type=DIV<?php if (!empty($_GET['content'])) echo '&content=' . $_GET['content']; ?>" <?php
                                                                                                            if ($_GET['html_type'] == 'DIV') {
                                                                                                                echo 'class="selected"';
                                                                                                            } ?>>Блочная верстка</a>
    </header>
    <main>
        <div id="left_menu">
            <a href="/" <?php
                        if (!array_key_exists('content', $_GET) || $_GET['content'] == '') {
                            echo 'class="selected"';
                            $_GET['content'] = 'all';
                        }
                        ?>>Всё</a>
            <?php
            for ($i = 2; $i <= 9; $i++) {
                echo '<a href="?content=' . $i . '&html_type=' . $_GET['html_type'] . '" ';
                if (array_key_exists('content', $_GET) && $_GET['content'] == $i)
                    echo 'class="selected"';
                echo '>' . $i . '</a>';
            }
            ?>
        </div>
        <div>
            <?php
            if ((isset($_GET['html_type']) && $_GET['html_type'] == 'TABLE')) {
                outTableForm($_GET['content']);
            } else if ($_GET['html_type'] == '') {
                outTableForm('all');
            }
             else
                //  echo '<script> alert("' . $_GET['html_type'] . ' ' . $_GET['content'] . '") </script>';
                outDivForm();
            ?>
        </div>
    </main>
    <footer>
        <?php
        if (!isset($_GET['html_type']) || $_GET['html_type'] == 'TABLE')
            $s = 'Табличная верстка. ';
        else
            $s = 'Блочная верстка. ';
        if (!isset($_GET['content']) || $_GET['content'] == '')
            $s .= 'Таблица умножения полностью. ';
        else
            $s = 'Столбец таблицы умножения на ' . $_GET['content'] . '. ';
        echo $s . date('d.Y.M h:i:s');
        ?>
    </footer>
</body>

</html>