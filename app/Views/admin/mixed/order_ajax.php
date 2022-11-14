<?php




echo get_ol($thisItems,$_cancel);



function get_ol($array,$_cancel, $child = FALSE)
{
    $str = '';

    if (count($array)) {


        $str .= $child == FALSE ? '<ol class="sortable">' : '<ol>';

        foreach ($array as $item) {
            $str .= '<li id="list_'. $item['id'] .'">';
                

            $str .= '<div  class="" alt="'.$item['id'].'" >
            
                    
                    <span>'.word_limiter($item['title'],6).'</span>
            
                    
                    
            
                    <span class="pull-right">
					<div class="btn-group btn-group-xs options">
					  <a class="btn btn-xs btn-primary" href="'.site_url($_cancel.'/view/'.$item['id']).'"><i class="fa fa-eye"></i></a>
					  
					</div></span></div>';

            // Do we have any children?
            if (isset($item['children']) && count($item['children'])) {
                $str .= get_ol($item['children'],$_cancel, TRUE);
            }

            $str .= '</li>' . PHP_EOL;
        }

        $str .= '</ol>' . PHP_EOL;
    }

    return $str;
}
?>

<script>
    $(document).ready(function(){

        $('.sortable').nestedSortable({
            handle: 'div',
            items: 'li',
            toleranceElement: '> div',
            maxLevels: 2
        });

    });
</script>
