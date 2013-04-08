<div id="map-wrapper">
    



    <!-- Show selection button --> 
    <?php get_template_part( "map", "selection" ); ?>

    <!-- The 4 graph buttons in right top --> 
    <div id="map-graph-wrapper" class="container">
        <div class="row-fluid">
            <div class="span12">
                <div id="map-graph-buttons">
                    <a href="#" class="hneue-bold" id="graph-button-map"></a>
                    <a href="#" class="hneue-bold" id="graph-button-graph"></a> 
                    <a href="#" class="hneue-bold" id="graph-button-table"></a>
                    <a href="#" class="hneue-bold" id="graph-button-treemap"></a>
                </div>
            </div>
        </div>
    </div>

    <div id="map-slider-tooltip">

    </div>

    <div id="map-timeline-wrapper">
        <?php for ($i = 1950; $i < 2050;$i++){   
        echo '<div class="slider-year';
//        if($i > 2000 && $i < 2013){ echo ' slider-active'; }
        echo '" id="year-' . $i . '">';
        echo '<div class="slider-year-inner-white"></div></div>'; 
        } ?>
    </div>


    <!-- The black overlay for filtering options --> 
	<div id="map-filter-overlay">
        <div class="container">
<!--                            var indicator_keys = {};
        indicator_keys['all'] = 'all';
        indicator_keys['avg_annual_rate_change_percentage_urban'] = 'test';
                indicator_keys['avg_annual_rate_change_total_population'] = 'test';
        indicator_keys['bottle_water'] = 'test';
        indicator_keys['composting_toilet'] = 'test';
        indicator_keys['connection_to_electricity'] = 'test';
        indicator_keys['deprivation'] = 'test';
        indicator_keys['enrollment_female_primary_education'] = 'test';
        indicator_keys['enrollment_male_primary_education'] = 'test';
        indicator_keys['has_telephone'] = 'test';
        indicator_keys['improved_floor'] = 'test';
        indicator_keys['improved_flush_toilet'] = 'test';
        indicator_keys['improved_pit_latrine'] = 'test';
        indicator_keys['improved_spring_surface_water'] = 'test';
        indicator_keys['improved_toilet'] = 'test';
        indicator_keys['improved_water'] = 'test';
        indicator_keys['piped_water'] = 'test';
        indicator_keys['pit_latrine_with_slab_or_covered_latrine'] = 'test';
        indicator_keys['pit_latrine_without_slab'] = 'test';
        indicator_keys['test'] = 'test';
        indicator_keys['test'] = 'test';
        indicator_keys['test'] = 'test';
        indicator_keys['test'] = 'test';
        indicator_keys['test'] = 'test';-->
			<div class="row-fluid map-filter-list">
                            <div id="indicator_filters">
				<?php 

                                
                               $indicators = array( 
                                                    'avg_annual_rate_change_percentage_urban' => 'Average annual rate cahnge percentage urban',
                                                    'avg_annual_rate_change_total_population' => 'Average annual rate of total population change',
                                                    'bottle_water' => 'Bottle water',
                                                    'composting_toilet' => 'Composting toilets',
                                                    'connection_to_electricity' => 'avg_annual_rate_change_percentage_urban',
                                                    'deprivation' => 'deprivation',
                                                    'enrollment_female_primary_education' => 'enrollment_female_primary_education',
                                                    'enrollment_male_primary_education' => 'enrollment_male_primary_education',
                                                    'has_telephone' => 'has_telephone',
                                                    'improved_floor' => 'improved_floor',
                                                    'improved_flush_toilet' => 'improved_flush_toilet',
                                                    'improved_pit_latrine' => 'improved_pit_latrine',
                                                    'improved_spring_surface_water' => 'improved_spring_surface_water',
                                                    'improved_toilet' => 'improved_toilet',
                                                    'improved_water' => 'improved_water',
                                                    'piped_water' => 'piped_water',
                                                    'pit_latrine_with_slab_or_covered_latrine' => 'pit_latrine_with_slab_or_covered_latrine',
                                                    'pit_latrine_without_slab' => 'pit_latrine_without_slab',
                                                    'pop_rural_area' => 'pop_rural_area',
                                                    'pop_urban_area' => 'pop_urban_area',
                                                    'pop_urban_percentage' => 'pop_urban_percentage',
                                                    'population' => 'population',
                                                    'protected_well' => 'protected_well',
                                                    'public_tap_pump_borehole' => 'public_tap_pump_borehole',
                                                    'pump_borehole' => 'pump_borehole',
                                                    'rainwater' => 'rainwater',
                                                    'slum_proportion_living_urban' => 'slum_proportion_living_urban',
                                                    'sufficient_living' => 'sufficient_living',
                                                    'under_five_mortality_rate' => 'under_five_mortality_rate',
                                                    'urban_population' => 'urban_population',
                                                    'urban_slum_population' => 'urban_slum_population'

                                );
                               ?>
                            <?php $c = 0;?>
                            <?php foreach ($indicators as $key => $value) :?>
                            
                            <?php if(in_array($c, array(0, 15, 30, 45))) : ?>
                                    <div class="span3">
                            <?php endif ?>
                            
                            <div class="squaredThree">
						<input type="checkbox" value="<?php echo $key; ?>" id="land<?php echo $key; ?>" name="check" />
						<label class="map-filter-cb-value" for="land<?php echo $key; ?>"></label>
						<span><?php echo $value; ?></span>
					</div>
                                        
                             <?php if(in_array($c, array(14,29,44, 59))) : ?>
                                    </div>
                            <?php endif ?>
                                        
                                        
                            <?php $c++;?>
                            <?php endforeach;?>
                                </div>
                        </div>
                            <div id="region_filters"></div>
                            <div id="country_filters"></div>
                            <div id="city_filters"></div>
                            
                            
                </div>
			
		</div>

		<div id="map-filters-buttons">
			<div class="container">
				<div class="row-fluid">
					<div class="span12">

						<button id="map-filter-cancel" class="hneue-bold">CANCEL</button>
						<button id="map-filter-save" class="hneue-bold">SAVE</button>

					</div>
				</div>
			</div>
		</div>

	</div>
    <!-- treemap visualization placeholder, TO DO: load dynamically on click, no preloading of the treemap -->
    <div id="treemap-placeholder"></div>
    <div id="map-loader">
        <div id="map-loader-text">Loading indicator map</div>
        <img src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" alt="" />
    </div>
	<div id="map"></div>
</div>

<div id="map-hide-show">
	<div class="container">
		<div class="row-fluid">
			<div class="span12">
				<button id="map-hide-show-button" class="map-show"><img class="hide-show-icon" src="<?php echo get_template_directory_uri(); ?>/images/hide-show.png" alt="" /><span id="map-hide-show-text" class="hneue-bold">HIDE MAP</span></button>
			</div>
		</div>
	</div>
</div>