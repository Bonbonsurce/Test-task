//валидация поля для ввода имени
function validateInput(input) {
    input.value = input.value.replace(/[^А-Яа-я]/g, '');
}
//валидация поля для ввода телефона
function validatePhoneInput(input) {
    if (!input.value.startsWith('+')) {
        input.value = '+' + input.value;
    }
    input.value = input.value.replace(/[^\d+]/g, '');
    if (input.value.length > 1) {
        input.value = `${input.value.substring(0, 2)} ${input.value.substring(2, 5)} ${input.value.substring(5, 8)} ${input.value.substring(8, 10)} ${input.value.substring(10, 12)}`;
    }
}
//закрытие бургера при выборе пункта навигации
function closeMenu() {
    document.getElementById("menu__toggle").checked = false;
}

//проверка заполненности полей, информация о получении заявки
function check() {
    var name = document.getElementById('name_input');
    var phone = document.getElementById('phone_input');
    if (name.value == '' || phone.value.length < 16) {
        alert('Введите данные корректно!');
    }
    else {
        name.value = '';
        phone.value = '';
        var img_1 = document.getElementById('foot_img');
        var img_2 = document.getElementById('foot_img_2');
        img_1.style.display = 'none';
        img_2.style.display = 'block';
        alert('Спасибо за заявку!');
    }
}



