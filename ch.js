document.addEventListener("DOMContentLoaded", function () {
  var chDiv = document.querySelector(".ch");

  var options = {
    root: null,
    rootMargin: "0px",
    threshold: 0.5,
  };

  var observer = new IntersectionObserver(function (entries, observer) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        chDiv.classList.add("fadeIn");
        observer.unobserve(chDiv);

        // Ajoutez la classe "fadeIn" à l'image à l'intérieur de .ch
        var imageInsideCh = chDiv.querySelector('img');
        if (imageInsideCh) {
          imageInsideCh.classList.add("fadeInn");
        } else if (entry.intersectionRatio === 0 && entry.boundingClientRect.bottom < window.innerHeight) {
          // Si l'élément est en bas de la page, masquez-le
          chDiv.style.display = 'none';
          imageInsideCh.style.display = 'none';
        chDiv.classList.remove("fadeIn");
        imageInsideCh.classList.remove("fadeInn");
        }
      }
    });
  }, options);

  observer.observe(chDiv);
});
