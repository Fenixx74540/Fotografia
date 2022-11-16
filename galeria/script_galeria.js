const gallery = document.querySelectorAll(".image"),
previewBox = document.querySelector(".preview-box"), // podgląd okna do wyświetlania zdj
previewImg = previewBox.querySelector("img"), // podgląd samego zdj IMG
closeIcon = previewBox.querySelector(".icon"), // przycisk "x" zamykania podglądu
currentImg = previewBox.querySelector(".current-img"), // liczba aktualnie wyświetlanego zdj
totalImg = previewBox.querySelector(".total-img"), // liczba ilośći zdj
shadow = document.querySelector(".shadow"); // zmienna odpowiedzialna za ustawienie cienia/przyciemnienie tła 
 
window.onload = ()=>{ //kiedy okno się otworzy
    for (let i = 0; i < gallery.length; i++) {
        totalImg.textContent = gallery.length; // przypisanie długości stałej gallery jako ilość zdjęć
        let newIndex = i;
        let clickedImgIndex;

        gallery[i].onclick = ()=> {
            clickedImgIndex = i; // przekazanie indeksu klikniętego obrazu do utworoznej zmiennej
            function preview() {
                currentImg.textContent = newIndex + 1; // wyświetlenie nr klikniętego zdj do wyświetlenia (np. zdj 1 z 4) +1 bo liczy od zera
                let imageURL  = gallery[newIndex].querySelector("img").src; // uzyskanie url do konkretnego zdj po kliknięciu
                previewImg.src = imageURL; // przekaznie zdobytego url do znacznika IMG src="zdobyty url"
            }
            preview(); 

            const prevBtn = document.querySelector(".prev");
            const nextBtn = document.querySelector(".next");
            if(newIndex == 0) { // jeśli index jest równy zero 
                prevBtn.style.display = "none"; // to chowa się przycisk przewijania zdj do tyłu
            }
            if (newIndex >= gallery.length - 1) { // jeśli index jest większy równy -1 długości całej galerii 
                nextBtn.style.display = "none"; // to chowa się przycisk przewijania zdj do przodu
            }

            // przełączanie zdj do tyłu w podglądzie
            prevBtn.onclick = ()=> {
                newIndex--;
                if (newIndex == 0) {
                    preview(); 
                    prevBtn.style.display = "none"; // ukrycie przycisku przewijania zdj do tyłu
                } else {
                    preview(); // trzeba wywołać ponownie aby zaktualizować zdj, a nie pokazywało ostatnio zamkniete po kliknieciu na inne
                    nextBtn.style.display = 'block'; // nie spowoduje to ukrycia przycisku przewijania do tyłu jeśli zaczniemy przeglądać od 1. zdj
                }
            }
            
            // przełączanie zdj do przodu w podglądzie
            nextBtn.onclick = ()=> {
                newIndex++;
                if (newIndex >= gallery.length - 1) { // -1 bo liczy od zera
                    preview();
                    nextBtn.style.display = "none"; // ukrycie przycisku przewijania zdj do przodu
                } else {
                    preview(); // trzeba wywołać ponownie aby zaktualizować zdj, a nie pokazywało ostatnio zamkniete po kliknieciu na inne
                    prevBtn.style.display = 'block'; // nie spowoduje to ukrycia przycisku przewijania do przodu jeśli zaczniemy przeglądać od ostatniego zdj
                }
            }

            // preview();
            previewBox.classList.add("show"); // dodanie klasy show odpowiedzialnej za podgląd zdjęcia w oknie
            shadow.style.display("block"); // wyświetlenie cienia w tle na całej szerokości podczas podglądu 
            document.querySelector("body").style.overflow = "hidden"; // brak możliwości scrollowania strony podczas podglądu

            // akcja naciśnięcia "x" podczas podglądu / zamknięcie okna
            closeIcon.onclick = ()=> {
                newIndex = clickedImgIndex; // powoduje wyświetlenie ponownego podglądu klikniętego zdj, a nie tego co ostatnio było zamknięte
                prevBtn.style.display = 'block'; // block powodu nie znikanie przycisku przewijania po dojechaniu do początku kolejki
                nextBtn.style.display = 'block';  // block powodu nie znikanie przycisku przewijania po dojechaniu do końca kolejki
                previewBox.classList.remove("show"); // ukrycie/usunięcie klasy show odpowiedzialnej za pokazywanie podglądu
                shadow.style.display("none"); // nie wyświetlanie cienia 
                document.querySelector("body").style.overflow = "scroll";
            }
        }
    }
}