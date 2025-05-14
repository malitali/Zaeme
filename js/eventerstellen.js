// js/eventerstellen.js

document.addEventListener("DOMContentLoaded", function () {
    const imageInput = document.getElementById("image");
    const uploadBox = document.getElementById("uploadBox");
  
    imageInput.addEventListener("change", (e) => {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (event) {
          uploadBox.innerHTML = `<img src="${event.target.result}" alt="Preview" style="width:100%; height:100%; object-fit:cover; border-radius:10px;">`;
        };
        reader.readAsDataURL(file);
      }
    });
  });