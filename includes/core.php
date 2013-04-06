<?
function mapadosplanos_select_questionarios($post_id) {
   global $wpdb;
   global $db;

   $quests = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "mapadosplanos_quest WHERE post_id = " . $post_id);

   // Echo the title of the first scheduled post
   return $quests;
   }

function mapadosplanos_submit_form($post_id) { 

	if(isset($_POST['submit']) and $_POST['action']=='questionario'):
	    //implementar check if recaptcha
	    global $wpdb;
    	
    	$p = $_POST;
    	$p['qs_03'] = maybe_serialize($p['qs_03']);
    	$p['qs_04'] = maybe_serialize($p['qs_04']);

    	$sql = $wpdb->prepare("INSERT INTO wp_mapadosplanos_quest 
    		(id, post_id, qs_nome, qs_relacao, qs_relacao_obs, qs_conselho, qs_conselho_obs, qs_email, qs_telefone,
    		 qs_01, qs_01_1, qs_01_obs, qs_02, qs_02_obs, qs_03, qs_04, qs_obs) 
    		values (NULL, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
    		 $p['post_id'], $p['qs_nome'], $p['qs_relacao'], $p['qs_relacao_obs'], $p['qs_conselho'], $p['qs_conselho_obs'], $p['qs_email'], $p['qs_telefone'],
    		 $p['qs_01'], $p['qs_01_1'], $p['qs_01_obs'], $p['qs_02'], $p['qs_02_obs'], $p['qs_03'], $p['qs_04'], $p['qs_obs']);
    	
    		$wpdb->query($sql);
    	?>
	<?php else: ?>
	
		<form method="POST" action="" name="questionario_submit" enctype="multipart/form-data"> 
		<label for="nome">Nome da pessoa responsável pelo preenchimento:</label>
		<input type="hidden" name="post_id" value="<?php echo $post_id ?>">
		<input type="text" name="qs_nome" value="">
		<fieldset>
			<legend>Qual sua relação com a educação?</legend>
		<input type="radio" name="qs_relacao" value="Pai/mãe ou responsável">Pai/mãe ou responsável</input>
		<input type="radio" name="qs_relacao" value="Estudante">Estudante</input>
		<input type="radio" name="qs_relacao" value="Professor(a)">Professor(a)</input>
		<input type="radio" name="qs_relacao" value="Coordenador(a)">Coordenador(a)</input>
		<input type="text" name="qs_relacao_obs" value="">Qual?</input>
		</fieldset>
		<fieldset>
			<legend>Participa ou já participou de algum conselho</legend>
			<input type="radio" name="qs_conselho" value="Sim">Sim</input>
			<input type="radio" name="qs_conselho" value="Não">Não</input>
			<input type="text" name="qs_conselho_obs" value="">Qual?</input>
		</fieldset>
		<input type="text" name="qs_email" value="">Email</input>
		<input type="text" name="qs_telefone" value="">Telefone</input>

		<fieldset>
			<legend>1. Seu município tem Plano de Educação?</legend>
			<input type="radio" name="qs_01" value="Sim">Sim</input>
			<input type="radio" name="qs_01" value="Não">Não</input>
			<input type="radio" name="qs_01" value="Em elaboração">Em elaboração</input>
			<input type="radio" name="qs_01" value="Não sabe">Não sabe</input>
		</fieldset>

		<fieldset>
			<legend>1.1. Se sim ou em elaboração:
					Você participa ou participou do processo de construção do Plano?</legend>
			<input type="radio" name="qs_01_1" value="Sim">Sim</input>
			<input type="radio" name="qs_01_1" value="Não">Não</input>
			<input type="text" name="qs_01_obs" value="">Como?</input>
		</fieldset>

		<fieldset>
			<legend>2. Segundo a sua opinião, em que medida um Plano de Educação pode ajudar a melhorar a educação em seu município? Dê uma nota de 0 a 5 para
cada uma das possibilidades apresentadas abaixo, sendo 5 quando o Plano tem grande capacidade de realizar o que está dito e 0 quando o Plano
não interfere no aspecto mencionado.</legend>
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
		<input type="text" name="qs_02_obs" value="">Outros?</input>
		</fieldset>


		<fieldset>
			<legend>3. Escolha três aspectos que, na sua opinião, dificultam a participação da sociedade civil na construção e revisão do Plano de Educação em seu
município:</legend>
			<input type="checkbox" name="qs_03[]" value="Grandes distâncias e dificuldade de locomoção no município">Grandes distâncias e dificuldade de locomoção no município</input>
			<input type="checkbox" name="qs_03[]" value="Falta de conhecimento sobre os Planos de Educação">Falta de conhecimento sobre os Planos de Educação</input>
			<input type="checkbox" name="qs_03[]" value="Falta de tempo">Falta de tempo</input>
			<input type="checkbox" name="qs_03[]" value="Falta de interesse">Falta de interesse</input>
			<input type="checkbox" name="qs_03[]" value="Dificuldade de acesso à informação">Dificuldade de acesso à informação</input>
			<input type="checkbox" name="qs_03[]" value="Falta de divulgação dos eventos relacionados ao processo de construção do Plano">Falta de divulgação dos eventos relacionados ao processo de construção do Plano</input>
			<input type="checkbox" name="qs_03[]" value="Falta de diálogo entre as escolas e as famílias">Falta de diálogo entre as escolas e as famílias</input>
			<input type="checkbox" name="qs_03[]" value="Falta de diálogo entre o poder público e a sociedade">Falta de diálogo entre o poder público e a sociedade</input>
			<input type="text" name="qs_03[]" value="">Outros?</input>
		</fieldset>

		<fieldset>
			<legend>4. Escolha três aspectos que, na sua opinião, possibilitariam maior participação da sociedade civil na construção e revisão do Plano de Educação
em seu município:</legend>
			<input type="checkbox" name="qs_04[]" value="Reuniões na escola e/ou outros espaços públicos existentes na comunidade para discutir o que é um Plano de Educação e por que é importante participar de sua construção">Reuniões na escola e/ou outros espaços públicos existentes na comunidade para discutir o que é um Plano de Educação e por que é importante participar de sua construção</input>
			<input type="checkbox" name="qs_04[]" value="Ampla divulgação dos eventos realizados para a construção de Planos de Educação">Ampla divulgação dos eventos realizados para a construção de Planos de Educação</input>
			<input type="checkbox" name="qs_04[]" value="Facilitação do acesso às informações sobre a situação educacional no município">Facilitação do acesso às informações sobre a situação educacional no município</input>
			<input type="checkbox" name="qs_04[]" value="Ações realizadas em escolas próximas à residência / local de estudo">Ações realizadas em escolas próximas à residência / local de estudo</input>
			<input type="checkbox" name="qs_04[]" value="Apoio para transporte">Apoio para transporte</input>
			<input type="checkbox" name="qs_04[]" value="Apoio para alimentação">Apoio para alimentação</input>
			<input type="checkbox" name="qs_04[]" value="Apoio com o cuidado dos(as) filhos(as) durante os eventos e reuniões">Apoio com o cuidado dos(as) filhos(as) durante os eventos e reuniões</input>
			<input type="checkbox" name="qs_04[]" value="Envolvimento da escola onde estudo ou onde o(a) filho(a) estuda no processo de construção ou revisão do Plano de Educação">Envolvimento da escola onde estudo ou onde o(a) filho(a) estuda no processo de construção ou revisão do Plano de Educação</input>
			<input type="checkbox" name="qs_04[]" value="Envolvimento do poder público local no processo de construção ou revisão do Plano de Educação">Envolvimento do poder público local no processo de construção ou revisão do Plano de Educação</input>
			<input type="checkbox" name="qs_04[]" value="Participação da população nos espaços destinados à construção do Plano de Educação">Participação da população nos espaços destinados à construção do Plano de Educação</input>
			<input type="text" name="qs_04[]" value="">Outros?</input>
		</fieldset>

			<input type="text" name="qs_obs" value=""></input>

		<input type="hidden" name="action" value="questionario" />
		<input type="submit" name="submit" value="Enviar"/>
		</form>
	
	<?php endif;
	}
	
	add_shortcode( 'mapadosplanos_submit_form', 'mapadosplanos_submit_form' );
?>
