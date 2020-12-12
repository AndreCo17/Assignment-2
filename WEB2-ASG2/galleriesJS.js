/* inititializes map from Google's API */
function initMap() {

    map = new google.maps.Map(document.querySelector("div#map"), {
        center: { lat: 41.89474, lng: 12.4838 },
        zoom: 6
    });
}

//Fetches galleries api and stores it within local storage. If api is already stored set api to local storage
document.addEventListener("DOMContentLoaded", function () {
    const API = "api-galleries.php";

    fetch(API)
        .then(resp => resp.json())
        .then(data => {
            populateGalleries(data);
        })
        .catch(err => console.error(err));

    /* LocalStorage not working as of 10:30am December 10th 2020 */

    /* if (localStorage.getItem("gallery") === null) {
        fetch(galleryAPI)
            .then(resp => resp.json())
            .then(gallery => {
                localStorage.setItem("gallery", JSON.stringify(gallery));
                populateGalleries(gallery);
            })
            .catch(err => console.error(err));
        console.log("was null");
    } else {
        const gallery = JSON.parse(localStorage.getItem("gallery"));
        populateGalleries(gallery);
        console.log("not null");
    } */


    /* populates galleryList section, populate galleryInfo section,
    generate the list of paintings in selected gallery and displays map with the gallery's location */
    function populateGalleries(data) {
        const list = document.querySelector("#galleries");

        for (let d of data) {
            let li = document.createElement("li");
            li.textContent = d.GalleryName;

            li.addEventListener("click", function () {
                galleryInfo(d);
                generatePaintings(d);
                createMap(d);
            });

            list.appendChild(li);
        };

    }

    /* fills in the information for each selected gallery including:
    name, native name, city, address, country and its museum website */
    function galleryInfo(gallery) {

        document.querySelector(".info").style.display = "inline";
        document.querySelector("#galleryName").innerHTML = gallery.GalleryName + "<br>";;
        document.querySelector("#galleryNative").innerHTML = gallery.GalleryNativeName + "<br>";;
        document.querySelector("#galleryCity").innerHTML = gallery.GalleryCity + "<br>";;
        document.querySelector("#galleryAddress").innerHTML = gallery.GalleryAddress + "<br>";;
        document.querySelector("#galleryCountry").innerHTML = gallery.GalleryCountry + "<br>";;

        const a = document.querySelector("#website");
        a.setAttribute("href", gallery.GalleryWebSite);
        document.querySelector("#galleryInfo .info").appendChild(a);
    }

    /* create a map using Google's API */
    function createMap(gallery) {
        map = new google.maps.Map(document.querySelector("div#map"), {
            center: { lat: parseFloat(gallery.Latitude), lng: parseFloat(gallery.Longitude) },
            zoom: 18,
            mapTypeId: 'satellite'
        });
    }

    /* fetches the information from paintings.php */
    function generatePaintings(d) {
        fetch(`api-paintings.php?galleryID=${d.GalleryID}`)
            .then(response => response.json())
            .then(paintingsData => {
                populatePaintingsTable(paintingsData);
                sortingTable(paintingsData);
            }).catch(err => console.error(err));
    }

    /* creates the list of paintings in the gallery which can be sorted by name, title and yearOfWork */
    function populatePaintingsTable(paintingsData) {
        let paintingsTable = document.querySelector("tbody");
        paintingsTable.textContent = "";

        for (let p of paintingsData) {
            //create new row
            let row = document.createElement("tr");

            //appends new row to table
            paintingsTable.appendChild(row);

            //creating td elements
            let imgtd = document.createElement("td");
            let artist = document.createElement("td");
            let linkToSingle = document.createElement("a");
            let title = document.createElement("td");
            let yow = document.createElement("td");

            let img = document.createElement("img");
            img.src = smallImage(p.ImageFileName);
            img.value = p.ImageFileName;
            linkToSingle.href = `single-painting.php?paintingID=${p.PaintingID}`;

            //checks if either first and last name are null and replaces them with an empty string
            if (p.LastName == null) {
                artist.innerHTML = p.FirstName + "<br>";
            } else if (p.FirstName == null) {
                artist.innerHTML = p.LastName + "<br>";
            } else {
                artist.innerHTML = p.FirstName + " " + p.LastName + "<br>";
            }

            //changes the content of the element
            title.textContent = p.Title;
            yow.innerHTML = p.YearOfWork + "<br>";

            //appends each painting info into the new row
            imgtd.appendChild(img);
            row.appendChild(imgtd);
            row.appendChild(artist);
            row.appendChild(linkToSingle);
            linkToSingle.appendChild(title);
            row.appendChild(yow);

        }
    }

    /* sorts the table of painting based on user's input(click) */
    function sortingTable(paintings) {
        let artist = document.querySelector("#artist");
        let year = document.querySelector("#year");
        let title = document.querySelector("#title");

        artist.addEventListener("click", function () {
            let sortedArtists = paintings.sort((a, b) => {
                return a.LastName < b.LastName ? -1 : 1;
            })
            populatePaintingsTable(sortedArtists);
        });
        year.addEventListener("click", function () {
            let sortedYears = paintings.sort((a, b) => {
                return a.YearOfWork < b.YearOfWork ? -1 : 1;
            })
            populatePaintingsTable(sortedYears);
        });
        title.addEventListener("click", function () {
            let sortedTitles = paintings.sort((a, b) => {
                return a.Title < b.Title ? -1 : 1;
            })
            populatePaintingsTable(sortedTitles);
        });
    }

    /* retrieves data from the cloud and returns the image passed in with a size of 55px x 55px */
    function smallImage(filename) {
        let size = "w_55";
        return `https://res.cloudinary.com/funwebdev/image/upload/${size}/art/paintings/${filename}`;
    }
}
);