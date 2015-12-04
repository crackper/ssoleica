<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Alertas SSOLeica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="font-family: sans-serif;
             font-size: 10px;min-height: 100%;
             margin: 0;
             padding: 0;
             background-color: #f4f4f4;">
    <table cellpadding="0" cellspacing="0"
            style="width: 100%;
            height: 100%;
            font-family: sans-serif;
                         font-size: 10px;min-height: 100%;
                         margin: 0;
                         padding: 0;
                         background-color: #f4f4f4;">
        <tr style="background-color: #2fa4e7;
                     border-top-color: #1995dc;
                     border-right-color: #1995dc;
                     border-bottom-color: #1995dc;
                     border-left-color: #1995dc;">
            <td><br/></td>
        </tr>
        <tr>
            <td>
                <h1 style="margin-top: 6px;margin-right: 0px;margin-bottom: 6px;margin-left: 0px;font-size: 20px; padding-left: 15px;">
                    <img src="http://ssoleica.herokuapp.com/images/logoHexagon.png" alt="HexagonMining"/>
                    <img src="http://ssoleica.herokuapp.com/images/logoLeicaGeosystem.gif" lt="Leica Geosystems" width="69"/>
                    SSO Leica <small style="font-size: 65%;font-weight: normal;line-height: 1;color: #777777;">Geosystems {!! $pais !!}</small>
                </h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 10px 10px 10px 10px;">
                <table style="
                              background-color: #ffffff;
                              background-origin: padding-box;
                              border: 1px solid #f4f4f4;
                              padding: 10px;
                              width: 100%;">
                    <tr>
                         <td style="font-size: 13px; padding: 5px;">
                             Estimdado(a),
                             <strong>{!! $subject !!}</strong> estan por vencer los siguientes documentos.
                         </td>
                     </tr>
                     @if(count($data_f))
                     <tr>
                         <td style="font-size: 13px; padding: 5px;">

                            <h2 style="font-size:18px;border-bottom: 1px solid #ddd;">Fotochecks</h2>
                                @foreach($data_f as $key => $row)
                                        <b> {!! $row["proyecto"] !!} </b>
                                        <br/>
                                            <table style="padding: 8px;margin-bottom: 5px;font-size: 12px;" >
                                                <thead>
                                                    <th>#</th>
                                                    <th>Trabajador</th>
                                                    <th>Nro. Fotocheck</th>
                                                    <th>F.Vencimiento</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($row["fotochecks"] as $k => $f)
                                                     <tr>
                                                         <td style="border-top: 1px solid #dddddd; padding: 4px;">{!! $k+1 !!}</td>
                                                         <td style="border-top: 1px solid #dddddd; padding: 4px;">{!! $f->trabajador !!}</td>
                                                         <td style="border-top: 1px solid #dddddd; padding: 4px;text-align: center;">{!! $f->fotocheck !!}</td>
                                                         <td style="border-top: 1px solid #dddddd; padding: 4px;text-align: center;">{!! date_format(new DateTime($f->fecha_vencimiento),'d/m/Y') !!} </td>
                                                     </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                    @endforeach

                         </td>
                     </tr>
                     @endif
                     @if(count($data_e))
                     <tr>
                         <td style="font-size: 13px; padding: 5px;">


                            <h2 style="font-size:18px;border-bottom: 1px solid #ddd">Exámenes Médicos</h2>
                                @foreach($data_e as $key => $row)
                                        <b> {!! $row["proyecto"] !!} </b>
                                        <br/>
                                            <table style="padding: 8px; margin-bottom: 5px;font-size: 12px;" >
                                                <thead>
                                                    <th>#</th>
                                                    <th>Trabajador</th>
                                                    <th>Exámen</th>
                                                    <th>F.Vencimiento</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($row["examenes"] as $k => $f)
                                                     <tr>
                                                         <td style="border-top: 1px solid #dddddd; padding: 4px;">{!! $k+1 !!}</td>
                                                         <td style="border-top: 1px solid #dddddd; padding: 4px;">{!! $f->trabajador !!}</td>
                                                         <td style="border-top: 1px solid #dddddd; padding: 4px;">{!! $f->vencimiento !!}</td>
                                                         <td style="border-top: 1px solid #dddddd; padding: 4px;text-align: center;">{!! date_format(new DateTime($f->fecha_vencimiento),'d/m/Y') !!} </td>
                                                     </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <br/>
                                    @endforeach

                         </td>
                     </tr>
                     @endif
                      @if(count($data_d))
                     <tr>
                         <td style="font-size: 13px; padding: 5px;">


                            <h2 style="font-size:18px;border-bottom: 1px solid #ddd">Otros Documentos</h2>
                                @foreach($data_d as $key => $row)
                                            <table style="padding: 8px; margin-bottom: 5px;font-size: 12px;" >
                                                <thead>
                                                    <th>#</th>
                                                    <th>Trabajador</th>
                                                    <th>Documento</th>
                                                    <th>F.Vencimiento</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($row["documentos"] as $k => $f)
                                                     <tr>
                                                         <td style="border-top: 1px solid #dddddd; padding: 4px;">{!! $k+1 !!}</td>
                                                         <td style="border-top: 1px solid #dddddd; padding: 4px;">{!! $f->trabajador !!}</td>
                                                         <td style="border-top: 1px solid #dddddd; padding: 4px;">{!! $f->vencimiento !!}</td>
                                                         <td style="border-top: 1px solid #dddddd; padding: 4px;text-align: center;">{!! date_format(new DateTime($f->fecha_vencimiento),'d/m/Y') !!} </td>
                                                     </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <br/>
                                    @endforeach

                         </td>
                     </tr>
                     @endif
                </table>
            </td>
        </tr>
        <tr style="background-color: #3c8dbc;
                     color: #ffffff;">
            <td style="padding: 10px; font-size: 12px;">
                <strong style="">Copyright © 2015 <a href="http://ssoleica.herokuapp.com/" target="_blank" style="color: #fff;
                                                                                                                  text-decoration-line: none;
                                                                                                                  text-decoration-style: solid;">Leica Geosystems</a>.</strong> All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>