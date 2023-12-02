<?php
header('Content-Type: application/json');

// Получаем число count из POST-запроса
$count = isset($_POST['count']) ? intval($_POST['count']) : 0;

// Генерируем указанное количество чисел
$generatedNumbers = generateNumbers($count);

// Возвращаем сгенерированные числа в формате JSON
echo json_encode(['numbers' => $generatedNumbers]);


// Функция для генерации чисел
function generateNumbers($count) {
    $numbers = [];

    for ($i = 0; $i < $count; $i++) {
        $numbers[] = rand(1, 100); // Генерация случайных чисел от 1 до 100
    }

    return $numbers;
}
?>