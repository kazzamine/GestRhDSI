$(()=>{



    //function uses ajax to add new division
    const addDivision=(data)=>{
        let id=0;
        $.ajax({
            url: '/super-admin/gererdivision/insertdevision',
            method: 'POST',
            async: false,
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(responseText) {
                id=responseText;

            },
            error: function(response) {
                alertify
                    .error("verifier les informations entrer", ()=>{
                        alertify.error();
                    });
            }
        });
        return id;
    }

    //function to redirect to add services
    const redirectServices=(data)=>{
        $.ajax({
            url: '/super-admin/gererservice?idDev='+data,
            method: 'POST',
            async: false,
            contentType: 'application/json',
            success: function(response) {
                $('#page-top').html(response)
            },
            error: function(response) {
                alertify
                    .error("verifier les informations entrer", ()=>{
                        alertify.error();
                    });
            }
        });
    }


    let nomdivision=$('#nomdevision');
    let responsable=$('#responsable');
    let direction=$('#direction');
    $('#btnaddDevision').on('click',()=>{
        if(nomdivision.val()==='' || responsable.val()===''){
            alertify
                .warning("il faut remplir tous les champs", ()=>{
                    alertify.warning();
                });
        }else {
            let data={
                nomdivision:nomdivision.val(),
                direction:direction.val(),
                responsable:responsable.val()
            }
            let idreturned =addDivision(data);
            if(idreturned>0){
                alertify.confirm('ajouter des services?', 'devision a été ajouter avec success, voulez-vous ajouter des services',
                    ()=>{

                        redirectServices(idreturned);
                    }
                    , function(){ alertify.error('pas maintenant')});
            }
        }
    });

    //ajouter nouveau service
    const addService=(data)=>{
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
    $('#btnaddService').on('click',()=> {
            let data={
                nomserv:nomserv.val(),
                description:description.val(),
                idev: $('#btnaddService').val()
            }
            addService(data)
    })

});