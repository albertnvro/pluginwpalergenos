<?php
/*
Plugin Name: Alergenos Alimentarios
Description: Muestra un panel con imágenes de alérgenos alimentarios y sus shortcodes correspondientes.
Version: 1.0
Author: Albert Navarro
Author URI: https://www.linkedin.com/in/albert-n-579261256/
*/

if (!defined('ABSPATH')) {
    exit; // Evita el acceso directo.
}

// Registrar los scripts y estilos
function alergenos_enqueue_scripts() {
    wp_enqueue_style('alergenos-css', plugin_dir_url(__FILE__) . 'css/alergenos.css');
    wp_enqueue_script('popper-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js', array(), null, true);
    wp_enqueue_script('tippy-js', 'https://cdnjs.cloudflare.com/ajax/libs/tippy.js/6.3.7/tippy.umd.min.js', array('popper-js'), null, true);
    wp_enqueue_script('alergenos-js', plugin_dir_url(__FILE__) . 'js/alergenos.js', array('jquery', 'tippy-js'), null, true);
}
add_action('wp_enqueue_scripts', 'alergenos_enqueue_scripts');

// Crear el shortcode
function alergenos_shortcode($atts) {
    $a = shortcode_atts(array(
        'id' => '',
    ), $atts);

    $output = '<div class="alergeno">';
    // carpeta de los iconos
    $output .= '<img src="' . plugin_dir_url(__FILE__) . 'iconos/' . $a['id'] . '.png" alt="' . $a['id'] . '" class="alergeno-icon" data-tippy-content="' . ucfirst(str_replace('-', ' ', $a['id'])) . '">';
    $output .= '</div>';

    return $output;
}
add_shortcode('alergeno', 'alergenos_shortcode');

// pag del panel
function alergenos_admin_menu() {
    add_menu_page('Alergenos Alimentarios', 'Alergenos', 'manage_options', 'alergenos', 'alergenos_admin_page');
}
add_action('admin_menu', 'alergenos_admin_menu');

function alergenos_admin_page() {
    $alergenos = array(
        'altramuces', 'apio', 'cacahuetes', 'contiene-gluten', 
        'crustaceos', 'dioxido-de-azufre-y-sulfitos', 'frutos-de-cascara', 
        'granos-de-sesamo', 'huevos', 'lacteos', 'moluscos', 
        'mostaza', 'pescado', 'soja'
    );

    echo '<div class="wrap">';
    echo '<h1>Alergenos Alimentarios</h1>';
    echo '<div class="alergenos-container">';
    
    foreach ($alergenos as $alergeno) {
        echo '<div class="alergeno-item">';
        echo '<img src="' . plugin_dir_url(__FILE__) . 'iconos/' . $alergeno . '.png" alt="' . $alergeno . '" class="alergeno-icon">';
        echo '<span class="alergeno-nombre">' . ucfirst(str_replace('-', ' ', $alergeno)) . '</span>';
        echo '<input type="text" value="[alergeno id=&quot;' . $alergeno . '&quot;]" readonly>';
        echo '</div>';
    }
    echo '</div></div>';
}
