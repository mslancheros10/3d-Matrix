<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>
                <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                      <div class="panel-heading">Agregar archivos</div>
                        <div class="panel-body">
                          <form method="POST" action="http://localhost:1337/laravel_installation/public/matrix" accept-charset="UTF-8" enctype="multipart/form-data">
                            
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            
                            <div class="form-group">
                              <label class="col-md-4 control-label">Nuevo Archivo</label>
                              <div class="col-md-6">
                                <input type="file" class="form-control" name="file" >
                              </div>
                            </div>
                 
                            <div class="form-group">
                              <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </body>
</html>
