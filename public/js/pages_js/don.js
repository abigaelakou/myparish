/**
 * @description      : 
 * @author           : AbigaelHOMENYA
 * @group            : 
 * @created          : 05/09/2024 - 10:33:36
 * 
 * MODIFICATION LOG
 * - Version         : 1.0.0
 * - Date            : 05/09/2024
 * - Author          : AbigaelHOMENYA
 * - Modification    : 
 **/
$(document).ready(function() {
    liste_des_dons();
    liste_des_dons_utilisateur();

});

function liste_des_dons() {
    $.ajax({
        type: "GET",
        url: "/liste_don",
        dataType: "json",
        success: function(response) {
            table_don(response);
        }
    });
}

function table_don(response) {
    dons = response
    console.log(dons)
    var tableau = '<table id="liste_tableau" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Type Don</th>' +
        '<th>Date Don</th>' +
        '<th>Montant</th>' +
        '<th>Description</th>' +
        '<th>Mode de paiement</th>' +
        '<th>Contact</th>' +
        '<th>Type donateur</th>' +
        '<th>Nom du donateur</th>' +
        // '<th>Statut Don</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    dons.forEach(function(don) {
        tableau += '<tr>' +
            '<td>' + (don.type_don ? don.type_don.lib_type_don : 'N/A') + ' </td>' +
            '<td>' + date_format_fr(don.date_don) + '</td>' +
            '<td>' + format_num(don.montant) + '</td>' +
            '<td>' + don.description + '</td>' +
            '<td>' + don.mode_paiement + '</td>' +
            '<td>' + don.contact + '</td>' +
            '<td>' + don.type_donateur + '</td>' +
            '<td>' + (don.user ? don.user.name : 'Anonyme') + '</td>' +
            // '<td>' + don.payment_status + '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_don_offrande").html(tableau);
    appel_data_table("liste_tableau");
}
// *********************** DONS ET OFFRANDES UTILISATEUR CONNECTE******************************
function liste_des_dons_utilisateur() {
    $.ajax({
        type: "GET",
        url: "/listUserDons",
        dataType: "json",
        success: function(response) {
            table_don_util(response);
        }
    });
}

function table_don_util(response) {
    dons_util = response
    console.log(dons)
    var tableau = '<table id="liste_tableau" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Type Don</th>' +
        '<th>Date Don</th>' +
        '<th>Montant</th>' +
        '<th>Description</th>' +
        '<th>Mode de paiement</th>' +
        '<th>Contact</th>' +
        // '<th>Type donateur</th>' +
        // '<th>Statut Don</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    dons_util.forEach(function(don) {
        tableau += '<tr>' +
            '<td>' + (don.type_don ? don.type_don.lib_type_don : 'N/A') + ' </td>' +
            '<td>' + date_format_fr(don.date_don) + '</td>' +
            '<td>' + format_num(don.montant) + '</td>' +
            '<td>' + don.description + '</td>' +
            '<td>' + don.mode_paiement + '</td>' +
            '<td>' + don.contact + '</td>' +
            // '<td>' + don.type_donateur + '</td>' +
            // '<td>' + don.payment_status + '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_don_offrande_user").html(tableau);
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