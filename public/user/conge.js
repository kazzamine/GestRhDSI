$(()=> {

    const addconge=(data)=>{
        $.ajax({
            url: '/user/requestConge',
            method: 'POST',
            async: false,
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(responseText) {
                    alertify
                        .success("demande envoyé avec success", () => {
                            alertify.success();
                        });
            },
            error: function(response) {
                console.log(response)
                alertify
                    .error("une error de system essayer plus tard", ()=>{
                        alertify.error();
                    });
            }
        });
    }

    let date_debut=$("#date_debut");
    let date_fin=$("#date_fin");
    let type_conge=$("#typeconge");
    let explication=$('#explication');

    $('#sendRequest').on('click',()=>{
        let data={
            dataDebut:date_debut.val(),
            dateFin:date_fin.val(),
            typeconge:type_conge.val(),
            explication:explication.val()
        }
        console.log(type_conge.val())
        addconge(data);

    })


})