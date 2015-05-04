<?php
add_action('init', 'teo_post_types');
function teo_post_types() {
  $labels = array(
    'name' => _x('Itens de A Rede', 'post type general name', 'Proma'),
    'singular_name' => _x('A Rede item', 'post type singular name', 'Proma'),
    'add_new' => _x('Adicionar', 'arede_item', 'Proma'),
    'add_new_item' => __('Adicionar novo item A rede', 'Proma'),
    'edit_item' => __('Editar item A Rede', 'Proma'),
    'new_item' => __('Novo item A Rede', 'Proma'),
    'all_items' => __('Todos os itens A Rede', 'Proma'),
    'view_item' => __('Ver todos os detalhes do item de A Rede', 'Proma'),
    'search_items' => __('Procurar item A Rede', 'Proma'),
    'not_found' =>  __('Nenhum item de A Rede encontrado', 'Proma'),
    'not_found_in_trash' => __('Nenhum item de A Rede encontrado na lixeira.' , 'Proma'),
    'parent_item_colon' => '',
    'menu_name' => 'A Rede'

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title')
  );

  register_post_type('portfolio',$args);
  register_taxonomy_for_object_type( 'category', 'portfolio' );
}

add_action('init', 'projetos_post_type');
function projetos_post_type() {
  $labels = array(
    'name' => _x('Projetos', 'post type general name', 'Proma'),
    'singular_name' => _x('Projeto', 'post type singular name', 'Proma'),
    'add_new' => _x('Adicionar projeto', 'arede_item', 'Proma'),
    'add_new_item' => __('Adicionar novo projeto', 'Proma'),
    'edit_item' => __('Editar projeto', 'Proma'),
    'new_item' => __('Novo projeto', 'Proma'),
    'all_items' => __('Todos os projetos', 'Proma'),
    'view_item' => __('Ver todos os detalhes do projeto', 'Proma'),
    'search_items' => __('Procurar projeto', 'Proma'),
    'not_found' =>  __('Nenhum projeto encontrado', 'Proma'),
    'not_found_in_trash' => __('Nenhum projeto encontrado na lixeira.' , 'Proma'),
    'parent_item_colon' => '',
    'menu_name' => 'Projetos'

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','thumbnail','editor',)
  );
  register_post_type('projetos',$args);
  register_taxonomy_for_object_type( 'category', 'projetos' );
  register_taxonomy_for_object_type( 'post_tag', 'projetos' );
}
?>