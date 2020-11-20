function start(cells) { // основная функция для каждого хода
	let i = 0; // счетчик ходов	
	for (let cell of cells) { // пока все ячейки не заполнены
		cell.addEventListener('click', function step() { // при нажатии на одну из ячеек активируется функция
//			this.innerHTML = ['X', 'O'][i % 2];
			if (i % 2 == 0) { // очередность ходов в зависимости от остатка
				this.innerHTML = 'X'; // если остаток 0
			} else {
				this.innerHTML = '0'; // если остаток 1
			}
			this.removeEventListener('click', step); // удаляет функцию у ячейки, чтобы нельзя было еще раз на нее нажать 
			if (isVictory(cells)) { // если есть одна из выигрышных комбинаций
				alert("Победили "+this.innerHTML); // выводим имя победителя
			}
			else if (i == 8) {
				alert('ничья'); // иначе ничья
			}			
			i++;
		});
	}
	}
	function isVictory(cells) { // функция для определения победы
	let combs = [ // выйгрышные комбинации
		[0, 1, 2],
		[3, 4, 5],
		[6, 7, 8],
		[0, 3, 6],
		[1, 4, 7],
		[2, 5, 8],
		[0, 4, 8],
		[2, 4, 6],
	];
	for (let comb of combs) { // перебор всех выйгрышных комбинаций
		if ( // если какая-то из выйгрышных комбинаций совпадает
			cells[comb[0]].innerHTML == cells[comb[1]].innerHTML &&
			cells[comb[1]].innerHTML == cells[comb[2]].innerHTML &&
			cells[comb[0]].innerHTML != ''
		) {
			return true; // возвращает истину
		}
	}
	return false; // иначе возвращает ложь
	}
	let cells = document.querySelectorAll('#field td') // выбирает блоки в таблице
	start(cells) // запуск функции