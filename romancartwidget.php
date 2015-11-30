<?php
/**
 * @copyright   Copyright (C) 2015 SSOFB. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *  
 * Code by Andy Gaskell - ag@ssofb.co.uk
 * Usage like '{romancart 36}' with the number being the product id.
 *
 * For more info on RomanCart, see http://www.romancart.com/
 */
defined('_JEXEC') or die;

class PlgContentRomancartwidget extends JPlugin
{

	/**
	 * Plugin that loads a RomanCart widget
	 *
	 * @param   string   $context   The context of the content being passed to the plugin.
	 * @param   object   &$article  The article object.  Note $article->text is also available
	 * @param   mixed    &$params   The article params
	 * @param   integer  $page      The 'page' number
	 *
	 * @return  mixed   true if there is an error. Void otherwise.
	 *
	 * @since   1.6
	 */
	public function onContentPrepare($context, &$article, &$params, $page = 0)
	{
		
        $show_widget = $this->params->get('show_widget', 1);
        $store_id = $this->params->get('store_id', 0);
        $error_text = "";
        
        if ($store_id) {
        
            # Expression to search for 
            $regex		= '/{romancart\s(.*?)}/i';

            # Find all instances of plugin and put in $matches for loadposition
            # $matches[0] is full pattern match
            # $matches[1] is the position
            preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER);
            
            #echo "all:" . print_r($matches, TRUE) . "<br/>";
                        
            if ( isset($matches[0][1]) ) {
                # product id from regex
                $product_id = $matches[0][1];
                # string in text to replace from regex
                $string_to_replace = $matches[0][0];
                # make the widget
                $romancart_widget = "<!-- start of romancart widget -->\n";
                $romancart_widget .= "<SCRIPT LANGUAGE=\"JavaScript\" SRC=\"http://remote.romancart.com/js/roc_button.asp?storeid=" . $store_id . "\"></script> \n";
                $romancart_widget .= "<div id='ROC_widget'></div> \n";
                $romancart_widget .= "<script>ROC_buttonWidget('ROC_widget','" . $store_id . "'," . $product_id . ",0);</script> \n";
                $romancart_widget .= "<!-- end of romancart widget -->\n";
                # sub it in
                $article->text = str_replace($string_to_replace, $romancart_widget, $article->text);
            }
        }
	}
}
