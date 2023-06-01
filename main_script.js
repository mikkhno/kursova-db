// СКРИПТ ДО MAIN.PHP
//Пошук прізвища
function SearchSurname() {
  var input, filter, table, tr, td, i, txtValue,
  occ, td_occ, txt_occ;
  input = document.getElementById("searching_surname");
  occ = document.getElementById("sort").value;
  filter = input.value.toUpperCase();
  table = document.getElementById("employers");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
    td_occ = tr[i].getElementsByTagName("td")[5];
    
    if (td || td_occ) {
      txtValue = td.textContent || td.innerText;
      txt_occ = td_occ.textContent || td_occ.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1 || (occ && txt_occ==occ)) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
};










