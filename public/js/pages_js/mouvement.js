/**
 * @description      : 
 * @author           : AbigaelHOMENYA
 * @group            : 
 * @created          : 06/08/2024 - 10:53:27
 * 
 * MODIFICATION LOG
 * - Version         : 1.0.0
 * - Date            : 06/08/2024
 * - Author          : AbigaelHOMENYA
 * - Modification    : 
 **/
$(document).ready(function() {
    liste_rencontre_mouvements();
    liste_membre_mouvements();
});

function liste_rencontre_mouvements() {
    $.ajax({
        type: "GET",
        url: "/liste_des_rencontres_mouvement",
        dataType: "json",
        success: function(response) {
            table_rencontre_mouv(response);
        }
    });
}

function table_rencontre_mouv(response) {
    rencontres = response
    var tableau = '<table id="liste_tableau" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Nom mouvement</th>' +
        '<th>Description</th>' +
        '<th>Date création</th>' +
        '<th>Jour Rencontre</th>' +
        '<th>H. Début Rencontre</th>' +
        '<th>H. Fin Rencontre</th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    rencontres.forEach(function(rencontre_mouv) {
        tableau += '<tr>' +
            '<td>' + rencontre_mouv.lib_mouvement + '</td>' +
            '<td>' + rencontre_mouv.description + '</td>' +
            '<td>' + rencontre_mouv.date_creation + '</td>' +
            '<td>' + rencontre_mouv.jour + '</td>' +
            '<td>' + rencontre_mouv.heure_debut + '</td>' +
            '<td>' + rencontre_mouv.heure_fin + '</td>' +
            '<td>' +
            '<button type="button" onclick="modal_modif_rencontre_mouv(' + rencontre_mouv.id + ');" class="btn btn-success mr-1" title="Modifier">' +
            '<i class="fas fa-pen"></i>' +
            '</button>' +
            '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_des_mouvements").html(tableau);
    appel_data_table("liste_tableau");
}
// ********* Permet de recuperer les informations du tableau dans le formulaire de la modale *********** //
function modal_modif_rencontre_mouv(i) {
    rencontres.forEach(element_modif => {
        if (element_modif.id == i) {
            $("#lib_mouvement").val(element_modif.lib_mouvement)
            $("#date_creation").val(element_modif.date_creation)
            $("#description").val(element_modif.description)
            $("#id_rencontre").val(element_modif.id)
            $("#id_mouvement").val(element_modif.id_mouvement)
            $("#jour").val(element_modif.jour)
            $("#heure_debut").val(element_modif.heure_debut)
            $("#heure_fin").val(element_modif.heure_fin)
        }
    });
    $("#editRencontreModal").modal("show")
}


$('#editRencontreMouvForm').submit(function(e) {
    e.preventDefault();
    form = $(this)
    titre = "Modification rencontre mouvement !"
    text = "Modification des informations  effectuée "
    send_form(form, titre, text)
    $("#editRencontreModal").modal("hide")
    setTimeout(() => {
        liste_rencontre_mouvements()
    }, 200);
});
// ******************************************BOX MEMBRE DES MOUVEMENTS***************************************************************
function liste_membre_mouvements() {
    $.ajax({
        type: "GET",
        url: "/list_membre_mouv",
        dataType: "json",
        success: function(response) {
            table_membre_mouv(response);
        }
    });
}

function table_membre_mouv(response) {
    membres = response
    var tableau = '<table id="liste_membre_tab" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Nom & Prénom(s)</th>' +
        '<th>Contact</th>' +
        '<th>Role</th>' +
        '<th>Mouvement</th>' +
        '<th>Date Inscription</th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    membres.forEach(function(membr_mouv) {
        tableau += '<tr>' +
            '<td>' + membr_mouv.name_membre + '</td>' +
            '<td>' + membr_mouv.contact + '</td>' +
            '<td>' + membr_mouv.role_membre + '</td>' +
            '<td>' + membr_mouv.lib_mouvement + '</td>' +
            '<td>' + membr_mouv.date_inscription + '</td>' +
            '<td>' +
            '<button type="button" onclick="modal_modif_membre_mouv(' + membr_mouv.id + ');" class="btn btn-success mr-1" title="Modifier">' +
            '<i class="fas fa-pen"></i>' +
            '</button>' +
            '<button type="button" onclick="supprimer_membre(' + membr_mouv.id + ');" class="btn btn-danger mr-1" title="Supprimer">' +
            '<i class="fas fa-trash"></i>' +
            '</button>' +
            '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_membre").html(tableau);
    appel_data_table("liste_membre_tab");
}


function modal_modif_membre_mouv(i) {
    membres.forEach(element_modif => {
        if (element_modif.id == i) {
            $("#id_membre_mouvement").val(element_modif.id)
            $("#modif_name_membre").val(element_modif.name_membre)
            $("#modif_contact").val(element_modif.contact)
            $("#modif_role_membre").val(element_modif.role_membre)
            $("#modif_id_mouvement").val(element_modif.id_mouvement)
            $("#modif_id_mouvement" + element_modif.id_mouvement)
            $("#modif_date_inscription").val(element_modif.date_inscription)
        }
    });
    // console.log("Son contact: ", $("#modif_contact").val());
    $("#modalModifMembre").modal("show")
}


$('#formModifMembre').submit(function(e) {
    e.preventDefault();
    form = $(this)
    titre = "Modification rencontre mouvement !"
    text = "Modification des informations  effectuée "
    send_form(form, titre, text)
    $("#modalModifMembre").modal("hide")
    setTimeout(() => {
        liste_membre_mouvements()
    }, 200);
});

function supprimer_membre(id) {
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
            url: "/supp_membre/" + id,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                swal("Supprimé!", "Ce membre ne fait plus partie du mouvement!", "success");
                liste_membre_mouvements()
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

//******************************************************************************************************************
function appel_data_table(id_tableau) {
    $('#' + id_tableau).dataTable({
        dom: 'Bfrltip',
        lengthMenu: [
            [10, 15, 20, 25, 30, -1],
            [10, 15, 20, 25, 30, "Tout"]
        ],
        retrieve: true,
        responsive: true,
        fixedHeader: true,
        colReorder: true,
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        language: {
            "sEmptyTable": "Aucune donnée disponible dans le tableau",
            "sInfo": "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
            "sInfoEmpty": "Affichage de l'élément 0 à 0 sur 0 élément",
            "sInfoFiltered": "(filtré à partir de _MAX_ éléments au total)",
            "sLengthMenu": "Afficher _MENU_ éléments",
            "sLoadingRecords": "Chargement...",
            "sProcessing": "Traitement...",
            "sSearch": "Rechercher :",
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