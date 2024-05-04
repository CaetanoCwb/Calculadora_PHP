<!DOCTYPE html>
<html>

<head>
    <title>Calculadora Simples</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <h2>Calculadora Simples</h2>
    <form method="post">
        <input type="text" name="num1" placeholder="Digite o primeiro número">
        <select name="operacao" required>
            <option value="+">Adição</option>
            <option value="-">Subtração</option>
            <option value="X">Multiplicação</option>
            <option value="/">Divisão</option>
            <option value="^">Potência</option>
            <option value="%">Porcentagem</option>
        </select>
        <input type="text" name="num2" placeholder="Digite o segundo número">
        <button type="submit" name="calcular">Calcular</button>
        <button type="submit" name="memoria">Memória</button>
        <button type="submit" name="usar_memoria">Usar Memória</button>
        <button type="submit" name="limpar_historico">Limpar</button>
    </form>

    <?php
    session_start();

    if (isset($_POST['calcular'])) {
        $num1 = isset($_POST['num1']) ? $_POST['num1'] : '';
        $num2 = isset($_POST['num2']) ? $_POST['num2'] : '';
        $operacao = $_POST['operacao'];

        if ($num1 === '' || $num2 === '') {
            echo "<p>Digite valores válidos!</p>";
        } else {
            switch ($operacao) {
                case '+':
                    $resultado = $num1 + $num2;
                    break;
                case '-':
                    $resultado = $num1 - $num2;
                    break;
                case 'X':
                    $resultado = $num1 * $num2;
                    break;
                case '^':
                    $resultado = $num1 ** $num2;
                    break;
                case'%':
                    $resultado = $num1/100 * $num2; 
                    break;
                case '/':
                    if ($num2 != 0) {
                        $resultado = $num1 / $num2;
                    } else {
                        $resultado = "Divisão por zero não é permitida";
                    }
                    break;
                default:
                    $resultado = "Operação inválida";
            }

            // Adicionando o cálculo ao histórico
            $historicoItem = "$num1 $operacao $num2 = $resultado";
            $_SESSION['historico'][] = $historicoItem;

            // Armazenando o último valor do histórico na memória
            end($_SESSION['historico']);
            $_SESSION['memoria'] = prev($_SESSION['historico']);
        }
    }

    if (isset($_POST['limpar_historico'])) {
        unset($_SESSION['historico']);
    }

    if (isset($_POST['usar_memoria'])) {
        if (isset($_SESSION['memoria'])) {
            echo "<p>Último valor armazenado na memória: {$_SESSION['memoria']}</p>";
        } else {
            echo "<p>Nenhum valor armazenado na memória.</p>";
        }
    }

    if (isset($_POST['memoria'])) {
        if (isset($_SESSION['historico'])) {
            $ultimoCalculo = end($_SESSION['historico']);
            if ($ultimoCalculo) {
                $_SESSION['memoria'] = $ultimoCalculo;
                echo "<p>Último cálculo armazenado na memória: $ultimoCalculo</p>";
            } else {
                echo "<p>Nenhum cálculo no histórico para armazenar na memória.</p>";
            }
        } else {
            echo "<p>Nenhum cálculo no histórico para armazenar na memória.</p>";
        }
    }

    // Exibindo o histórico
    echo "<h3>Histórico</h3>";
    echo "<ul>";
    if (isset($_SESSION['historico'])) {
        foreach ($_SESSION['historico'] as $item) {
            echo "<li>$item</li>";
        }
    }
    echo "</ul>";
    ?>
</body>

</html>