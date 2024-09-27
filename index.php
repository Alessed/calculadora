<?php
// Variables para manejar la entrada y el cálculo
$display = '';
$firstOperand = '';
$secondOperand = '';
$operator = '';
$result = '';

// Verificar si se envió un valor del botón
if (isset($_POST['button'])) {
    $button = $_POST['button'];

    // Si el botón es un número o un punto decimal
    if (is_numeric($button) || $button === '.') {
        $display .= $button;
    } elseif ($button === 'C') {
        // Limpiar todo
        $display = '';
        $firstOperand = '';
        $operator = '';
        $result = '';
    } elseif ($button === '+' || $button === '-' || $button === '*' || $button === '/') {
        // Si se selecciona un operador, guardamos el primer operando y el operador
        $firstOperand = isset($_POST['display']) ? $_POST['display'] : '0';
        $operator = $button;
        $display = ''; // Limpiar la pantalla para el siguiente número
    } elseif ($button === '=') {
        // Si se presiona "=", realizamos la operación
        $secondOperand = isset($_POST['display']) ? $_POST['display'] : '0';

        // Convertir los operandos a valores numéricos
        $firstOperand = floatval($_POST['firstOperand']);
        $secondOperand = floatval($secondOperand);

        // Realizar la operación según el operador
        switch ($_POST['operator']) {
            case '+':
                $result = $firstOperand + $secondOperand;
                break;
            case '-':
                $result = $firstOperand - $secondOperand;
                break;
            case '*':
                $result = $firstOperand * $secondOperand;
                break;
            case '/':
                // Verificar división por cero
                if ($secondOperand != 0) {
                    $result = $firstOperand / $secondOperand;
                } else {
                    $result = "Error";
                }
                break;
        }
        $display = $result; // Mostrar el resultado
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora PHP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const display = document.getElementById('display');

            // Función para manejar teclas del teclado
            document.addEventListener('keydown', function (event) {
                let key = event.key;
                if (!isNaN(key) || key === '.') {
                    // Si es un número o un punto decimal
                    display.value += key;
                } else if (['+', '-', '*', '/'].includes(key)) {
                    // Si es un operador
                    document.getElementById('operator').value = key;
                    document.getElementById('firstOperand').value = display.value;
                    display.value = '';
                } else if (key === 'Enter') {
                    // Realizar la operación
                    document.getElementById('equal').click();
                } else if (key === 'Escape') {
                    // Limpiar todo con la tecla Escape
                    document.getElementById('clear').click();
                }
            });

            // Función para manejar el clic en los botones
            document.querySelectorAll('.calc-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const value = this.value;
                    if (!isNaN(value) || value === '.') {
                        display.value += value;
                    }
                });
            });
        });
    </script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

    <div class="bg-white p-6 rounded-lg shadow-lg max-w-xs">
        <!-- Pantalla de la calculadora -->
        <form action="index.php" method="POST">
            <div class="mb-4">
                <input type="text" name="display" id="display" class="w-full p-3 text-right bg-gray-100 text-2xl rounded" 
                       placeholder="0" value="<?php echo isset($display) ? $display : ''; ?>" disabled />
            </div>

            <!-- Guardar los operandos y operador en campos ocultos -->
            <input type="hidden" name="firstOperand" id="firstOperand" value="<?php echo isset($firstOperand) ? $firstOperand : ''; ?>">
            <input type="hidden" name="operator" id="operator" value="<?php echo isset($operator) ? $operator : ''; ?>">

            <!-- Botones de la calculadora -->
            <div class="grid grid-cols-4 gap-3">
                <button type="submit" name="button" value="7" class="p-4 bg-gray-200 rounded text-xl calc-btn">7</button>
                <button type="submit" name="button" value="8" class="p-4 bg-gray-200 rounded text-xl calc-btn">8</button>
                <button type="submit" name="button" value="9" class="p-4 bg-gray-200 rounded text-xl calc-btn">9</button>
                <button type="submit" name="button" value="/" class="p-4 bg-yellow-400 rounded text-xl">/</button>

                <button type="submit" name="button" value="4" class="p-4 bg-gray-200 rounded text-xl calc-btn">4</button>
                <button type="submit" name="button" value="5" class="p-4 bg-gray-200 rounded text-xl calc-btn">5</button>
                <button type="submit" name="button" value="6" class="p-4 bg-gray-200 rounded text-xl calc-btn">6</button>
                <button type="submit" name="button" value="*" class="p-4 bg-yellow-400 rounded text-xl">*</button>

                <button type="submit" name="button" value="1" class="p-4 bg-gray-200 rounded text-xl calc-btn">1</button>
                <button type="submit" name="button" value="2" class="p-4 bg-gray-200 rounded text-xl calc-btn">2</button>
                <button type="submit" name="button" value="3" class="p-4 bg-gray-200 rounded text-xl calc-btn">3</button>
                <button type="submit" name="button" value="-" class="p-4 bg-yellow-400 rounded text-xl">-</button>

                <button type="submit" name="button" value="0" class="p-4 bg-gray-200 rounded text-xl calc-btn">0</button>
                <button type="submit" name="button" value="." class="p-4 bg-gray-200 rounded text-xl calc-btn">.</button>
                <button type="submit" name="button" id="equal" value="=" class="p-4 bg-yellow-400 rounded text-xl">=</button>
                <button type="submit" name="button" value="+" class="p-4 bg-yellow-400 rounded text-xl">+</button>
                
                <!-- Botón para limpiar la pantalla -->
                <button type="submit" name="button" id="clear" value="C" class="p-4 bg-red-400 rounded text-xl">C</button>
            </div>
        </form>
    </div>

</body>
</html>
