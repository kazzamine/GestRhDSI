$(()=>{



    //function uses ajax to add new contract
    const addcontract=(data)=>{
        let id=0;
        $.ajax({
            url: '/admin/empMenu/addEmp/addContract',
            method: 'POST',
            async: false,
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(responseText) {
                id=responseText;

            },
            error: function(response) {
                console.log(response)
                alertify
                    .error("une error de system essayer plus tard", ()=>{
                        alertify.error();
                    });
            }
        });
        return id;
    }
    //function to add new employe
    const addemploye=(data)=>{
        let persoid=0
        $.ajax({
            url: '/admin/empMenu/addEmp/add',
            method: 'POST',
            async: false,
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(responseText) {
               persoid=responseText;

            },
            error: function(response) {
                alertify
                    .error("une error de system essayer plus tard", ()=>{
                        alertify.error();
                    });
            }
        });
        return persoid;
    }

    //function to add conge days
    const addcongejour=(data)=>{
        $.ajax({
            url: '/admin/empMenu/conge/jourConge/add',
            method: 'POST',
            async: false,
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(responseText) {
                alertify
                    .success("employé a été ajouter", ()=>{
                        alertify.success();
                    });
            },
            error: function(response) {
                alertify
                    .error("une error de system essayer plus tard", ()=>{
                        alertify.error();
                    });
            }
        });
    }

    //get elements
    let btnaddEmp=$('#btnaddEmp');
    let nom=$('#nom');
    let prenom=$('#prenom');
    let cin=$('#CIN');
    let ppr=$('#PPR');
    let datenaiss=$('#datenaiss');
    let adresse=$('#adresse');
    let telephone=$('#telephone');
    let mail=$('#mail');
    let grade=$('#grade');
    let poste=$('#poste');
    let devision=$('#devision');
    let service=$('#service');
    let sexe=$('#sexe');
    let dateEmb=$('#dateEmb');
    let dateContract=$('#dateContract');
    let typeContract=$('#typeContract');
    let numcontract=$('#numcontract');


    //on click event to update
    $('#btnaddEmp').on("click",()=>{

        let dataContract={
            datecontract:dateContract.val(),
            dateEmbauche:dateEmb.val(),
            typeContract:typeContract.val(),
            numcontract:numcontract.val()
        }
        //calling function

       let idcontract= addcontract(dataContract);
       let employeData={
           nom:nom.val(),
           prenom:prenom.val(),
           cin:cin.val(),
           ppr:ppr.val(),
           datenaiss:datenaiss.val(),
           adresse:adresse.val(),
           telephone:telephone.val(),
           mail:mail.val(),
           grade:grade.val(),
           poste:poste.val(),
           devision:devision.val(),
           service:service.val(),
           sexe:sexe.val(),
           idcontract:idcontract,
       }
       let idPerso=addemploye(employeData);
       let congejourData={
           idpersonnel:idPerso
       }
        setTimeout(addcongejour(congejourData),3000);

    })

});