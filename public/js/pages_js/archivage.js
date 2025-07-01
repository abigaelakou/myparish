/**
 * @description      : 
 * @author           : AbigaelHOMENYA
 * @group            : 
 * @created          : 10/09/2024 - 10:32:28
 * 
 * MODIFICATION LOG
 * - Version         : 1.0.0
 * - Date            : 10/09/2024
 * - Author          : AbigaelHOMENYA
 * - Modification    : 
 **/
$(document).ready(function() {
    liste_doc_archives();
    // console.log('Alert');

});

function liste_doc_archives() {
    $.ajax({
        type: "GET",
        url: "/listDocuments",
        dataType: "json",
        success: function(response) {
            tableau_doc_archives(response);
        }
    });
}

function tableau_doc_archives(response) {
    list_doc_archiv = response
    var tableau = '<table id="liste_tableau_archiv" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Titre Document</th>' +
        '<th>Date archivage</th>' +
        '<th>Archivé par </th>' +
        '<th>Fichier</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    list_doc_archiv.forEach(function(list_doc) {
        tableau += '<tr>' +
            '<td>' + list_doc.lib_document + '</td>' +
            '<td>' + date_format_fr(list_doc.date_archivage) + '</td>' +
            '<td>' + list_doc.user.name + '</td>' +
            '<td align="center">' + '<a href="/storage/' + list_doc.fichier + ' " download="' + list_doc.lib_document + '">' + '<button type="button"  class="btn btn-danger my-2 ml-2" title="Télécharger">' + '<i class="i-File"></i>' + '</button>' + '</a>' + '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#doc_archives").html(tableau);
    appel_data_table("liste_tableau_archiv");
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