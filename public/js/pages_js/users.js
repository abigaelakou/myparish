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

    // console.log('OKAY');
    $('#email').on('blur', function() {
        var email = $(this).val();
        $.ajax({
            url: '/check-email',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                email: email
            },
            success: function(response) {
                if (response.exists) {
                    alert('Cet email est déjà utilisé.');
                }
            }
        });
    });

    listes_utilisateurs();
    listes_super_utilisateurs();
});

function listes_utilisateurs() {
    $.ajax({
        type: "GET",
        url: "/list_users",
        dataType: "json",
        success: function(response) {
            table_utilisateur(response);
        }
    });
}

function table_utilisateur(response) {
    users = response
    var tableau = '<table id="liste_tableau" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Nom & Prénoms</th>' +
        '<th>Email</th>' +
        '<th>Contact</th>' +
        '<th>Profil</th>' +
        '<th>Date inscription</th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    users.forEach(function(user) {
        switch (Number(user.status)) {
            case 1:

                btn = '<button type="button" onclick="update(' + user.id + ',0);" class="btn btn-danger mr-3" title="Bloqué"> ' + '<i class="fas fa-unlock></i>' +
                    '</button>'
                break;
            case 0:

                btn = '<button type="button" onclick="update(' + user.id + ',1);" class="btn btn-warning mr-3" title="Debloqué"> ' + '<i class="fas fa-lock"></i>' +
                    '</button>'
                break;
            default:
                break;
        }
        tableau += '<tr>' +
            '<td>' + user.name + '</td>' +
            '<td>' + user.email + '</td>' +
            '<td>' + user.contact + '</td>' +
            '<td>' + user.lib_type_utilisateur + '</td>' +
            '<td>' + date_format_fr(user.created_at) + '</td>' +
            '<td>' +
            '<button type="button" onclick="modal_modif_utilisateur(' + user.id + ');" class="btn btn-success mr-1" title="Modifier">' +
            '<i class="fas fa-pen"></i>' +
            '</button>' +
            btn +
            '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_utilisateurs").html(tableau);
    appel_data_table("liste_tableau");
}
// ********* Permet de recuperer les informations du tableau dans le formulaire de la modale *********** //
function modal_modif_utilisateur(i) {
    users.forEach(element_modif => {
        if (element_modif.id == i) {
            $("#modif_name").val(element_modif.name)
            $("#modif_email").val(element_modif.email)
            $("#modif_contact").val(element_modif.contact)
            $("#id_user").val(element_modif.id)
            $("#modif_id_type_utilisateur").val(element_modif.id_type_utilisateur)
            $("#modif_id_type_utilisateur" + element_modif.id_type_utilisateur)
        }
    });
    $("#editUserModal").modal("show")
}


$('#editUserForm').submit(function(e) {
    e.preventDefault();
    form = $(this)
    titre = "Modification d'utilisateur !"
    text = "Modification des informations de l'utilisateur effectuée "
    send_form(form, titre, text)
    $("#editUserModal").modal("hide")
    setTimeout(() => {
        listes_utilisateurs()
        listes_super_utilisateurs()
    }, 200);
});

// fonction permettant de faire la mise à jour du statut de l'utilisateur
function update(id_user, status_code) {
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
            url: "/update_status/" + id_user + "/" + status_code,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                swal(titre_texte,
                    "Vous venez de " + titre_texte + " cet utilisateur !",
                    'success'
                );
                listes_utilisateurs();
                listes_super_utilisateurs();
            },
            error: function() {
                swal('error', 'Opération échouée :)', 'Echec');
            }
        });
    });
}

// ************************** TRAITEMENT SUPER ADMIN *****************************************

function listes_super_utilisateurs() {
    $.ajax({
        type: "GET",
        url: "/liste_des_super_admins",
        dataType: "json",
        success: function(response) {
            table_sup_utilisateur(response);
        }
    });
}

function table_sup_utilisateur(response) {
    sup_users = response
        // console.log(sup_users);

    var tableau = '<table id="liste_tableau_sup_admin" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Nom & Prénoms</th>' +
        '<th>Email</th>' +
        '<th>Contact</th>' +
        '<th>Profil</th>' +
        '<th>Date inscription</th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    sup_users.forEach(function(user) {
        switch (Number(user.status)) {
            case 1:

                btn = '<button type="button" onclick="update(' + user.id + ',0);" class="btn btn-danger mr-3" title="Bloqué"> ' + '<i class="fas fa-unlock"></i>' +
                    '</button>'
                break;
            case 0:

                btn = '<button type="button" onclick="update(' + user.id + ',1);" class="btn btn-warning mr-3" title="Debloqué"> ' + '<i class="fas fa-lock"></i>' +
                    '</button>'
                break;
            default:
                break;
        }
        tableau += '<tr>' +
            '<td>' + user.name + '</td>' +
            '<td>' + user.email + '</td>' +
            '<td>' + user.contact + '</td>' +
            '<td>' + user.lib_type_utilisateur + '</td>' +
            '<td>' + date_format_fr(user.created_at) + '</td>' +
            '<td>' +
            '<button type="button" onclick="modal_modif_utilisateur(' + user.id + ');" class="btn btn-success mr-1" title="Modifier">' +
            '<i class="fas fa-pen"></i>' +
            '</button>' +
            btn +
            '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_des_supers_admins").html(tableau);
    appel_data_table("liste_tableau_sup_admin");
}

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