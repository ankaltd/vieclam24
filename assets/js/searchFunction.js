// searchFunction.js

function performSearch() {

  var searchQuery = document.querySelector(".search-field").value.trim();

  if (searchQuery !== "") {

    var searchUrl = "/?s=" +  encodeURIComponent(searchQuery);

    window.location.href = searchUrl;

  }

}



export { performSearch }; // Xuất hàm performSearch để có thể import vào module khác

