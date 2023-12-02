/**
* @charset UTF-8
*
* Задание 2. Работа с массивами и строками.
*
* Есть список временных интервалов (интервалы записаны в формате чч:мм-чч:мм).
*
* Необходимо написать две функции:
*
*
* Первая функция должна проверять временной интервал на валидность
* 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм)
* 	возвращать boolean
*
*
* Вторая функция должна проверять "наложение интервалов" при попытке добавить новый интервал в список существующих
* 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм). Учесть переход времени на следующий день
*  возвращать boolean
*
*  "наложение интервалов" - это когда в промежутке между началом и окончанием одного интервала,
*   встречается начало, окончание или то и другое одновременно, другого интервала
*
*  пример:
*
*  есть интервалы
*  	"10:00-14:00"
*  	"16:00-20:00"
*
*  пытаемся добавить еще один интервал
*  	"09:00-11:00" => произошло наложение
*  	"11:00-13:00" => произошло наложение
*  	"14:00-16:00" => наложения нет
*  	"14:00-17:00" => произошло наложение
*/

# Можно использовать список:
<?php
//валидация времени
function validate_time($time) {
    $pattern = '/^([01]?[0-9]|2[0-3]):[0-5][0-9]-([01]?[0-9]|2[0-3]):[0-5][0-9]$/';
    if (preg_match($pattern, $time) === 0) {
        return false;
    }
    $hour_1 = substr($time, 0, 2);
    $hour_2 = substr($time, 6, 2);
    $min_1 = substr($time, 3, 2);
    $min_2 = substr($time, 9, 2);

    if (intval($hour_1) > 23 || intval($hour_2) > 23 || intval($min_1) > 59 || intval($min_2) > 59) {
        return false;
    }

    $time1 = substr($time, 0, 5);
    $time2 = substr($time, 6, 5);

    $dateTime1 = DateTime::createFromFormat('H:i', $time1);
    $dateTime2 = DateTime::createFromFormat('H:i', $time2);

    if ($dateTime1 > $dateTime2) {
        return false;
    }
    return true;
}

//проверка на возможность дополнения интервала
function validate_interval($time) {
    global $list;
    $time1 = substr($time, 0, 5);
    $time2 = substr($time, 6, 5);

    $newDate_1 = DateTime::createFromFormat('H:i', $time1);
    $newDate_2 = DateTime::createFromFormat('H:i', $time2);

    foreach ($list as $el) {
        $el_1 = substr($el, 0, 5);
        $el_2 = substr($el, 6, 5);

        $existDate_1 = DateTime::createFromFormat('H:i', $el_1);
        $existDate_2 = DateTime::createFromFormat('H:i', $el_2);

        if (($newDate_1 > $existDate_1 && $newDate_1 < $existDate_2) || //начало внутри существующего времени
            ($newDate_2 > $existDate_1 && $newDate_2 < $existDate_2) || //окончание внутри существующего
            ($newDate_1 <= $existDate_1 && $newDate_2 >= $existDate_2)) { //полностью внутри
            return false;
        }
    }
    $list[] = $time;
    return true;
}
$list = array (
    '09:00-11:00',
    '11:00-13:00',
    '15:00-16:00',
    '17:00-20:00',
    '20:30-21:30',
    '21:30-22:30',
);

echo "Введите количество интервалов: ";

$n = fgets(STDIN);
$n = trim($n);
$n = intval($n);
for ($i = 1; $i <= $n; $i++) {
    $time = fgets(STDIN);
    $time = trim($time);

    if (!validate_time($time)) {
        echo "Ошибка: Неправильный формат времени.\n";
        continue;
    }

    if (!validate_interval($time)) {
        echo "произошло наложение интервалов.\n";
    } else {
        echo "наложения нет.\n";
    }
}

print_r($list);
?>
