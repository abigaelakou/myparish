/**
 * @description      : 
 * @author           : AbigaelHOMENYA
 * @group            : 
 * @created          : 03/09/2024 - 09:39:29
 * 
 * MODIFICATION LOG
 * - Version         : 1.0.0
 * - Date            : 03/09/2024
 * - Author          : AbigaelHOMENYA
 * - Modification    : 
 **/
$(document).ready(function() {
    liste_type_don();

});

function liste_type_don() {
    $.ajax({
        type: "GET",
        url: "/list_type_don",
        dataType: "json",
        success: function(response) {
            table_type_don(response);
        }
    });
}

function table_type_don(response) {
    type_don = response
    var tableau = '<table id="liste_tableau" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Type don</th>' +
        '<th>Date d\' ajout</th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    type_don.forEach(function(type_don) {
        tableau += '<tr>' +
            '<td>' + type_don.lib_type_don + '</td>' +
            '<td>' + date_format_fr(type_don.created_at) + '</td>' +
            '<td>' +
            '<button type="button" onclick="modal_modif_type_don(' + type_don.id + ');" class="btn btn-success mr-1" title="Modifier">' +
            '<i class="fas fa-pen"></i>' +
            '</button>' +
            '<button type="button" onclick="supprimer_type_don(' + type_don.id + ');" class="btn btn-danger mr-1" title="Supprimer">' +
            '<i class="fas fa-trash"></i>' +
            '</button>' +
            '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_type_dons").html(tableau);
    appel_data_table("liste_tableau");
}
// ********* Permet de recuperer les informations du tableau dans le formulaire de la modale *********** //
function modal_modif_type_don(i) {
    type_don.forEach(element_modif => {
        if (element_modif.id == i) {
            $("#id_type_don").val(element_modif.id)
            $("#modif_lib_type_don").val(element_modif.lib_type_don)
        }
    });
    $("#editTypeDonModal").modal("show")
}


$('#editTypeDonForm').submit(function(e) {
    e.preventDefault();
    form = $(this)
    titre = "Modification type don !"
    text = "Modification type don effectuée "
    send_form(form, titre, text)
    $("#editTypeDonModal").modal("hide")
    setTimeout(() => {
        liste_type_don()
    }, 200);
});

function supprimer_type_don(id) {
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
            url: "/supp_type_don/" + id,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                swal("Supprimé!", "success");
                liste_type_don()
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