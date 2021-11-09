<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title> Plugin application - Execute </title>
</head>
<body>
    
    <div class="container">
    
        <h1 class="text-center mt-5"> Pipline </h1>
        
        <div  class="row mt-4" >

     
            <div class="col-3 mb-3"> 

                <label for="exampleFormControlInput1" class="form-label">Store</label>
                <select class="form-select form-select-sm" id="selectStore" name="store">
                    <option selected value="default" >Default</option>
                </select>

                <label for="exampleFormControlInput1" class="form-label">Data</label>

                <div class="data-container">

                    <textarea class="form-control" rows="10" id="dataStore"></textarea>

                </div>

           


            </div>

            <div class="col-3 mb-3"> 
                <label for="exampleFormControlInput1" class="form-label">Prosses</label>
                <select class="form-select form-select-sm" id="selectProsses"  name="prosses">
                    <option selected value="default" >Default</option>
                </select>
            </div>

            <div class="col-3 mb-3"> 
                <label for="exampleFormControlInput1" class="form-label">Consume</label>
                <select class="form-select form-select-sm" id="selectConsume" name="consume">
                    <option selected value="default" >Default</option>
                </select>
            </div>

            <div class="col-md-3 mt-4 pt-2"> 
                <button class="btn btn-sm btn-primary" onclick="startProsses()" > Start Prosses </button>
            </div>


        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <script>

        const backend = "/plugingManager.php";

        loadPlugins();

        function loadPlugins(){
            
            const request = {
                "operation" : "get_plugins" 
            }

            $.post( backend , request , (data) => {

                const store    = data.data.plugins.filter( e => e.type === "store"    && e.status === "enable" );
                const prosses  = data.data.plugins.filter( e => e.type === "prosses"  && e.status === "enable" );
                const consumer = data.data.plugins.filter( e => e.type === "consumer" && e.status === "enable" );
                fillInputs( store , prosses , consumer )
            })


        }


        function fillInputs( store , prosses , consume ){


            $.each( store   , (k,v) => {
                $("#selectStore").append( `<option value="${v.name}" >${v.name}</option>` );
            } );

            $.each( prosses , (k,v) => {
                $("#selectProsses").append( `<option value="${v.name}" >${v.name}</option>` )
            } );

            $.each( consume , (k,v) => {
                $("#selectConsume").append( `<option value="${v.name}" >${v.name}</option>` );
            } );

        }

        function startProsses(){

            const request = {

                operation : "start_prosses" ,
                "store"     : $("#selectStore").val() ,
                "prosses"   : $("#selectProsses").val() ,
                "consumer"  : $("#selectConsume").val()
            }

            console.log( request )

            const data = document.querySelector("#dataStore").value;

            let storeData = "";

            switch( $("#selectStore").val() ){

                case "jsonloader" : storeData = data; break ;

                default : storeData = data.split('\n').filter(e => e); break ;
            }
            request["storeData"] = storeData;
            console.log( storeData )

            // console.log( dataStore )
            $.post( backend , request , (data) => {
                console.log( data )
            } )


        }

        $("#selectStore").change( function(){

            switch( $(this).val() ){
                case "jsonloader" : 
                    $(".data-container").empty();
                    $(".data-container").append(`<input type="text" class="form-control" id="dataStore"></input>`);
                    break ;

                default : 
                    $(".data-container").empty()
                    $(".data-container").append(`<textarea class="form-control" rows="10" id="dataStore"></textarea>`);
                    
                break 
            }

        })

    </script>

</body>
</html>