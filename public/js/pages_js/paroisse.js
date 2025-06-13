/**
 * @description      : 
 * @author           : AbigaelHOMENYA
 * @group            : 
 * @created          : 20/11/2024 - 10:19:26
 * 
 * MODIFICATION LOG
 * - Version         : 1.0.0
 * - Date            : 20/11/2024
 * - Author          : AbigaelHOMENYA
 * - Modification    : 
 **/
$(document).ready(function() {
    liste_paroisses();
});

function liste_paroisses() {
    $.ajax({
        type: "GET",
        url: "/liste_des_paroisses",
        dataType: "json",
        success: function(response) {
            table_paroisse(response);
        }
    });
}

function table_paroisse(response) {
    paroisses = response
    var tableau = '<table id="liste_tableau" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Nom paroisse</th>' +
        '<th>Adresse</th>' +
        '<th>Contact</th>' +
        '<th>Email</th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    paroisses.forEach(function(paroisse_list) {
        switch (Number(paroisse_list.status)) {
            case 1:

                btn = '<button type="button" onclick="update_paroisse(' + paroisse_list.id + ',0);" class="btn btn-danger mr-3" title="Bloqué"> ' + '<i class="fas fa-unlock"></i>' +
                    '</button>'
                break;
            case 0:

                btn = '<button type="button" onclick="update_paroisse(' + paroisse_list.id + ',1);" class="btn btn-warning mr-3" title="Débloqué"> ' + '<i class="fas fa-lock"></i>' +
                    '</button>'
                break;
            default:
                break;
        }

        tableau += '<tr>' +
            '<td>' + paroisse_list.nom_paroisse + '</td>' +
            '<td>' + paroisse_list.adresse + '</td>' +
            '<td>' + paroisse_list.contact + '</td>' +
            '<td>' + paroisse_list.email + '</td>' +
            '<td>' +
            '<button type="button" onclick="modal_modif_paroisse(' + paroisse_list.id + ');" class="btn btn-success mr-1" title="Modifier">' +
            '<i class="fas fa-pen"></i>' +
            '</button>' +
            btn +
            '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_des_paroisses").html(tableau);
    appel_data_table("liste_tableau");
}

// ********* Permet de recuperer les informations du tableau dans le formulaire de la modale *********** //
function modal_modif_paroisse(i) {
    paroisses.forEach(element_modif => {
        if (element_modif.id == i) {
            $("#id_paroisse").val(element_modif.id)
            $("#modif_nom_paroisse").val(element_modif.modif_nom_paroisse)
            $("#modif_adresse").val(element_modif.modif_adresse)
            $("#modif_contact").val(element_modif.modif_contact)
            $("#modif_email").val(element_modif.heure_debut)
        }
    });
    $("#modalModifParoisse").modal("show")
};


$('#formModifParoisse').submit(function(e) {
    e.preventDefault();
    form = $(this)
    titre = "Modification !"
    text = "Modification des infos  effectuée "
    send_form(form, titre, text)
    $("#modalModifParoisse").modal("hide")
    setTimeout(() => {
        liste_paroisses()
    }, 200);
});

// fonction permettant de faire la mise à jour du statut des paroisses
function update_paroisse(paroisse_id, status_code) {
    var titre_texte = (status_code == 1) ? "réactiver" : "désactiver";

    swal({
        title: "Voulez-vous vraiment " + titre_texte + " cet compte ?",
        text: "Cette opération changera son statut!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0CC27E',
        cancelButtonColor: '#FF586B',
        confirmButtonText: 'Oui, je le veux!',
        cancelButtonText: 'Non!',
        confirmButtonClass: 'btn btn-success mr-5',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "/update_status_paroisse/" + paroisse_id + "/" + status_code,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                swal(titre_texte,
                    "Vous venez de " + titre_texte + " cette paroisse !",
                    'success'
                );
                liste_paroisses();
            },
            error: function() {
                swal('error', 'Opération échouée :)', 'Echec');
            }
        });
    });
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