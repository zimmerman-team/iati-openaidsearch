// Global variables
var geojson;

// Project filter options
function initialize_project_filter_options(){
  //set loading gif in case call takes long
  var url = make_project_filter_options_url();
  var options = get_project_filter_options(url);
  draw_project_options(options);
}

function make_project_filter_options_url(){
  var dlmtr = ",";
  var str_country = reload_map_prepare_parameter_string("country", dlmtr);
  var str_region = reload_map_prepare_parameter_string("region", dlmtr);
  var str_sector = reload_map_prepare_parameter_string("sector", dlmtr);
  var str_budget = reload_map_prepare_parameter_string("budget", dlmtr);
  var url = site + 'json-project-filters?sectors=' + str_sector + '&budgets=' + str_budget + '&countries=' + str_country + '&regions=' + str_region;
  return url;
}

function get_project_filter_options(url){

  var project_options;
  $.ajax({
        type: 'GET',
         url: url,
         async: false,
         contentType: "application/json",
         dataType: 'json',
         success: function(data){
          project_options = data;
         }
  });
  return project_options;
}

function draw_project_options(options){

  var budget_keys = {};
  budget_keys['all'] = 'All';
  budget_keys[''] = '> US$ 0';
  budget_keys['10000'] = '> US$ 10.000';
  budget_keys['50000'] = '> US$ 50.000';
  budget_keys['100000'] = '> US$ 100.000';
  budget_keys['500000'] = '> US$ 500.000';
  budget_keys['1000000'] = '> US$ 1.000.000';

  var country_html = create_filter_attributes(options.countries, 4);
  $('#countries-filters').html(country_html);
  var region_html = create_filter_attributes(options.regions, 4);
  $('#regions-filters').html(region_html);
  var sector_html = create_filter_attributes(options.sectors, 3);
  $('#sectors-filters').html(sector_html);
  var budget_html = create_filter_attributes(budget_keys, 4);
  $('#budgets-filters').html(budget_html);
}



// init/reload the map
function initialize_projects_map(url, type){
    selected_type = type;
    var project_geojson = get_project_data(url);
    unload_project_map();
    load_project_map(project_geojson);
}

function get_project_data(url){

    var project_geojson = [];

    $.ajax({
        type: 'GET',
         url: url,
         async: false,
         contentType: "application/json",
         dataType: 'json',
         success: function(data){
          project_geojson = data;
         }
    });

    return project_geojson;
}

function unload_project_map(){
    // remove geojson layer from map
    if (geojson != null){
      geojson.clearLayers();
    }
}



// Map polygon styling


function getColor(d) {
    return d > 6  ? '#045A8D' :
           d > 1   ? '#2476A2' :
           d > 0   ? '#2B8CBE' :
    // return d > 8  ? '#FE6305' :
    //        d > 4   ? '#FE7421' :
    //        d > 0   ? '#FE8236' :
           //d > 220   ? '#2B8CBE' :
                      'transparent';
}

      // return d > 8  ? '#045A8D' :
      //      d > 4   ? '#2476A2' :
      //      d > 0   ? '#2B8CBE' :

function getWeight(d) {
    return d > 0  ? 1 :
                      0;
}

function style(feature) {
    return {
        fillColor: getColor(feature.properties.project_amount),
        weight: getWeight(feature.properties.project_amount),
        opacity: 1,
        color: '#FFF',
        dashArray: '',
        fillOpacity: 0.7
    };
}

function highlightFeature(e) {
    var layer = e.target;
    
    if(typeof layer.feature.properties.projects != "undefined"){
        
        if (currently_selected_country != layer.feature.properties.name){
            set_currently_selected_country(layer.feature.properties.name);
            showPopup(e);
        }

        layer.setStyle({
            weight: 2,
            fillOpacity: 0.9
        });

        if (!L.Browser.ie && !L.Browser.opera) {
            layer.bringToFront();
        }
    }
}

