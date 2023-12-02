<?php
//пределяем интерфейсы почты с методом расчета стоимости
interface Post {
    public function calculatePrice($weight);
}
//определяем класс, реализующий интерфейс
class RussianPost implements Post {
    public function calculatePrice($weight) {
        if ($weight <= 10) {
            return 100;
        } else {
            return 1000;
        }
    }
}

class DHL implements Post {
    public function calculatePrice($weight) {
        return $weight * 100;
    }
}

$russianPost = new RussianPost();
$dhl = new DHL();

$weight_rus = 9;
$weight_dhl = 20;

echo "Стоимость доставки Почтой России: " . $russianPost->calculatePrice($weight_rus) . " руб.\n";
echo "Стоимость доставки DHL: " . $dhl->calculatePrice($weight_dhl) . " руб.\n";
?>
