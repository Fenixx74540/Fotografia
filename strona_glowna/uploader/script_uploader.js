const form = document.querySelector("form"),
fileInput = form.querySelector(".file-input"),
progressArea = document.querySelector(".progress-area"),
uploadedArea = document.querySelector(".progress-area");

form.addEventListener("click", ()=>{ //uruchomienie okna wyboru pliku po kliknięciu w wykropkowanym obszarze 
    fileInput.click();
});

fileInput.onchange = ({target}) =>{
    let file = target.files[0]; // otrzymywanie pliku i nazwy
    if(file) { //jeśli plik jest wybrany
        let fileName = file.name; //otrzymanie nazwy wybranego pliku
        uploadFile(fileName); //wywołuje uploadFile z nazwą pasującą do pliku jako argument
    }
}

function uploadFile(name){
    let xhr = new XMLHttpRequest(); //stworzenie nowego obiektu xml
    xhr.open("POST", "php/upload.php"); //wysyła rządanie POST na określony URL/File
    xhr.upload.addEventListener("progress", ({loaded, total}) =>{
        let fileLoaded = Math.floor((loaded / total) * 100); //obliczenie procentu przesłanego pliku
        let fileTotal = Math.floor(total / 1000); //rozmiar pliku w KB
        let progressHTML = `<li class="row">
                                <i class="fas duotone fa-file-image"></i>
                                <div class="content">
                                    <div class="details">
                                        <span class="name">Testowy_plik.jpg ֍ Wysyłanie...</span>
                                        <span class="percent">50%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress"></div>
                                    </div>
                                </div>
                            </li>`;

        let uploadedHTML = '';
    });
    let formData = new FormData(form);
    xhr.send(formData); //wysyła dane do PHP
}