function showPopup(e){
    var layer = e.target;
    var mostNorth = layer.getBounds().getNorthWest().lat;
    var mostSouth = layer.getBounds().getSouthWest().lat;
    var center = layer.getBounds().getCenter();
    var heightToDraw = ((mostNorth - mostSouth) / 4) + center.lat;
    var pointToDraw = new L.LatLng(heightToDraw, center.lng);

    var popup = L.popup()
    .setLatLng(pointToDraw)
    .setContent('<div id="map-tip-header">' + layer.feature.properties.name + '</div><div id="map-tip-text">Total projects: '+ layer.feature.properties.project_amount + '</div><div id="map-tip-link"><a href="?s=&countries='+layer.feature.id+'">Click to view related projects</a></div>')
    .openOn(map);
}

function resetHighlight(e) {
    geojson.resetStyle(e.target);
}

function load_project_map(project_geojson){
    geojson = L.geoJson(project_geojson, {style: style,onEachFeature: function(feature,layer) {

      layer.on({
          mouseover: highlightFeature,
          mouseout: resetHighlight,
          click: showPopup
      });
    }});

    geojson.addTo(map); 
}
















  // load listeners at page initialisation:
  load_projects_listeners();

  

  function load_new_page(reloadmap,keepoffset){
   if (reloadmap === undefined) reloadmap = true;
   if (keepoffset === undefined) keepoffset = false;
   if (!keepoffset){
    current_selection.offset = [];
   }

   var link = document.URL.toString().split("?")[0] + build_current_url();
   history.pushState(null, null, link);
   $('#page-wrapper').fadeOut(100, function(){ //fade out the content area
   $("#paginated-loader").show();
   }).load(link + ' #page-wrapper', function(){ 
    $("#paginated-loader").hide();
    $('#page-wrapper').fadeIn(200, function(){
      load_projects_listeners();

   
   }); });
   $('html,body').animate({
     scrollTop: ($("#map-hide-show").offset().top - 150)},
     'slow', function(){
        if(reloadmap){
          reload_map();
          initialize_filters();
          fill_selection_box();
        }
     });
  }


  function load_projects_listeners(){
    
    // Reload projects on pagination container click
    $('#pagination a').click(function(){ 
     var href = $(this).attr('href');
     var splitted = href.split("=");
     var parkey = splitted[0].substr(1);
     var parval = splitted[1];
     current_selection[parkey] = [{"id":parval, "name":"unnamed"}];
     load_new_page(false, true);
     return false;
    });

    // Reload projects on sort type click
    $('.project-sort-type a').click(function(){ 
     var href = $(this).attr('href');
     var splitted = href.split("=");
     var parkey = splitted[0].substr(1);
     var parval = splitted[1];
     current_selection[parkey] = [{"id":parval, "name":"unnamed"}];
     load_new_page();
     return false;
    });

    $('.projects-description-link').click(function(){
     var href = $(this).attr('href');
     var splitted = href.split("=");
     var parkey = splitted[0].substr(1);
     var parval = splitted[1];
     current_selection = new Object();
     current_selection[parkey] = [{"id":parval, "name":"unnamed"}];
     load_new_page(true, false);
     return false;
    });

    // XXXXXXX sort buttons project page XXXXX

    $(".project-sort-type").click(function(){

      if($('.dropdown-project', this).is(":hidden")){
          $('.dropdown-project', this).show("blind", { direction: "vertical" }, 200);
      } else {
          $('.dropdown-project', this).hide("blind", { direction: "vertical" }, 200);
      }

      return false;
    });


      // plus - min button in project description 

  $('.project-expand-button').click(function(e){
    // TO DO: show the whole description.

    var currentId = $(this).attr('id');

    if($(this).hasClass("expand-plus")){
      $('.project-project-spec-hidden.'+currentId).show();
      $('.projects-project-description.'+currentId).css("height", "auto");
      $(this).removeClass('expand-plus');
      $(this).addClass('expand-min');
    } else {
      $('.project-project-spec-hidden.'+currentId).hide();
      $('.projects-project-description.'+currentId).css("height", "6em");
      $(this).removeClass('expand-min');
      $(this).addClass('expand-plus');
    }
    
    });
  }





