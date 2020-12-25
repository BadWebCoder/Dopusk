let swtch = 0;
function coverAdd() // добавлегие обложки
{
  if(swtch == 0)
  {
   let block = document.getElementById('addCov');
   let inp = document.createElement("input");
   inp.type = 'file';
   inp.name = 'image';
   block.appendChild(inp); // добавляет тег для добавления файла
   chgButton.innerHTML = "- Убрать обложку";
   swtch++;
  }
  else
  {
     let block = document.getElementById('addCov');
     block.removeChild(block.lastChild);      // убирает тег для добавления файла
     chgButton.innerHTML = "+ Добавить обложку";
     swtch--;
  }
}