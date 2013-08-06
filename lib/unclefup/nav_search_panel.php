<?php
/**
 * Provides a navigation bar search panel.
 */
/**
 * fup_search_panel()
 *
 * return
 */
function fup_search_panel(){
	?><ul class="pull-right nav navbar-nav">
		<li class="dropdown">
			<a href="#" data-toggle="dropdown" data-target="#"
			class="dropdown-toggle" title="<?php
			esc_attr_e( 'Search', 'fup'); ?>"><i
			class="glyphicon glyphicon-search"></i></a>
			<div class="dropdown-menu">
				<?php get_search_form( TRUE ); ?>
			</div>
		</li>
	</ul>
<?php
}
