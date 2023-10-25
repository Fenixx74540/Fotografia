const form = document.querySelector("form"),
statusTxt = form.querySelector(".button-area span");

form.onsubmit = (e)=>{
  e.preventDefault(); // uniemożliwienie przesłania formularza
  statusTxt.style.color = "#349e69";
  statusTxt.style.display = "block";
  statusTxt.innerText = "Wysyłanie wiadomości...";
  form.classList.add("disabled");

  let xhr = new XMLHttpRequest(); // tworzenie nowego obiektu do interakcji z serwerem
  xhr.open("POST", "formularz/wiadomosc.php", true); // wysłanie żądania wysłania wiadomości
  xhr.onload = ()=>{ //po załądowaniu ajaxa
    if(xhr.readyState == 4 && xhr.status == 200){ //jesli status 200 i status gotowości 4 to nie ma errora
      let response = xhr.response; // przechowywanie odpowiedzi ajax w zmiennej response
      if(response.indexOf("Pola E-mail oraz notka są wymagane") != -1 || response.indexOf("Podaj poprawny adres E-mail") != -1 || response.indexOf("Przepraszamy, mamy problem z wysłaniem wiadomości") != -1){
        statusTxt.style.color = "red"; //zmiana koloru na czerwony jeśli wystąpi error
      }else{
        form.reset();
        setTimeout(()=>{
          statusTxt.style.display = "none";
        }, 3000); // ukrycie komunikatu po 3s
      }
      statusTxt.innerText = response;
      form.classList.remove("disabled");
    }
  }
  let formData = new FormData(form); // nowy obiekt do wysłania formatu daty
  xhr.send(formData);
}
