window.addEventListener('scroll', agrandirDiv);

function estDansLeChampDeVision(element) {
    var rect = element.getBoundingClientRect();
    var seuil = window.innerHeight * 1.6 / 3; // 1.6/3 de la hauteur de la fenêtre

    return (
        rect.top <= seuil &&
        rect.bottom >= 0
    );
}

function agrandirDiv() {
    var monDiv = document.getElementById('monDiv');
    var h2Element = document.querySelector('.explication h2');
    var pElement = document.querySelector('.explication p');
    var imageElement = document.querySelector('.explication img');
    var chElement = document.querySelector('.ch')

    if (estDansLeChampDeVision(monDiv)) {
        monDiv.style.width = '100vw';
        monDiv.style.marginLeft = '0vw';
        monDiv.style.borderRadius = '0vw';
        h2Element.classList.add('animateH2');
        h2Element.style.display = 'block';
        imageElement.style.marginLeft = '30vw';
        pElement.classList.add('animateH2');
        pElement.style.display = 'block';
        chElement.style.display = 'block';
    } else {
        monDiv.style.width = '400px';
        monDiv.style.marginLeft = '35vw';
        monDiv.style.borderRadius = '1vw';
        h2Element.classList.remove('animateH2');
        h2Element.style.display = 'none';
        imageElement.style.marginLeft = '9vw';
        pElement.classList.remove('animateH2');
        pElement.style.display = 'none';
        chElement.style.display = 'none';
    }
}