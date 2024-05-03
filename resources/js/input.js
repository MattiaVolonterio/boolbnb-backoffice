// get address
const searchInput = document.getElementById('address');

// get latitude
const lat = document.getElementById('lat');

// get longitude
const lon = document.getElementById('lon');

const form = document.getElementById('form');

// get search button
const searchBtn = document.getElementById('search_btn');

const apiKey = 'cXFRhnBAXKnWWIK6455uRtxFdwAGvyV2';

// axios call
function fetchAddress (){
    // tomtom api
    axios.get(`https://api.tomtom.com/search/2/geocode/${searchInput.value}.json?typeahead=true&limit=3&countrySet=IT&lat=37.337&lon=-121.89&view=Unified&key=${apiKey}`)
        .then(response => {
        console.log(response.data);
    })


    // console.log(`https://api.tomtom.com/search/2/geocode/${searchInput.value}.json?typeahead=true&limit=3&countrySet=IT&lat=37.337&lon=-121.89&view=Unified&key=${apiKey}`)

};

searchBtn.addEventListener('click', () => {

    console.log('ciao');

    fetchAddress ();
});


