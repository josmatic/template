<div class="widget">
    <h2>Users</h2>
    <div class="inner">
        <?php
        $user_count = user_count();
        if($user_count > 1)
        {
            $suffix='s';
        }
        else
        {
            $suffix='';
        }
        ?>
        We current have <?php echo $user_count?> registred user<?php echo $suffix;?>.
    </div>

</div>
