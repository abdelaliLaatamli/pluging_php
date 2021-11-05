<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Pluging Manager</title>
</head>
<body>

    <div class="container">
    
        <h1 class="text-center mt-5"> Plugins Manager </h1>

        <div class="row">
            <div class="col-md-6 offset-3 mt-4">
                    <!-- Plungs table -->
                <form action="plugingManager.php" method="post" enctype="multipart/form-data" >

                    <div class="row">

                        <input type="hidden" name="isFile" value="test">

                        <div class="col-10 mb-3">
                            <input class="form-control form-control-sm" name="plugin" type="file" id="formFile" 
                            accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed" >
                        </div>

                        <div class="col-2" >
                            <button class="btn btn-primary btn-sm float-end" type="submit">upload</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="row">

            <div class="col-md-12">
                <!-- Import pluging -->

                <table class="table" id="table-plugins">

                    <caption> ALL plugins</caption>

                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>

                    <tbody></tbody>
                </table>

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

                console.log( data )
                fillTable( data.data.plugins )

            })


        }

        function fillTable( plugins ){

            $('#table-plugins > tbody').empty();

            $.each( plugins , ( k , v ) => {

                $('#table-plugins > tbody').append(
                    `<tr>
                        <th scope="row">${v.name}</th>
                        <td>${v.type}  </td>
                        <td>${v.status}</td>
                        <td>${v.status}</td>
                    </tr>
                    `
                );

            } );
        }


    </script>

</body>
</html>