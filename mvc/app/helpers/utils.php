<?php
    
    function mssql_real_escape_string($str)
    {
        if(get_magic_quotes_gpc())
        {
            $str = stripslashes($str);
        }
        
        return str_replace("'", "''", $str);
    }
    function mssql_sanitize($data)
    {
        return strip_tags(mssql_real_escape_string($data));
    }
    function sanitize2( $link, $dado )
    {
        //return strtoupper(utf8_decode(trim(preg_replace('/\s+/', ' ',(strip_tags(mysql_real_escape_string( $dado )))))));
        return strtoupper(trim(preg_replace('/\s+/', ' ',(strip_tags(mysqli_real_escape_string( $link, $dado ))))));
    }

    function sanitize2NoStripTags( $link, $dado )
    {
        return trim(preg_replace('/\s+/', ' ',(mysqli_real_escape_string( $link, $dado ))));
    }

    function inverteData($str) {
        $data = explode('-', $str);
        $ano = $data[0];
        $mes = $data[1];
        $dia = $data[2];
        return $dia . "/" . $mes . "/" . $ano;
    }

    function desfazData($str) {
        $data = explode('/', $str);
        $ano = $data[0];
        $mes = $data[1];
        $dia = $data[2];
        return $dia . "-" . $mes . "-" . $ano;
    }

    function customizarDataHora($str) {
        $dataHora = explode(' ', $str);
        $data = explode('-', $dataHora[0]);
        $dataHora[0] = "$data[2]/$data[1]/$data[0]";
        $saida = implode(', às ', $dataHora);

        return $saida;
    }

    // funcao que recebe valor em int e converte em string com pontos e virgula
    function converteDinheiro($valor) {
        return number_format(str_replace(",", ".", intval($valor) / 100), 2, ",", ".");
    }

    /**
     * retorna true/false baseado na permissao que o usuario tem sobre a funcionalidade alvo
     *
     * @param Object $link
     * @param int $nivel
     * @param string $funcionalidade
     * @return boolean
     */
    function validarPermissao($link, $nivel, $funcionalidade) {
        $query = "SELECT
                    $funcionalidade AS permitido
                FROM permissoes
                WHERE id_nivel = $nivel
                AND ativo = 1";
        // exit($query);
        $resultado = mysqli_query($link, $query);
        $rs = mysqli_fetch_object($resultado);
        
        return $rs ? $rs->permitido : 0;
    }
	
    function cadastraTitulo($pagina){
        return "SGPA";
    }

    function sanitize( $link, $param_name )
    {
        /*if ( isset($_GET[$param_name]) ) return utf8_decode(trim(preg_replace('/\s+/', ' ',(strip_tags(mysql_real_escape_string($_GET[$param_name]))))));
        else if ( isset($_POST[$param_name]) ) return utf8_decode(trim(preg_replace('/\s+/', ' ',(strip_tags(mysql_real_escape_string($_POST[$param_name]))))));
        else return null;*/
        if ( isset($_GET[$param_name]) ) return trim(preg_replace('/\s+/', ' ',(strip_tags(mysqli_real_escape_string($link, $_GET[$param_name])))));
        else if ( isset($_POST[$param_name]) ) return trim(preg_replace('/\s+/', ' ',(strip_tags(mysqli_real_escape_string($link, $_POST[$param_name])))));
        else return null;
    }

    function generateRandomString($size)
    {
        if ( $size % 2 != 0 ) throw new Exception("O parametro da funcao generateRandomString deve ser um numero par", 1);

        $size   = $size / 2;
        $bytes  = openssl_random_pseudo_bytes( $size );
        $random = bin2hex( $bytes );

        return $random;
    }


    function limpar_utf8($link, $dado)
    {
        return mysqli_escape_string($link,  trim( utf8_decode( $dado)  ) );
    }

    function dump( $dado )
    {
        echo '<pre>'; print_r( $dado ); echo '</pre>';
    }

    function sanitize_array($link, $array )
    {
        if ( !isset($_POST[$array])) return false;
        
        $resposta=$_POST[$array];


        if( ! is_array( $resposta )  ) return false;

        foreach($resposta as $key=>$value )
        {
            //echo $value;
            $resposta[$key] = sanitize2($link, $value );
        }
         
        return $resposta;
    }

    function array_has_empty_item( $array )
    {
        if( ! is_array( $array ) ) return true; //

        foreach( $array as $key => $value )
        {
            if ( empty ( $array[$key] ) ) return true;
        }

        return false;
    }

    function all_to_utf8($array)
    {
        if( ! is_array( $array ) ) return false;

        foreach( $array as $key => $value )
        {
            $array[$key] = utf8_decode( $array[$key] );
        }

        return $array;
    }


    function checarParaData ( $param){
        return ($param == '1' ) ? 'CURRENT_TIMESTAMP' : NULL;
    }


    function criarArrayDataLancamento( $array )
    {
        if( ! is_array( $array ) ) return false;

        foreach( $array as $key => $value )
        {
            $array[$key] = checarParaData( $array[$key] );
        }

        return $array;
    }


    function criarArrayDataParaBanco( $array )
    {
        if( ! is_array( $array ) ) return false;

        foreach( $array as $key => $value )
        {
            $array[$key] = dataParaBanco( $array[$key] );
        }

        return $array;
    }



    function criarArrayDataParaBr( $array )
    {
        if( ! is_array( $array ) ) return false;

        foreach( $array as $key => $value )
        {
            $array[$key] = dataParaBr( $array[$key] );
        }

        return $array;
    }


    function checarExistente ( $link,  $tabela ,$complemento  ){
        $queryBusca = "SELECT count(*) FROM ".$tabela." ".$complemento;
        //mysql_select_db('agentedaeducacao');
        $rsBusca = mysqli_query($link, $queryBusca);
        @$contadorBusca = mysqli_fetch_row($rsBusca);
        return $contadorBusca[0];
    }


    function checked ( $variavel ) {
        switch ( $variavel ) {
                case 0:
                    $checked = "unchecked";
                    break;
                case 1:
                    $checked = "checked";
                    break;
            }
        return $checked;
    }

    function rChecked ( $variavel ) {
        switch ( $variavel ) {
                case 0:
                    $checked = "checked";
                    break;
                case 1:
                    $checked = "unchecked";
                    break;
            }
        return $checked;
    }

    function checkNull ( $param_name )
    {
        if ( ! empty($param_name) ) return $param_name;
        else return 0;
    }


    function dataParaBanco( $data ){
        if ($data == '' )
            return null;
        $date = date_create_from_format('d/m/Y', $data);
        return date_format($date, 'Y-m-d');
    }

    function dataParaBanco2( $data ){
        if ($data == '' )
            return null;
        $date = date_create_from_format('d/m/Y H:i:s', $data);
        return date_format($date, 'Y-m-d H:i:s');
    }
    
    function dataParaBanco3( $data ){
        if ($data == '' )
            return null; 
        $data = str_replace('T', ' ', $data);
        $data .=":00";
        return $data;
    }

    function dataParaBr( $data ){
        if ($data == '' )
            return null;
        $date = date_create_from_format('Y-m-d', substr($data , 0 , 10));
        return date_format($date, 'd/m/Y');
    }
    function dataHoraParaBr( $data ){
        if ($data == '' )
            return null;
        $date = date_create_from_format('Y-m-d H:i:s', $data );
        return date_format($date, 'd/m/Y H:i:s');
    }
	
    function Hora( $data ){
        if ($data == '' )
            return null;
        $date = date_create_from_format('H:i:s', $data );
        return date_format($date, 'H:i:s');
    }	


    function formatarInt ( $int){
        if( $int == "" )
            return 0;
        if ( intval($int) > 10 )
            return 10;
        else
            return intval($int);
    }


    // Função: Realizar uma consulta no banco
    function consultar($link, $tabela , $where ) {
        $resultQueryConsultar = mysqli_query($link, "SELECT * FROM ".$tabela." WHERE ".$onde);
        $resultado = 0;

        while ( $rowResultConsultar = mysqli_fetch_array($resultQueryConsultar) ){
            $resultado = $rowResultConsultar[$campo];
        }
        $resultado = utf8_encode($resultado);
        return $resultado;
    }


    function gerarSelect($link, $tabela, $name, $selecionado = null){
        $select =  mysqli_query($link, "SELECT * FROM ".$tabela);

        $id = "id";
        $desc = "descricao";

        $resultado = '<select class="form-control" id="'.$name.'" name="'.$name.'" required>';
        $resultado .=   '<option value="">Selecione o Tipo de Deficiência...</option>';
        while ( $item = mysqli_fetch_array($select) ){
            $resultado .= '<option ';
            if($selecionado == $item[$id])
                $resultado .= 'selected';
            $resultado .= ' value="'.$item[$id].'">'.$item[$desc].'</option>';
        }
        $resultado .= '</select>';
        return $resultado;
    }


    function gerarSelect2($link, $tabela , $campo, $selecionado = null ) {
        $select = mysqli_query($link, "SELECT * FROM ".$tabela);
        $resultado = 0;

        $resultado =  '<select class="form-control" id="'.$tabela.'" name="'.$tabela.'">';
        $resultado .=   '<option value="">Selecione...</option>';

        while ( $item = mysqli_fetch_array($select) ){
            $resultado .= '<option ';
            if($selecionado == $item['id'])
                $resultado .= 'selected';
           $resultado .= ' value="'.$item['id'].'">'.$item[$campo].'</option>';
        }
        $resultado .= '</select>';
        return $resultado;
    }


    function exibirBotaoPorData( $dataCriado , $dataDiferenca){
        $dataEncerramento = strtotime($dataCriado.'+'.$dataDiferenca.' day');
        $dataHoje = strtotime(date('Y-m-d'));
        $diferenca = $dataHoje - $dataEncerramento;
        // if (($diferenca>0)&&($_SESSION['nivel'] != 1))

        if ($diferenca>0)
            echo 'style="display:none;"';
    }

    function exibirBotaoPorMes($dataCriado, $diaLimite){

        $mesCriado = substr($dataCriado, 5, 2);
        $diaCriado = substr($dataCriado, 8, 2);
        $anoCriado = substr($dataCriado, 0, 4);

        $diaAtual = date('d');
        $mesAtual = date('m');
        $anoAtual = date('Y');



        if( ($anoAtual == $anoCriado) && ($mesAtual > $mesCriado) && ($diaCriado < $diaLimite ) ){
            echo 'style="display:none;"';
        }

        if( ($anoAtual == $anoCriado) && ($mesAtual == $mesCriado) && ($diaCriado < $diaLimite ) ){
            echo 'style="display:none;"';
        }

    }



    // Função: exibirBotaoOm
    // Objetivo: Não exibir registros que são do próximo mês, após passarmos a data Limite
    function exibirBotaoOm($dataCriado, $tmpLimte){

        $mesCriado = substr($dataCriado, 5, 2);
        $diaCriado = substr($dataCriado, 8, 2);
        $anoCriado = substr($dataCriado, 0, 4);

        $diaAtual = date('d');
        $mesAtual = date('m');
        $anoAtual = date('y');

        $proxMes = $mesAtual + 1;

        $dataAtual = date('Y-m-d');
        $dataCriado = $anoCriado . '-' . $mesCriado . '-' . $diaCriado;


        // não é possivel editar depois da data do registro
        if( (strtotime($dataAtual)) > (strtotime($dataCriado)) ){
            echo 'style="display:none"';
        }

        // se o DIA ATUAL for maior que o DIA LIMITE , E o PROX MES for igual ao MES DO REGISTRO
        if( ($diaAtual > $tmpLimte ) && ( $proxMes == $mesCriado) ){
            echo 'style="display:none"';
        }

    }



		
	function dias_uteis($datainicial){
		$datafinal=date('Y-m-d h:i:s');
		if (!isset($datainicial)) return false;
		if (!isset($datafinal)) $datafinal=time();

		$segundos_datainicial = strtotime(preg_replace("#(\d{2})/(\d{2})/(\d{4})#","$3/$2/$1",$datainicial));
		$segundos_datafinal = strtotime(preg_replace("#(\d{2})/(\d{2})/(\d{4})#","$3/$2/$1",$datafinal));
		$dias = abs(floor(floor(($segundos_datafinal-$segundos_datainicial)/3600)/24 ) );
		$uteis=0;
		for($i=1;$i<=$dias;$i++){
		$diai = $segundos_datainicial+($i*3600*24);
		$w = date('w',$diai);
		if ($w==0){
		//echo date('d/m/Y',$diai)." é Domingo<br />";
		}elseif($w==6){
		//echo date('d/m/Y',$diai)." é Sábado<br />";
		}else{
		//echo date('d/m/Y',$diai)." é dia útil<br />";
		$uteis++;
		}
		}
		return $uteis;
    }
    
    function dd(){
        $arguments = func_get_args();
    
        foreach ($arguments as $key => $argument) {
            var_dump(json_encode($argument));
        }

        die();
    }

    function deserialize($arr) {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
        die;
    }


    function soNumero($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }
    
    function idade($data){
        if(!$data)
            return 0;
        list($ano, $mes, $dia) = explode('/', $data);

        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
        $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);

        return $idade;
    }


    function check_format(string $format, array $formats) {
        $imageFileType = explode('/', $format)[1];
    
        // $imageFileType = strtolower(pathinfo($file['tmp_name'],PATHINFO_EXTENSION));
        foreach ($formats as $key => $value) {
            if ($imageFileType == $value)
                return 1;
        }
    
        return 0;
    }

    function uploadFile($file , $tempName , $caminhoFinal ,  $tipo , $conn_id){     
    
        // define o destino a ser gravada a imagem ( caminho + pasta criada )
        if ( ! (ftp_chdir($conn_id, "/".$caminhoFinal))){
                ftp_chdir($conn_id, "/".$caminhoFinal);
        }
    
        if(($file == "") || ($tempName == "" ) ) {
            return false;
        }
    
                        
        $contents = count(ftp_nlist($conn_id, $caminhoFinal));
        $contents = $contents +1;

        $extensao = pathinfo ( $file, PATHINFO_EXTENSION );
        $extensao = strtolower ( $extensao );
        $novoNome = $tipo.".".$extensao;
        
        $enderecoGravacao = $novoNome;
        
        return ftp_put($conn_id, $novoNome , $tempName , FTP_BINARY) ? $enderecoGravacao : false;   
    } 


function criaPasta($conn_id, $caminhoFinal){
    // dd(file_exists(ROOTPATH.$caminhoFinal));
    if (!file_exists(ROOTPATH.$caminhoFinal)){
        if (!(ftp_mkdir($conn_id, $caminhoFinal))){
            return false;
        }
        return true;
    }
    else {
        return true;
    }
}

