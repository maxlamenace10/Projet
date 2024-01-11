// import './styles/app.css';

// import '../bootstrap';

console.log('hello');

function addPlayerToTeam(teamId, userId) {
    fetch(`/team/${teamId}/add-player/${userId}`, {method: 'POST'}).then(response => response.json()).then(data => {
    if (data.success) {
    alert('Joueur ajouté avec succès à l\'équipe');
    } else {
    alert('Erreur lors de l\'ajout du joueur à l\'équipe');
    }
    }).catch((error) => {
    console.error('Erreur:', error);
    });
 }


 document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelector('.nav-links');
    const burger = document.querySelector('.burger');

    burger.addEventListener('click', () => {
        navLinks.classList.toggle('nav-active');
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#myForm');
    console.log(form);
    if (form){
   
    const n = form.length;

    console.log(n);
    for (let i = 1; i <= n; i++) {
        let actualDelay = document.querySelector('#actualDelay' + i);
        let actualPresence = document.querySelector('#actualPresence' + i);
        let actualAbsence = document.querySelector('#actualAbsence' + i);

        console.log(actualDelay);
        if (actualDelay && actualPresence && actualAbsence) {
            actualPresence.addEventListener('change', function() {
                if (this.checked) {
                    actualAbsence.checked = false;
                }
            });

            actualAbsence.addEventListener('change', function() {
                if (this.checked) {
                    actualPresence.checked = false;
                }
            });

            actualDelay.addEventListener('change', function() {
                if (this.checked) {
                    actualPresence.checked = true;
                    actualAbsence.checked = false;
                }
            });
        }
    }
}
});
window.addEventListener('scroll', function() {
    let navbarLinks = document.querySelectorAll('.navbar, .nav-links a, a.title, .logo-container h1, .footer-content, .footer-content p, .burger'); 
    let scrollPosition = window.scrollY;

    if (scrollPosition > 110) { 
        navbarLinks.forEach(link => {
            link.style.backgroundColor = '#e1e8ef'; 
            link.style.color = '#121e2d';
            link.style.transition = 'background-color 0.1s, color 0.1s'; // Add transition with duration of 0.3s
        });

       
    } else {
        navbarLinks.forEach(link => {
            link.style.backgroundColor = '#121e2d'; 
            link.style.color = '#e1e8ef';
            link.style.transition = 'background-color 0.1s, color 0.1s'; // Add transition with duration of 0.3s
        });

    }
});