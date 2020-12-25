let i = document.getElementById('crt').getElementsByTagName('select').length - 1; // счетчик списков
function add() // добавление вложенного списка
{
  let form = document.getElementById("crt"); // обращение к блоку со списками
  let sel = document.createElement("select"); // создает вложенный список
      sel.innerHTML = '<option disabled="" selected=""></option> <option value="1"> NES/Famicom </option> <option value="2"> SNES </option> <option value="3"> N64 </option> <option value="4"> GB </option> <option value="5"> GBC </option> <option value="6"> GBA </option> <option value="7"> Sega Genesis </option> <option value="8"> Sega Saturn </option> <option value="9"> Dreamcast </option>';
      // добавление в список элементов
      sel.name = "platform[]"; // имя вложенного списка
      sel.setAttribute("required",true);
      sel.className = "selec";
      form.appendChild(sel); // добавляет список на страницу
   i++;
}

function del() // удаление вложенного списка
{
   if(i > 0) // если списков больше 1, то можно удалять
   {
      document.getElementsByName("platform[]")[i].remove();
    i--;
   }
}