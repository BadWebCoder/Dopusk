for (let year = 1975; year <= 2020; year++) 
{
    let options = document.createElement("option");
    document.getElementById("year").appendChild(options).innerHTML = year; // задает в выпадающий список года
    options.value = year;
}