<?php

  //Campos principales
  $formData = array(
    "firstName" =>  array("name" => __('Nombre', 'ac-update-forms'), 'required' => true),
    "lastName" =>   array("name" => __('Apellidos', 'ac-update-forms'), 'required' => true),
    "phone" =>   array("name" => __('Teléfono', 'ac-update-forms'), 'required' => false, 'type' => 'tel', 'pattern' => '[0-9]{9}')
  );
  
  //Campos extras   
  $fields = array( 
    /* array("id" => 8, "text" => __('Código postal', 'ac-update-forms')), */
    /* array("id" => 6, "text" => __('Población', 'ac-update-forms')), */
    /* array("id" => 9, "text" => __('País', 'ac-update-forms')), */
    array("id" => 40, "text" => __('Tratamiento', 'ac-update-forms'), "position" => "pre", 'required' => false, "select" => array(
      array("text" => __("Sr.", 'ac-update-forms'), "label" => "Sr."),
      array("text" => __("Sra.", 'ac-update-forms'), "label" => "Sra."),
    )),
    array("id" => 42, "text" => __('DNI/CIF/Pasaporte', 'ac-update-forms'), "position" => "post", 'required' => false),
    array("id" => 7, "text" => __('Provincia', 'ac-update-forms'), "position" => "post", 'required' => true, "select" => array(
      array("text" => __("Bizkaia", 'ac-update-forms'), "label" => "Bizkaia"),
      array("text" => __("Gipuzkoa", 'ac-update-forms'), "label" => "Gipuzkoa"),
      array("text" => __("Araba", 'ac-update-forms'), "label" => "Araba"),
      array("text" => __("Otros", 'ac-update-forms'), "label" => "Otros"),
    )),
    array("id" => 41, "text" => __('Nombre de empresa', 'ac-update-forms'), "position" => "post", 'required' => false),
  array("id" => 43, "text" => __('CIF', 'ac-update-forms'), "position" => "post", 'required' => false/*, 'pattern' => '(([X-Z]{1})([-]?)(\d{7})([-]?)([A-Z]{1}))|((\d{8})([-]?)([A-Z]{1}))'*/),
    array("id" => 44, "text" => __('Perfíl de Linkedin', 'ac-update-forms'), "position" => "post", 'required' => false, "type" => 'url', 'pattern' => '^http(s)?:\/\/(www\.)?linkedin\.com\/in\/.*$'),
    array("id" => 10, "text" => __('Sector', 'ac-update-forms'), "position" => "post", 'required' => false, "select" => array(
      array("text" => __("Administración gubernamental", 'ac-update-forms'), "label" => "Administración gubernamental"),
      array("text" => __("Aeronáutica/Aviación", 'ac-update-forms'), "label" => "Aeronáutica/Aviación"),
      array("text" => __("Alimentación", 'ac-update-forms'), "label" => "Alimentación"),
      array("text" => __("Automoción", 'ac-update-forms'), "label" => "Automoción"),
      array("text" => __("Banca de inversiones", 'ac-update-forms'), "label" => "Banca de inversiones"),
      array("text" => __("Biosalud", 'ac-update-forms'), "label" => "Biosalud"),
      array("text" => __("Capital de riesgo y capital privado", 'ac-update-forms'), "label" => "Capital de riesgo y capital privado"),
      array("text" => __("Construcción", 'ac-update-forms'), "label" => "Construcción"),
      array("text" => __("Contenidos digitales", 'ac-update-forms'), "label" => "Contenidos digitales"),
      array("text" => __("Energía", 'ac-update-forms'), "label" => "Energía"),
      array("text" => __("Equipos Ferroviarios", 'ac-update-forms'), "label" => "Equipos Ferroviarios"),
      array("text" => __("Fundición", 'ac-update-forms'), "label" => "Fundición"),
      array("text" => __("Industrías Marítimas", 'ac-update-forms'), "label" => "Industrías Marítimas"),
      array("text" => __("Investigación", 'ac-update-forms'), "label" => "Investigación"),
      array("text" => __("Maquinaria", 'ac-update-forms'), "label" => "Maquinaria"),
      array("text" => __("Medioambiente", 'ac-update-forms'), "label" => "Medioambiente"),
      array("text" => __("Papel", 'ac-update-forms'), "label" => "Papel"),
      array("text" => __("Petróleo y energía", 'ac-update-forms'), "label" => "Petróleo y energía"),
      array("text" => __("Seguridad del ordenador y de las redes", 'ac-update-forms'), "label" => "Seguridad del ordenador y de las redes"),
      array("text" => __("Servicios y tecnologías de la información", 'ac-update-forms'), "label" => "Servicios y tecnologías de la información"),
      array("text" => __("Siderurgia", 'ac-update-forms'), "label" => "Siderurgia"),
      array("text" => __("Tec. Av. Fabricación", 'ac-update-forms'), "label" => "Tec. Av. Fabricación"),
      array("text" => __("Telecomunicaciones", 'ac-update-forms'), "label" => "Telecomunicaciones"),
      array("text" => __("Transporte, movilidad y logística", 'ac-update-forms'), "label" => "Transporte, movilidad y logística"),
      array("text" => __("Videojuegos", 'ac-update-forms'), "label" => "Videojuegos"),
      array("text" => __("Otros", 'ac-update-forms'), "label" => "Otros")
    )),
  );

  //Campos de las newsletter
  $fields_newsletter = array( 
    array("id" => 32, "text" => __('Mi boletín semanal de Grupo SPRI ', 'ac-update-forms'), "description" => __("Lo mejor de la semana: entrevistas, noticias, ayudas, agenda, formación y tendencias sobre ciberseguridad, digitalización, nuevos modelos de gestión avanzada, internacionalización, emprendimiento, infraestructuras.", 'ac-update-forms')),
    array("id" => 35, "text" => __('Mi boletín mensual UP! Euskadi', 'ac-update-forms'), "description" => __("Una vez al mes la información sobre la red de Startups vascas y sus últimas innovaciones.", 'ac-update-forms')),
    array("id" => 37, "text" => __('Mi boletín semanal Oferta y demanda tecnológica.', 'ac-update-forms'), "description" => __("Cada semana las oportunidades del mercado en materia de transferencia tecnológica internacional.", 'ac-update-forms')),
    /*array("id" => 34, "text" => __('Newsletter de Adi! Agenda', 'ac-update-forms'), "description" => __("", 'ac-update-forms')),*/
  ); 

  //Etiquetas de intereses
  $tags = array (
    array("id" => 98, "tag" => "interes-ciberseguridad", "text" => __('Ciberseguridad ', 'ac-update-forms'), "position" => "intereses"),
    array("id" => 101, "tag" => "interes-digitalizacion", "text" => __('Digitalización', 'ac-update-forms'), "position" => "intereses"),
    array("id" => 96, "tag" => "interes-emprendimiento", "text" =>  __('Emprendimiento', 'ac-update-forms'), "position" => "intereses"),
    array("id" => 102, "tag" => "interes-i+d", "text" =>  __('I+D', 'ac-update-forms'), "position" => "intereses"),
    array("id" => 97, "tag" => "interes-innovacion", "text" =>  __('Innovación', 'ac-update-forms'), "position" => "intereses"),
    array("id" => 103, "tag" => "interes-internacionalizacion", "text" =>  __('Internacionalización', 'ac-update-forms'), "position" => "intereses"),
    array("id" => 104, "tag" => "interes-invertir-en-euskadi", "text" =>  __('Invertir en Euskadi', 'ac-update-forms'), "position" => "intereses"),
    array("id" => 114, "tag" => "interes-invertir-inmovilizado", "text" =>  __('Invertir en inmovilizado', 'ac-update-forms'), "position" => "intereses"),
    array("id" => 115, "tag" => "interes-relanzamiento-empresarial", "text" =>  __('Relanzamiento empresarial', 'ac-update-forms'), "position" => "intereses"),
    array("id" => 106, "tag" => "interes-sostenibilidad-medioambiental", "text" =>  __('Sostenibilidad Medioambiental', 'ac-update-forms'), "position" => "intereses"),
    array("id" => 116, "tag" => "interes-fondos-capital-riesgo", "text" =>  __('Fondos de Capital Riesgo', 'ac-update-forms'), "position" => "intereses"),
    /*array("id" => 105, "tag" => "interes-financiacion", "text" =>  __('Financiación', 'ac-update-forms'), "position" => "intereses"),*/
    /*array("id" => 107, "tag" => "interes-infraestructuras", "text" => __('Infraestructuras', 'ac-update-forms'), "position" => "intereses"),*/
    
    array("id" => 117, "tag" => "empresa-personas-emprendedoras", "text" => __('Personas emprendedoras', 'ac-update-forms'), "position" => "empresa"),
    array("id" => 118, "tag" => "empresa-autonomos", "text" => __('Autonómos/as', 'ac-update-forms'), "position" => "empresa"),
    array("id" => 119, "tag" => "empresa-micropyme", "text" => __('Micropyme (1-10 empleados/as)', 'ac-update-forms'), "position" => "empresa"),
    array("id" => 120, "tag" => "empresa-pequena-empresa", "text" => __('Pequeña empresa (10-50)', 'ac-update-forms'), "position" => "empresa"),
    array("id" => 121, "tag" => "empresa-mediana-empresa", "text" => __('Mediana empresa (50-250)', 'ac-update-forms'), "position" => "empresa"),
    array("id" => 122, "tag" => "empresa-gran-empresa", "text" => __('Gran empresa (+250)', 'ac-update-forms'), "position" => "empresa"),
    array("id" => 123, "tag" => "empresa-agentes-rvcti", "text" => __('Agentes de la RVCTI', 'ac-update-forms'), "position" => "empresa"),
    array("id" => 124, "tag" => "empresa-asociaciones", "text" => __('Asociaciones', 'ac-update-forms'), "position" => "empresa"),
    array("id" => 125, "tag" => "empresa-estudiantes", "text" => __('Estudiantes', 'ac-update-forms'), "position" => "empresa"),
    array("id" => 126, "tag" => "empresa-inversores", "text" => __('Inversores', 'ac-update-forms'), "position" => "empresa"),
    array("id" => 127, "tag" => "empresa-agentes-intermedios", "text" => __('Agentes intermedios', 'ac-update-forms'), "position" => "empresa"),

    /*array("id" => 109, "tag" => "preferencias-asesoramiento-experto", "text" => __('Asesoramiento experto', 'ac-update-forms'), "position" => "preferencias"),
    array("id" => 110, "tag" => "preferencias-subvenciones-inanciacion-inversiones", "text" => __('Subvenciones, financiación e inversiones', 'ac-update-forms'), "position" => "preferencias"),
    array("id" => 111, "tag" => "preferencias-tendencias-vision-estrategica", "text" => __('Tendencias y visión estratégica', 'ac-update-forms'), "position" => "preferencias"),
    array("id" => 112, "tag" => "preferencias-agenda-formacion-aprendizaje", "text" => __('Agenda, formación y aprendizaje', 'ac-update-forms'), "position" => "preferencias"),
    array("id" => 113, "tag" => "preferencias-networking-cooperacion-empresarial", "text" => __('Networking y cooperación empresarial', 'ac-update-forms'), "position" => "preferencias"),*/
  );

  //Idiomas
  $langs = array (
    array("id" => 18, "tag" => "newsletter-es", "text" => __('Castellano ', 'ac-update-forms')),
    array("id" => 30, "tag" => "newsletter-eu", "text" => __('Euskera', 'ac-update-forms')),
    /* array("id" => 43, "tag" => "newsletter-en", "text" => __('Inglés', 'ac-update-forms')), */
  );
