<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://nanoincub.com.br
 * @since      1.0.0
 *
 * @package    Instagram_Links_Bio
 * @subpackage Instagram_Links_Bio/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Instagram_Links_Bio
 * @subpackage Instagram_Links_Bio/admin
 * @author     Nano Incub <desenvolvimento@email.com.br>
 */
class Instagram_Links_Bio_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Instagram_Links_Bio_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Instagram_Links_Bio_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/instagram-links-bio-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Instagram_Links_Bio_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Instagram_Links_Bio_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/instagram-links-bio-admin.js', array('jquery'), $this->version, false);

    }

    /**
     * Registra CPT para gestão de conteúdos para Link da Bio
     */
    public function criar_cpt_instagram_links_bio()
    {

        $labels = array(
            'name' => _x('Links da Bio', 'post type general name', 'your-plugin-textdomain'),
            'singular_name' => _x('Link da Bio', 'post type singular name', 'your-plugin-textdomain'),
            'menu_name' => _x('Links da Bio', 'admin menu', 'your-plugin-textdomain'),
            'name_admin_bar' => _x('Link da Bio', 'add new on admin bar', 'your-plugin-textdomain'),
            'add_new' => _x('Adicionar novo', 'link-bio', 'your-plugin-textdomain'),
            'add_new_item' => __('Adicionar novo Link da Bio', 'your-plugin-textdomain'),
            'new_item' => __('Novo Link da Bio', 'your-plugin-textdomain'),
            'edit_item' => __('Editar Link da Bio', 'your-plugin-textdomain'),
            'view_item' => __('Ver Link da Bio', 'your-plugin-textdomain'),
            'all_items' => __('Todos Links da Bio', 'your-plugin-textdomain'),
            'search_items' => __('Pesquisar Links da Bio', 'your-plugin-textdomain'),
            'parent_item_colon' => __('Categorias Links da Bio:', 'your-plugin-textdomain'),
            'not_found' => __('Nenhum Link da Bio encontrado.', 'your-plugin-textdomain'),
            'not_found_in_trash' => __('Nenhum Link da Bio encontrado na lixeira.', 'your-plugin-textdomain')
        );

        $args = array(
            'labels' => $labels,
            'description' => __('Description.', 'your-plugin-textdomain'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'link-bio'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 5,
            'supports' => array('title', 'excerpt', 'thumbnail', 'post-formats')
        );

        register_post_type('link-bio', $args);

    }

    /**
     * Cria uma taxonomia para organizar os conteúdos do CPT link-bio
     */
    public function criar_taxonomia_link_bio()
    {

        $labels = array(
            'name' => _x('Categorias', 'categorias para conteúdos', 'textdomain'),
            'singular_name' => _x('Categoria', 'categoria para conteúdos', 'textdomain'),
            'search_items' => __('Pesquisar Categorias', 'textdomain'),
            'all_items' => __('Todas Categorias', 'textdomain'),
            'parent_item' => __('Categoria mãe', 'textdomain'),
            'parent_item_colon' => __('Categoria mãe:', 'textdomain'),
            'edit_item' => __('Editar Categoria', 'textdomain'),
            'update_item' => __('Atualizar Categoria', 'textdomain'),
            'add_new_item' => __('Adicionar Nova Categoria', 'textdomain'),
            'new_item_name' => __('Novo Nome de Categoria', 'textdomain'),
            'menu_name' => __('Categorias', 'textdomain'),
        );

        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
//            'rewrite'           => array( 'slug' => 'genre' ),
        );

        register_taxonomy('categoria-link-bio', array('link-bio'), $args);

    }

    /**
     * Função para adicionar campos customizados para o CPT link-bio
     */
    public function definir_campos_personalizados_cpt()
    {

        add_meta_box(
            'metaboxes-link-bio',
            __('Campos personalizados para Link da Bio'),
            array($this, 'exibir_campos_personalizados'),
            'link-bio',
            'normal',
            'default'
        );

    }

    public function exibir_campos_personalizados($post)
    {

        wp_nonce_field('link_bio_link_nonce', 'link_bio_link_nonce');

        $value = get_post_meta($post->ID, 'link_bio_link', true);

        echo '<div class="link-bio-campos-admin">';

        echo '<label for="link_bio_link">Link relacionado com esse conteúdo</label>';
        echo '<input type="text" value="' . esc_attr($value) . '" id="link_bio_link" name="link_bio_link" class="link-bio-campos-admin-input">';

        echo '</div>';

    }

    public function salvar_campos_personalizados($post_id)
    {

        $link_bio_link_nonce = $_POST['link_bio_link_nonce'];

        if (!isset($link_bio_link_nonce)) {
            return;
        }

        if (!wp_verify_nonce($link_bio_link_nonce, 'link_bio_link_nonce')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Verifica permissões do usuário
        if (isset($_POST['post_type']) && 'link-bio' == $_POST['post_type']) {

            if (!current_user_can('edit_posts', $post_id)) {
                return;
            }

        }

        $campos = array(
            'link_bio_link' => $_POST['link_bio_link']
        );

        $this->validar_campos_personalizados($campos, $post_id);

    }

    public function validar_campos_personalizados($campos, $post_id)
    {

        foreach ($campos as $index => $valor) {

            if (!isset($valor)) {
                return;
            }

            $dados_campos_personalizados = sanitize_text_field($valor);
            update_post_meta($post_id, 'link_bio_link', $dados_campos_personalizados);

        }

    }

    public function definir_suporte_tema()
    {
        add_theme_support('post-formats', array('link', 'video', 'image', 'quote', 'audio'));
    }

    public function definir_campos_personalizados_taxonomia()
    {

        add_action('categoria-link-bio_add_form_fields', array($this, 'formulario_adicionar_campos_personalizados_taxonomia'), 10, 2);
        add_action('categoria-link-bio_edit_form_fields', array($this, 'formulario_editar_campos_personalizados_taxonomia'), 10, 2);
        add_action('categoria-link-bio_edit_form_fields', array($this, 'formulario_editar_campos_personalizados_taxonomia'), 10, 2);
        add_action('edited_categoria-link-bio', array($this, 'salvar_campos_personalizados_taxonomia'), 10, 2);
        add_action('create_categoria-link-bio', array($this, 'salvar_campos_personalizados_taxonomia'), 10, 2);

    }

    public function formulario_adicionar_campos_personalizados_taxonomia()
    {

        echo '<div class="form-field">';
        echo '<label for="categoria-link-bio-cor">Cor da categoria</label>';
        echo '<input type="text" name="term_meta[categoria-link-bio-cor]" id="term_meta[categoria-link-bio-cor]">';
        echo '<p>Informe o RGB da cor da categoria (ex. #ee564b)</p>';
        echo '</div>';

    }

    public function formulario_editar_campos_personalizados_taxonomia($term)
    {

        $term_meta = get_option("categoria-link-bio_" . $term->term_id);

        echo '<tr class="form-field">';
        echo '<th scope="row" valign="top">';
        echo '<label for="categoria-link-bio-cor">Cor da categoria</label>';
        echo '</th>';

        echo '<td>';
        echo '<input type="text" value="' . (esc_attr($term_meta['categoria-link-bio-cor']) ? esc_attr($term_meta['categoria-link-bio-cor']) : "") . '" name="term_meta[categoria-link-bio-cor]" id="term_meta[categoria-link-bio-cor]">';
        echo '<p>Informe o RGB da cor da categoria (ex. #ee564b)</p>';
        echo '</td>';
        echo '</tr>';

    }

    public function salvar_campos_personalizados_taxonomia($term_id)
    {

        if (isset($_POST['term_meta'])) {

            $term_meta = get_option('categoria-link-bio_' . $term_id);
            $cat_keys = array_keys($_POST['term_meta']);

            foreach ($cat_keys as $key) {
                if (isset ($_POST['term_meta'][$key])) {
                    $term_meta[$key] = $_POST['term_meta'][$key];
                }
            }

            update_option('categoria-link-bio_' . $term_id, $term_meta);
        }

    }

    function criar_pagina_configuracao_plugin()
    {

        add_options_page('Link Bio', 'Link Bio', 'manage_options', 'link_bio_configuracao', array($this, 'pagina_opcao_plugin'));

    }


    function inicializar_configuracao_plugin()
    {

        register_setting('pagina_plugin', 'configuracao_plugin');

        add_settings_section(
            'pagina_configuracao_plugin_secao_1',
            __('Configurações adicionais do plugin', 'text_domain'),
            array($this, 'configurar_plugin_callback'),
            'pagina_plugin'
        );

        add_settings_field(
            'pagina_configuracao_plugin_secao_1_campo_1',
            __('Link do perfil do Instagram', 'text_domain'),
            array($this, 'pagina_configuracao_plugin_secao_1_campo_1'),
            'pagina_plugin',
            'pagina_configuracao_plugin_secao_1'
        );

        add_settings_field(
            'pagina_configuracao_plugin_secao_1_campo_2',
            __('Quantidade de conteúdos por página', 'text_domain'),
            array($this, 'pagina_configuracao_plugin_secao_1_campo_2'),
            'pagina_plugin',
            'pagina_configuracao_plugin_secao_1'
        );

    }


    function pagina_configuracao_plugin_secao_1_campo_1()
    {

        $options = get_option('configuracao_plugin');
        ?>
        <input type="text" name="configuracao_plugin[pagina_configuracao_plugin_secao_1_campo_1]" value="<?php echo $options['pagina_configuracao_plugin_secao_1_campo_1']; ?>" class="regular-text">
        <p class="description">Deixe o campo vazio para ocultar o botão de acesso ao perfil no Instagram</p>
        <?php

    }


    function pagina_configuracao_plugin_secao_1_campo_2()
    {

        $options = get_option('configuracao_plugin');
        ?>
        <input type="text" name="configuracao_plugin[pagina_configuracao_plugin_secao_1_campo_2]" value="<?php echo $options['pagina_configuracao_plugin_secao_1_campo_2']; ?>" class="regular-text">
        <p class="description">Quantidade padrão de 12 itens</p>
        <?php

    }


    function configurar_plugin_callback()
    {

        echo __('', 'text_domain');

    }


    function pagina_opcao_plugin()
    {

        ?>
        <form action='options.php' method='post'>

            <h2>Link Bio</h2>

            <?php
            settings_fields('pagina_plugin');
            do_settings_sections('pagina_plugin');
            submit_button();
            ?>

        </form>
        <?php

    }
}
