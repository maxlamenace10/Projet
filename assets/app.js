/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';


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