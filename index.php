<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Audio File Convert To MP3</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>


    <div class="container">
        <div class="row">
            <div style="margin-top: 100px;">
                <div class="col-md-6">
                    <form method="post" enctype="multipart/form-data" id="form">

                        <div class="form-group">
                            <label>Audio File:</label>
                            <input type="file" name="audioFile" class="form-control">
                        </div>

                        <button id="convertBtn" type="submit" class="btn btn-default">Convert</button>



                        <div style="margin-top: 20px;display: none;" id="successAlert" class="alert alert-success">

                        </div>

                        <div style="margin-top: 20px;display: none;" id="errorAlert" class="alert alert-danger">

                        </div>

                        <div style="margin-top: 20px;display: none;" id="loadingAlert" class="alert alert-info">
                           Loading..
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>


    <script>
        $(document).ready(function () {

            $("#convertBtn").click(function (event) {

                //stop submit the form, we will post it manually.
                event.preventDefault();

                // Get form
                var form = $('#form')[0];
                // Create an FormData object
                var data = new FormData(form);

                $('#loadingAlert').show();
                $('#successAlert').hide();
                $('#errorAlert').hide();

                // disabled the submit button
                $("#convertBtn").prop("disabled", true);

                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "service.php",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    success: function (resp) {
                        resp =JSON.parse(resp);
                        if(resp.status =='success'){
                            $('#successAlert').show();
                            var mp3Link= "<a href='"+resp.message+"'>Mp3 Download Link</a>"
                            $('#successAlert').html(mp3Link);
                        } else if(resp.status =='error'){
                            $('#errorAlert').show();
                            $('#errorAlert').html(resp.message);
                        }
                        $("#convertBtn").prop("disabled", false);

                        $('#loadingAlert').hide();

                    },
                    error: function (e) {
                        $('#loadingAlert').hide();
                        $('#errorAlert').show();
                        $('#errorAlert').html(resp.message);
                        $("#convertBtn  ").prop("disabled", false);

                    }
                });

            });

        });
    </script>
</body>
</html>