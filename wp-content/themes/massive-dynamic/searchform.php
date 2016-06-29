<div class="search-form">
    <form action="<?php echo esc_url(home_url( '/' )); ?>">
        <fieldset>
            <input type="text" name="s" placeholder="<?php esc_attr_e('Search...', 'massive-dynamic'); ?>" value="<?php if(!empty($_GET['s'])) echo get_search_query(); ?>">
            <input type="submit" value="">
        </fieldset>
    </form>
</div>