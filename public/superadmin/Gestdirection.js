$(()=>{

    //function uses ajax to add new division
    const addDirection=(data)=>{
        $.ajax({
            url: '/super-admin/direction/insertdirection',
            method: 'POST',
            async: false,
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(responseText) {
                alertify
                    .success("l'ajout a été bien reussit", ()=>{
                        alertify.success();
                    });

            },
            error: function(response) {
                alertify
                    .error("verifier les informations entrer", ()=>{
                        alertify.error();
                    });
            }
        });

    }

    let nomdirection=$('#nomdirection');
    let location=$('#location');
    let ministre=$('#ministre');

    $('#btnaddDirection').on('click',()=>{
        if(nomdirection.val()==='' || location.val()===''){
            alertify
                .warning("il faut remplir tous les champs", ()=>{
                    alertify.warning();
                });
        }else {
            let data={
                nomdirection:nomdirection.val(),
                location:location.val(),
                ministre:ministre.val()
            }
            addDirection(data)
        }
    });

    //ajouter nouveau service
    const updateDirection=(data)=>{
        $.ajax({
            url: '/super-admin/gererservice/addservice',
            method: 'POST',
            async: false,
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(responseText) {
                alertify
                    .success("service ajouter avec success", ()=>{
                        alertify.success();
                    });

            },
            error: function(response) {
                alertify
                    .error("verifier les informations entrer", ()=>{
                        alertify.error();
                    });
            }
        });
    }
    let description=$('#descservice')
    let nomserv=$('#nomservice');
    $('#btnupdateDirection').on('click',()=> {
        let data={
            nomserv:nomserv.val(),
            description:description.val(),
            idev: $('#btnaddService').val()
        }
        addService(data)
    })

});