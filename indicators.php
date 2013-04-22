<?php
/*
Template Name: Indicators page
*/
?>

<?php get_header(); ?>

<?php get_template_part( "indicator", "filters" ); ?>
<?php get_template_part( "indicator", "map" ); ?>

<div id="page-wrapper">
	<div class="page-header page-header-less-margin">
		<div class="container">
			<div class="row-fluid">
				<div class="span8">

					<div class="project-share-container share-left">

						<a href="#" id="project-share-graph" class="project-share-button hneue-bold">
							<div class="share-icon"></div>
							<div class="share-text">TYPE GRAPH</div>
							<div id="dropdown-type-graph" class="dropdown-menu-page-header">
								<button id="dropdown-line-graph">LINE GRAPH</button>
								<button id="dropdown-table-graph">TABLE GRAPH</button>
							</div>
						</a>

						<a href="#" id="project-share-export" class="project-share-button hneue-bold">
							<div class="share-icon"></div>
							<div class="share-text">EXPORT</div>
							<div id="dropdown-export-indicator" class="dropdown-menu-page-header">
								<button id="dropdown-png">AS IMAGE</button>
								<button id="dropdown-csv">AS CSV</button>
							</div>
						</a>
						<a href="#" id="project-share-embed" class="project-share-button hneue-bold">
							<div class="share-icon"></div>
							<div class="share-text">EMBED</div>
						</a>
					</div>

				</div>
				<?php get_template_part("global", "page-navbar-right"); ?>
			</div>

		</div>
	</div>

	<div class="container">
		<div class="row-fluid">
			<div class="span3">
				<div id="line-chart-filter-title">Countries</div>
				<div id="line-chart-filter"></div>
			</div>
			<div class="span9">
				<div id="line-chart-title">The line chart title</div>
				<div id="line-chart-placeholder"></div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="page-content">
			<div clas="row-fluid">
				<div class="span12">
					<div id="table-chart-placeholder"></div>
				</div>
			</div>
		</div>
	</div>

</div>


<?php get_footer(); ?>

<script type="text/javascript">
$(document).ready(function(){
  initialize_map('http://dev.oipa.openaidsearch.org/json',2015,"indicator", "", "");
  current_selection.indicator = [];
  current_selection.indicator.push({"id":"population", "name":"Total population"});
  fill_selection_box();
});

initialize_charts();

</script>
