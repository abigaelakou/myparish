/**
 * @description      : 
 * @author           : AbigaelHOMENYA
 * @group            : 
 * @created          : 20/08/2024 - 14:44:48
 * 
 * MODIFICATION LOG
 * - Version         : 1.0.0
 * - Date            : 20/08/2024
 * - Author          : AbigaelHOMENYA
 * - Modification    : 
 **/
$(document).ready(function() {
    liste_toutes_les_messes();
});

function liste_toutes_les_messes() {
    $.ajax({
        type: "GET",
        url: "/liste_toutes_les_messes",
        dataType: "json",
        success: function(response) {
            table_toute_messe(response);
        }
    });
}

function table_toute_messe(response) {
    toute_messes = response
    var tableau = '<table id="liste_tableau" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Date Messe</th>' +
        '<th>Heure </th>' +
        '<th>Lieu </th>' +
        '<th>Créée par </th>' +
        '<th>Type Messe </th>' +
        '<th>Assignée à </th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    toute_messes.forEach(function(toute_messe) {
        tableau += '<tr>' +
            '<td>' + date_format_fr(toute_messe.date_messe) + '</td>' +
            '<td>' + toute_messe.heure_messe + '</td>' +
            '<td>' + toute_messe.lieu_messe + '</td>' +
            '<td>' + toute_messe.creator_name + '</td>' +
            '<td>' + toute_messe.lib_type_messe + '</td>' +
            '<td>' + toute_messe.celebrant_name + '</td>' +
            '<td>' +
            '<button type="button" onclick="modal_modif_messe(' + toute_messe.id + ');" class="btn btn-success mr-1" title="Modifier">' +
            '<i class="icon-pencil-alt2"></i>' +
            '</button>' +
            '<button type="button" onclick="supprimer_messe(' + toute_messe.id + ');" class="btn btn-danger mr-1" title="Supprimer">' +
            '<i class="icon-pencil-alt2"></i>' +
            '</button>' +
            '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_toutes_messes").html(tableau);
    appel_data_table("liste_tableau");
}
// ********* Permet de recuperer les informations du tableau dans le formulaire de la modale *********** //
function modal_modif_messe(i) {
    toute_messes.forEach(element_modif => {
        if (element_modif.id == i) {
            $("#id_messe").val(element_modif.id)
            $("#modif_date_messe").val(element_modif.date_messe)
            $("#modif_heure_messe").val(element_modif.heure_messe)
            $("#modif_lieu_messe").val(element_modif.lieu_messe)
            $("#modif_id_celebrant").val(element_modif.id_celebrant)
            $("#modif_id_celebrant" + element_modif.id_celebrant)
            $("#modif_id_type_messe").val(element_modif.id_type_messe)
            $("#modif_id_type_messe" + element_modif.id_type_messe)
        }
    });
    $("#editMesseModal").modal("show")
}


$('#form_modif_messe').submit(function(e) {
    e.preventDefault();
    form = $(this)
    titre = "Modification messe !"
    text = "Modification de messe effectuée "
    send_form(form, titre, text)
    $("#editMesseModal").modal("hide")
    setTimeout(() => {
        liste_toutes_les_messes()
    }, 200);
});

function supprimer_messe(id) {
    swal({
        title: 'Voulez-vous vraiment supprimer?',
        text: "Cette opération est irréversible!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0CC27E',
        cancelButtonColor: '#FF586B',
        confirmButtonText: 'Oui!',
        cancelButtonText: 'Non!',
        confirmButtonClass: 'btn btn-success mr-5',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function() {
        $.ajax({
            type: "get",
            url: "/supp_messe/" + id,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                swal("Supprimé!", "success");
                liste_toutes_les_messes()
            }
        });
    }, function(dismiss) {
        if (dismiss === 'Annuler') {
            swal(
                'Annulé',
                'Votre demande a été annulé :)',
                'error'
            )
        }
    })
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