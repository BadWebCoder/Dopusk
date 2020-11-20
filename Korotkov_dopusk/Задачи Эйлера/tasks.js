function kratnie() // Первая задача Эйлера
{
    let n = document.getElementById("val").value; // получаем введенное число
    let sum = 0; // здесь будет хранится сумма кратных
    for(let i = 0; i < n; i++) // перебор всех чисел от 0 до указанного пользователем
    {
      if(i % 3 === 0 || i % 5 === 0) sum += i; // если число кратно 3 или 5, то складывается с остальными кратными
    }
    document.getElementById("res").innerHTML = "Ответ: " + sum; // вывод суммы кратных чисел
}

function fibonachi() // Вторая задача Эйлера
{
  let n = document.getElementById("val").value; // вводимое пользователем число
  let a = 1; // первое число
  let b = 1; // второе число
  let c = a + b; // сумма двух чисел
  let chet = c; // счетчик четных чисел Фибоначчи
  while(c <= n) // пока числа меньше указанного пользователем
  {
    a = b; // первому числу присваивается второе
    b = c // второму числу присваивается сумма двух чисел
    c = a + b; // снова сумма двух чисел
    if (c % 2 == 0 && c <= n)  chet += c; // если число делится без остатка и оно меньше 4 млн то сумма четных чисел увеличивается  
  }
  document.getElementById("res").innerHTML = "Ответ: " + chet; // вывод суммы четных чисел Фибоначчи
}

function maxPalindrom() // Четвертая задача Эйлера
{
let res1;
let max = 0; // будет хранится макс. палиндром
for(let num1 = 999; num1 > 99; num1--)
{
  for(let num2 = 999; num2 > 99; num2--) // циклы, перебирающие все 3-х значные числа
  {
    res1 = num1*num2; // произведение чисал
    let one = res1 % 10;
    let del1 = Math.floor(res1/10);  // разбивание произведения на отдельные цифры
    let two = del1 % 10;
    let del2 = Math.floor(del1/10);
    let three = del2 % 10;
    let del3 = Math.floor(del2/10);
    let four = del3 % 10;
    let del4 = Math.floor(del3/10);
    let five = del4 % 10;
    let del5 = Math.floor(del4/10);
    let six = del5 % 10;
    if((one==six) && (two == five) &&            //если крайние числа равны друг другу
    (three == four) && (max < res1)) max = res1; //и макс. палиндром меньше чем тот, который сейчас перебирается, то он заменяется им
  }
}
document.getElementById("res").innerHTML = "Наибольший палиндром: " + max; // вывод наибольшего палиндрома
}

function sqrSum()
{
  let n = document.getElementById("val").value; // кол-во натуральных чисел вводимых пользователем
  if(n <= 100000)
  {
    let a = 0;
    let b = 0;
    let c = 0;
    for (let i = 1; i <= n; i++) // перебираются числа от 0 до числа введенного пользователем
    {
      a += i; // сумма чисел от 1 до введенного пользователем
      b += Math.pow(i, 2); // сумма квадратов
    }
    c = Math.pow(a, 2); // квадрат суммы
    document.getElementById("res").innerHTML = "Ответ: " + (c - b); // выводит результат
  }
  else alert("Слишком большое число");
}