<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://nanoincub.com.br
 * @since      1.0.0
 *
 * @package    Instagram_Links_Bio
 * @subpackage Instagram_Links_Bio/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Instagram_Links_Bio
 * @subpackage Instagram_Links_Bio/public
 * @author     Nano Incub <desenvolvimento@email.com.br>
 */
class Instagram_Links_Bio_Public
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
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/instagram-links-bio-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/instagram-links-bio-public.js', array('jquery'), $this->version, false);

    }

    /**
     * Shortcode para listar conteúdos criados pelo CPT link-bio
     */
    public function shortcode_listar_conteudo()
    {

        $quantidade_conteudos = 12;

        $configuracoes_plugin = get_option('configuracao_plugin');

        if(!empty($configuracoes_plugin['pagina_configuracao_plugin_secao_1_campo_2'])) {
            $quantidade_conteudos = $configuracoes_plugin['pagina_configuracao_plugin_secao_1_campo_2'];
        }

        $args = array(
            'post_status' => 'publish',
            'post_type' => 'link-bio',
            'posts_per_page' => $quantidade_conteudos
        );

        $query = new WP_Query($args);

        echo '<div class="s-link-bio-plugin">';

        if(!empty($configuracoes_plugin['pagina_configuracao_plugin_secao_1_campo_1'])) {
            echo '<div class="row">';
            echo '<div class="col-xs-12 col-sm-12 col-md-12"><a class="btn btn-default btn-block btn-lg" href="'. $configuracoes_plugin['pagina_configuracao_plugin_secao_1_campo_1'] .'" target="_blank">Voltar para perfil do Instagram</a></div>';
            echo '</div>';
            echo '<br>';
        }

        echo '<div class="row">';
        echo '<div class="c-link-bio-plugin">';

        if ($query->have_posts()) {

            $count = 1;

            while ($query->have_posts()) {

                $query->the_post();

                $categoria = get_the_terms(get_the_ID(), 'categoria-link-bio');
                $campos_customizados_categoria = get_option('categoria-link-bio_' . reset($categoria)->term_id);
                $cor_categoria = $campos_customizados_categoria['categoria-link-bio-cor'];

                ?>

                <div class="col-xs-12 col-sm-4 col-md-4">

                    <div class="c-link-bio-plugin-item">

                        <?php

                        $url_imagem = '';

                        if (has_post_thumbnail()) {
                            $url_imagem = get_the_post_thumbnail_url();
                        } else {
                            $url_imagem = plugin_dir_path(__FILE__) . '/public/images/imagem-padrao.jpg';
                        }

                        ?>

                        <a href="<?php echo get_post_meta(get_the_ID(), 'link_bio_link', true); ?>" target="_blank">
                            <div class="c-link-bio-plugin-imagem" style="background-image: url(<?php echo $url_imagem ?>); background-size: cover;">

                            </div>
                        </a>

                        <div class="c-link-bio-plugin-item-dados">
                            <div class="c-link-bio-plugin-titulo">
                                <h2><?php echo get_the_title(); ?></h2>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-9 col-md-7">
                                    <div class="c-link-bio-plugin-categoria">
                                        <div style="background-color: <?php echo $cor_categoria ? $cor_categoria : '#dddddd'; ?>; color: <?php echo $this->is_cor_escura($cor_categoria ? $cor_categoria : '#ffffff') ? '#fff' : '#000'; ?>;">
                                            <?php echo reset($categoria)->name; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-3 col-md-5">
                                    <div class="c-link-bio-plugin-meta__data text-right"><?php echo get_the_date(); ?></div>
                                </div>
                            </div>

                            <div class="c-link-bio-plugin-descricao">
                                <?php echo get_the_excerpt(); ?>
                            </div>

                            <div class="c-link-bio-plugin-meta">
                                <div class="c-link-bio-plugin-meta__link">
                                    <a href="<?php echo get_post_meta(get_the_ID(), 'link_bio_link', true); ?>" target="_blank" class="btn btn-default" title="Veja mais sobre: <?php echo get_the_title(); ?>">
                                        <?php echo $this->formatar_nome_formato(get_post_format(get_the_ID())) ?>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <?php

                if ($count % 3 == 0) {
                    echo '<div class="clearfix"></div> <br><br>';
                }

                $count++;

            }

        }

        echo '</div>';
        echo '</div>';
        echo '</div>';

    }

    public function formatar_nome_formato($formato)
    {

        switch ($formato) {
            case 'link':
                return 'Ver conteúdo';
                break;
            case 'video':
                return 'Ver vídeo';
                break;
            case 'image':
                return 'Ver imagem';
                break;
            case 'quote':
                return 'Quero refletir';
                break;
            case 'audio':
                return 'Ouvir áudio';
                break;
            default:
                return 'Ver mais';
        }

    }

    public function is_cor_escura($cor_hexadecimal)
    {
        $r = hexdec(substr($cor_hexadecimal, 1, 2));
        $g = hexdec(substr($cor_hexadecimal, 3, 2));
        $b = hexdec(substr($cor_hexadecimal, 5, 2));
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

        return ($yiq >= 128) ? false : true;
    }

}
