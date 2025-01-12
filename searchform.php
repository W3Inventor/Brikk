<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="brk-search-form" autocomplete="nope">
    <input type="text" class="brk--input" name="s" placeholder="<?php esc_attr_e( 'Search ...', 'brikk' ); ?>" value="<?php echo esc_html( get_search_query() ); ?>">
    <button type="submit" class="brk--submit">
        <i class="fas fa-search"></i>
    </button>
</form>
