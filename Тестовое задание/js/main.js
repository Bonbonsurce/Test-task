var tableBody;
var id = 1;
//валидация ввода
function validateInput(input) {
    input.value = input.value.replace(/[^А-Яа-я,]/g, '');
}

//добавление вызова функции по enter
document.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        add();
    }
});

//Берем ввод, запрос на сервер
async function add() {
    var str_add = document.getElementById('members').value;
    //Если последний символ - запятая
    var last = str_add[str_add.length - 1];
    if (last == ',') {
        str_add = str_add.slice(0, -1);
    }
    if (str_add == '') {
        alert('Введите имена участников через запятую');
    }
    else {
        document.getElementById('members').value = '';
        str_add = str_add.split(',');
        var count = str_add.length;
        var generatedNumbers;

        try {
            var response = await fetch('php/main.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'count=' + encodeURIComponent(count),
            });

            if (!response.ok) {
                throw new Error('Ошибка при запросе: ' + response.statusText);
            }

            var responseData = await response.json();

            // Проверяем ответ
            if (responseData.numbers) {
                generatedNumbers = responseData.numbers;
            } else {
                console.error('Ответ от сервера не содержит числа.');
            }

        } catch (error) {
            console.error(error);
        }
        fillTable(str_add, generatedNumbers);
    }
}

// Заполняем таблицу
function fillTable(str_add, generatedNumbers) {
    console.log(generatedNumbers);
    tableBody = document.getElementById('table-body');
    var data = [];
    for (let i = 0; i < generatedNumbers.length; i++) {
        var newObj = {};
        newObj.id = id;
        id += 1;
        newObj.name = str_add[i];
        newObj.points = generatedNumbers[i];
        data.push(newObj);
    }

    data.forEach(function (row) {
        var newRow = createTableRow(row);
        tableBody.appendChild(newRow);
    });
}

// Для создания строки таблицы
function createTableRow(data) {
    var row = document.createElement('tr');

    var idCell = document.createElement('td');
    idCell.textContent = data.id;
    row.appendChild(idCell);

    var nameCell = document.createElement('td');
    nameCell.textContent = data.name;
    row.appendChild(nameCell);

    var pointsCell = document.createElement('td');
    pointsCell.textContent = data.points;
    row.appendChild(pointsCell);

    return row;
}

//Сортировка по выбранному столбцу
function sortTable(columnIndex) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("data-table");
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < rows.length - 1; i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("td")[columnIndex];
            y = rows[i + 1].getElementsByTagName("td")[columnIndex];

            var xValue = isNaN(parseInt(x.innerHTML)) ? x.innerHTML.toLowerCase() : parseInt(x.innerHTML);
            var yValue = isNaN(parseInt(y.innerHTML)) ? y.innerHTML.toLowerCase() : parseInt(y.innerHTML);

            if (xValue > yValue) {
                shouldSwitch = true;
                break;
            }
        }

        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}




