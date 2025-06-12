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
    liste_type_messe();
    liste_type_intention();
    // console.log('OKAY');
});

function liste_type_messe() {
    $.ajax({
        type: "GET",
        url: "/list_type_messe",
        dataType: "json",
        success: function(response) {
            table_type_messe(response);
        }
    });
}

function table_type_messe(response) {
    type_messe = response
    var tableau = '<table id="liste_tableau" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Type messes</th>' +
        '<th>Date ajout</th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    type_messe.forEach(function(type_messe) {
        tableau += '<tr>' +
            '<td>' + type_messe.lib_type_messe + '</td>' +
            '<td>' + date_format_fr(type_messe.created_at) + '</td>' +
            '<td>' +
            '<button type="button" onclick="modal_modif_type_messe(' + type_messe.id + ');" class="btn btn-success mr-1" title="Modifier">' +
            '<i class="fas fa-pen"></i>' +
            '</button>' +
            '<button type="button" onclick="supprimer_type_messe(' + type_messe.id + ');" class="btn btn-danger mr-1" title="Supprimer">' +
            '<i class="fas fa-trash"></i>' +
            '</button>' +
            '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_des_type_messe").html(tableau);
    appel_data_table("liste_tableau");
}
// ********* Permet de recuperer les informations du tableau dans le formulaire de la modale *********** //
function modal_modif_type_messe(i) {
    type_messe.forEach(element_modif => {
        if (element_modif.id == i) {
            $("#id_type_messe").val(element_modif.id)
            $("#modif_lib_type_messe").val(element_modif.lib_type_messe)
        }
    });
    $("#editTypeMesseModal").modal("show")
}


$('#editTypeMesseForm').submit(function(e) {
    e.preventDefault();
    form = $(this)
    titre = "Modification type messe !"
    text = "Modification type messe effectuée "
    send_form(form, titre, text)
    $("#editTypeMesseModal").modal("hide")
    setTimeout(() => {
        liste_type_messe()
    }, 200);
});

function supprimer_type_messe(id) {
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
            url: "/supp_type_messe/" + id,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                swal("Supprimé!", "success");
                liste_type_messe()
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
// **************************** BOX INTENTION ******************************************************

function liste_type_intention() {
    $.ajax({
        type: "GET",
        url: "/list_type_intention",
        dataType: "json",
        success: function(response) {
            table_type_intention(response);
        }
    });
}

function table_type_intention(response) {
    type_intention = response
    var tableau = '<table id="liste_tableau_intention" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Type Intention</th>' +
        '<th>Date ajout</th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    type_intention.forEach(function(type_intention) {
        tableau += '<tr>' +
            '<td>' + type_intention.lib_type_intention + '</td>' +
            '<td>' + date_format_fr(type_intention.created_at) + '</td>' +
            '<td>' +
            '<button type="button" onclick="modal_modif_type_intention(' + type_intention.id + ');" class="btn btn-success mr-1" title="Modifier">' +
            '<i class="fas fa-pen"></i>' +
            '</button>' +
            '<button type="button" onclick="supprimer_type_intention(' + type_intention.id + ');" class="btn btn-danger mr-1" title="Supprimer">' +
            '<i class="fas fa-trash"></i>' +
            '</button>' +
            '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_type_intention_messe").html(tableau);
    appel_data_table("liste_tableau_intention");
}
// ********* Permet de recuperer les informations du tableau dans le formulaire de la modale *********** //
function modal_modif_type_intention(i) {
    type_intention.forEach(element_modif => {
        if (element_modif.id == i) {
            $("#id_type_intention").val(element_modif.id)
            $("#modif_lib_type_intention").val(element_modif.lib_type_intention)
        }
    });
    $("#editTypeIntentionModal").modal("show")
}


$('#editTypeIntentionForm').submit(function(e) {
    e.preventDefault();
    form = $(this)
    titre = "Modification type intention !"
    text = "Modification type intention effectuée "
    send_form(form, titre, text)
    $("#editTypeIntentionModal").modal("hide")
    setTimeout(() => {
        liste_type_intention()
    }, 200);
});

function supprimer_type_intention(id) {
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
            url: "/supp_type_intention/" + id,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                swal("Supprimé!", "success");
                liste_type_intention()
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