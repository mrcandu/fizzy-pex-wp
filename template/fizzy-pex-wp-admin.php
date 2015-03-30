<div class="wrap">

	<?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : '';  ?>  

    <h2>Fizzy PEX WP Options</h2>
    
    <h2 class="nav-tab-wrapper">  
        <a href="?page=fizzy-pex-wp-admin&tab=general" class="nav-tab <?php echo ($active_tab == '' || $active_tab == 'general') ? 'nav-tab-active' : ''; ?>">General</a>  
        <a href="?page=fizzy-pex-wp-admin&tab=search" class="nav-tab <?php echo ($active_tab == 'search') ? 'nav-tab-active' : ''; ?>">Search</a>  
        <a href="?page=fizzy-pex-wp-admin&tab=availability" class="nav-tab <?php echo $active_tab == 'availability' ? 'nav-tab-active' : ''; ?>">Availability</a>  
        <a href="?page=fizzy-pex-wp-admin&tab=properties" class="nav-tab <?php echo $active_tab == 'properties' ? 'nav-tab-active' : ''; ?>">Properties</a>
    </h2> 

    <form method="post" action="options.php">
    	
        <?php if( $active_tab == 'general' || $active_tab == '' ): ?>
			
            <?php settings_fields( 'fizzy_pex_wp_options_general' ); ?>
			<?php $this->options = get_option( 'fizzy_pex_wp_options_general' ); ?> 

            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Search Slug</th>
                    <td><input type="text" name="fizzy_pex_wp_options_general[slug]" value="<?php echo isset( $this->options['slug'] ) ? esc_attr( $this->options['slug']) : '' ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Search Template</th>
                    <td><input type="text"  name="fizzy_pex_wp_options_general[search_template]" class="large-text" value="<?php echo isset( $this->options['search_template'] ) ? esc_attr( $this->options['search_template']) : '' ?>"/></td>
                </tr>
 
                <tr valign="top">
                    <th scope="row">Property Template</th>
                    <td><input type="text" name="fizzy_pex_wp_options_general[property_template]" class="large-text" value="<?php echo isset( $this->options['property_template'] ) ? esc_attr( $this->options['property_template']) : '' ?>" /></td>
                </tr>
                        
            </table>
			<?php submit_button(); ?>

        <?php endif; ?>

        <?php if( $active_tab == 'search'): ?>
			
            <?php settings_fields( 'fizzy_pex_wp_options_search' ); ?>
			<?php $this->options = get_option( 'fizzy_pex_wp_options_search' ); ?> 

            <table class="form-table">
                <tr valign="top">
                    <th scope="row">API URL</th>
                    <td><input type="url" name="fizzy_pex_wp_options_search[url]" value="<?php echo isset( $this->options['url'] ) ? esc_attr( $this->options['url']) : '' ?>" class="large-text" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">API JSON Template</th>
                    <td><textarea name="fizzy_pex_wp_options_search[template]" class="large-text" rows="20" cols="50" /><?php echo isset( $this->options['template'] ) ? esc_attr( $this->options['template']) : '' ?></textarea></td>
                </tr>
 
                <tr valign="top">
                    <th scope="row">API Cache Time (Seconds)</th>
                    <td><input type="number" name="fizzy_pex_wp_options_search[cache]" value="<?php echo isset( $this->options['cache'] ) ? esc_attr( $this->options['cache']) : '' ?>" /></td>
                </tr>
                                       
                <tr valign="top">
                    <th scope="row">Search Config</th>
                    <td><textarea name="fizzy_pex_wp_options_search[config]" class="large-text" rows="20" cols="50" /><?php echo isset( $this->options['config'] ) ? esc_attr( $this->options['config']) : '' ?></textarea></td>
                </tr>
        

                        
            </table>
			<?php submit_button(); ?>

        <?php endif; ?>

        
        <?php if( $active_tab == 'availability' ): ?>
        
			<?php settings_fields( 'fizzy_pex_wp_options_availability' ); ?>
			<?php $this->options = get_option( 'fizzy_pex_wp_options_availability' ); ?> 
        
            <table class="form-table">
            
                <tr valign="top">
                    <th scope="row">API URL</th>
                    <td><input type="url" name="fizzy_pex_wp_options_availability[url]" value="<?php echo isset( $this->options['url'] ) ? esc_attr( $this->options['url']) : '' ?>" class="large-text" /></td>
                </tr>
 
                 <tr valign="top">
                    <th scope="row">API JSON Template</th>
                    <td><textarea name="fizzy_pex_wp_options_availability[template]" class="large-text" rows="20" cols="50" /><?php echo isset( $this->options['template'] ) ? esc_attr( $this->options['template']) : '' ?></textarea></td>
                </tr>               

                <tr valign="top">
                    <th scope="row">API Cache Time (Seconds)</th>
                    <td><input type="number" name="fizzy_pex_wp_options_availability[cache]" value="<?php echo isset( $this->options['cache'] ) ? esc_attr( $this->options['cache']) : '' ?>" /></td>
                </tr>
                                
            </table>
			<?php submit_button(); ?>

        <?php endif; ?>
        
        <?php if( $active_tab == 'properties' ): ?>
        
			<?php settings_fields( 'fizzy_pex_wp_options_properties' ); ?>
			<?php $this->options = get_option( 'fizzy_pex_wp_options_properties' ); ?> 
        
            <table class="form-table">
            
                <tr valign="top">
                    <th scope="row">API URL</th>
                    <td><input type="url" name="fizzy_pex_wp_options_properties[url]" value="<?php echo isset( $this->options['url'] ) ? esc_attr( $this->options['url']) : '' ?>" class="large-text" /></td>
                </tr>
 
                 <tr valign="top">
                    <th scope="row">API JSON Template</th>
                    <td><textarea name="fizzy_pex_wp_options_properties[template]" class="large-text" rows="20" cols="50" /><?php echo isset( $this->options['template'] ) ? esc_attr( $this->options['template']) : '' ?></textarea></td>
                </tr>               

                <tr valign="top">
                    <th scope="row">API Cache Time (Seconds)</th>
                    <td><input type="number" name="fizzy_pex_wp_options_properties[cache]" value="<?php echo isset( $this->options['cache'] ) ? esc_attr( $this->options['cache']) : '' ?>" /></td>
                </tr>
                                
            </table>
			<?php submit_button(); ?>

        <?php endif; ?>
                    
    </form>
</div>