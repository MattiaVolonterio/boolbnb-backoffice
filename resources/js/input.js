// const { default: axios } = require("axios");

// get address
const searchInput = document.getElementById("address");

// get latitude
const lat = document.getElementById("lat");
const latTxt = document.getElementById("latitude");

// get longitude
const lon = document.getElementById("lon");
const lonTxt = document.getElementById("longitude");

const form = document.getElementById("form");

// get search button
const searchBtn = document.getElementById("search_btn");

const suggestion = document.getElementById("suggestion");

const apiKey = "cXFRhnBAXKnWWIK6455uRtxFdwAGvyV2";

// axios call
function fetchAddress() {
    suggestion.innerHTML = "";
    axios
        .get(
            `https://api.tomtom.com/search/2/geocode/${searchInput.value}.json?typeahead=true&limit=3&countrySet=IT&lat=37.337&lon=-121.89&view=Unified&key=${apiKey}`
        )
        .then((response) => {
            const results = response.data.results;
            results.forEach((result) => {
                const address = result.address.freeformAddress;
                const latitude = result.position.lat;
                const longitude = result.position.lon;
                createSuggestion(address, latitude, longitude);
            });
        });
}

// function create suggestion
function createSuggestion(address, latitude, longitude) {
    suggestion.classList.remove("d-none");
    const addressContainer = document.createElement("div");
    addressContainer.classList.add("suggested-address");
    addressContainer.innerHTML = address;
    addressContainer.addEventListener("click", () => {
        searchInput.value = address;
        lat.value = latitude;
        latTxt.innerText = `Lat: ${latitude}`;
        lon.value = longitude;
        lonTxt.innerText = `Lon: ${longitude}`;
        suggestion.classList.add("d-none");
    });
    suggestion.append(addressContainer);
}

// searchBtn.addEventListener("click", () => {
//     fetchAddress();
// });

searchInput.addEventListener("input", () => {
    fetchAddress();
});

document.addEventListener("click", () => {
    suggestion.classList.add("d-none");
});

// ------------------------------------------------------

// get element input file
const fileInput = document.getElementById('apartment_images');

// event listener on input file
fileInput.addEventListener('change', function() {
    // get files list
    const fileList = fileInput.files;
    // get files index
    const numFiles = fileList.length;

    if (numFiles == 1) {
        document.getElementById('files').innerHTML = numFiles + ' foto selezionata';
    } else {
        document.getElementById('files').innerHTML = numFiles + ' foto selezionate';
    }

});
