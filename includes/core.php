<?
function sum_array_options($questao) {
  $tmp = 0;
    foreach ($questao as $n => $times) {
      if ($n == '') {
        $n = 0;
      }
      $tmp = $tmp + ($n*$times);
    }
  return $tmp;
}


function get_meta_count( $key = '', $value = '', $type = 'post', $status = 'publish' ) {
    global $wpdb;
    // Example code only
    // Good idea to add your own arg checking here
    if( empty( $key ) )
        return;
    $p = $wpdb->prepare( "
        SELECT DISTINCT COUNT(*) as count FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id 
        WHERE pm.meta_key = '%s' 
        AND pm.meta_value = '%s'
        AND p.post_status = '%s' 
        AND p.post_type = '%s' 
        OR pm.meta_key = 'wpcf-a187' 
        AND pm.meta_value = '%s'
    ", $key, $value, $status, $type, $value );

    $r = $wpdb->get_var($p);
    return $r;
}

function mapadosplanos_select_questionarios($post_id) {
   global $wpdb;
   global $db;

   $quests = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "mapadosplanos_quest WHERE post_id = " . $post_id);

$summary = array(
   		'post_id' => array(),
   		'qs_01' => array(),
   		'qs_01_1' => array(),
   		'qs_02_1' => array(),
	    'qs_02_2' => array(),
		'qs_02_3' => array(),
      	'qs_02_4' => array(),
      	'qs_02_5' => array(),
   		'qs_03' => array(),
   		'qs_04' => array(),
   		'qs_05' => array()
   	);

   foreach ($quests as $q) {
		$summary[post_id][] = $q->post_id;
   		$summary[qs_01][] = $q->qs_01;
   		$summary[qs_01_1][] = $q->qs_01_1;
   		$summary[qs_02_1][] = $q->qs_02_1;
      	$summary[qs_02_2][] = $q->qs_02_2;
      	$summary[qs_02_3][] = $q->qs_02_3;
      	$summary[qs_02_4][] = $q->qs_02_4;
      	$summary[qs_02_5][] = $q->qs_02_5;
   		if (array_key_exists('qs_03', $q)) {
   			$output = array_merge((array) $summary[qs_03], (array) unserialize($q->qs_03));
   			$summary[qs_03] = $output;
   		}
   		if (array_key_exists('qs_04', $q)) {
   			$output = array_merge((array) $summary[qs_04], (array) unserialize($q->qs_04));
   			$summary[qs_04] = $output;
   		}
   		$summary[qs_05][] = $q->qs_05;
   }
  	$summary_count = array();
  	foreach ($summary as $k => $s) {
  		$summary_count[$k] = array_count_values($s);
  	}
    $summary_count[qs_02_1] = sum_array_options($summary_count[qs_02_1]);
    $summary_count[qs_02_2] = sum_array_options($summary_count[qs_02_2]);
    $summary_count[qs_02_3] = sum_array_options($summary_count[qs_02_3]);
    $summary_count[qs_02_4] = sum_array_options($summary_count[qs_02_4]);
    $summary_count[qs_02_5] = sum_array_options($summary_count[qs_02_5]);
    //print_r($summary_count);
  	return $summary_count;
}

