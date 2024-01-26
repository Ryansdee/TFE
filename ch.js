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
      } else {
        chDiv.classList.remove("fadeIn");
      }
    });
  }, options);

  observer.observe(chDiv);
});
