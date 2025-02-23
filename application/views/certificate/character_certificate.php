<html>
    <head></head>
    <title>Charater Certificate</title>
    <style type="text/css">
        .serif{
font-family: serif;
}
.texto {
margin: 0;
}
.negrito {
font-weight: 700
}
.negrito-2 {
font-weight: 600
}
.sublinhar{
text-decoration: underline;
}
.center {
text-align: center
}
.esquerda {
text-align: justify;
font-family: 'Palatino Linotype';
word-spacing: 10px;
line-height: 200%;
}
.overline {
text-decoration: overline;
}
.quebra_linha{
display: block;
}
/*.cert{
    display: block;
    border: 2px solid black;
    border-radius: 25px;
}*/
/*configurações de fonts*/
.font-17 {
font-size: 16px;
}
.font-24 {
font-size: 20px;
}
.font-36 {
font-size: 30px;
}
.font-31 {
font-size: 30px;
}
.font-40 {
font-size: 32px;
}
/*confifurações de margin*/
.padding_top_35{
padding-top:35px;
}
.margin_bottom_35{
margin-bottom: 35px;
}
.altura_linhas_19{
line-height: 19px;
}
.altura_linhas_35{
line-height: 35px;
}
.altura_linhas_25{
line-height: 25px;
}
.caixa_informacoes_aluno_cea{
font-size: 22px;
text-align: justify;
padding-right: 46px;
}
.caixa_informacoes_aluno_cea_2{
font-size: 22px;
text-align: justify;
padding-right: 46px;
padding-left: 46px;
}
.caixa_informacoes_aluno_cea p{
margin-top: 5px;
}
.assinatura_cea{
line-height: 22px;
font-size: 22px;
padding-top: 22px;
}
.titulo_cea_2{
margin-top: 35px
margin-bottom: 35px
}
.data_entrega_cea{
padding-top: 25px;
padding-bottom: 43px;
}
/*.certificado_conteudo {
-webkit-print-color-adjust: exact;
height: 755px;
width: 1085px;
background-repeat: no-repeat
}*/
/*.certificado_pagina {
padding: 5mm;
width: 1085px;
margin: 30px auto;
box-shadow: .5px .5px 7px #000;
border-radius: 2px;
overflow: hidden;
}
@page {
size: 300mm 260mm;
margin: 5mm;
size: portrait;
}*/
body {
margin: 0;
padding: 0px !important;
border-style: double;
border-width:10px; 
font-family: 'Open Sans', sans-serif
}
p{
margin: 0px;
}
/*SEMPRE DEIXAR NO FIM DO CODIGO configuração de impresão*/
@media print {
.certificado_pagina {
padding: 0;
background: transparent;
margin: 0;
box-shadow: none;
-webkit-box-shadow: none;
border-style: double;
border-width:10px; 
}
}
    </style>
    <body>
        <div>
    <div class="certificado_pagina">
        <div class="certificado_conteudo">
            <div class="row end-xs">
                <div class="col-xs-12">
                    <div class="box">
                        <table style="width:100%">
                            <tbody>
                                <tr>
                                    <th align="left"><img src="<?php echo $_SERVER['DOCUMENT_ROOT'];?>/<?php echo $logo;?>" height="95px;"></th>
                                    <th align="center" width="80%"> 
                                         <p class="padding_top_35 center">
                            <span class="font-40 negrito  quebra_linha serif"> <?php echo $school_desc[0]->description; ?> </span>
                        </p>
                        <p class="center altura_linhas_19">
                            <span class="font-17 quebra_linha"><?php echo $school_desc[0]->address; ?> </span>
                            <span class="font-17 quebra_linha"><?php echo $school_desc[0]->vision; ?></span>
                            <span class="font-17 quebra_linha">MAIL : <?php echo $school_desc[0]->email; ?> &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; TEL : <?php echo $school_desc[0]->phone; ?></span>
                        </p>
                                    </th>                            
                                    <th align="right" width="10%"></th>
                                </tr>
                            </tbody>
                        </table>
                                            </div><br><br>


                    <div class="box">
                        <p class="padding_top_35 margin_bottom_35 center">
                            <span class="font-31 negrito-2  quebra_linha "><u>CHARACTER CERTIFICATE</u></span>
                        </p>
                        <table style="width:100%">
                <tbody>
                    <tr>
                        <th align="left">&nbsp; Certificate No. : DAVBAR/20-21/<?php echo $tc_data[0]->tc_number;?> </th>
                    </tr>
                </tbody>
            </table><br>
            <?php  
                        $originalDate = $tc_data[0]->date_of_adm;
                        $newDatedob = date("d/m/Y", strtotime($originalDate));

                        $last_date = $tc_data[0]->date;
                        $newlastdob = date("d/m/Y", strtotime($last_date));
                ?>
                        <div class="caixa_informacoes_aluno_cea serif">
                            <p class="esquerda"><i>&nbsp;&nbsp;This is to Certify that &nbsp; Master/Miss <span class="sublinhar negrito"><?php echo $data[0]->first_name. ' '. $data[0]->middle_name. ' '. $data[0]->last_name; ?><br> </span>&nbsp;&nbsp;S/O/D/O <span class="sublinhar negrito"><?php echo $data[0]->father_name?> </span>&  <span class="sublinhar negrito"><?php echo $data[0]->mother_name?> </span><br>&nbsp;&nbsp;admission no. <span class="sublinhar negrito"><?php echo $data[0]->admission_no; ?></span> Class <span class="sublinhar negrito"><?php echo $data[0]->class_name; ?></span>  has been a bonafide<br>&nbsp;&nbsp;student of this school from <span class="sublinhar negrito"><?php echo $newDatedob; ?> </span> to <span class="sublinhar negrito"><?php echo $newlastdob; ?></span></i></p><br><br><br><br>
                            <p style="font-weight: bold">
                                <i>&nbsp;&nbsp;To the best of my knowledge he/she bears a Good moral character.</i>
                            </p><br>
                            <p style="font-weight: bold">
                                <i>&nbsp;&nbsp;I wish him/her every success in life.</i>
                            </p>
                        </div>
                    </div>
                </div><br><br><br><br><br><br><br><br><br>
                <table style="width:100%;font-size: 10px;">
                            <tbody>
                                <tr>
                                    <th align="left" width="30%">&nbsp;&nbsp;&nbsp;&nbsp;<p> &nbsp;&nbsp;ISSUE DATE </p><p style="font-size: 8px;"> &nbsp;&nbsp;<?php echo date("d/m/Y"); ?></p></th>
                                    <th align="center" width="50%"><p>DEALING CLERK</p><p style="font-size: 8px;">(Signature)</p>
                                    </th>                            
                                    <th align="right" width="15%"><p>PRINCIPAL</p><p style="font-size: 8px;">(Signature)</p></th>
                                    <th align="right" width="5%"></th>
                                </tr>
                            </tbody>
                        </table>
            </div>
            
            </div>
        </div>
    </div>
    </body>
</html>