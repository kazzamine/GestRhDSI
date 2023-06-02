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
    let typeconge=$('#typeconge');
    let date_debutexcep=$("#date_debutexcep");

    $('#btncongeannuel').on('click',()=>{
        if(date_debut.val()===''||date_fin.val()===''){
            alertify
                .warning("il faut remplir tous les champs", ()=>{
                    alertify.warning();
                });
        }else{
            let data={
                dataDebut:date_debut.val(),
                dateFin:date_fin.val(),
                type:1,
                explication:null

            }
            addconge(data);
        }



    })

    $('#btncongeexceptionel').on('click',()=>{

        if(date_debutexcep.val()===''){
            alertify
                .warning("il faut remplir tous les champs", ()=>{
                    alertify.warning();
                });
        }else{
            let data={
                dataDebut:date_debutexcep.val(),
                dateFin:null,
                explication:typeconge.val(),
                type:2
            }
            addconge(data);
        }


    })

})