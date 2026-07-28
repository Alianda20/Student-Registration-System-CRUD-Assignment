document.getElementById("search").addEventListener("keyup", function(){

    let keyword = this.value;

    fetch("search_ajax.php?search=" + encodeURIComponent(keyword))
    .then(response => response.text())
    .then(data => {

        document.getElementById("result").innerHTML = data;

    });

});