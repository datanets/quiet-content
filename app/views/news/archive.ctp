<div id="single_page">

<div class="row">

<!-- panel -->
<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-sm-push-2 col-md-push-2 col-lg-push-2">
    <div id="page_entry">
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
                        echo '<h1>' . $created_array[0] . '</h1>';
                        echo '<div class="archive_heading">' . $months[$created_array[1]] . '</div><ul>';
                    } else {
                        echo '</ul><div class="archive_heading">' . $months[$created_array[1]] . '</div><ul>';
                    }
                }
            
                $last_month = $created_array[1];
                
                echo '<li><a href="' . $site_base_url . 'news/' . $v['News']['id']. '">' . $v['News']['subject'] . '</a></li>';

                $first_time = false;

            }

        ?>
        </ul>
    </div>
    </div>

    <!-- sidebar -->
    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-sm-pull-10 col-md-pull-10 col-lg-pull-10">
        <div id="side_nav">
            <ul>
            <li>News Archive</li>
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
    </div> <!-- end of sidebar -->

</div> <!-- end of row -->
</div>
