/**
 * @description      : 
 * @author           : AbigaelHOMENYA
 * @group            : 
 * @created          : 25/11/2025 - 16:36:17
 * 
 * MODIFICATION LOG
 * - Version         : 1.0.0
 * - Date            : 25/11/2025
 * - Author          : AbigaelHOMENYA
 * - Modification    : 
 **/
$(document).ready(function() {
    tous_annonces();

});

function tous_annonces() {
    $.ajax({
        type: "GET",
        url: "/liste_des_annonces",
        dataType: "json",
        success: function(response) {
            tableau_annonce(response);
        }
    });
}

function tableau_annonce(response) {
    annonces = response
    var tableau = '<table id="liste_tableau" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Titre Annonce</th>' +
        '<th>Description</th>' +
        '<th>Crée par </th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    annonces.forEach(function(annonce) {
        tableau += '<tr>' +
            '<td>' + annonce.titre + '</td>' +
            '<td>' + annonce.contenu + '</td>' +
            '<td>' + annonce.user.name + '</td>' +
            '<td>' +
            '<button type="button" onclick="modal_modif_annonce(' + annonce.id + ');" class="btn btn-success mr-1" title="Modifier">' +
            '<i class="fas fa-pen"></i>' +
            '</button>' +
            '<button type="button" onclick="supprimer_annonce(' + annonce.id + ');" class="btn btn-danger mr-1" title="Supprimer">' +
            '<i class="fas fa-trash"></i>' +
            '</button>' +
            '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_des_annonces").html(tableau);
    appel_data_table("liste_tableau");
}
// ********* Permet de recuperer les informations du tableau dans le formulaire de la modale *********** //
function modal_modif_annonce(i) {
    annonces.forEach(element_modif => {
        if (element_modif.id == i) {
            $("#id_annonce").val(element_modif.id)
            $("#modif_titre").val(element_modif.titre)
            $("#modif_contenu").val(element_modif.contenu)
        }
    });
    $("#editAnnonceModal").modal("show")
}


$('#editAnnonceForm').submit(function(e) {
    e.preventDefault();
    form = $(this)
    titre = "Modification Annonce !"
    text = "Modification annonce effectuée "
    send_form(form, titre, text)
    $("#editAnnonceModal").modal("hide")
    setTimeout(() => {
        tous_annonces()
    }, 200);
});

function supprimer_annonce(id) {
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
            url: "/supp_annonce/" + id,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                swal("Supprimé!", "success");
                tous_annonces()
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