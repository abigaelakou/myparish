/**
 * @description      : 
 * @author           : AbigaelHOMENYA
 * @group            : 
 * @created          : 09/09/2024 - 15:35:04
 * 
 * MODIFICATION LOG
 * - Version         : 1.0.0
 * - Date            : 09/09/2024
 * - Author          : AbigaelHOMENYA
 * - Modification    : 
 **/
$(document).ready(function() {
    tous_evenements();
    evenements_non_realise();

});

function tous_evenements() {
    $.ajax({
        type: "GET",
        url: "/liste_des_evements",
        dataType: "json",
        success: function(response) {
            tableau_evenement(response);
        }
    });
}

function tableau_evenement(response) {
    evenements = response
    var tableau = '<table id="liste_tableau" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Titre Even.</th>' +
        '<th>Date Even.</th>' +
        '<th>Heure Even.</th>' +
        '<th>Description</th>' +
        '<th>Crée par </th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    evenements.forEach(function(evenement) {
        tableau += '<tr>' +
            '<td>' + evenement.lib_evenement + '</td>' +
            '<td>' + date_format_fr(evenement.date_evement) + '</td>' +
            '<td>' + evenement.heure_evenement + '</td>' +
            '<td>' + evenement.description + '</td>' +
            '<td>' + evenement.user.name + '</td>' +
            '<td>' +
            '<button type="button" onclick="modal_modif_evenement(' + evenement.id + ');" class="btn btn-success mr-1" title="Modifier">' +
            '<i class="icon-pencil-alt2"></i>' +
            '</button>' +
            '<button type="button" onclick="supprimer_evenement(' + evenement.id + ');" class="btn btn-danger mr-1" title="Supprimer">' +
            '<i class="icon-pencil-alt2"></i>' +
            '</button>' +
            '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_des_evenements").html(tableau);
    appel_data_table("liste_tableau");
}
// ********* Permet de recuperer les informations du tableau dans le formulaire de la modale *********** //
function modal_modif_evenement(i) {
    evenements.forEach(element_modif => {
        if (element_modif.id == i) {
            $("#id_evenement").val(element_modif.id)
            $("#modif_lib_evenement").val(element_modif.lib_evenement)
            $("#modif_date_evement").val(element_modif.date_evement)
            $("#modif_heure_evenement").val(element_modif.heure_evenement)
            $("#modif_description").val(element_modif.description)
        }
    });
    $("#editEvenementModal").modal("show")
}


$('#editEvenementForm').submit(function(e) {
    e.preventDefault();
    form = $(this)
    titre = "Modification Evènement !"
    text = "Modification évènement effectuée "
    send_form(form, titre, text)
    $("#editEvenementModal").modal("hide")
    setTimeout(() => {
        tous_evenements()
    }, 200);
});

function supprimer_evenement(id) {
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
            url: "/supp_evenement/" + id,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                swal("Supprimé!", "success");
                tous_evenements()
            }
        });
    }, function(dismiss) {
        if (dismiss === 'Annuler') {
            swal(
                'Annulé',
                'Votre requette a été annulé :)',
                'error'
            )
        }
    })
}

// ***********************************LES EVENEMENTS NON REALISES**********************************************************

function evenements_non_realise() {
    $.ajax({
        type: "GET",
        url: "/liste_des_evenements_non_realises",
        dataType: "json",
        success: function(response) {
            tableau_evenement_non_real(response);
        }
    });
}

function tableau_evenement_non_real(response) {
    evenements_non_real = response
    var tableau = '<table id="liste_tableau_non" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Titre Even.</th>' +
        '<th>Date Even.</th>' +
        '<th>Heure Even.</th>' +
        '<th>Description</th>' +
        '<th>Crée par </th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    evenements_non_real.forEach(function(evenements_non) {
        tableau += '<tr>' +
            '<td>' + evenements_non.lib_evenement + '</td>' +
            '<td>' + date_format_fr(evenements_non.date_evement) + '</td>' +
            '<td>' + evenements_non.heure_evenement + '</td>' +
            '<td>' + evenements_non.description + '</td>' +
            '<td>' + evenements_non.user.name + '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_des_evenements_non_rea").html(tableau);
    appel_data_table("liste_tableau_non");
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