const form = document.querySelector("form"),
statusTxt = form.querySelector(".button span");

form.onsubmit = (e)=>{
    e.preventDefault();// uniemożliwienie przesłania formularza
    statusTxt.style.color = "#349e69";
    statusTxt.style.display = "block";

    let xhr = new XMLHttpRequest(); // tworzenie nowego obiektu do interakcji z serwerem
    xhr.open("POST", "wiadomosc.php", true); // wysłanie żądania wysłania wiadomości
    xhr.onload = ()=>{ //po załądowaniu ajaxa
        if(xhr.readyState == 4 && xhr.status == 200){ //jesli status 200 i status gotowości 4 to nie ma errora
            let response = xhr.response; // przechowywanie odpowiedzi ajax w zmiennej odpowiedzi
            //zmiana koloru na czerwony jeśli wystąpi error
            if(response.indexOf("Wpisz dane do pola wiadomość i email") != -1 || response.indexOf("Podaj poprawny e-mail") ||  response.indexOf("Bład podczas wysyłania wiadomości")){
                statusTxt.style.color = "red";
            }else{
                form.reset();
                setTimeout(()=>{
                    statusTxt.style.display = "none";
                }, 5000); // ukrycie komunikatu po 5s
            }
            statusTxt.innerText = response;
        }
    }
    let formData = new FormData(); // nowy obiekt do wysłania formatu daty
    xhr.send(formData); 
}