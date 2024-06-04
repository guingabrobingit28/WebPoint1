function logOut() {
  document.getElementById("logout-link").addEventListener("click", function(event) {
    event.preventDefault();

    Swal.fire({
    title: 'Are you sure you want to logout?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "logout.php";
    }
  });
});
}
//Search function
function mySearch() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    table = document.getElementById("tblInventory");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td");
      for(j=0; j < td.length; j++){
      if (td[j]) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
            break;
          } else {
            tr[i].style.display = "none";
          }
        }
      }       
    }
}
// function poll() {
//   // create an XMLHttpRequest object
//   var xhr = new XMLHttpRequest();

//   // set the callback function
//   xhr.onreadystatechange = function() {
//     if (xhr.readyState === 4 && xhr.status === 200) {
//       // update the table with the new data
//       document.getElementById("tblInventory").innerHTML = xhr.responseText;
//     }
//   };

//   // open the request with the URL of the PHP file
//   xhr.open("GET", "./trackOrders.php", true);

//   // send the request
//   xhr.send();
// }

// // call the poll function every 5 seconds
// setInterval(poll, 5000);

//Sorting Tables
/**
 * 
 * @param {HTMLTableElement} table To sort the table
 * @param {number} column index of the column to sort
 * @param {boolean} asc to determine if the table is ascending order 
 */ 
function sortTableColumn(table, column, asc = true){
  const dirModifier = asc ? 1 : -1;
  
  const tBody = table.tBodies[0];
  const rows = Array.from(tBody.querySelectorAll("tr"));

  // Sort for each row
  const sortedRows = rows.sort((a,b) => {
    const aColText = a.querySelector(`td:nth-child(${ column + 1})`).textContent.trim();
    const bColText = b.querySelector(`td:nth-child(${ column + 1})`).textContent.trim();
    
    return aColText > bColText ? (1 * dirModifier) : (-1 * dirModifier);
  });

  while (tBody.firstChild){
    tBody.removeChild(tBody.firstChild);
  }

  //re-add new sorted rows
  tBody.append(...sortedRows);

  //Remember column current sorted
  table.querySelectorAll("th").forEach(th => th.classList.remove("th-sort-asc", "th-sort-desc"));
  table.querySelector(`th:nth-child(${ column + 1})`).classList.toggle("th-sort-asc", asc);
  table.querySelector(`th:nth-child(${ column + 1})`).classList.toggle("th-sort-desc", !asc);
}

document.querySelectorAll(".table-sortable th").forEach(headersCell => {
  headersCell.addEventListener("click", () => {
    const tableElement = headersCell.parentElement.parentElement.parentElement;
    const headerIndex = Array.prototype.indexOf.call(headersCell.parentElement.children, headersCell);
    const currentIsAscending = headersCell.classList.contains("th-sort-asc");

    sortTableColumn(tableElement, headerIndex, !currentIsAscending);
  });
});



(function ($) {
    "use strict";

    // Sidebar Toggler
    $('.sidebar-toggler').click(function () {
        $('.sidebar, .content').toggleClass("open");
        return false;
    });
    
    // // Progress Bar
    // $('.pg-bar').waypoint(function () {
    //     $('.progress .progress-bar').each(function () {
    //         $(this).css("width", $(this).attr("aria-valuenow") + '%');
    //     });
    // }, {offset: '80%'});

}
)(jQuery);

  