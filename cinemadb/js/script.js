// js για να μην κανει resubmit την form οταν γινεται refresh
if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }

// Get the modal
var modal1 = document.getElementById('id01');
var modal2 = document.getElementById('id02');
var modal3 = document.getElementById('id03');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal1) {
        modal1.style.display = "none";
    }
    if (event.target == modal2) {
        modal2.style.display = "none";
    }
    if (event.target == modal3) {
        modal3.style.display = "none";
    }
  
}




//++++++++    Rest API για τις χωρες
const xhttp2 = new XMLHttpRequest();
const select2 = document.getElementById("countries");
const flag = document.getElementById("flag");

let countries;

xhttp2.onreadystatechange = function(){
    console.log('this.status', this.status);
    if (this.readyState == 4 && this.status ==200){
        countries = JSON.parse(xhttp2.responseText);
        assignValues2();
        //handleCountryChange();
    }
};
xhttp2.open("GET", "https://countriesnow.space/api/v0.1/countries", true);
xhttp2.send();

function assignValues2(){
    countries['data'].forEach(data => {
        const option = document.createElement("option");
        console.log('data', data)
        option.value = data.country;
        option.textContent = data.country;
        select2.appendChild(option);
    });
}

//++++++++  Rest API για τις πολεις
function showCities(){

    const xhttp = new XMLHttpRequest();
    const select = document.getElementById("cities");
    const selectedCountry = document.getElementById("countries").value;

    let cities;

    xhttp.onreadystatechange = function(){
        console.log('this.status', this.status);
        if (this.readyState == 4 && this.status ==200){
            cities = JSON.parse(xhttp.responseText);
            assignValues();
            //handleCountryChange();
        }
    };
    xhttp.open("GET", "https://countriesnow.space/api/v0.1/countries/population/cities", true);
    xhttp.send();

    select.length=0;
    function assignValues(){
        cities["data"].forEach(data => {
            if(data.country==selectedCountry){
            const option = document.createElement("option");
            console.log('data', data)
            option.value = data.city;
            option.textContent = data.city;
            select.appendChild(option);
            }
        });
    }
}
