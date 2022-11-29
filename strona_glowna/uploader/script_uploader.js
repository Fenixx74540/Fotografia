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
        let fileSize;
        //jeśli rozmiar poniżej 1024 to dopisze KB, jeśli powyżej to przeliczy i wypisze MB
        (fileTotal < 1024) ? fileSize = fileTotal + " KB" : fileSize = (loaded / (1024 * 1024)).toFixed(2) + " MB";
        let progressHTML = `<li class="row">
                                <i class="fas duotone fa-file-image"></i>
                                <div class="content">
                                    <div class="details">
                                        <span class="name">${name} ֍ Przesyłanie</span>
                                        <span class="percent">${fileLoaded}%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress style="${fileLoaded}%"></div>
                                    </div>
                                </div>
                            </li>`;
        uploadedArea.classList.add("onprogress");
        progressArea.innerHTML = progressHTML;
        if(loaded == total){
            progressArea.innerHTML = "";
            let uploadedHTML = `<li class="row">
                                    <div class="content">
                                        <i class="fas duotone fa-file-image"></i>
                                        <div class="details">
                                            <span class="name">${name} ֍ Przesłane</span>
                                            <span class="size">${fileSize}</span>
                                        </div>
                                    </div>
                                    <i class="fas fa-check"></i>
                                </li>`;
            uploadedArea.classList.remove("onprogress");
            uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);
        }
    });
    let formData = new FormData(form);
    xhr.send(formData); //wysyła dane do PHP
}

