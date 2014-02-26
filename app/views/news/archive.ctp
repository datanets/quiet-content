<div id="single_page">

<div id="side_nav">
    <ul>
    <?php

        if (isset($archive_years_array) && count($archive_years_array) > 0) {

            foreach ($archive_years_array as $year) :

    ?>
                <li><a href="<?php echo $site_base_url ?>news/archive/<?php echo $year ?>"><?php echo $year ?></a></li>
    <?php
            endforeach;

        } else {

    ?>
                <li><a href="<?php echo $site_base_url ?>news/archive/<?php echo date("Y") ?>"><?php echo date("Y") ?></a></li>
    <?php

        }

    ?>
    </ul>
</div>
<div id="archive_index">
<?php

    $months = array('01' => 'January',
                    '02' => 'February',
                    '03' => 'March',
                    '04' => 'April',
                    '05' => 'May',
                    '06' => 'June',
                    '07' => 'July',
                    '08' => 'August',
                    '09' => 'September',
                    '10' => 'October',
                    '11' => 'November',
                    '12' => 'December');

    $last_month = '01';
    $first_time = true;

    foreach ($news as $k => $v) {

        $created = $v['News']['created'];
        $created_array = split(' ', $created);  
        $created_array = split('-', $created_array[0]);
        if ($created_array[1] != $last_month) {
            if ($first_time) {
                echo '<div class="archive_heading">' . $months[$created_array[1]] . '</div><ul>';
            } else {
                echo '<li>&nbsp;</li>';
                echo '</ul><div class="archive_heading">' . $months[$created_array[1]] . '</div><ul>';
            }
        }
    
        $last_month = $created_array[1];
        
        echo '<li><a href="' . $site_base_url . 'news/' . $v['News']['id']. '">' . $v['News']['subject'] . '</a></li>';

        $first_time = false;

    }

?>
</ul>
<br style="clear:both;" />
</div>

</div>
