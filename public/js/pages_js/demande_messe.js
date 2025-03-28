/**
 * @description      : 
 * @author           : AbigaelHOMENYA
 * @group            : 
 * @created          : 30/07/2024 - 14:38:31
 * 
 * MODIFICATION LOG
 * - Version         : 1.0.0
 * - Date            : 30/07/2024
 * - Author          : AbigaelHOMENYA
 * - Modification    : 
 **/
$(document).ready(function() {
    liste_des_demandes_de_messe();
    liste_des_demandes_de_messe_jour_suivant();
    liste_mes_demandes_de_messe();

});

function liste_des_demandes_de_messe() {
    $.ajax({
        type: "GET",
        url: "/liste_demande_messe",
        dataType: "json",
        success: function(response) {
            table_demande_messe(response);
        }
    });
}

function table_demande_messe(response) {
    demande_messe = response
    var tableau = '<table id="liste_tableau" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<h4>Liste de toutes les demandes messes </h4>' +
        '<tr>' +
        '<th>Type de Messe</th>' +
        '<th>Type d\'Intention</th>' +
        '<th>Date</th>' +
        '<th>Heure</th>' +
        '<th>Lieu</th>' +
        '<th>Intention</th>' +
        '<th>Demandeur</th>' +
        '<th>Statut</th>' +
        // '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    demande_messe.forEach(function(demande_messe) {
        tableau += '<tr>' +
            '<td>' + demande_messe.type_messe.lib_type_messe + '</td>' +
            '<td>' + demande_messe.type_intention.lib_type_intention + '</td>' +
            '<td>' + date_format_fr(demande_messe.date_messe) + '</td>' +
            '<td>' + demande_messe.heure_messe + '</td>' +
            '<td>' + demande_messe.lieu_messe + '</td>' +
            '<td>' + demande_messe.intentions + '</td>' +
            '<td>' + demande_messe.user.name + '</td>' +
            '<td>' + demande_messe.statut + '</td>' +
            // '<td>' +
            // '<button type="button" onclick="modal_modif_type_messe(' + type_messe.id + ');" class="btn btn-success mr-1" title="Modifier">' +
            // '<i class="icon-pencil-alt2"></i>' +
            // '</button>' +
            // '<button type="button" onclick="supprimer_type_messe(' + type_messe.id + ');" class="btn btn-danger mr-1" title="Supprimer">' +
            // '<i class="icon-pencil-alt2"></i>' +
            // '</button>' +
            // '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#demande_messe").html(tableau);
    appel_data_table("liste_tableau");
}


function liste_des_demandes_de_messe_jour_suivant() {
    $.ajax({
        type: "GET",
        url: "/demandes-messes-jour-suivant",
        dataType: "json",
        success: function(response) {
            construireTableauDemandes(response);
        }
    });
}

function construireTableauDemandes(demandes) {
    let tableauHTML = `
        <table border="1" class="display table table-striped table-bordered" style="width:100% !important">
            <thead  class="bg-white text-black">
              <h4>Liste des demandes messe du jour suivant</h4>
                <tr>
                    <th>Type d'intention</th>
                    <th>Description</th>
                    <th>Lieu de la messe</th>
                    <th>Heure </th>
                    <th>Nom du demandeur</th>
                </tr>
            </thead>
            <tbody>`;

    if (demandes.length > 0) {
        demandes.forEach(function(demande) {
            tableauHTML += `
                <tr>
                    <td>${demande.type_intention}</td>
                    <td>${demande.intentions}</td>
                    <td>${demande.lieu_messe}</td>
                    <td>${demande.heure_messe}</td>
                    <td>${demande.name}</td>
                </tr>`;
        });
    } else {
        tableauHTML += `
            <tr>
                <td colspan="3">Aucune demande de messe pour le jour suivant.</td>
            </tr>`;
    }

    tableauHTML += `
            </tbody>
        </table>`;

    // Injecter le tableau dans la div #tableau-demandes-messes
    $('#tableau-demandes-messes').html(tableauHTML);

    // Ajouter les boutons de téléchargement après l'affichage du tableau
    ajouterBoutonsTelechargement();
}

function ajouterBoutonsTelechargement() {
    let boutonsHTML = `
        <a href="/generer-pdf-demandes-messes" class="btn btn-primary mt-3" target="_blank">Télécharger PDF</a>
        <a href="/generer-word-demandes-messes" class="btn btn-secondary mt-3" target="_blank">Télécharger Word</a>`;

    // Injecter les boutons dans la div #boutons-telechargement
    $('#boutons-telechargement').html(boutonsHTML);
}

// ************************** LES DEMANDES DE MESSE DE L'UTILISATEUR CONNECTE *******************

function liste_mes_demandes_de_messe() {
    $.ajax({
        type: "GET",
        url: "/mesDemandesMesses",
        dataType: "json",
        success: function(response) {
            table_demande_messe_connected_user(response);
        },
        error: function(xhr, status, error) {
            alert('Erreur.');

        }
    });
}

function table_demande_messe_connected_user(response) {
    // console.log(response);

    demande_messe_user_con = response

    var tableau = '<table id="liste_tableau_user" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<h4>Toutes mes demandes messe </h4>' +
        '<tr>' +
        '<th>Type de Messe</th>' +
        '<th>Type d\'Intention</th>' +
        '<th>Date</th>' +
        '<th>Heure</th>' +
        '<th>Lieu</th>' +
        '<th>Intention</th>' +
        // '<th>Demandeur</th>' +
        '<th>Statut</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    demande_messe_user_con.forEach(function(demande_messe_user) {
        tableau += '<tr>' +
            '<td>' + demande_messe_user.type_messe.lib_type_messe + '</td>' +
            '<td>' + demande_messe_user.type_intention.lib_type_intention + '</td>' +
            '<td>' + date_format_fr(demande_messe_user.date_messe) + '</td>' +
            '<td>' + demande_messe_user.heure_messe + '</td>' +
            '<td>' + demande_messe_user.lieu_messe + '</td>' +
            '<td>' + demande_messe_user.intentions + '</td>' +
            // '<td>' + demande_messe_user.user.name + '</td>' +
            '<td>' + demande_messe_user.statut + '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#mes_demande_messe").html(tableau);
    appel_data_table("liste_tableau_user");
}



function appel_data_table(id_tableau) {
    $('#' + id_tableau).dataTable({
        dom: 'Bfrltip',
        lengthMenu: [
            [5, 10, 15, 20, 25, 30, -1],
            [5, 10, 15, 20, 25, 30, "Tout"]
        ],
        retrieve: true,
        responsive: true,
        fixedHeader: true,
        colReorder: true,
        buttons: ['excel', 'pdf'],
        language: {
            "sEmptyTable": "Aucune donnée disponible dans le tableau",
            "sInfo": "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
            "sInfoEmpty": "Affichage de l'élément 0 à 0 sur 0 élément",
            "sInfoFiltered": "(filtré à partir de _MAX_ éléments au total)",
            "sLengthMenu": "Afficher _MENU_ éléments",
            "sLoadingRecords": "Chargement...",
            "sProcessing": "Traitement...",
            "sSearch": "Rechercher:",
            "sZeroRecords": "Aucun élément correspondant trouvé",
            "oPaginate": {
                "sFirst": "Premier",
                "sLast": "Dernier",
                "sNext": "Suivant",
                "sPrevious": "Précédent"
            }
        }
    });
}