
let userSize = prompt("Choice field size", 3);  // задаем размер поля
let table = document.getElementById('feld');   // получаем данные тега таблицы
let colors = ['red', 'green', 'blue'];   // цвета ячеек
let stepCount = 0;   // кол-во шагов

function getRandomInt(max) {
	return Math.floor(Math.random() * (max + 1));   // функция для рандомного выбора
}

function random(arr) {
	return arr[getRandomInt(arr.length - 1)]; // функция для рандомного выбора индекса массива с цветами
}

function createField(size){   // функция создания поля
	for (let tblRow = 0; tblRow < size; tblRow++){   // цикл создания строк таблицы
		let tr = document.createElement('tr');   // создание строки таблицы
		for (let tblColl = 0; tblColl < size; tblColl++){   // цикл создания ячеек для каждой строки таблицы
			let td = document.createElement('td');   // создает ячейку для строки таблицы
			td.classList.add(random(colors))   // рандомный цвет для ячейки
			td.addEventListener("click", step)   // добавление ячейки выполнение функции при нажатии
			tr.appendChild(td);   // добавляет ячейку в строку таблицы
		}
	table.appendChild(tr);   // создает строку таблицы
	}
}

function step() {   // функция шагов при нажатии
	stepCount += 1;   // при нажатии увеличивается кол-во шагов
    let color = colors.indexOf(this.classList.item(0))   // индекс цвета ячейки
	if (color == colors.length-1) this.classList.add(colors[0])  // если цвет ячейки последний в массиве, то берется цвет из начала массива
    else this.classList.add(colors[color+1]) // иначе просто просто при нажатии цвета идут друг за другом
	this.classList.remove(colors[color]) // удаляет предыдущее имя класса   
	if (isVictory(cells)) {   // если существует функция победы
		alert("Победа, количество шагов: "+ stepCount); // вывод победного окна с кол-вом сделанных шагов
	}
}

function isVictory(cells) {   // функция условия победы
	let cellsColor = []; // массив
	for (let cell of cells) cellsColor.push(cell.classList.item(0)); // заталкиваем все названия классов ячеек в массив
	for (let i = 0; i < cellsColor.length; i++) { // перебираем все ячейки
        while(cellsColor[i] != cellsColor[0]) return false; // возвращает ложь, пока хоть какой то класс ячейки не равен классу первой ячейки
    } 
	return true; // возвращает истину, если все именя классов равны
}
createField(userSize)   // вызов функции для создания поля
let cells = document.querySelectorAll('td');   // выбираем все поле