<?
#### Custom Post Types
/* Antigo sistema de Custom Fields - substituido pelo plugin Types */
/*
global $ibge_setup, $ficha_setup;
$ibge_setup = array(
	    'A187' => 'Possui Plano',
	    'A171' => 'Instâncias de Gestão Democrática<br />Sistema Municipal de Ensino',
	    'A219' => 'Fundo Municipal de Educação',
	    'A211' => 'Conselho Municipal de Educação',
	    'A181' => 'Conselho de Controle e Acompanhamento Social do FUNDEF',
	    'A182' => 'Conselhos Escolares',
	    'A183' => 'Conselho de Alimentação Escolar',
	    'A184' => 'Conselho do Transporte Escolar',
	    'A188' => 'O Plano Municipal de Educação incorpora educação em direitos humanos no currículo?',
	    'A189' => 'Na rede municipal de ensino existe capacitação de professores em:<br />Direitos Humanos',
	    'A190' => 'Gênero',
	    'A191' => 'Raça/etnia',
	    'A192' => 'Orientação Sexual',
	    'A194' => 'Na rede municipal de ensino existem escolas aptas a receber pessoas com deficiência?'
	);


$ficha_setup = array(
    'Q1' => '1. Seu município possui plano de educação em vigência?',
    'Q2' => '2. Quando o plano de educação foi aprovado?',
    'Q3' => '3. O plano de educação já foi revisado nos últimos quatro anos?',
    'Q4' => '4. Seu município está elaborando um plano de educação? [Somente para quem respondeu Não na pergunta 01]',
    'Q5' => '5. Seu município pretende elaborar um plano de educação nesta gestão (2013-2016)? [Somente para quem respondeu Sim na pergunta 04]',
    'Q6' => '6. Seu município pretende revisar o plano de educação nesta gestão (2013-2016)? [Somente para quem já tem plano]',
    'Q7' => '7. Em qual momento da elaboração se encontra? (Somente para os munícipios que estão em processo de elaboração do Plano de Educação)',
    'Q8' => '8. O município contratou ou pretende contratar algum tipo de consultoria externa para elaboração do plano de educação? [Para todos]',
    'Q9' => '9. Quais dos órgãos/instâncias abaixo participam ou participaram da elaboração do plano de educação?',
    'Q10' => '10. Quais das organizações/movimentos abaixo participam ou participaram da elaboração do plano de educação?',
    'Q11' => '11. Dos segmentos da comunidade escolar descritos abaixo, quais participaram ou estão participando da elaboração do plano de educação de seu município.',
    'Q12' => '12. Quais foram ou estão sendo os dados utilizados para a elaboração do diagnóstico do município a ser utilizado no plano de educação? [Se necessário, assinale mais de uma alternativa]',
    'Q13' => '13. Quais foram ou estão sendo as principais metodologias utilizadas para a elaboração do plano de educação de seu município?',
    'Q14' => '14. O processo de elaboração do plano de educação mobilizou ou vem mobilizando',
    'Q15' => '15. Houve ou há um investimento na comunicação sobre o processo de construção/revisão do Plano?',
    'Q16' => '16. Caso positivo, a comunicação do processo se deu:',
    'Q17' => '17. Seu município está preparado para cumprir a lei de acesso à informação pública (lei 12.527/2011) com relação à área de educação?',
    'Q18' => '18. Além da gestão municipal, participam ou participaram do processo de construção/revisão dos Planos',
    'Q19' => '19. A construção do plano envolveu/envolve as seguintes etapas/modalidades e níveis da educação?',
    'Q20' => '20. Houve ou há um investimento na participação de crianças e adolescentes na construção do Plano de Educação?',
    'Q21' => '21.  Se sim, de que forma?'
);
*/
/* Fim do antigo sistema de Custom Fields */

add_action('init', 'municipio_register');
 
function municipio_register() {
	$args = array(
	'label' => __('Municípios'),
	'singular_label' => __('Município'),
	'public' => true,
	'show_ui' => true,
	'capability_type' => 'post',
	'hierarchical' => false,
	'rewrite' => false,
	'query_var' => false,
	'supports' => array('title'),
	 'register_meta_box_cb' => 'add_municipio_metaboxes'
   );
 
	register_post_type( 'municipio' , $args );
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function add_municipio_metaboxes() {
	 remove_meta_box( 'slugdiv', 'municipio', 'normal' );
	 remove_meta_box( 'submitdiv', 'municipio', 'normal' );
}
?>
