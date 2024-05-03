// const { default: axios } = require("axios");

// get address
const searchInput = document.getElementById("address");

// get latitude
const lat = document.getElementById("lat");

// get longitude
const lon = document.getElementById("lon");

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
                suggestion.innerHTML += `<div>${address}</div>`;
            });
        });
}

searchBtn.addEventListener("click", () => {
    fetchAddress();
});