function mapadosplanos_submit_form($post_id) { 
	if (!function_exists('recaptcha_get_html')) {
		die("Plugin <a href='https://github.com/blaenk/wp-recaptcha'>reCapcha</a> não instalado.");
	}
	//performance sofrivel?
	$recaptcha =  wp_load_alloptions();
	$recaptcha =  unserialize($recaptcha['recaptcha_options']);
	if(isset($_POST['submit']) and $_POST['action']=='questionario'):
		echo '<script>window.location.hash = "#parte3";</script>';
	    //implementar check if recaptcha
  		$resp = recaptcha_check_answer ($recaptcha['private_key'],
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  		if (!$resp->is_valid) {
			die ("O reCAPTCHA deu um problema. Tente novamente!" .
         		"(Erro: " . $resp->error . ")");
  		}
  		else {
  			global $wpdb;
  			$r = $wpdb->get_var( $wpdb->prepare( "
        		SELECT COUNT(*) as count FROM {$wpdb->prefix}mapadosplanos_quest
        		WHERE `qs_cpf` = '%s' 
        		AND `post_id` = %d
    			", $_POST['qs_cpf'], $_POST['post_id'] ) );
    		if ($r != 0) {
    			echo "Você já respondeu esse questionario. Obrigado!";
    		}
    		
    		else {
    			$p = $_POST;
    			$p['qs_03'] = maybe_serialize($p['qs_03']);
    			$p['qs_04'] = maybe_serialize($p['qs_04']);

    			$sql = $wpdb->prepare("INSERT INTO wp_mapadosplanos_quest 
    				(id, post_id, qs_nome, qs_cpf, qs_relacao, qs_relacao_obs, qs_conselho, qs_conselho_obs, qs_email, qs_telefone,
    		 		qs_01, qs_01_1, qs_01_obs, qs_02_1, qs_02_2, qs_02_3, qs_02_4, qs_02_5, qs_02_obs, qs_03, qs_04, qs_obs) 
    				values (NULL, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
    		 		$p['post_id'], $p['qs_nome'], $p['qs_cpf'], $p['qs_relacao'], $p['qs_relacao_obs'], $p['qs_conselho'], $p['qs_conselho_obs'], $p['qs_email'], $p['qs_telefone'],
    		 		$p['qs_01'], $p['qs_01_1'], $p['qs_01_obs'], $p['qs_02_1'], $p['qs_02_2'], $p['qs_02_3'], $p['qs_02_4'], $p['qs_02_5'], $p['qs_02_obs'], $p['qs_03'], $p['qs_04'], $p['qs_obs']);
    	
    			$wpdb->query($sql);
    			
    			echo '<!-- <script>$("#respostas-sociedade").removeClass("nao-respondido");</script> -->';
    			echo "<span class='titulo'>Agradecemos a sua participação!</span><br>Seu questionário foi registrado no banco de dados do <b>De Olho nos Planos</b>.<br>Continue monitorando o Plano de Educação do seu município.<br/><br/>";
				echo "<span class='titulo'>Clique <a onclick='window.location.reload();' style='cursor: pointer;'>aqui</a> para visualizar as respostas.</span>";
    		}
		}	
    		?>
	<?php else: ?>
		<form method="POST" action="" name="questionario_submit" enctype="multipart/form-data">
		<span>Este pequeno cadastro foi criado para que possamos conhecê-lo(a) melhor e estimular o debate sobre a construção e revisão de Planos de Educação. Vamos refletir sobre este processo em seu município? Bom trabalho!</span><br><p style="color: #F11D4F;">*campos obrigatórios</p><br> 
		<fieldset>
			<label for="qs_nome">Nome da pessoa responsável pelo preenchimento:<span style="color: #F11D4F;">*</style></label>
			<input type="hidden" name="post_id" value="<?php echo $post_id ?>">
			<input type="text" name="qs_nome" required>
		</fieldset>
		<fieldset>
			<label for="qs_cpf">CPF:<span style="color: #F11D4F;">(Ex:99999999999)*</span></label>
			<input type="text" name="qs_cpf" pattern="\d{11}" title="Digite o CPF, apenas números" required>
		</fieldset>
		<fieldset>
			<label for="qs_email">Email:</label>
			<input type="text" name="qs_email">

			<label for="qs_telefone">Telefone:</label>
			<input type="text" name="qs_telefone" value="">
		</fieldset>

		<fieldset>
			<legend>Qual sua relação com a educação?</legend>
		
			<label for="qs_relacao_1"><input type="radio" name="qs_relacao" value="Pai/mãe ou responsável" checked="checked">Pai/mãe ou responsável</label>
			
			<label for="qs_relacao_2"><input type="radio" name="qs_relacao" value="Estudante">Estudante</label>
		
			<label for="qs_relacao_3"><input type="radio" name="qs_relacao" value="Professor(a)">Professor(a)</label>
		
			<label for="qs_relacao_4"><input type="radio" name="qs_relacao" value="Coordenador(a)">Coordenador(a)</label>
		
			<label for="qs_relacao_5"><input type="radio" name="qs_relacao" value="Outra">Outra</label>
			
			<label for="qs_relacao_obs">Se outra, qual?</label>
			<input type="text" name="qs_relacao_obs" value="">
		</fieldset>
		
		<fieldset>
			<legend>Participa ou já participou de algum conselho</legend>
			
			<label for="qs_conselho_1"><input type="radio" name="qs_conselho" value="Sim">Sim</label>
			
			<label for="qs_conselho_2"><input type="radio" name="qs_conselho" value="Não">Não</label>
			
			<label for="qs_conselho_obs">Em caso afirmativo, de qual?</label>
			<input type="text" name="qs_conselho_obs" value="">
		</fieldset>
		<hr>


		<fieldset id="fs_qs_01">
			<legend>Seu município tem Plano de Educação?</legend>
			
			<label for="qs_01_r1"><input type="radio" name="qs_01" value="Sim">Sim</label>
						
			<label for="qs_01_r2"><input type="radio" name="qs_01" value="Não">Não</label>
			
			<label for="qs_01_r3"><input type="radio" name="qs_01" value="Em elaboração">Em elaboração</label>
			
			<label for="qs_01_r4"><input type="radio" name="qs_01" value="Não sabe">Não sabe</label>
		</fieldset>

		<fieldset id="fs_qs_01_1">
			<legend>Se sim ou em elaboração: você participa ou participou do processo de construção do Plano?</legend>
				
				<label for="qs_01_1_r1"><input type="radio" name="qs_01_1" value="Sim">Sim</label>
				
				
				<label for="qs_01_1_r2"><input type="radio" name="qs_01_1" value="Não">Não</label>
				
				<label for="qs_01_obs">Em caso afirmativo, como?</label>
				<input type="text" name="qs_01_obs" value="">
		</fieldset>
		<hr>

		<fieldset id="fs_qs_02">
			<legend>Segundo a sua opinião, em que medida um Plano de Educação pode ajudar a melhorar a educação em seu município?</legend> 
			<div class="form-info">Dê uma nota de 0 a 5 para cada uma das possibilidades apresentadas abaixo, sendo 5 quando o Plano tem grande capacidade de realizar o que está dito, e 0 quando o Plano não interfere no aspecto mencionado.</div>
			
		<label for="qs_02_1">Permite que boas iniciativas de uma gestão governamental perdurem entre diferentes mandatos</label>
		<select name="qs_02_1">
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
			<option>5</option>
		</select>
		
		<label for="qs_02_2">Colabora com a construção de parcerias e articulações entre as escolas de diferentes redes no município (municipal, estadual e federal)</label>
		<select name="qs_02_2">
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
			<option>5</option>
		</select>
		
		<label for="qs_02_3">Permite identificar os problemas a serem enfrentados, ao se realizar um estudo/diagnóstico sobre a situação educacional local</label>
		<select name="qs_02_3">
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
			<option>5</option>
		</select>
		
		<label for="qs_02_4">Permite o acompanhamento e fiscalização do cumprimento dos objetivos e metas presentes no Plano de Educação</label>
		<select name="qs_02_4">
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
			<option>5</option>
		</select>
		
		<label for="qs_02_5">Possibilita a participação das escolas (professores/as, funcionários/as, alunos/as e pais) na definição dos rumos da política educacional local</label>
		<select name="qs_02_5">
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
			<option>5</option>
		</select>
		
		<label for="qs_02_obs">Outros?</label>
		<input type="text" name="qs_02_obs" value="">
		</fieldset>
		<hr>


		<fieldset id="fs_qs_03">
			<legend>Escolha três aspectos que, na sua opinião, dificultam a participação da sociedade civil na construção e revisão do Plano de Educação em seu município:</legend>
			
			<label for="qs_03_1"><input type="checkbox" name="qs_03[]" value="Grandes distâncias e dificuldade de locomoção no município">Grandes distâncias e dificuldade de locomoção no município</label>
			
			<label for="qs_03_2"><input type="checkbox" name="qs_03[]" value="Falta de conhecimento sobre os Planos de Educação">Falta de conhecimento sobre os Planos de Educação</label>
			
			<label for="qs_03_3"><input type="checkbox" name="qs_03[]" value="Falta de tempo">Falta de tempo</label>
			
			<label for="qs_03_4"><input type="checkbox" name="qs_03[]" value="Falta de interesse">Falta de interesse</label>
			
			<label for="qs_03_5"><input type="checkbox" name="qs_03[]" value="Dificuldade de acesso à informação">Dificuldade de acesso à informação</label>
			
			<label for="qs_03_6"><input type="checkbox" name="qs_03[]" value="Falta de divulgação dos eventos relacionados ao processo de construção do Plano">Falta de divulgação dos eventos relacionados ao processo de construção do Plano</label>
			
			<label for="qs_03_7"><input type="checkbox" name="qs_03[]" value="Falta de diálogo entre as escolas e as famílias">Falta de diálogo entre as escolas e as famílias</label>
			
			<label for="qs_03_8"><input type="checkbox" name="qs_03[]" value="Falta de diálogo entre o poder público e a sociedade">Falta de diálogo entre o poder público e a sociedade</label>
			
			<label for="qs_03_obs">Outros?</label>
			<input type="text" name="qs_03_obs" value="">
		</fieldset>
		<hr>

		<fieldset id="fs_qs_04">
			<legend>Escolha três aspectos que, na sua opinião, possibilitariam maior participação da sociedade civil na construção e revisão do Plano de Educação em seu município:</legend>
			
			<label for="qs_04_1"><input type="checkbox" name="qs_04[]" value="Reuniões na escola e/ou outros espaços públicos existentes na comunidade para discutir o que é um Plano de Educação e por que é importante participar de sua construção">Reuniões na escola e/ou outros espaços públicos existentes na comunidade para discutir o que é um Plano de Educação e por que é importante participar de sua construção</label>
			
			<label for="qs_04_2"><input type="checkbox" name="qs_04[]" value="Ampla divulgação dos eventos realizados para a construção de Planos de Educação">Ampla divulgação dos eventos realizados para a construção de Planos de Educação</label>

			<label for="qs_04_3"><input type="checkbox" name="qs_04[]" value="Facilitação do acesso às informações sobre a situação educacional no município">Facilitação do acesso às informações sobre a situação educacional no município</label>
			
			<label for="qs_04_4"><input type="checkbox" name="qs_04[]" value="Ações realizadas em escolas próximas à residência / local de estudo">Ações realizadas em escolas próximas à residência / local de estudo</label>
			
			<label for="qs_04_5"><input type="checkbox" name="qs_04[]" value="Apoio para transporte">Apoio para transporte</label>
			
			<label for="qs_04_6"><input type="checkbox" name="qs_04[]" value="Apoio para alimentação">Apoio para alimentação</label>
			
			<label for="qs_04_7"><input type="checkbox" name="qs_04[]" value="Apoio com o cuidado dos(as) filhos(as) durante os eventos e reuniões">Apoio com o cuidado dos(as) filhos(as) durante os eventos e reuniões</label>
			
			<label for="qs_04_8"><input type="checkbox" name="qs_04[]" value="Envolvimento da escola onde estudo ou onde o(a) filho(a) estuda no processo de construção ou revisão do Plano de Educação">Envolvimento da escola onde estudo ou onde o(a) filho(a) estuda no processo de construção ou revisão do Plano de Educação</label>
			
			<label for="qs_04_9"><input type="checkbox" name="qs_04[]" value="Envolvimento do poder público local no processo de construção ou revisão do Plano de Educação">Envolvimento do poder público local no processo de construção ou revisão do Plano de Educação</label>
			
			<label for="qs_04_10"><input type="checkbox" name="qs_04[]" value="Participação da população nos espaços destinados à construção do Plano de Educação">Participação da população nos espaços destinados à construção do Plano de Educação</label>
			
			<label for="qs_04_obs">Outros?</label>
			<input type="text" name="qs_04_obs" value="">
		</fieldset>
		<hr>

		<input type="hidden" name="action" value="questionario" />
	<?php 
		//RecaptchaLib
        echo recaptcha_get_html($recaptcha['public_key']);
	?>


		<input type="submit" name="submit" value="Enviar questionário"/>
		</form>
	
	<?php endif;
	}
	
	add_shortcode( 'mapadosplanos_submit_form', 'mapadosplanos_submit_form' );

	function mapadosplanos_count( $atts ){
 		extract( shortcode_atts( array(
			'etapa' => 'todas',
		), $atts ) );
		if ($etapa == 'complano') {
			return get_meta_count('wpcf-qs_etapa01', 'Sim', 'municipio');
		}
		else if ($etapa == 'elaboracao') {
			return get_meta_count('wpcf-qs_etapa01', 'Elaboração', 'municipio');
		}
		else if ($etapa == 'semplano') {
			return get_meta_count('wpcf-qs_etapa01', 'Não', 'municipio');
		}
		else {
			return 0;
		}
	}
	add_shortcode( 'mapa_respostas', 'mapadosplanos_count' );
	add_filter( 'widget_text', 'shortcode_unautop');
	add_filter('widget_text', 'do_shortcode');

//Adding javascript to admin to conditional form
function mapadosplanos_questionario_script() {
        wp_enqueue_script( 'my_custom_script', plugins_url('/js/questionario.js', __FILE__) );
}
add_action( 'admin_enqueue_scripts', 'mapadosplanos_questionario_script' );


?>
