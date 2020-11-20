let n = 2 // начальный размер таблицы
let del = 0;
let init=0; // выключатель
let startDate; // нынешнее время
let clocktimer; // время в таймере
function tables() // функция создания таблицы
{
  findTIME();
  let num = n; // размер таблицы
  let j = 0; // счетчик для ячеек
  let i = 0 // счетчик для условия цикла
  let arr = []; // массив
  while(i < num*num) // пока i меньше чем размер массива
  {
    arr[i] = i+1; 
    i++; // добавляются числа по порядку в массив от 0 и более
  }
  arr = (shuffle(arr)) // перемешивание чисел в массиве через функцию
  let num1 = num;
  let mun;
  while(num > 0) // цикл генерирующий столбы таблицы
  {
      mun = num1 // служит счетчиком для генерации ячеек
      let tab = document.getElementById("field"); 
      let tr = document.createElement("tr");
      tab.appendChild(tr); // создание столбца в таблице
      while(mun > 0)  // генерация ячеек в столбцах
      {
        let td = document.createElement("td");
        td.classList.add(j);
        tr.appendChild(td); // создание ячейки в столбце таблицы
        td.innerHTML = arr[j]; // добавление числа в ячейку
        j++;
        mun--;
      }
      num--;
  }
  let cells = document.querySelectorAll('#field td') // выбирает блоки в таблице
  gameplay(cells); // запуск функции

}

function shuffle(arr) // функция берет значение массива arr
{ 
	let result = []; // будет хранится массив с перемешанными числами
  while (arr.length > 0) // пока длина массива меньше 0 
  { 
		let random = getRandomInt(0, arr.length - 1); // получаем рандомное число
		let elem = arr.splice(random, 1)[0]; // вырезаем из массива и записываем в переменную
		result.push(elem); // заталкиваем в новый массив
	}
	return result; // возвращаем перемешанный массив
}

function getRandomInt(min, max) // функция для выбора рандомного числа
{ 
	return Math.floor(Math.random() * (max - min + 1)) + min;
}

function gameplay(cells) // функция процесса игры
{
  let i = 0;
  for (let cell of cells) 
  {
    cell.addEventListener('click', function step() // при нажатии на одну из ячеек активируется функция
    {
      if(i+1 ==  this.innerText) // если значение i+1 равен числу в ячейки
      {
        this.style.background = 'black'; // ячейка красится в красный
        this.style.transition = "0.3s";
        i++; // счетчик растет
        if(i == n*n) // если счетчик равен размеру игрового поля
        {
          let j = Math.sqrt(i); // кол-во строк в таблице
          while(j > 0) 
          {
            document.getElementById('field').deleteRow(del); // цикл для очищения таблицы
            j--;
          }
          n++; // увеличение размера игрового поля
          findTIME();
          tables(); // игра начинается заново, но с увеличенным полем
        }
      } 
    });
	}
}

 function clearFields() { // функция очищения поля с таймером
  init = 0; // выключатель  снова равен 0
  clearTimeout(clocktimer); // очищает переменную в которой выполняется setTimeout
  document.clockform.clock.value='00:00.00';
  document.clockform.label.value='';
 }

 function startTIME() { // функция запуска таймера
  let thisDate = new Date(); // объект с нынешними датой и временем
  let t = thisDate.getTime() - startDate.getTime(); // получаем начальное время, то есть 0
  let ms = t%1000; t-=ms; ms=Math.floor(ms/10); // милисекунды
  t = Math.floor (t/1000);
  let s = t%60; t-=s; // секунды
  t = Math.floor (t/60);
  let m = t%60; t-=m; // минуты
  if (m<10) m='0'+m;
  if (s<10) s='0'+s;
  if (ms<10) ms='0'+ms; // если часы, минуты, секунды, милисекунды меньше 10, то к ним добавляется 0
  if (init==1) document.clockform.clock.value = m + ':' + s + '.' + ms; // если переключатель равен 1
  clocktimer = setTimeout("startTIME()",10); // каждую милисекунду операция повторяется
 }

 function findTIME() { // функция при нажатии
  if (init==0) { // если значение 0
   startDate = new Date(); // объект с нынешними датой и временем
   startTIME(); // запуск функции подсчета времени с момента начала игры
   init=1; // значение = 1
  } 
  else {
   alert("Вы прошли уровень за время: " + document.clockform.clock.value);
   clearFields(); // функция очищения времени
  }
 }

tables(); // начало игры

