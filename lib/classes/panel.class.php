<?php
	/**
	 *  This functions build the output for the panel in order to standardize 
	 */
	class Panel {
		function build_panel($left = '', $right = '', $msg = ''){
			$output  = '<div id="panel-wrapper">';
			$output .= '<div id="panel-msg">'.$msg.'</div>';
			if ($left != '') {
			  $output .= '<div id="panel-left">'.$left.'</div>';			  	
			}
			else {
				$class = ' full';
			}
			$output .= '<div id="panel-right" class="content'.$class.'">'.$right.'</div>';
			$output .= '</div>';
			$output .= '<a id="panel-close">Close</a>';
			return $output;
		}
	}
	
	/**
	 *  This functions build the output for the panel in order to standardize 
	 *  Old with scrollbars removed by Carlos request
	class Panel {
		function build_panel($left = '', $right = '', $msg = ''){
			$output  = '<div id="panel-wrapper">';
			$output .= '<div id="panel-msg">'.$msg.'</div>';
			if ($left != '') {
			  $output .= '<div id="panel-left">'.$left.'</div>';			  	
			}
			else {
				$class = ' full';
			}
			$output .= '<div id="panel-right" class="content'.$class.'">
			              <div id="panel-right-slider"></div>
                    <div id="panel-right-scroll">'.$right.'</div>
								  </div>';
			$output .= '</div>';
			$output .= '<a id="panel-close">Close</a>';
			return $output;
		}
	}
		 */
?>
