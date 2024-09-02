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
        '<tr>' +
        '<th>Type de Messe</th>' +
        '<th>Type d\'Intention</th>' +
        '<th>Date</th>' +
        '<th>Heure</th>' +
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