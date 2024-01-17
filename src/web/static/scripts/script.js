// const maxSize = 1000000;

// const inputElement = document.getElementById("file");
// inputElement.addEventListener("change", verifyFileSize, false);

// function verifyFileSize(){
//     if(this.files[0].size > maxSize){
//         this.files=[];
//         console.log('file to big');
//     }
// }

document.addEventListener('DOMContentLoaded', function () {
    let form = document.querySelector('form');
    let fileInput = document.getElementById('file');

    form.addEventListener('submit', function (event) {
        let fileSize = fileInput.files[0].size; 
        let fileType = fileInput.files[0].type; 

        if (fileSize > 1024 * 1024) { 
            alert('Plik jest zbyt duży. Maksymalny rozmiar to 1MB.');
            fileInput.value = ''; 
            event.preventDefault(); 
        }

       
        if (!fileType.startsWith('image')) {
            alert('Proszę załączyć plik: .jpeg, .jpg lub .png.');
            fileInput.value = ''; 
            event.preventDefault(); 
        }
    });
});