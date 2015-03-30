<?php
namespace fizzy_pex_wp;

class admin
{

    private $options;

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
		add_action( 'activated_plugin', array( $this, 'activate' ), 10, 2 );
    }
		
	public function add_plugin_page() {
	
        add_menu_page(
            'Fizzy PEX WP Settings', 
            'Fizzy PEX WP', //Short Desc
            'manage_options', //Permission
            'fizzy-pex-wp-admin', //Slug
            array( $this, 'templater' )
        );
		
	}

	public function page_init() {
		register_setting( 'fizzy_pex_wp_options_general', 'fizzy_pex_wp_options_general' );
		register_setting( 'fizzy_pex_wp_options_search', 'fizzy_pex_wp_options_search' );
		register_setting( 'fizzy_pex_wp_options_availability', 'fizzy_pex_wp_options_availability' );
		register_setting( 'fizzy_pex_wp_options_properties', 'fizzy_pex_wp_options_properties' );
	}

	public function templater() {
		$tmpl = new templater(plugin_dir_path( __FILE__ )."../template/fizzy-pex-wp-admin.php");
		$template = $tmpl->parse();
		printf( $template );
	}
	
	public function activate() {

		$general['slug'] = "properties";
		$general['search_template'] = "fizzy-pex-wp-search.php";
		$general['property_template'] = "fizzy-pex-wp-property.php";

		$search['url'] = "http://fizzydev539-www.pexsoftware.com/JSONInterface/rs/webService/init";
		$search['cache'] = "60";
		$search['template'] = '{
<?php foreach($this->response->select as $options => $option): ?>

<?php if($options == "roomType"): ?>
<?php $i=0; ?>
"unit_type_id" : {
<?php foreach($option as $opt): ?>
<?php if($i>0){echo",";} //Add comma after each record ?>
"<?php echo $opt->lookupValue; ?>": "<?php echo $opt->displayValue; ?>"
<?php $i++; ?>
<?php endforeach; ?>
},
<?php endif; ?>

<?php if($options == "location"): ?>
<?php $i=0; ?>
"area_id" : {
<?php foreach($option as $opt): ?>
<?php if($i>0){echo",";} //Add comma after each record ?>
"<?php echo $opt->lookupValue; ?>": "<?php echo $opt->displayValue; ?>"
<?php $i++; ?>
<?php endforeach; ?>
}
<?php endif; ?>

<?php endforeach; ?>
}';
		$search['config'] = '{
	"elements" : {
		"area_id" : {
			"type":"select",
			"label":"Area",
			"options":"area_id",
			"search":"multi",
			"placeholder":"All Area\'s"
		},
		"unit_type_id" : {
			"type":"checkbox",
			"label":"Unit Type",
			"options":"unit_type_id",
			"search":"multi",
			"placeholder":""
		}
	},
	"sort" : "unit_ref",
	"order" : "asc"
}';

		$availability['url'] = "http://fizzydev539-www.pexsoftware.com/JSONInterface/rs/webService/searchAvailability";
		$availability['cache'] = "60";
		$availability['template'] = '[
<?php $i=0; ?>
<?php foreach($this->response->locations as $locations): ?>
<?php foreach($locations->roomTypes as $roomTypes): ?>
<?php foreach($roomTypes->rooms as $rooms): ?>
<?php if($i>0){echo",";} //Add comma after each record ?>
{
"building_id": "<?php echo $locations->building->lookupValue; ?>",
"building": "<?php echo $locations->building->displayValue; ?>",
"building_address": "<?php echo str_replace("<br />",", ",$locations->building->address); ?>",
"area_id": "<?php echo $locations->location->lookupValue; ?>",
"area": "<?php echo $locations->location->displayValue; ?>",
"unit_type_id": "<?php echo $roomTypes->roomType->lookupValue; ?>",
"unit_type": "<?php echo $roomTypes->roomType->displayValue; ?>",   
"unit_id": "<?php echo $rooms->id; ?>",
"unit_ref": "<?php echo $rooms->lookupValue; ?>",
"unit_no": "<?php echo $rooms->title; ?>",
"price": "<?php echo $rooms->price; ?>",
"base_rent": "<?php echo $rooms->baseRent; ?>",
"portfolio_id": "<?php echo $rooms->portfolio->lookupValue; ?>",
"portfolio": "<?php echo $rooms->portfolio->displayValue; ?>",
"floor": "<?php echo $rooms->floor->displayValue; ?>",
"available_date": "<?php echo $rooms->availability->start; ?>",
"booking_type_id": "<?php echo $rooms->bookingType->lookupValue; ?>",
"booking_type": "<?php echo $rooms->bookingType->displayValue; ?>",
"bookable": "<?php echo $rooms->bookable; ?>"
}
<?php $i++; ?>
<?php endforeach; ?>
<?php endforeach; ?>
<?php endforeach; ?>
]';

		$properties['url'] = "http://fizzydev539-www.pexsoftware.com/JSONInterface/rs/webService/getRoomDetails";
		$properties['cache'] = "60";
		$properties['template'] = '{
"unit_id": "<?php echo $this->response->room->id; ?>",
"unit_ref": "<?php echo $this->response->room->lookupValue; ?>",
"unit_no": "<?php echo $this->response->room->title; ?>",
"price": "<?php echo $this->response->room->price; ?>",
"base_rent": "<?php echo $this->response->room->baseRent; ?>",
"unit_type_id": "<?php echo $this->response->room->roomType->lookupValue; ?>",
"unit_type": "<?php echo $this->response->room->roomType->displayValue; ?>",  
"portfolio_id": "<?php echo $this->response->room->portfolio->lookupValue; ?>",
"portfolio": "<?php echo $this->response->room->portfolio->displayValue; ?>",
"building_id": "<?php echo $this->response->room->building->lookupValue; ?>",
"building": "<?php echo $this->response->room->building->displayValue; ?>",
"building_address": "<?php echo str_replace("<br />",", ",$this->response->room->building->address) ?>",
"area_id": "<?php echo $this->response->room->location->lookupValue; ?>",
"area": "<?php echo $this->response->room->location->displayValue; ?>"
<?php if(isset($this->response->features)): ?>
,
"features" : [
<?php $i=0; ?>
<?php foreach($this->response->features as $featuretype): ?>
<?php foreach($featuretype as $feature): ?>
<?php if($i>0){echo",";} //Add comma after each record ?>
{
"feat_type_id": "<?php echo $feature->type->lookupValue; ?>",
"feat_type": "<?php echo $feature->type->displayValue; ?>",
"feat_id": "<?php echo $feature->id; ?>",
"feat_image": "<?php if(isset($feature->image))echo $feature->image; ?>",
"feat_text": "<?php if(isset($feature->text))echo $feature->text; ?>",
"feat_showcase": "<?php if(isset($feature->feat_showcase))echo $feature->showcase; ?>"
}
<?php endforeach; ?>
<?php $i++; ?>
<?php endforeach; ?>
<?php endif; ?>
]
}';

		add_option('fizzy_pex_wp_options_general', $general, null, "yes" );
		add_option('fizzy_pex_wp_options_search', $search, null, "yes" );
		add_option('fizzy_pex_wp_options_availability', $availability, null, "yes" );
		add_option('fizzy_pex_wp_options_properties', $properties, null, "yes" );

	}
	
}